<footer id="footer">
    <div class="social-icons">
        <?php if ( ! empty ( $this->settings_model->system['_social_facebook_'] ) ) : ?>
            <a href="<?= $this->settings_model->system['_social_facebook_']; ?>" class="facebook"></a>
        <?php endif; ?>
        <?php if ( ! empty ( $this->settings_model->system['_social_twitter_'] ) ) : ?>
            <a href="<?= $this->settings_model->system['_social_twitter_']; ?>" class="twitter"></a>
        <?php endif; ?>
        <?php if ( ! empty ( $this->settings_model->system['_social_google_plus_'] ) ) : ?>
            <a href="<?= $this->settings_model->system['_social_google_plus_']; ?>" class="googleplus"></a>
        <?php endif; ?>
    </div>
    <div class="links">

        <span class="copyright"><?= $this->settings_model->system['_system_copyright_']; ?></span>

        <?php foreach ( get_languages() as $lang ) : ?>

            <a href="<?= switch_lang( $lang['code'] ) ?>"
               class="language<?= ( $lang['code'] == current_language() ) ? ' active' : ''; ?>">
                <span class="flag flag-<?= $lang['code'] ?>"></span>
            </a>
        <?php endforeach; ?>

    </div>
    <div class="clear"></div>
</footer>