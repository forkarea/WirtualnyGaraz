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
            <form action="<?= $form_url ?>" class="contact-form2" method="POST">
                <?php
                if (isset($vehicle_id) && $vehicle_id > 0) {
                    print '<input type="hidden" name="id" value="' . $vehicle_id . '"/>';
                }
                ?>
                <fieldset>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('mark') ?></label>
                            <input name="mark" class="form-control" type="text" placeholder="<?= trans('mark') ?>*" value="<?= isset($mark) ? $mark : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('model') ?></label>
                            <input name="model" class="form-control" type="text" placeholder="<?= trans('model') ?> *" value="<?= isset($model) ? $model : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('car_type') ?></label>
                            <input name="car_type" class="form-control" type="text" placeholder="<?= trans('car_type') ?>" value="<?= isset($car_type) ? $car_type : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('year') ?></label>
                            <input name="year" class="form-control" type="text" placeholder="<?= trans('year') ?>" value="<?= isset($year) ? $year : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('engine') ?></label>
                            <input name="engine" class="form-control" type="text" placeholder="<?= trans('engine') ?>" value="<?= isset($engine) ? $engine : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('power') ?></label>
                            <input name="power" class="form-control" type="text" placeholder="<?= trans('power') ?>" value="<?= isset($power) ? $power : "" ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('fuel') ?></label>
                            <input name="fuel" class="form-control" type="text" placeholder="<?= trans('fuel') ?>" value="<?= isset($fuel) ? $fuel : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('colour') ?></label>
                            <input name="colour" class="form-control" type="text" placeholder="<?= trans('colour') ?>" value="<?= isset($colour) ? $colour : "" ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('transmission') ?></label>
                            <input name="transmission" class="form-control" type="text" placeholder="<?= trans('transmission') ?>" value="<?= isset($transmission) ? $transmission : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('doors') ?></label>
                            <input name="doors" class="form-control" type="text" placeholder="<?= trans('doors') ?>" value="<?= isset($doors) ? $doors : "" ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('mileage') ?></label>
                            <input name="mileage" class="form-control" type="text" placeholder="<?= trans('mileage') ?>" value="<?= isset($mileage) ? $mileage : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10 update-form">
                            <label><?= trans('unit') ?></label>
                            <select name="unit" data-jcf='{"wrapNative": false}'>
                                <?php
                                $units = array('km', 'mile');
                                foreach ($units as $unitInfo) {
                                    $select = ($unit == $unitInfo) ? ' selected' : '';
                                    print '<option' . $select . '>' . $unitInfo . '</option>';
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('date_purchase') ?></label>
                            <input id="datepicker" name="date_purchase" class="form-control" type="text" placeholder="<?= trans('date_purchase') ?>" value="<?= isset($date_purchase) ? $date_purchase : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('price') ?></label>
                            <input name="price" class="form-control" type="text" placeholder="<?= trans('price') ?>" value="<?= isset($price) ? $price : "" ?>">
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-xs-12">
                            <input class="btn btn-primary" type="submit" value="<?php
                                   if (isset($vehicle_id) && $vehicle_id > 0) {
                                       print trans('save_changes');
                                   } else {
                                       print trans('button_add_vehicle');
                                   }
                                   ?>">
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