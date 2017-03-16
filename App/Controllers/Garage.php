<?php

namespace PioCMS\Controllers;

use PioCMS\Models\Repository\RepositoryVehicle;
use PioCMS\Models\Auth;
use PioCMS\Engine\Validator;
use PioCMS\Models\Repository\RepositoryVehicleBrand;
use PioCMS\Models\Repository\RepositoryVehicleModel;
use PioCMS\Models\Vehicle;
use PioCMS\Models\VehicleModel;
use PioCMS\Models\VehicleBrand;
use PioCMS\Models\VehicleRefuel;
use PioCMS\Models\VehicleRepair;
use PioCMS\Models\Repository\RepositoryVehicleRefuel;
use PioCMS\Models\Repository\RepositoryWorkshop;
use PioCMS\Utils\Pagination;

class Garage extends Controller {

    public function index($page = 1) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }

        $repository = new RepositoryVehicle($this->database);
        $vehicles = $repository->getVehicleList(Auth::getUserID())->paginate($page, 20)->getAll();
        $paginator = new Pagination($page);
        $paginator->setURL(genereteURL('garageList'));
        $paginator->total = $repository->getTotalPages();
        $this->view->setTitle(trans('vehicle_list'));
        $this->view->header('style5');
        $this->view->renderView('home/garage/list', array('vehicles' => $vehicles->getData(), 'total_vehicles' => $repository->getCount(), 'paginator' => $paginator));
        $this->view->footer();
    }

    public function vehicle_info($alias, $vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $array = array();
        $info = $this->session->get('vehicle_info_error');
        $this->session->put('vehicle_info_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['vehicle'] = $vehicle;
        $this->view->setTitle(sprintf(trans('vehicle_info'), $vehicle->getBrandModel()));
        $this->view->header('style5');
        $this->view->renderView('home/garage/vehicle_info', $array);
        $this->view->footer();
    }

    public function vehicle_add() {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $array = array();
        $info = $this->session->get('vehicle_add_error');
        $this->session->put('vehicle_add_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['form_url'] = genereteURL('vehicle_add');
        $this->view->setTitle(trans('button_add_vehicle'));
        $this->view->header('style5');
        $this->loadDataPicker();
        $this->view->renderView('home/garage/vehicle_add', $array);
        $this->view->footer();
    }

    public function vehicle_add_form() {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }

        $_POST['price'] = convertCurrency($_POST['price']);
        $_POST['mileage'] = convertCurrency($_POST['mileage']);
        $v = new Validator($this->database);
        $v->validate([
            'mark' => [$_POST['mark'], 'required|min(3)|max(20)'],
            'model' => [$_POST['model'], 'required|min(3)|max(20)'],
            'year' => [$_POST['year'], 'int'],
            'fuel' => [$_POST['fuel'], 'alnumDash|min(3)|max(20)'],
            'transmission' => [$_POST['transmission'], 'alnumDash|min(3)|max(20)'],
            'colour' => [$_POST['colour'], 'alnumDash|min(3)|max(20)'],
            'doors' => [$_POST['doors'], 'int'],
            'car_type' => [$_POST['car_type'], 'alnumDash|min(3)|max(20)'],
            'price' => [$_POST['price'], 'number'],
            'date_purchase' => [$_POST['date_purchase'], 'date'],
            'engine' => [$_POST['engine'], 'number|min(3)|max(20)'],
            'power' => [$_POST['power'], 'int'],
            'mileage' => [$_POST['mileage'], 'number'],
            'unit' => [$_POST['unit'], 'alnumDash']
        ]);

        if ($v->passes()) {

            $brandRepository = new RepositoryVehicleBrand($this->database);
            $brand = $brandRepository->findByParams('name', $_POST['mark']);
            if ($brand->getID() > 0) {
                $_POST['brand_id'] = $brand->getID();
            } else {
                $brand->setName($_POST['mark']);
                $_POST['brand_id'] = $brandRepository->insert($brand->convertToArray());
            }

            $modelRepository = new RepositoryVehicleModel($this->database);
            $model = $modelRepository->findByParams('name', $_POST['model']);
            if ($model->getID() > 0) {
                $_POST['model_id'] = $model->getID();
            } else {
                $model->setName($_POST['model']);
                $model->setBrand_id($_POST['brand_id']);
                $_POST['model_id'] = $modelRepository->insert($model->convertToArray());
            }

            $_POST['ip'] = ip2long(get_client_ip());
            $_POST['user_id'] = Auth::getUserID();
            $vehicle = new Vehicle;
            $vehicle->loadFromArray($_POST);
            $id = $vehicle->insert();
            $this->redirect(genereteURL('vehicle_add_photo', array('vehicle_id' => $id)));
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->session->set('vehicle_add_error', serialize($array));
            $this->redirect(genereteURL('vehicle_add'));
        }
    }

    public function vehicle_edit($vehicle_id) {
        $vehicle_id = intval(abs($vehicle_id));
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }

        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $array = $vehicle->convertToArray();
        $mark = new VehicleBrand($vehicle->getBrand());
        $array['mark'] = $mark->getName();
        $model = new VehicleModel($vehicle->getModel());
        $array['model'] = $model->getName();
        if ($array['date_purchase'] == '0000-00-00') {
            unset($array['date_purchase']);
        }
        if ($array['price'] == '0.00') {
            unset($array['price']);
        }

        $info = $this->session->get('vehicle_edit_error');
        $this->session->put('vehicle_edit_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }

        $array['vehicle_id'] = $vehicle_id;
        $array['form_url'] = genereteURL('vehicle_edit', array('id' => $vehicle->getID()));
        $this->view->setTitle(trans('vehicle_edit_form'));
        $this->view->header('style5');
        $this->loadDataPicker();
        $this->view->renderView('home/garage/vehicle_add', $array);
        $this->view->footer();
    }

    public function vehicle_edit_form() {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }

        if (!isset($_POST['id']) || intval(abs($_POST['id'])) == 0) {
            $this->redirect(genereteURL('garage'));
        }
        $vehicle_id = intval(abs($_POST['id']));
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $v = new Validator($this->database);

        $rules = array(
            'id' => 'int',
            'mark' => 'required|min(3)|max(20)',
            'model' => 'required|min(3)|max(20)',
            'year' => 'int',
            'fuel' => 'alnumDash|min(3)|max(20)',
            'transmission' => 'alnumDash|min(3)|max(20)',
            'colour' => 'alnumDash|min(3)|max(20)',
            'doors' => 'int',
            'car_type' => 'alnumDash|min(3)|max(20)',
            'price' => 'price',
            'date_purchase' => 'date',
            'engine' => 'number|min(3)|max(20)',
            'power' => 'int',
            'mileage' => 'int',
            'unit' => 'alnumDash'
        );

        $v->validate($_POST, $rules);

        if ($v->passes()) {
            $brandRepository = new RepositoryVehicleBrand($this->database);
            $brand = $brandRepository->findByParams('name', $_POST['mark']);
            if ($brand->getID() > 0) {
                $_POST['brand_id'] = $brand->getID();
            } else {
                $brand->setName($_POST['mark']);
                $_POST['brand_id'] = $brandRepository->insert($brand->convertToArray());
            }

            $modelRepository = new RepositoryVehicleModel($this->database);
            $model = $modelRepository->findByParams('name', $_POST['model']);
            if ($model->getID() > 0) {
                $_POST['model_id'] = $model->getID();
            } else {
                $model->setName($_POST['model']);
                $model->setBrand_id($_POST['brand_id']);
                $_POST['model_id'] = $modelRepository->insert($model->convertToArray());
            }

            $_POST['ip'] = ip2long(get_client_ip());
            $_POST['user_id'] = Auth::getUserID();
            $vehicle->loadFromArray($_POST);
            $vehicle->setDateEdit(date("Y-m-d H:i:s"));
            $vehicle->update();
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->session->set('vehicle_edit_error', serialize($array));
        }
        $this->redirect(genereteURL('vehicle_edit', array('id' => $_POST['id'])));
    }

    public function refuel_add($vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }

        $vehicle_id = intval(abs($vehicle_id));
        if ($vehicle_id > 0) {
            $vehicle = new Vehicle($vehicle_id);
            if ($vehicle->getUser_id() <> Auth::getUserID()) {
                $this->redirect(genereteURL('garage'));
            }
            $array['vehicle_id'] = $vehicle_id;
        }

        $repository = new RepositoryVehicle($this->database);
        $vehicles = $repository->getVehicleList()->getAll();
        $array['vehicles'] = $vehicles->getData();
        $array['date_tank'] = date('Y-m-d');
        $info = $this->session->get('refuel_add_error');
        $this->session->put('refuel_add_error', '');
        if (!empty($info)) {
            $array += unserialize($info);
        }
        $array['form_url'] = genereteURL('refuel_add', array('id' => $vehicle_id));
        $this->view->setTitle($vehicle->getBrandModel() . ' - ' . trans('refuel_add'));
        $this->loadDataPicker();

        $this->view->header('style5');
        $this->view->renderView('home/garage/refuel_add', $array);
        $this->view->footer();
    }

    public function refuel_add_form($vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle_id = intval(abs($vehicle_id));
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }
        $_POST['vehicle_id'] = $vehicle_id;
        $_POST['price'] = convertCurrency($_POST['price']);
        $_POST['distance'] = convertCurrency($_POST['distance']);
        $_POST['galon'] = convertCurrency($_POST['galon']);
        $_POST['price_per_galon'] = convertCurrency(@($_POST['price'] / $_POST['galon']));
        $_POST['average_consumption'] = isset($_POST['average_consumption']) ? $_POST['average_consumption'] : convertCurrency(@((100 * $_POST['galon']) / $_POST['distance']));
        $_POST['date_add'] = isset($_POST['date_add']) ? date("Y-m-d H:i:s", $_POST['date_add']) : date("Y-m-d H:i:s");
        $vehicle_sqliteId = isset($_POST['vehicle_sqliteId']) ? $_POST['vehicle_sqliteId'] : -1;
        $sqliteId = isset($_POST['sqliteId']) ? $_POST['sqliteId'] : -1;
        if ($sqliteId > -1) {
            $_POST['date_tank'] = date("Y-m-d", $_POST['date_tank']);
        }
        unset($_POST['id']);
        unset($_POST['gcm']);
        unset($_POST['token']);
        unset($_POST['vehicle_sqliteId']);
        unset($_POST['sqliteId']);

        print_r($_POST);
        exit;

        $v = new Validator($this->database);
        $rules = array(
            'vehicle_id' => 'int',
            'date_tank' => 'required|date',
            'distance' => 'required|number|min(1, number)',
            'galon' => 'required|number|min(1, number)',
            'price' => 'number',
            'average_consumption' => 'number',
            'price_per_galon' => 'number',
            'date_add' => 'date'
        );

        $v->validate($_POST, $rules);


        if ($v->passes()) {

            $_POST['ip'] = ip2long(get_client_ip());
            $vehicleRefuel = new VehicleRefuel;
            $vehicleRefuel->loadFromArray($_POST);
            $id = $vehicleRefuel->insert();
            $vehicleRefuel->setId($id);
            $array['succes'] = array(trans('refuel_add_success'));
            $vehicle->setTotalExpenses($vehicle->getTotalExpenses() + $_POST['price']);
            $vehicle->setTotalMileage($vehicle->getTotalMileage() + $_POST['distance']);
            $vehicle->setMileage($vehicle->getMileage() + $_POST['distance']);
            $vehicle->setTotalRefuel($vehicle->getTotalRefuel() + $_POST['galon']);
            $vehicle->update();
//            if (isXML()) {
//                $this->view->renderView('home/garage/vehicle_add', array('vehicleRefuel' => $vehicleRefuel->toArray()));
//            } else {
            $this->redirect(genereteURL('vehicle_info', array('alias' => $vehicle->getAlias(), 'id' => $vehicle->getID())));
//            }
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->session->set('refuel_add_error', serialize($array));
            $this->redirect(genereteURL('refuel_add', array('id' => $vehicle_id)));
        }
    }

    public function refuel_delete($refuel_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicleRefuel = new VehicleRefuel($refuel_id);
        $vehicleInfo = $vehicleRefuel->getVehicle();
        if ($vehicleInfo->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }
        $vehicleInfo->setTotalExpenses($vehicleInfo->getTotalExpenses() - $vehicleRefuel->getPrice());
        $vehicleInfo->setTotalMileage($vehicleInfo->getTotalMileage() - $vehicleRefuel->getDistance());
        $vehicleInfo->setTotalRefuel($vehicleInfo->getTotalRefuel() - $vehicleRefuel->getGalon());
        $vehicleRefuel->delete();
        $vehicleInfo->update();
        $this->redirect(genereteURL('vehicle_info', array('alias' => $vehicleInfo->getAlias(), 'id' => $vehicleInfo->getID())));
    }

    public function repair_add($vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle_id = intval(abs($vehicle_id));
        if ($vehicle_id > 0) {
            $vehicle = new Vehicle($vehicle_id);
            if ($vehicle->getUser_id() <> Auth::getUserID()) {
                $this->redirect(genereteURL('garage'));
            }
            $array['vehicle_id'] = $vehicle_id;
        }

        $repository = new RepositoryVehicle($this->database);
        $vehicles = $repository->getVehicleList()->getAll();
        $array['vehicles'] = $vehicles->getData();

        $info = $this->session->get('repair_add_error');
        $this->session->put('repair_add_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['form_url'] = genereteURL('repair_add', array('id' => $vehicle_id));
        $this->view->setTitle($vehicle->getBrandModel() . ' - ' . trans('repair_add'));
        $this->view->header('style5');
        $this->loadDataPicker();
        $this->view->renderView('home/garage/repair_add', $array);
        $this->view->footer();
    }

    public function repair_add_form($vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle_id = intval(abs($vehicle_id));

        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }
        $_POST['vehicle_id'] = $vehicle_id;
        $_POST['price'] = convertCurrency($_POST['price']);

        $vehicle_sqliteId = isset($_POST['vehicle_sqliteId']) ? $_POST['vehicle_sqliteId'] : -1;
        $sqliteId = isset($_POST['sqliteId']) ? $_POST['sqliteId'] : -1;
        unset($_POST['id']);
        unset($_POST['gcm']);
        unset($_POST['token']);
        unset($_POST['vehicle_sqliteId']);
        unset($_POST['sqliteId']);

        $v = new Validator($this->database);

        $rules = array(
            'vehicle_id' => 'int',
            'date_repair' => 'required|date',
            'price' => 'number'
        );

        $v->validate(array_intersect_key($_POST, $rules), $rules);

        if ($v->passes()) {
            $_POST['ip'] = ip2long(get_client_ip());

            $workshopRepository = new RepositoryWorkshop($this->database);
            $workshop = $workshopRepository->findByParams('title', $_POST['workshop']);
            if ($workshop->getID() > 0) {
                $_POST['workshop_id'] = $workshop->getID();
            } else {
                $workshop->setTitle($_POST['workshop']);
                $_POST['workshop_id'] = $workshop->insert();
            }

            $vehicleRepair = new VehicleRepair;
            $vehicleRepair->loadFromArray($_POST);
            $vehicleRepair->insert();

            $vehicle->setTotalExpenses($vehicle->getTotalExpenses() + $_POST['price']);
            $vehicle->update();
            $array['succes'] = array(trans('repair_add_success'));
            $this->redirect(genereteURL('vehicle_info', array('alias' => $vehicle->getAlias(), 'id' => $vehicle->getID())));
        } else {
            $array = $_POST;
            $array['error'] = $v->errors()->all();
            $this->session->set('repair_add_error', serialize($array));
            $this->redirect(genereteURL('repair_add', array('id' => $vehicle_id)));
        }
    }

    public function repair_delete($refuel_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicleRepair = new VehicleRepair($refuel_id);
        $vehicleInfo = $vehicleRepair->getVehicle();
        if ($vehicleInfo->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }
        $vehicleInfo->setTotalExpenses($vehicleInfo->getTotalExpenses() - $vehicleRepair->getPrice());
        $vehicleRepair->delete();
        $vehicleInfo->update();
        $this->redirect(genereteURL('vehicle_info', array('alias' => $vehicleInfo->getAlias(), 'id' => $vehicleInfo->getID())));
    }

    public function loadDataPicker() {
        $this->view->jsPush('https://code.jquery.com/ui/1.12.0/jquery-ui.js');
        $this->view->jsPush('js/date_picker.js', true);
        $this->view->cssPush('http://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css');
    }

    public function vehicle_refuel_info($alias, $vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $array = array();
        $info = $this->session->get('vehicle_info_error');
        $this->session->put('vehicle_info_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['vehicle'] = $vehicle;
        $array['vehicleRefuels'] = $vehicle->getVehicleRefuelAll()->loadFromArray();
        $this->view->setTitle(trans('refuel_list') . ' ' . $vehicle->getBrandModel());
        $this->view->header('style5');
        $this->view->renderView('home/garage/vehicle_refuel_info', $array);
        $this->view->footer();
    }

    public function vehicle_repair_info($alias, $vehicle_id) {
        if (!Auth::isAuth()) {
            $this->session->set('login_error', serialize(array(trans('login_error_default'))));
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $array = array();
        $info = $this->session->get('vehicle_info_error');
        $this->session->put('vehicle_info_error', '');
        if (!empty($info)) {
            $array = unserialize($info);
        }
        $array['vehicle'] = $vehicle;
        $array['vehicleRepairs'] = $vehicle->getVehicleRepair(-1)->loadFromArray();
        $this->view->setTitle(trans('repair_list') . ' ' . $vehicle->getBrandModel());
        $this->view->header('style5');
        $this->view->renderView('home/garage/vehicle_repair_info', $array);
        $this->view->footer();
    }

}
