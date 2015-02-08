<?php if ( isset ( $widget['image'] ) ) : ?>
    <div id="supersized-loader"></div>
    <ul id="supersized"></ul>
    <script type="text/javascript">
        var supersized_slides = [
        {
        image: '<?= $this->template->path ( 'uploads', $widget['image'] ); ?>'
        }
        ];</script>
<?php endif; ?>

<?php if ( isset ( $widget['image_no_zoom'] ) ) : ?>
    <div id="supersized-loader"></div>
    <ul id="supersized"></ul>
    <script type="text/javascript">
    	    var supersized_slides = [
    	    {
    	    image: '<?= $this->template->path ( 'uploads', $widget['image_no_zoom'] ); ?>'
    	    }
    	    ];</script>
<?php endif; ?>

<?php if ( isset ( $widget['gallery_no_zoom'] ) && is_array ( $widget['gallery_no_zoom'] ) ) : ?>
    <div id="supersized-loader"></div>
    <ul id="supersized"></ul>
    <div id="supersized-info">
        <div class="inner">
    	<h2><a href="#">&nbsp;</a></h2>
    	<p></p>
    	<a class="supersized-prev"><span></span></a>
    	<a class="supersized-next"><span></span></a>
        </div>
    </div>
    <script type="text/javascript">
    	    var supersized_slides = [
    <?php foreach ( $widget['gallery_no_zoom'] as $image ) : ?>
		    {
		    image: '<?= $this->template->path ( 'uploads', $image['url'] ); ?>',
			    article_title: '<?= (empty ( $image['title'] )) ? tr ( '_GLOBAL_GALLERY_title_' ) : $image['title']; ?>',
			    article_text: '<?= (empty ( $image['text'] )) ? tr ( '_GLOBAL_GALLERY_text_' ) : $image['text']; ?>'
		    },
    <?php endforeach; ?>
    	    ];</script>
<?php endif; ?>

<?php if ( isset ( $widget['gallery'] ) && is_array ( $widget['gallery'] ) ) : ?>
    <div id="supersized-loader"></div>
    <ul id="supersized"></ul>
    <a class="supersized-fullscreen"><span></span></a>
    <div id="supersized-info">
        <div class="inner">
    	<h2><a href="#">&nbsp;</a></h2>
    	<p></p>
    	<a class="supersized-prev"><span></span></a>
    	<a class="supersized-next"><span></span></a>
        </div>
    </div>
    <script type="text/javascript">
    	    var supersized_slides = [
    <?php foreach ( $widget['gallery'] as $image ) : ?>
		    {
		    image: '<?= $this->template->path ( 'uploads', $image['url'] ); ?>',
			    article_title: '<?= (empty ( $image['title'] )) ? tr ( '_GLOBAL_GALLERY_title_' ) : $image['title']; ?>',
			    article_text: '<?= (empty ( $image['text'] )) ? tr ( '_GLOBAL_GALLERY_text_' ) : $image['text']; ?>'
		    },
    <?php endforeach; ?>
    	    ];
    </script>
<?php endif; ?>



