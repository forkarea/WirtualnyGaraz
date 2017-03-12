<!-- app mainbanner -->
<section class="app-mainbanner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 holder">
                <h1><?= trans('homepage_h1') ?></h1>
                <form action="<?= genereteURL('user_register'); ?>" class="signup-form" method="post">
                    <fieldset>
                        <div class="frame">
                            <input name="first_name" type="text" placeholder="<?= trans('first_name') ?> *" required>
                            <input name="mail" type="email" placeholder="<?= trans('mail') ?> *" required>
                            <input name="password" type="password" placeholder="<?= trans('password') ?> *" required>
                            <input name="password_repeat" type="password" placeholder="<?= trans('password_repeat') ?> *" required>
                        </div>
                        <button class="btn btn-submit">Załóż konto</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="stretch">
        <img alt="image description" src="<?= HTTP_SERVER; ?>/images/car_background.jpg" data-animate="fadeInUpRight" data-delay="300">
    </div>
</section>
<!-- section -->
<section class="container padding-top-90 padding-bottom-90" id="section1">
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <!-- page heading -->
            <header class="page-heading left-align">
                <div class="col-xs-12 col-sm-10">
                    <h2 class="lime text-capitalize font-medium margin-bottom-20"><?= trans('app_about_header') ?></h2>
                    <p><?=trans('app_info')?></p>
                </div>
            </header>
            <ul class="list-unstyled margin-zero">
                <!-- f iconbox -->
                <li class="f-iconbox margin-bottom-30">
                    <span class="icon"><i class="fa fa-bars"></i></span>
                    <strong class="title"><?=trans('app_info_info1_label')?></strong>
                    <p><?=trans('app_info_info1')?></p>
                </li>
                <!-- f iconbox -->
                <li class="f-iconbox margin-bottom-30">
                    <span class="icon"><i class="fa fa-money"></i></span>
                    <strong class="title"><?=trans('app_info_info2_label')?></strong>
                    <p><?=trans('app_info_info2')?></p>
                </li>
                <!-- f iconbox -->
                <li class="f-iconbox margin-bottom-30">
                    <span class="icon"><i class="fa fa-eye"></i></span>
                    <strong class="title"><?=trans('app_info_info3_label')?></strong>
                    <p><?=trans('app_info_info3')?></p>
                </li>
            </ul>
        </div>
        <div class="col-sm-4 col-xs-12 hidden-sm hidden-xs">
            <img src="<?= HTTP_SERVER; ?>/images/img02.png" alt="image description" class="img" data-animate="fadeInRight" data-delay="250">
        </div>
    </div>
</section>
<!-- testimon section -->
<div class="testimon-section padding-top-100 padding-bottom-100" id="section2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span class="icon"><i class="fa fa-quote-left"></i></span>
                <div class="beans-slider" data-rotate="true">
                    <div class="beans-mask">
                        <div class="beans-slideset">
                            <!-- beans-slide 1 -->
                            <div class="beans-slide">
                                <blockquote>
                                    <q>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus Nam libero tempore, cum soluta nobis est eligendi optio.</q>
                                </blockquote>
                            </div>
                            <!-- beans-slide 2 -->
                            <div class="beans-slide">
                                <blockquote>
                                    <q>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus Nam libero tempore, cum soluta nobis est eligendi optio.</q>
                                </blockquote>
                            </div>
                            <!-- beans-slide 3 -->
                            <div class="beans-slide">
                                <blockquote>
                                    <q>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus Nam libero tempore, cum soluta nobis est eligendi optio.</q>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <div class="beans-pagination">
                        <!-- pagination generated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- parallax-holder -->
    <div class="parallax-holder">
        <div class="parallax-frame"><img src="<?= HTTP_SERVER; ?>/images/people.jpg" height="800" width="1920" alt="image description"></div>
    </div>
</div>
<!-- work section -->
<section class="work-section bg-grey padding-top-90 padding-bottom-90" id="section4">
    <!-- page heading -->
    <header class="page-heading">
        <h2 class="lime text-capitalize font-medium margin-bottom-20"><?= trans('app_our_car') ?></h2>
        <p></p>
    </header>
    <!-- beans-stepslider -->
    <div class="beans-stepslider work-slider" data-rotate="true">
        <div class="beans-mask">
            <div class="beans-slideset">
                <!-- beans-slide 1 -->
                <div class="beans-slide">
                    <!-- portfolio block nospace style4 -->
                    <div class="portfolio-block nospace style4">
                        <!-- box -->
                        <div class="box">
                            <div class="over">
                                <a href="<?= HTTP_SERVER; ?>/images/img04.jpg" class="search lightbox"><i class="fa fa-search"></i></a>
                                <a href="portfolio-single-image.html" class="link"><i class="fa fa-link"></i></a>
                            </div>
                            <img src="<?= HTTP_SERVER; ?>/images/img04.jpg" alt="image description">
                        </div>
                    </div>
                </div>
                <!-- beans-slide 2 -->
                <div class="beans-slide">
                    <!-- portfolio block nospace style4 -->
                    <div class="portfolio-block nospace style4">
                        <!-- box -->
                        <div class="box">
                            <div class="over">
                                <a href="<?= HTTP_SERVER; ?>/images/img05.jpg" class="search lightbox"><i class="fa fa-search"></i></a>
                                <a href="portfolio-single-image.html" class="link"><i class="fa fa-link"></i></a>
                            </div>
                            <img src="<?= HTTP_SERVER; ?>/images/img05.jpg" alt="image description">
                        </div>
                    </div>
                </div>
                <!-- beans-slide 3 -->
                <div class="beans-slide">
                    <!-- portfolio block nospace style4 -->
                    <div class="portfolio-block nospace style4">
                        <!-- box -->
                        <div class="box">
                            <div class="over">
                                <a href="<?= HTTP_SERVER; ?>/images/img06.jpg" class="search lightbox"><i class="fa fa-search"></i></a>
                                <a href="portfolio-single-image.html" class="link"><i class="fa fa-link"></i></a>
                            </div>
                            <img src="<?= HTTP_SERVER; ?>/images/img06.jpg" alt="image description">
                        </div>
                    </div>
                </div>
                <!-- beans-slide 4 -->
                <div class="beans-slide">
                    <!-- portfolio block nospace style4 -->
                    <div class="portfolio-block nospace style4">
                        <!-- box -->
                        <div class="box">
                            <div class="over">
                                <a href="<?= HTTP_SERVER; ?>/images/img07.jpg" class="search lightbox"><i class="fa fa-search"></i></a>
                                <a href="portfolio-single-image.html" class="link"><i class="fa fa-link"></i></a>
                            </div>
                            <img src="<?= HTTP_SERVER; ?>/images/img07.jpg" alt="image description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container padding-top-30">
            <a class="btn-next" href="#"><i class="fa fa-angle-right"></i></a>
            <a class="btn-prev" href="#"><i class="fa fa-angle-left"></i></a>
            <a class="btn btn-dark pull-left" href="#"><?= trans('show_more') ?></a>
        </div>
    </div>
</section>