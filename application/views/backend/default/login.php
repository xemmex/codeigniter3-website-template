<!DOCTYPE html>
<html lang="<?= $this->settings_model->language['code']; ?>" class="bg-black">
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
        <!-- LIBRARY -->
	<?= $this->template->library ( 'css', 'bootstrap/css/bootstrap.min', '20150123' ); ?>
	<?= $this->template->css ( 'style', '20140112' ) ?>
	<?= $this->template->css ( 'helper', '20140112' ); ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
	<?= $body ?>
    </body>
</html>