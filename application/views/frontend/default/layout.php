<!doctype html>
<!--[if lte IE 7 ]>
<html class="ie7 oldie" dir="ltr" lang="<?= $this->settings_model->language['code']; ?>"><![endif]-->
<!--[if IE 8 ]>
<html class="ie8 oldie" dir="ltr" lang="<?= $this->settings_model->language['code']; ?>"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html dir="ltr" lang="<?= $this->settings_model->language['code']; ?>"><!--<![endif]-->
    <head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="<?= @$data['seo_description'] ?>">
	<meta name="keywords" content="<?= @$data['seo_keywords'] ?>">

	<!-- TITLE -->
	<title><?= @$data['seo_title'] ?></title>
	<!-- FAVICON -->
	<?= $this->template->favicon ( 'ico', 'favicon.ico' ) ?>
	<!-- CSS -->
	<?= $this->template->css ( 'style.min', '20141231' ) ?>
	<?= $this->template->css ( 'flags.min', '20141231' ) ?>
	<?= $css ?>
	<!--[if IE]>
	<?= $this->template->js ( 'ie.min', '20141231' ) ?>
	<![endif]-->
    </head>
    <body class="home no-js">

	<?php if ( !empty ( $this->settings_model->system['_seo_google_analytics_'] ) ) : ?>
    	<!-- GOOGLE ANALYTICS -->
	    <?= $this->settings_model->system['_seo_google_analytics_']; ?>
	<?php endif; ?>
	<!-- NAVBAR -->
	<?php $this->template->widget ( 'header' ); ?>
	<!-- CONTENT -->
	<?= $body ?>
	<!-- JS -->
	<script>var assets = '<?= $this->template->path ( 'assets' ); ?>';</script>
	<!-- JS EXTERNAL -->
	<?= $js_external ?>
	<!-- JS -->
	<?= $this->template->js ( 'jquery.min', '20141231' ) ?>
	<?= $this->template->js ( 'jquery.migrate', '20141231' ) ?>
	<?= $this->template->js ( 'plugins/jquery.nicescroll.min', '20141231' ) ?>
	<?= $this->template->js ( 'plugins/jquery.supersized.min', '20141231' ) ?>
	<?= $javascript ?>
	<?= $this->template->js ( 'main.min', '20141231' ) ?>
    </body>
</html>