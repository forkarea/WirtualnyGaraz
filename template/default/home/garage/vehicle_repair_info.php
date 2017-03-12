<!-- page banner -->
<header class="page-banner small">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="holder">
                    <h1 class="heading text-uppercase"><?= $vehicle->getBrandModel() ?></h1>
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
        <div class="col-xs-12 col-sm-9 col-sm-push-3">
            <?
            include(dirname(__FILE__)."/../../message_alert.php");
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <a href="<?= genereteURL('vehicle_info', array('id' => $vehicle->getID(), 'alias' => $vehicle->getAlias())) ?>"><h2 class="heading-v5 text-uppercase"><span><?= $vehicle->getBrandModel() ?></span></h2></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumbs list-inline">
                        <li><?= $vehicle->getColour() ?></li>
                        <li><?= $vehicle->getEngineFuel() ?></li>
                        <li><?= $vehicle->getYear() ?></li>
                        <li><?= $vehicle->getPower() ?> KM</li>
                    </ul>

                    <div class="divider-line1"></div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td colspan="6"><h3><?= trans('repair_list_last') ?> <a href="<?= genereteURL('repair_add', array('id' => $vehicle->getID())) ?>" type="button" class="btn btn-link">Dodaj naprawę</a></h3></td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th colspan="3"><?= trans('workshop') ?></th>
                                    <th><?= trans('repair_date') ?></th>
                                    <th><?= trans('repair_price') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>


                                <?
                                $total = count($vehicleRepairs);
                                foreach ($vehicleRepairs as $k => $repair) {
                                ?>
                                <tr>
                                    <td><?= $total-- ?></td>
                                    <td colspan="3"><?= stripslashes($repair['workshop']['title']) ?></td>
                                    <td><?= $repair['date_repair'] ?></td>
                                    <td><?= sprintf(trans('currency_format'), $repair['price']) ?></td>
                                    <td><!--<a type="button" class="btn btn-info">szczegóły</a> --><a href="<?= genereteURL('repair_delete', array('id' => $refuel['id'])) ?>" type="button" class="btn btn-danger">usuń</a></td>
                                </tr>
                                <?
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
        <?
        include("left_menu.php");
        ?>
    </div>
</div>