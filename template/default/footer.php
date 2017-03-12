</main>
<!-- footer of the page -->
<footer id="footer" class="style26">
    <!-- footer app -->
    <div class="footer-app bg-shark">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- bottom box3 -->
                    <div class="bottom-box3">
                        <div class="logo"><a href="<?= HTTP_SERVER ?>"><img src="<?= $default_url; ?>images/logo.png" height="49" width="90" alt="fekra"></a></div>
                        <!-- f info box -->
                        <div class="f-info-box">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 counter-box">
                                    <span class="num">250.250</span>
                                    <p>POBRAŃ</p>
                                </div>
                                <div class="col-xs-12 col-sm-3 counter-box">
                                    <span class="num">16.258</span>
                                    <p>POJAZDÓW</p>
                                </div>
                                <div class="col-xs-12 col-sm-3 counter-box">
                                    <span class="num">10.258.202</span>
                                    <p>UŻYTKOWNIKÓW</p>
                                </div>
                                <div class="col-xs-12 col-sm-3 counter-box">
                                    <span class="num">380.950</span>
                                    <p>GOŚCI</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer bottom -->
    <div class="footer-bottom bg-dark-jungle">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- bottom box1 -->
                    <div class="bottom-box1">
                        <!-- footer nav -->
                        <ul class="list-inline footer-nav">
                            <li class="active"><a href="<?= HTTP_SERVER ?>">Home</a></li>
                            <li><a href="#"><?= \PioCMS\Engine\Language::trans('app_about_header') ?></a></li>
                            <li><a href="#">Career</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Use of terms</a></li>
                        </ul>
                        <span class="copyright">&copy; 2015 <a href="#">WirutalnyGaraz.pl</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<div class="fa fa-chevron-up" id="gotoTop" style="display: none;"></div>
</div>
<?
foreach ($_js as $key => $js) {
	print '<script type="text/javascript" src="'.$js.'"></script>'."\n";
}
?>
</body>
</html>