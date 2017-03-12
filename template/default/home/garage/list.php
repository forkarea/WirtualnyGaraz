<!-- page banner -->

<header class="page-banner small">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="holder">
                    <h1 class="heading text-uppercase"><?= trans('vehicle_list') ?></h1>
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
            <div class="row padding-bottom-30">				
                <a href="<?= genereteURL('vehicle_add') ?>" class="btn btn-primary"><?= trans('button_add_vehicle') ?></a>
            </div>
            <? foreach ($vehicles as $key => $vehicle) {
            //[0]->getFilename());
            $image = (!empty($vehicle->getPhotos()->getFilename())) ? HTTP_SERVER .'/uploads/'. $vehicle->getPhotos()->getPath().$vehicle->getPhotos()->getFilename() : "http://placehold.it/200x150";
            //print 'dsdsadas';
            ?>
            <article class="row padding-bottom-30">
                <div class="col-xs-12 col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">
                    <h3><a href="<?= genereteURL('vehicle_info', array('id' => $vehicle->getID(), 'alias' => $vehicle->getAlias())) ?>"><?= $vehicle->getBrandModel() ?></a></h3>
                    <ul class="breadcrumbs list-inline">
                        <li><?= $vehicle->getColour() ?></li>
                        <li><?= $vehicle->getEngineFuel() ?></li>
                        <li><?= $vehicle->getYear() ?></li>
                        <li><?= $vehicle->getPower() ?> KM</li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
                    <img src="<?= $image; ?>" alt="<?= $vehicle->getBrandModel() ?>" class="img-responsive"/>
                </div>
            </article>
            <?
            }
            ?>							

            <ul class="pagination">
                <?= $paginator->paginate() ?>
            </ul>

        </div>
        <?
        include("left_menu.php");
        ?>
    </div>
</div>