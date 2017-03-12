<!-- page banner -->

<header class="page-banner small">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="holder">
                    <h1 class="heading text-uppercase"><?php
                        if (isset($vehicle_id) && $vehicle_id > 0) {
                            print trans('vehicle_edit_form');
                        } else {
                            print trans('button_add_vehicle');
                        }
                        ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="stretch">
        <img src="<?= HTTP_SERVER; ?>/images/car_background.jpg" alt="image description">
    </div>
</header>
<div class="container padding-bottom-100 padding-top-100">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
            <?
            include(dirname(__FILE__)."/../../message_alert.php");
            ?>
            <form action="<?= $form_url ?>" class="update-form" method="POST">
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('vehicle') ?></label>
                            <select name="vehicle_id" data-jcf='{"wrapNative": false}'>
                                <option><?= trans('vehicle_select') ?></option>
                                <?php
                                foreach ($vehicles as $k => $vehicle) {
                                    $select = ($vehicle_id == $vehicle->getID()) ? ' selected' : '';
                                    print '<option' . $select . '>' . $vehicle->getID() . ' - ' . $vehicle->getBrandModel() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('refuel_date') ?> *</label>
                            <input id="datepicker" name="date_tank" class="form-control" type="text" placeholder="<?= trans('refuel_date') ?> *" value="<?= isset($date_tank) ? $date_tank : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('mileage_per_tank') ?> *</label>
                            <input name="distance" class="form-control price" type="text" placeholder="<?= trans('mileage_per_tank') ?> *" value="<?= isset($distance) ? $distance : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('total_galon') ?> *</label>
                            <input name="galon" class="form-control price" type="text" placeholder="<?= trans('total_galon') ?> *" value="<?= isset($galon) ? $galon : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('total_price') ?></label>
                            <input name="price" class="form-control price" type="text" placeholder="<?= trans('total_price') ?>" value="<?= isset($price) ? $price : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('price_per_galon') ?></label>
                            <input name="price_per_galon" class="form-control price" type="text" placeholder="<?= trans('price_per_galon') ?>" value="<?= isset($price_per_galon) ? $price_per_galon : "" ?>">
                        </div>

                    </div>
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <input class="btn btn-primary" type="submit" value="<?= trans('refuel_add') ?>">
                        </div>
                    </div>
                </fieldset>
            </form>						

        </div>
        <?
        include("left_menu.php");
        ?>
    </div>
</div>