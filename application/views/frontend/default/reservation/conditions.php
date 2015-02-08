<section id="main">
    <div class="wrapper">
        <h2><?= tr ( '_PAGE_RESERVATION_CONDITIONS_title_' ); ?></h2>
	<?= tr ( '_PAGE_RESERVATION_CONDITIONS_text_' ); ?>
    </div>
</section>
<?php $this->template->widget ( 'footer' ); ?>
<?php $this->template->widget ( 'gallery', 'gallery_model', 'get_one', 4, 'image' ); ?>