<?= form_open ( 'backend/bloger/entries-search', array( 'id' => 'bloger_search_form', 'class' => 'mb15' ) ); ?>
<div class="well">
    <h4><?= tr ( '_GLOBAL_search_' ) ?></h4>
    <div class="input-group">
	<input type="text" class="form-control">
	<span class="input-group-btn">
	    <button class="btn btn-primary ladda-button" data-style="zoom-out" type="submit"><i class="fa fa-search"></i></button>
	</span>
    </div>
</div>

<?= form_close (); ?>

<div class="well">
    <h4><?= tr ( '_GLOBAL_categories_' ) ?></h4>
    <div class="row">
	<div class="col-lg-6">
	    <ul class="list-unstyled">
		<?php foreach ( $data['categories'] as $category ) : ?>
    		<li><a href="<?= $category['url'] ?>"><?= $category['text'] ?> (<?= $category['total'] ?>)</a>
			<?php unset ( $category ) ?>
		    <?php endforeach; ?>
		    <?php unset ( $data['categories'] ) ?>
	    </ul>
	</div>
    </div>
</div>

<div class="well">
    <h4><?= tr ( '_GLOBAL_archive_' ) ?></h4>
    <div class="row">
	<div class="list-group">
	    <?php foreach ( $data['archive'] as $year => $months ) : ?>
    	    <div class="col-lg-6">
    		<h5> - <?= $year ?> - </h5>
    		<ul class="list-unstyled">
			<?php foreach ( $months as $month ) : ?>
			    <li class="mb5"><i class="ico-angle-right text-muted mr5"></i> <a href="<?= $month['url'] ?>" title="<?= $month['title'] ?>"><?= $month['text'] ?></a></li>
				<?php unset ( $month ) ?>
			    <?php endforeach ?>
    		</ul>
    	    </div>
		<?php unset ( $year, $months ) ?>
	    <?php endforeach ?>
	    <?php unset ( $data['archive'] ) ?>
        </div>
    </div>
</div>