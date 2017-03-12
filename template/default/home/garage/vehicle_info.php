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

            <a href="<?= genereteURL('vehicle_edit', array('id' => $vehicle->getID())) ?>" class="btn btn-warning"><?= trans('vehicle_button_edit') ?></a>
            <a href="<?= genereteURL('vehicle_remove', array('id' => $vehicle->getID())) ?>" class="btn btn-danger"><?= trans('vehicle_button_remove') ?></a>
            <a href="<?= genereteURL('vehicle_add_photo', array('vehicle_id' => $vehicle->getID())) ?>" class="btn btn-info"><?= trans('gallery') ?></a>

            <div class="row">
                <div class="col-xs-12">
                    <h2 class="heading-v5 text-uppercase"><span><?= $vehicle->getBrandModel() ?></span></h2>
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

                    <div class="row facts-section">
                        <div class="col-xs-12 col-sm-4 box">

                            <div class="counter">
                                <span class="num-counter num" data-from="0" data-to="<?= $vehicle->getTotalMileage(); ?>" data-refresh-interval="80" data-speed="3000" data-comma="true">15</span>
                            </div>
                            <p><?= trans('vehicle_total_mileage') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 box">

                            <div class="counter">
                                <span class="num-counter num" data-from="0" data-to="<?= $vehicle->getTotalRefuel(); ?>" data-refresh-interval="80" data-speed="3000" data-comma="true">150</span>
                            </div>
                            <p><?= trans('vehicle_total_galon') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 box">

                            <div class="counter">
                                <span class="num-counter num" data-from="0" data-to="<?= $vehicle->getTotalExpenses(); ?>" data-refresh-interval="80" data-speed="3000" data-comma="true">20</span>
                            </div>
                            <p><?= trans('vehicle_total_expenses') ?></p>
                        </div>
                    </div>

                    <h3><?= trans('refuel_list_last') ?> <a href="<?= genereteURL('refuel_add', array('id' => $vehicle->getID())) ?>" type="button" class="btn btn-link">Dodaj tankowanie</a></h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= trans('refuel_date') ?></th>
                                    <th><?= trans('mileage') ?></th>
                                    <th><?= trans('galons') ?></th>
                                    <th><?= trans('expenses') ?></th>
                                    <th><?= trans('repair_average') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $total = $totalVehicleRefuels = $vehicle->getVehicleRefuel()->getCount();
                                foreach ($vehicle->getVehicleRefuel()->loadFromArray() as $k => $refuel) {
                                ?>
                                <tr>
                                    <td><?= $total-- ?></td>
                                    <td><?= $refuel['date_tank'] ?></td>
                                    <td><?= $refuel['distance'] ?></td>
                                    <td><?= sprintf(trans('galon_format'), $refuel['galon']) ?></td>
                                    <td><?= sprintf(trans('currency_format'), $refuel['price']) ?></td>
                                    <td><?= sprintf(trans('galon_format'), $refuel['average_consumption']) ?> / <?= sprintf(trans('currency_format'), $refuel['price_per_galon']) ?></td>
                                    <td><a href="<?= genereteURL('refuel_delete', array('id' => $refuel['id'])) ?>" type="button" class="btn btn-danger">usuń</a></td>
                                </tr>
                                <?
                                }
                                ?>
                                <tr>
                                    <? if ($totalVehicleRefuels>1) { ?>
                                    <td colspan="9" style="text-align: right;"><a href="<?= genereteURL('vehicle_refuel_info', array('id' => $vehicle->getID(), 'alias' => $vehicle->getAlias())) ?>" type="button" class="btn btn-history"><?= trans('show_more') ?></a></td>
                                    <? } ?>
                                </tr>
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
                                $total = $totalVehicleRepairs = $vehicle->getVehicleRepair()->getCount();
                                foreach ($vehicle->getVehicleRepair()->loadFromArray() as $k => $repair) {
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
                                <? if ($totalVehicleRepairs>1) { ?>
                                <tr>
                                    <td colspan="9" style="text-align: right;"><a href="<?= genereteURL('vehicle_repair_info', array('id' => $vehicle->getID(), 'alias' => $vehicle->getAlias())) ?>" type="button" class="btn btn-history"><?= trans('show_more') ?></a></td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="wedding-photos holder" id="masonry-container">
                        <?
                        $total = $vehicle->getPhotos()->getCount();
                        print $total;
                        foreach ($vehicle->getPhotos()->loadFromArray() as $photo) {
                        $image = HTTP_SERVER .'/uploads/'. $photo['path'].$photo['filename'];
                        $image_org = HTTP_SERVER .'/uploads/'. $photo['path'].'org/'.$photo['filename'];
                        ?>
                        <div class="box item">
                            <img src="<?= $image ?>" class="img-responsive">
                            <div class="over">
                                <a href="<?= $image_org ?>" class="lightbox"><i class="fa fa-search-plus"></i></a>
                            </div>
                        </div>

                        <?
                        }
                        ?>
                    </div>

                </div>
            </div>


        </div>
        <?
        include("left_menu.php");
        ?>
    </div>
</div>