<div class="panorama tour">
    <div class="preloader"></div>
    <div class="panorama-view">
        <div class="panorama-container" id="panorama-tour">
            <noscript>
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="100%" id="panoramatour">
                <param name="movie" value="<?= $this->template->path ( 'assets' ); ?>js/tour/tour.swf"/>
                <param name="allowFullScreen" value="true"/>
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="tourdata/tour.swf" width="100%" height="100%">
                    <param name="movie" value="<?= $this->template->path ( 'assets' ); ?>js/tour/tour.swf"/>
                    <param name="allowFullScreen" value="true"/>
                    <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflash">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>
                    </a>
                    <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
            </noscript>
        </div>
    </div>
</div>
<?php $this->template->widget ( 'gallery', 'gallery_model', 'get_gallery', 4, 'gallery_no_zoom' ); ?>