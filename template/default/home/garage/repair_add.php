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
                            <label><?= trans('workshop') ?></label>
                            <input name="workshop" class="form-control" type="text" placeholder="<?= trans('workshop') ?>" value="<?= isset($workshop) ? $workshop : "" ?>">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('repair_price') ?></label>
                            <input name="price" class="form-control price" type="text" placeholder="<?= trans('repair_price') ?>" value="<?= isset($price) ? $price : "" ?>">
                        </div>
                        <div class="col-xs-12 col-sm-6 margin-bottom-10">
                            <label><?= trans('repair_date') ?></label>
                            <input id="datepicker" name="date_repair" class="form-control" type="text" placeholder="<?= trans('repair_date') ?>" value="<?= isset($date_repair) ? $date_repair : "" ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <label><?= trans('repair_description') ?></label>
                            <textarea name="description" class="form-control" placeholder="<?= trans('repair_description') ?>"><?= isset($description) ? $description : "" ?></textarea>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-xs-12">
                            <input class="btn btn-primary" type="submit" value="<?= trans('repair_add') ?>">
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