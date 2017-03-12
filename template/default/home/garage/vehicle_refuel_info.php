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
                                $total = count($vehicleRefuels);
                                foreach ($vehicleRefuels as $k => $refuel) {
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