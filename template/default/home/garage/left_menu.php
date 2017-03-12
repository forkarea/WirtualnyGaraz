<aside class="col-xs-12 col-sm-4 col-md-3 col-sm-pull-8 col-md-pull-9">
    <!-- widget -->
    <section class="widget cate-widget">
        <h2><?= trans('user_panel'); ?></h2>
        <ul class="list-unstyled">
            <li><a href="<?= genereteURL('garage'); ?>"><i class="fa fa-caret-right"></i> <?= trans('vehicle_list') ?></a></li>
            <li><a href="<?= genereteURL('profile_edit'); ?>"><i class="fa fa-caret-right"></i> <?= trans('user_edit_profile') ?></a></li>
            <li><a href="<?= genereteURL('user_logout'); ?>"><i class="fa fa-caret-right"></i> <?= trans('user_notify') ?></a></li>
            <li><a href="<?= genereteURL('user_logout'); ?>"><i class="fa fa-caret-right"></i> <?= trans('logout') ?></a></li>
        </ul>
    </section>
    <!-- widget -->
    <section class="widget video-widget">
        <h2>Ads</h2>
        <div class="video-area">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/1sfuxvwHBnY" frameborder="0" allowfullscreen></iframe>
        </div>
    </section>
</aside>