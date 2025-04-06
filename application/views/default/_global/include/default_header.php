<?php if(ENVIRONMENT === 'production'): ?>
<!-- Google Tag Manager (noscript)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NHGKWHM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    End Google Tag Manager (noscript) -->
<?php endif; ?>
    
<header data-js-mainnav-scope class="he-header-section uk-section">
    <div class="he-header-section__height-setter uk-inline uk-width-expand">
        <div class="he-header-section__bg uk-position-cover"></div>

        <div class="uk-position-top uk-animation-slide-top">
            <div class="he-mainnav-container uk-container uk-light">
                <nav data-uk-navbar hidden
                    class="he-navbar__container uk-navbar-container uk-navbar-transparent"
                    aria-labelledby="aria-mainnav-heading">

                    <h2 class="sr-only" id="aria-mainnav-heading"><?= lang('menu_main_heading'); ?></h2>

                    <div class="he-navbar__collapse">
                        <div class="uk-navbar-left">
                            <ul data-js-mainnav-list-container class="he-navbar__nav uk-navbar-nav">

                                <li class="<?= setActiveNavbarNavItem('uk-active', 'homepage', 'index') ?>">
                                    <a href="<?= site_url('/') ?>">
                                        <span class="uk-cust-navbar-nav-link-text">
                                            <?= lang('menu_home') ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'rentals') ?>">
                                    <a href="<?= site_url('rentals') ?>">
                                        <span class="uk-cust-navbar-nav-link-text">
                                            <?= lang('menu_rentals') ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'excursions') ?>">
                                    <a href="<?= site_url('excursions') ?>">
                                        <span class="uk-cust-navbar-nav-link-text">
                                            <?= lang('menu_excursions') ?>
                                        </span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'homepage', 'transfers') ?>">
                                    <a href="<?= site_url('homepage/transfers') ?>">
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_transfers') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#jump-to-contact-section" data-uk-scroll>
                                        <span class="uk-cust-navbar-nav-link-text">
                                            <?=lang('menu_contact')?>
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="he-navbar__toggle-and-logo-wrapper">
                        <div class="he-navbar__logo-box">
                            <a class="he-navbar__logo-box-link" href="<?= site_url('/') ?>">
                                <!-- TODO: lang -->
                                <img class="he-navbar__logo-box-image" alt="Hvar Excursions - Bumbar Rent Hvar" src="<?= base_url('img/logo/logo-bumbar-rent-hvar-excursions.png') ?>">
                            </a>
                        </div>
                        <a data-js-mainnav-toggle data-uk-navbar-toggle-icon="ratio: 1.65"
                            class="he-navbar__toggle uk-navbar-toggle" role="button" href="javascript:void(0)"
                            data-uk-toggle="target: #mainnav-offcanvas">
                        </a>
                        <!--<a data-uk-navbar-toggle-icon="ratio: 1.55"
                            class="he-navbar__toggle uk-navbar-toggle" role="button" href="javascript:void(0)"
                            data-uk-toggle="target: .he-navbar__collapse; animation:
                                uk-animation-scale-up uk-transform-origin-top-left,
                                uk-animation-scale-up uk-transform-origin-top-left uk-animation-reverse">
                        </a>-->
                    </div>

                </nav>
            </div>
        </div>

        <div class="he-contact-sidebar uk-animation-slide-top">
            <a data-js-contact-uk-drop-container
            class="he-contact-sidebar__item uk-inline" role="button"
            href="<?=lang('general-contact-phone-href')?>"
            target="_blank">
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="top-left" class="uk-hidden@m"></div>
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="left-center" class="uk-visible@m"></div>
                <div class="he-contact-sidebar__trigger" data-uk-icon="icon: receiver; ratio: 1.3"></div>
                <div class="he-contact-sidebar__drop" data-js-contact-uk-drop hidden>
                    <div class="uk-card uk-card-body uk-card-secondary"><?=lang('general-contact-phone')?></div>
                </div>
            </a>
        
            <a data-js-contact-uk-drop-container
            class="he-contact-sidebar__item uk-inline" role="button"
            href="<?=lang('general-contact-email-href')?>"
            target="_blank">
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="top-left" class="uk-hidden@m"></div>
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="left-center" class="uk-visible@m"></div>
                <div class="he-contact-sidebar__trigger" data-uk-icon="icon: mail; ratio: 1.3"></div>
                <div class="he-contact-sidebar__drop" data-js-contact-uk-drop hidden>
                    <div class="uk-card uk-card-body uk-card-secondary"><?=lang('general-contact-email')?></div>
                </div>   
            </a>
        </div>

        <?php

            // OVERRIDE: LOAD INNER PART OF THE HEADER
            // ===================================================================
            $default_header_inner = APPPATH . 'views/'.$dir.'_global/include/default_header_inner_view.php';
            $lookup_header_inner = APPPATH . 'views/'.$site_path.'_header_inner_view.php';

            if(file_exists($lookup_header_inner)) include_once($lookup_header_inner); // it might include() default one
            else include_once($default_header_inner);

        ?>

    </div>

    <div id="mainnav-offcanvas" data-js-mainnav-offcanvas
         data-uk-offcanvas="overlay: true; mode: push">
        <div class="uk-offcanvas-bar uk-flex uk-flex-column">
            <button class="uk-offcanvas-close" type="button" data-uk-close></button>
            <ul data-js-mainnav-list-container-xs class="uk-nav uk-nav-primary uk-nav-center uk-margin-large-top"></ul>
        </div>
    </div>

</header>
