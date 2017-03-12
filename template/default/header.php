<?php
use PioCMS\Models\Auth;
//include '/home/pionas/ftp/wirtualnygaraz/App/Models/Auth.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title; ?></title>
        <link rel="shortcut icon" href="<?= $default_url; ?>images/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= $default_url; ?>images/favicon/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= $default_url; ?>images/favicon/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= $default_url; ?>images/favicon/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= $default_url; ?>images/favicon/apple-touch-icon-144x144.png">
        <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic%7CPlayfair+Display:400,400italic,700,700italic,900,900italic%7CRoboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900%7CRaleway:400,100,200,300,500,600,700,800,900%7CGreat+Vibes%7CPoppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
<?
foreach ($_css as $key => $css) {
	print "\t\t".'<link rel="stylesheet" href="'.$css.'">'."\n";
}
?>
    </head>
    <body>

        <!-- Page pre loader -->
        <div id="pre-loader">
            <div class="loader-holder">
                <div class="frame">
                    <img src="<?= $default_url; ?>images/preloader/logo.png" alt="Fekra"/>
                    <div class="spinner7">
                        <div class="circ1"></div>
                        <div class="circ2"></div>
                        <div class="circ3"></div>
                        <div class="circ4"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main container of all the page elements -->
        <div id="wrapper">
            <div class="w1">
                <!-- header of the page -->
                <header id="header" class="<?= $header_style ?>">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- page logo -->
                                <div class="logo">
                                    <a href="<?= HTTP_SERVER ?>">
                                        <img src="<?= $default_url; ?>images/logo.png" alt="Fekra" class="img-responsive w-logo">
                                        <img src="<?= $default_url; ?>images/logo-2.png" alt="Fekra" class="img-responsive b-logo">
                                    </a>
                                </div>
                                <!-- main navigation of the page -->
                                <nav id="nav">
                                    <a href="#" class="nav-opener">
                                        <span class="txt">Menu</span>
                                        <i class="fa fa-bars"></i>
                                    </a>
                                    <div class="nav-holder">
                                        <ul class="list-inline nav-top">
                                            <li><a class="smoothanchor" href="<?= HTTP_SERVER ?>/#wrapper">Home</a></li>
                                            <li><a class="smoothanchor" href="<?= HTTP_SERVER ?>/#section1"><?= trans('app_about_header') ?></a></li>
                                            <li><a class="smoothanchor" href="<?= HTTP_SERVER ?>/#section2"><?= trans('app_about_us') ?></a></li>
                                            <li><a class="smoothanchor" href="<?= HTTP_SERVER ?>/#section4"><?= trans('gallery') ?></a></li>
                                            <? if (!Auth::isAuth()) { ?>
                                            <li><a class="smoothanchor" href="<?= genereteURL('user_login'); ?>"><?= trans('login') ?></a></li>
                                            <? } else { ?>
                                            <li><a class="smoothanchor" href="<?= genereteURL('garage'); ?>"><?= trans('my_account') ?></a></li>
                                            <li><a class="smoothanchor" href="<?= genereteURL('user_logout'); ?>"><?= trans('logout') ?></a></li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- contain main informative part of the site -->
                <main id="main">