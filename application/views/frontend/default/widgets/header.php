<header id="header">
    <div id="logo">
        <h1>
            <a href="<?= frontend_url(); ?>">
                <img src="<?= $this->template->path( 'uploads', 'logo.png' ) ?>" alt="logo">
            </a>
        </h1>

        <div class="menu-toggle"><span class="tooltip" title="<?= tr( '_GLOBAL_toogle_menu_' ); ?>"></span></div>
    </div>
    <nav id="menu">
        <ul>
            <li class="arrow<?= is_active( array ( 'villas' ), ' current_page_item expand-menu' ) ?>">
                <a href="javascript:void(0);"><?= tr( '_MENU_villas_' ); ?></a>
                <ul class="sub-menu">
                    <li<?= is_active( array ( 'villas', 'villa-spa-i' ), ' class="current_page_item"' ) ?>>
                        <a href="<?= frontend_url( array (
                                'villas',
                                'villa-spa-i'
                            ) ); ?>">&raquo; <?= tr( '_MENU_villas_villa_spa_i_' ); ?></a>
                    </li>
                    <li<?= is_active( array ( 'villas', 'villa-spa-ii' ), ' class="current_page_item"' ) ?>>
                        <a href="<?= frontend_url( array (
                                'villas',
                                'villa-spa-ii'
                            ) ); ?>">&raquo;  <?= tr( '_MENU_villas_villa_spa_ii_' ); ?></a>
                    </li>
                </ul>
            </li>
            <li<?= is_active( array ( 'about-us' ), ' class="current_page_item"' ) ?>>
                <a href="<?= frontend_url( array ( 'about-us' ) ); ?>"><?= tr( '_MENU_about_us_' ); ?></a>
            </li>
            <li<?= is_active( array ( 'surroundings' ), ' class="current_page_item"' ) ?>>
                <a href="<?= frontend_url( array ( 'surroundings' ) ); ?>"><?= tr( '_MENU_surroundings_' ); ?></a>
            </li>
            <li>
                <a href="http://villascomfort.com/en/properties/?titulo=VillaSpa#listing-container"><?= tr( '_MENU_reservation_' ); ?></a>
            </li>

            <li<?= is_active( array ( 'contact' ), ' class="current_page_item"' ) ?>>
                <a href="<?= frontend_url( array ( 'contact' ) ); ?>"><?= tr( '_MENU_contact_' ); ?></a>
            </li>
        </ul>
    </nav>
</header>