<!DOCTYPE html>
<html lang="<?= $this->settings_model->language['code']; ?>" class="lockscreen">
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= @$data['seo_description']; ?>">
        <meta name="keywords" content="<?= @$data['seo_keywords']; ?>">
        <!-- TITLE -->
        <title><?= @$data['seo_title']; ?></title>
        <!-- FAVICON -->
	<?= $this->template->favicon ( 'ico', 'favicon.ico' ); ?>
        <!-- CSS LIBRARY -->
	<?= $this->template->library ( 'css', 'bootstrap/css/bootstrap.min', '20150123' ); ?>
	<?= $this->template->plugin ( 'css', 'fontawesome/css/font-awesome.min', '20150123' ); ?>
        <!-- CSS -->
	<?= $this->template->css ( 'style', '20140112' ) ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
	<?= $body ?>
        <!-- JS LIBRARY -->
	<?= $this->template->library ( 'js', 'jquery/js/jquery-2.1.3.min', '20140112' ); ?>
	<?= $this->template->library ( 'js', 'bootstrap/js/bootstrap.min', '20150123' ); ?>
        <!-- JS -->
	<?= $this->template->js ( 'auth/locked', '20140112' ); ?>
    </body>
</html>