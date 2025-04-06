<?php if (ENVIRONMENT === 'production'): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NHGKWHM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>

<header data-js-mainnav-scope class="he-header-section uk-section" style="min-height: 1000px;">
    <div class="he-header-section__height-setter uk-inline uk-width-expand">
        <!-- Video pozadina -->
        <div class="video-background">
            <video autoplay muted loop>
                <source src="<?= base_url('img/videos/speedboat.mp4'); ?>" type="video/mp4">
                Vaš preglednik ne podržava video.
            </video>
        </div>

        <!-- Navigacija -->
        <div class="uk-position-top uk-animation-slide-top">
            <div class="he-mainnav-container uk-container uk-light">
                <nav data-uk-navbar hidden class="he-navbar__container uk-navbar-container uk-navbar-transparent" aria-labelledby="aria-mainnav-heading">
                    <h2 class="sr-only" id="aria-mainnav-heading"><?= lang('menu_main_heading'); ?></h2>
                    <div class="he-navbar__collapse">
                        <div class="uk-navbar-left">
                            <ul data-js-mainnav-list-container class="he-navbar__nav uk-navbar-nav">
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'homepage', 'index') ?>">
                                    <a href="<?= site_url('/'); ?>">
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_home'); ?></span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'rentals') ?>">
                                    <a href="<?= site_url('rentals'); ?>">
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_rentals'); ?></span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'excursions') ?>">
                                    <a href="<?= site_url('excursions'); ?>">
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_excursions'); ?></span>
                                    </a>
                                </li>
                                <li class="<?= setActiveNavbarNavItem('uk-active', 'homepage', 'transfers') ?>">
                                    <a href="<?= site_url('homepage/transfers'); ?>">
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_transfers'); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#jump-to-contact-section" data-uk-scroll>
                                        <span class="uk-cust-navbar-nav-link-text"><?= lang('menu_contact'); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="he-navbar__toggle-and-logo-wrapper">
                        <div class="he-navbar__logo-box">
                            <a class="he-navbar__logo-box-link" href="<?= site_url('/'); ?>">
                                <img class="he-navbar__logo-box-image" alt="Hvar Excursions - Bumbar Rent Hvar" src="<?= base_url('img/logo/logo-bumbar-rent-hvar-excursions.png'); ?>">
                            </a>
                        </div>
                        <a data-js-mainnav-toggle data-uk-navbar-toggle-icon="ratio: 1.65" class="he-navbar__toggle uk-navbar-toggle" role="button" href="javascript:void(0)" data-uk-toggle="target: #mainnav-offcanvas"></a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Kontakt sidebar -->
        <div class="he-contact-sidebar uk-animation-slide-top">
            <a data-js-contact-uk-drop-container class="he-contact-sidebar__item uk-inline" role="button" href="<?= lang('general-contact-phone-href'); ?>" target="_blank">
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="top-left" class="uk-hidden@m"></div>
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="left-center" class="uk-visible@m"></div>
                <div class="he-contact-sidebar__trigger" data-uk-icon="icon: receiver; ratio: 1.3"></div>
                <div class="he-contact-sidebar__drop" data-js-contact-uk-drop hidden>
                    <div class="uk-card uk-card-body uk-card-secondary"><?= lang('general-contact-phone'); ?></div>
                </div>
            </a>
            <a data-js-contact-uk-drop-container class="he-contact-sidebar__item uk-inline" role="button" href="<?= lang('general-contact-email-href'); ?>" target="_blank">
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="top-left" class="uk-hidden@m"></div>
                <div data-js-contact-uk-drop-breakpoint data-js-contact-uk-drop-position="left-center" class="uk-visible@m"></div>
                <div class="he-contact-sidebar__trigger" data-uk-icon="icon: mail; ratio: 1.3"></div>
                <div class="he-contact-sidebar__drop" data-js-contact-uk-drop hidden>
                    <div class="uk-card uk-card-body uk-card-secondary"><?= lang('general-contact-email'); ?></div>
                </div>
            </a>
        </div>

        <!-- Naslovi i YouTube link - samo za our-services -->
        <?php if ($this->uri->segment(1) === 'our-services' || $this->uri->segment(1) === '' || ($this->uri->segment(1) === 'en' && $this->uri->segment(2) === 'our-services')): ?>
        <div class="he-header-section__headings uk-position-center">
            <div class="uk-container uk-light">
                <h1 class="he-header-section__title"><?= lang('homepage-header-title'); ?></h1>
                <div class="he-header-section__subtitle"><?= lang('homepage-header-subtitle'); ?></div>
                <a class="he-header-section__teaser-btn uk-button uk-button-default uk-button-small uk-hidden@m" href="#jump-to-contact-section" data-uk-scroll>
                    <?= lang('homepage-header-teaser-btn'); ?>
                </a>
            </div>
        </div>
        <div class="uk-position-bottom uk-position-large uk-animation-slide-bottom">
            <div data-uk-lightbox>
                <div class="uk-container uk-light">
                    <a href="https://www.youtube.com/watch?v=Xveg6s-j5c0" class="uk-link-reset">
                        <span data-uk-icon="icon: play-circle; ratio: 2.4"></span>
                        <div><strong><?= lang('homepage-watch-video'); ?></strong></div>
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Override za ostale stranice -->
        <?php
            $site_path = config_item('site_path');
            $default_header_inner = APPPATH . 'views/default/_global/include/default_header_inner_view.php';
            $lookup_header_inner = APPPATH . 'views/' . $site_path . '_header_inner_view.php';
            if (file_exists($lookup_header_inner)) {
                include_once($lookup_header_inner);
            } else {
                include_once($default_header_inner);
            }
        ?>
        <?php endif; ?>

    </div>

    <!-- Offcanvas meni -->
    <div id="mainnav-offcanvas" data-js-mainnav-offcanvas data-uk-offcanvas="overlay: true; mode: push">
        <div class="uk-offcanvas-bar uk-flex uk-flex-column">
            <button class="uk-offcanvas-close" type="button" data-uk-close></button>
            <ul data-js-mainnav-list-container-xs class="uk-nav uk-nav-primary uk-nav-center uk-margin-large-top"></ul>
        </div>
    </div>
</header>