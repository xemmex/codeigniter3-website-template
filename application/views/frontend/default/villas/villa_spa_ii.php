<section id="main">
    <div class="wrapper">
        <h2><?= tr ( '_PAGE_VILLAS_VILLA_SPA_II_title_' ); ?></h2>
	<?= tr ( '_PAGE_VILLAS_VILLA_SPA_II_text_' ); ?>

        <div class="sep mt20"><span></span></div>

        <h3><?= tr ( '_PAGE_VILLAS_links_' ); ?></h3>
        <ul class="links">
            <li><h5><a href="http://villascomfort.com/en/properties/?titulo=VillaSpa#listing-container"><?= tr ( '_MENU_reservation_' ); ?></a></h5></li>
            <li><h5><a href="<?= frontend_url ( array( 'contact' ) ); ?>"><?= tr ( '_MENU_contact_' ); ?></a></h5></li>
        </ul>
    </div>
</section>
<?php $this->template->widget ( 'footer' ); ?>
<?php $this->template->widget ( 'gallery', 'gallery_model', 'get_gallery', 3, 'gallery' ); ?>