<header class="page-banner">
    <div class="stretch">
        <img alt="image description" src="<?= HTTP_SERVER; ?>/images/car_background.jpg" >
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="holder">
                    <h1 class="heading">404</h1>
                    <p><?= trans('error_404') ?></p>
                </div>
                <ul class="breadcrumbs list-inline">
                    <li><a href="#">HOME</a></li>
                    <li class="active"><a href="#">404</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="container lost-block">
    <div class="row">
        <div class="col-xs-12">
            <h2><?= trans('error'); ?><br /><span>404</span></h2>
            <a href="<?= HTTP_SERVER ?>" class="btn btn-back"><i class="fa fa-home"></i> <?= trans('homepage'); ?></a>
        </div>
    </div>
</div>