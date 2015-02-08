<!DOCTYPE html>
<html lang="<?= $this->settings_model->language['code']; ?>">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="description" content="<?= @$data['seo_description']; ?>">
        <meta name="keywords" content="<?= @$data['seo_keywords']; ?>">
        <!-- TITLE -->
        <title><?= @$data['seo_title']; ?></title>
        <!-- FAVICON -->
	<?= $this->template->favicon ( 'ico', 'favicon.ico' ); ?>
        <!-- CSS LIBRARY -->
	<?= $this->template->library ( 'css', 'bootstrap/css/bootstrap.min', '20150123' ); ?>
        <!-- CSS PLUGINS -->
	<?= $this->template->plugin ( 'css', 'datatables/css/dataTables.bootstrap', '20140112' ) ?>
	<?= $this->template->plugin ( 'css', 'xeditable/css/bootstrap-editable.min', '20140112' ) ?>
	<?= $this->template->plugin ( 'css', 'jasny/css/jasny-bootstrap.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'css', 'fontawesome/css/font-awesome.min', '20150123' ); ?>
	<?= $this->template->plugin ( 'css', 'metismenu/css/metisMenu.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'css', 'selectize/css/selectize.bootstrap3', '20141120' ); ?>
	<?= $this->template->plugin ( 'css', 'ladda/css/ladda-themeless.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'css', 'flags/css/flags', '20140112' ); ?>
	<?= $css_plugins ?>
        <!-- CSS -->
	<?= $this->template->css ( 'style', '20140112' ); ?>
	<?= $this->template->css ( 'helper', '20140112' ); ?>
	<?= $css ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="<?= $this->settings_model->system['_system_theme_backend_style_']; ?>">

	<?php $this->template->widget ( 'header' ); ?>

        <div class="wrapper row-offcanvas row-offcanvas-left">

	    <?php $this->template->widget ( 'sidebar' ); ?>

	    <?= $body ?>

        </div>
        <!-- JS PATH -->
        <script>var assets = '<?= $this->template->path ( 'assets' ); ?>';</script>
        <!-- JS EXTERNAL -->
	<?= $js_external ?>
        <!-- JS LIBRARY -->
	<?= $this->template->library ( 'js', 'jquery/js/jquery-2.1.3.min', '20140112' ); ?>
	<?= $this->template->library ( 'js', 'bootstrap/js/bootstrap.min', '20150123' ); ?>
        <!-- JS PLUGINS -->
	<?= $this->template->plugin ( 'js', 'bootbox/js/bootbox.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'jasny/js/jasny-bootstrap.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'metismenu/js/metisMenu.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'ladda/js/spin.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'ladda/js/ladda.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'form/js/jquery.form.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'growl/js/bootstrap-growl.min', '20140112' ); ?>
	<?= $this->template->plugin ( 'js', 'xeditable/js/bootstrap-editable.min', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'datatables/js/jquery.dataTables.min', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'datatables/js/dataTables.bootstrap', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'highlight/js/jquery.highlight', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'sortable/js/jquery-sortable-min', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'selectize/js/selectize.min', '20141120' ) ?>
	<?= $this->template->plugin ( 'js', 'ckeditor/ckeditor', '20140112' ) ?>
	<?= $this->template->plugin ( 'js', 'ckeditor/adapters/jquery', '20140112' ) ?>
	<?= $js_plugins ?>
        <!-- JS -->
	<?= $this->template->js ( 'app', '20140112' ); ?>
	<?= $this->template->js ( '_global', '20140112' ); ?>
	<?= $javascript ?>
    </body>
</html>