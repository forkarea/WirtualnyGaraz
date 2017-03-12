
<!-- page banner -->
<header class="page-banner">
    <div class="stretch">
        <img alt="image description" src="<?= HTTP_SERVER; ?>/images/car_background.jpg" >
    </div>
    <div class="container">
        <div class="row">
        </div>
    </div>
</header>
<div class="container padding-bottom-100 padding-top-100">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-9 col-sm-push-4 col-md-push-3">

            <form action="<?= $form_url ?>" class="update-form" method="POST">
    <fieldset>
        <!-- page heading -->
        <header class="page-heading">
            <div class="heading">
                <h2 class="heading5 lime text-uppercase font-medium"><?= $form_title; ?></h2>
            </div>
        </header>
<?
	include(dirname(__FILE__)."/../message_alert.php");
?>
        <input name="first_name" type="text" placeholder="<?= trans('first_name') ?> *" value="<?= !empty($first_name) ? $first_name : ""; ?>" class="form-control" required>											
        <input name="mail" type="email" placeholder="<?= trans('mail') ?> *" class="form-control" value="<?= !empty($mail) ? $mail : ""; ?>" required>
        <input name="password" type="password" placeholder="<?= trans('password') ?> *" class="form-control" required>
        <input name="password_repeat" type="password" placeholder="<?= trans('password_repeat') ?> *" class="form-control" required>
		<input type="submit" value="<?= trans('save_changes'); ?>" class="btn btn-f-info">
    </fieldset>
</form>
        </div>
<? 
	include("garage/left_menu.php");
?>
    </div>
</div>