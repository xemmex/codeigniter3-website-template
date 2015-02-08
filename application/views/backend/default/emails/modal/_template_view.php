<?php $get_languages = get_languages ( TRUE ); ?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
	<?php foreach ( $get_languages as $language ) : ?>
    	<li class="translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>"><a href="#translation-view-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
	<?php endforeach; ?>
    </ul>
    <?php unset ( $language ); ?>

    <div class="tab-content">
	<?php foreach ( $get_languages as $language ) : ?>
    	<div class="tab-pane translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>" id="translation-view-<?= $language['code']; ?>">
    	    <div class="form-horizontal mt10">
    		<label class="control-label col-sm-2"><?= tr ( '_GLOBAL_subject_' ); ?></label>
    		<div class="col-sm-10">
			<?=
			form_input ( array(
			    'type' => 'text',
			    'value' => $template['template'][$language['uID']]['subject'],
			    'class' => 'form-control',
			    'disabled' => 'disabled'
			) );
			?>
    		</div>
    		<div class="clearfix"></div>
    	    </div>
    	    <div class="mt10">
		    <?= $template['template'][$language['uID']]['message']; ?>
    	    </div>
    	    <div class="clearfix"></div>
    	</div>
	<?php endforeach; ?>
	<?php unset ( $language, $get_languages ); ?>
    </div>
</div>
