<?php

namespace PioCMS\Controllers;

use PioCMS\Models\Repository\RepositoryVehicleGallery;
use PioCMS\Models\Auth;
use PioCMS\Models\Vehicle;
use PioCMS\Models\VehicleGallery;
use Intervention\Image\ImageManagerStatic as Image;

class Gallery extends Controller {

    public function vehicle_gallery_add($vehicle_id) {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> Auth::getUserID()) {
            $this->redirect(genereteURL('garage'));
        }

        $array = array();
        $info = $this->session->get('vehicle_gallery_add_error');
        $this->session->put('vehicle_gallery_add_error', '');
        if (!empty($info)) {
            $array += unserialize($info);
        }

        $repository = new RepositoryVehicleGallery($this->database);
        $photos = $repository->criteria(array('orderby' => array(VehicleGallery::$tableName . '.id', 'DESC'), 'where' => array(VehicleGallery::$tableName . '.vehicle_id', $vehicle_id)))->getAll();

        $array['total_photos'] = $repository->getCount();
        $array['photos'] = $photos;
        $array['vehicle'] = $vehicle;

        $this->view->jsPush('js/dropzone.js', true);
        $this->view->jsPush('js/del_photo.js', true);
        $this->view->cssPush('css/dropzone.css', true);
        $this->view->setTitle(trans('gallery') . ' - ' . $vehicle->getBrandModel());
        $this->view->header('style5');
        $this->view->renderView('home/garage/gallery', $array);
        $this->view->footer();
    }

    public function photo_post() {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }
        if (!isset($_POST['id']) || intval(abs($_POST['id'])) == 0) {
            header("HTTP/1.0 400 Bad Request");
            die(json_encode(array('brak id!')));
        }
        $user_id = Auth::getUserID();
        $vehicle_id = intval(abs($_POST['id']));
        $vehicle = new Vehicle($vehicle_id);
        if ($vehicle->getUser_id() <> $user_id) {
            header("HTTP/1.0 400 Bad Request");
            die(json_encode(array('to nie twoje!')));
        }
        $path = 'gallery/' . $user_id . '/';
        $directory = DIR_UPLOAD . $path;

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if (!file_exists($directory . '/org')) {
            mkdir($directory . '/org', 0777, true);
        }


        $storage = new \Upload\Storage\FileSystem($directory . '/org');
        $file = new \Upload\File('file', $storage);

        $new_filename = uniqid();
        $file->setName($new_filename);

        $file->addValidations(array(
            new \Upload\Validation\Mimetype(array('image/png', 'image/gif', 'image/jpeg', 'image/jpg', 'image/bmp')),
            new \Upload\Validation\Size('10M')
        ));

        $data1 = array(
            'name' => $file->getNameWithExtension(),
            'extension' => $file->getExtension(),
            'mime' => $file->getMimetype(),
            'size' => $file->getSize(),
            'md5' => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        try {
            $file->upload();
            $photo = new VehicleGallery();
            $photo->setVehicle_id($vehicle_id);
            $photo->setFilename($file->getNameWithExtension());
            $photo->setPath($path);
            $photo_id = $photo->insert();

            $image = Image::make($directory . 'org/' . $file->getNameWithExtension())->fit(200, 150);
            $image->save($directory . $file->getNameWithExtension());
            header("HTTP/1.1 200 OK");
            $data['name'] = $file->getNameWithExtension();
            $data['id'] = $photo_id;
        } catch (\Exception $e) {
            header("HTTP/1.0 400 Bad Request");
            $data[] = $file->getErrors();
        }

        print json_encode($data);
        exit;
    }

    public function photo_delete() {
        if (!Auth::isAuth()) {
            $this->redirect(genereteURL('user_login'));
        }
        if (!isset($_POST['id']) || intval(abs($_POST['id'])) == 0) {
            header("HTTP/1.0 400 Bad Request");
            die(json_encode(array('brak id!')));
        }

        $photo = new VehicleGallery(intval(abs($_POST['id'])));
        if ($photo->getID() == 0) {
            die(json_encode(array('brak id!')));
        }

        $vehicle = new Vehicle($photo->getVehicle_id());
        if ($vehicle->getUser_id() == Auth::getUserID()) {
            $path = $photo->getPath();
            $directory = DIR_UPLOAD . $path . '/';

            if ($photo->delete()) {
                unlink($directory . $photo->getFilename());
                unlink($directory . 'org/' . $photo->getFilename());
            }
        }
    }

}
