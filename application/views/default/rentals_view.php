<?php

// WARNING: Clear cache after any changes!! TODO:
if($transaction_callback): ?><span data-js-transaction-callback></span><?php endif; ?>




<!--<p class="info-text">For special requests or same date reservations please <a href="#jump-to-contact-section" data-uk-scroll>contact us directly</a>.</p>-->
<!-- TODO: No commission! - We are direct owners of all the boats -->



<div class="uk-section">
    <div class="uk-container">
        <p class="uk-text-lead"><?= lang('rentals-intro', array('<br>', '<strong>', '</strong>')); ?></p>
    </div>
</div>

<div class="uk-section uk-padding-remove-top" data-js-rentals-scope>
    <div class="uk-container he-sticky-container">

        <div data-uk-grid class="uk-grid uk-grid-large uk-child-width-expand@s"
             data-uk-filter="target: [data-js-rentals-sort-grid-target]"
             data-js-rentals-sort-component>
             <div class="uk-width-auto he-rental-items-col--menu">
                 
                 <!-- Secondary navigation -->
                 <div class="he-rentals-secondary-nav"
                      data-js-rentals-secnav data-js-rentals-secnav-expanded-class="he-rentals-secondary-nav--is-expanded"
                      data-uk-toggle="media: @s; cls: js-expanding-disabled; mode: media">
                    
                    <!--Available only on top when not sticked. Keeps the width when sticked -->
                    <div class="he-rentals-secondary-nav__sticky-pre-placeholder"></div>
                    <div class="he-rentals-secondary-nav__sticky" data-uk-sticky="bottom: !.he-sticky-container; cls-active: he-rentals-secondary-nav__sticky--is-sticked;">
                        <aside>
                            <!--Always available: Placeholder to match the heading height-->
                            <div class="uk-h2 he-rentals-section-heading he-rentals-secondary-nav__sticky-placeholder-offset-top">&nbsp;</div>

                            <nav class="he-rentals-secondary-nav__sticky-inner" aria-labelledby="aria-rentals-nav-heading">
                                <h2 class="sr-only" id="aria-rentals-nav-heading"><?= lang('rentals-nav-heading'); ?></h2>
                                <ul class="he-rentals-secondary-nav__ul" data-uk-scrollspy-nav="closest: li; scroll: true">
                                    <?php 

                                    // Add FAQ link into secondary nav #jump-to-rentals-faq
                                    $secondaryNavItems = $items;
                                    $secondaryNavItems['rentals-faq'] = []; 
                                    
                                    foreach($secondaryNavItems as $sectionName => $sectionItems): ?>
                                        <li class="he-rentals-secondary-nav__li">
                                            <a class="he-rentals-secondary-nav__a" href="#jump-to-<?= $sectionName; ?>"
                                                data-js-rentals-secnav-navitem-toggle data-uk-scroll>
                                                <?= lang('rentals-nav-' . $sectionName); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </aside>
                    </div>
                </div>
            </div>

            <div id="jump-to-rentals-content" class="he-rental-items-col--items">

                <?php foreach ($items as $sectionName => $sectionItems): ?>
                    <!-- Rental category section -->
                    <div>
                        <h2 id="jump-to-<?= $sectionName; ?>" class="he-rentals-section-heading">
                            <?= lang('rentals-heading-' . $sectionName); ?>
                        </h2>

                        <?php if ('speedboats' === $sectionName): ?>
                            <!-- TODO also there is some text in lang -->
                            <div class="">
                                <!-- TODO: for general rentals page
                                <p>
                                    Rent with or without a skipper -explore Hvar and surrounding islands on your own. Use a rental boat and sail to Pakleni islands, Caves, Vis, Korčula, Dubovica, Red rocks, and more.
                                    <br>We garantee the best rental deals in Hvar. Send us your inquiry or book directly.
                                </p>-->

                                <div class="he-rentals-sort-subnav-container">
                                    <!--<p>
                                        <strong>Don't have a boat license?</strong>
                                        <br>No problem, we can provide your personal boat skipper and a local tour guide for only 50€/day
                                    </p>-->
                                    <!-- TODO <ul class="he-rentals-sort-subnav uk-subnav uk-subnav-pill">
                                        <li class="uk-active">
                                            <a href="#">Sort by <span uk-icon="icon:  triangle-down"></span></a>
                                            <div data-uk-dropdown="mode: click;" data-js-rentals-sort-dropdown-component>
                                                <ul class="uk-nav uk-dropdown-nav">
                                                    <li data-uk-filter-control="sort: data-sort-relevance" class="uk-active"><a href="#">Popularity</a></li>
                                                    <li data-uk-filter-control="sort: data-sort-hp"><a href="#">Engine - smallest first</a></li>
                                                    <li data-uk-filter-control="sort: data-sort-hp; order: desc"><a href="#">Engine - biggest first</a></li>
                                                    <li data-uk-filter-control="sort: data-sort-price"><a href="#">Price - lowest first</a></li>
                                                    <li data-uk-filter-control="sort: data-sort-price; order: desc"><a href="#">Price - highest first</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>-->
                                </div>
                            </div>

                        <?php endif; ?>

                        <div data-js-rentals-sort-grid-target
                             data-uk-grid class="uk-grid uk-grid-match uk-grid-small uk-child-width-1-2@m">
                            <!-- Rental category items -->
                            <?php
                                $itemIndex = 0; 
                                foreach ($sectionItems as $itemName => $item):
                                    $itemTitle = lang($itemName . '-title');
                                    $itemDescription = lang($itemName.'-text');
                                    $itemSpecs = lang($itemName.'-specs');
                                    $itemIndex++;

                                    if ('speedboats' === $sectionName) {
                                        $itemSpecs = lang($itemName.'-specs', array(
                                            '<strong>', lang($itemName.'-length'), '</strong>', '<br>',
                                            '<strong>', lang($itemName.'-engine-special') ? lang($itemName.'-engine-special') : lang($itemName.'-engine'), '</strong>', '<br>',
                                            '<strong>', lang($itemName.'-passengers'), '</strong>'
                                        ));
                                    }
                                ?>

                                <!-- grid item -->
                                <div data-js-sort-container
                                    data-sort-relevance="<?= $itemIndex ?>"
                                    data-sort-price="<?= $item['priceHint']; ?>"
                                    data-sort-hp="<?= lang($itemName.'-engine') ?>"
                                    >

                                    <!-- Rental item -->
                                    <article data-js-rentals-item="<?= $itemName ?>"
                                            data-js-class-booking-not-available="he-rental-item-toggle-switch-not-available"
                                            data-js-class-booking-too-early="he-rental-item-toggle-switch-too-early"
                                            data-js-fl-bookable="<?= ($item['isBookable'] === true) ?>"
                                            data-js-fl-fuel-incl="<?= ($item['isFuelIncluded'] === true) ?>"
                                            class="he-rental-item uk-card">

                                        <div class="he-rental-item__section he-rental-item__section-media-top uk-inline uk-card-media-top">
                                            <!-- Rental item images -->
                                            <?php if (!empty($itemsImages[$itemName]['images'])): 
                                                    $itemThumbnail = $itemsImages[$itemName]['thumbnail'];
                                                    $itemImages = $itemsImages[$itemName]['images'];
                                                    $itemImagesCount = count($itemImages);
                                                ?>
                                                <div data-uk-lightbox>
                                                    <?php foreach($itemImages as $i => $ImageData): ?>
                                                        <a href="<?= $ImageData['src']; ?>"
                                                            class="uk-inline-clip uk-transition-toggle"
                                                            data-alt="<?= $itemTitle; ?>"
                                                            data-caption="<?= $itemTitle . " (" . ($i + 1) . " / " . $itemImagesCount . ")"; ?>"
                                                            <?= (0 === $i) ? '' : 'hidden'; ?>
                                                        ><?php if (0 === $i): ?>
                                                            <!-- Thumbnail image -->
                                                            <img src="<?= $itemThumbnail; ?>" alt="<?= $itemTitle; ?>" class="uk-transition-scale-up uk-transition-opaque">
                                                        <?php endif; ?></a>
                                                    <?php endforeach; ?>
                                                </div>

                                                <div class="uk-position-top-right uk-light">
                                                    <div class="uk-tile uk-padding-small">
                                                        <span data-uk-icon="icon: image; ratio: 0.7"></span> <?= $itemImagesCount ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Rental item specs -->
                                            <?php if ('speedboats' === $sectionName): ?>
                                                <div class="he-rental-item__specs uk-card-body uk-position-bottom uk-light">
                                                    <span class="he-rental-item__spec-item" title="<?= lang('rentals-label-engine'); ?>">
                                                        <strong><?= lang($itemName.'-engine'); ?></strong>
                                                    </span>
                                                    <span class="he-rental-item__spec-item" title="<?= lang('rentals-label-length'); ?>">
                                                        <span data-uk-icon="icon: code; ratio: 0.8"></span> <?= lang($itemName.'-length'); ?>
                                                    </span>
                                                    <span class="he-rental-item__spec-item" title="<?= lang('rentals-label-passengers'); ?>">
                                                        <span data-uk-icon="icon: users; ratio: 0.8"></span> <?= lang($itemName.'-passengers'); ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="uk-card-body he-rental-item__section">
                                            <h3 class="he-rental-item__title">
                                                <span data-js-txt-rentals-item-title><?= $itemTitle ?></span>
                                                <?php if ($item['isFuelIncluded'] === true) : ?><span class="uk-label">FUEL INCL.</span><?php endif; ?><!-- TODO: Lang file. Also this should not appear for the bike!! -->
                                            </h3>
                                            <div class="he-rental-item__price-hint" data-js-rental-item-price-hint>
                                                <span data-uk-icon="icon: tag; ratio: 0.8"></span>
                                                <?= $item['priceHint']; ?>
                                            </div>
                                        </div>
                                    
                                        <div class="uk-card-body" hidden data-js-rental-item-booking-info-section id="jump-to-<?= $itemName ?>-booking-section">
                                            <div class="he-rental-item__section">
                                                <div>
                                                    <div class="he-rental-item__booking-info-header">
                                                        <!-- Headline: Booking toggle: Regular -->
                                                        <div class="he-toggle-na--hidden he-toggle-te--hidden"><?= lang('rentals-booking-info-heading'); ?></div>

                                                        <!-- Headline: Booking toggle: Not available -->
                                                        <div class="he-toggle-na--shown">
                                                            <div class="he-el-with-icon">
                                                                <span data-uk-icon="icon: warning; ratio: 1.3"></span>
                                                                <span><?= lang('rentals-booking-info-heading-not-available'); ?></span>
                                                            </div>
                                                        </div>

                                                        <!-- Headline: Booking toggle: Too early -->
                                                        <div class="he-toggle-te--shown">
                                                            <div class="he-el-with-icon">
                                                                <span data-uk-icon="icon: warning; ratio: 1.3"></span>
                                                                <span><?= lang('rentals-booking-info-heading-too-early'); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="he-rental-item__booking-info">
                                                        <!-- Info: Booking toggle: Regular -->
                                                        <div class="he-toggle-na--hidden he-toggle-te--hidden">
                                                            <span data-js-txt-rental-item-additional-booking-info
                                                                data-js-txt-tpl-info-one-day="<?= lang('subject-booking-info-one-day'); ?>"
                                                                data-js-txt-tpl-info-more-days="<?= lang('subject-booking-info-more-days'); ?>"></span>
                                                        </div>

                                                        <!-- Info: Booking toggle: Not available -->
                                                        <div class="he-toggle-na--shown"><?= lang('subject-booking-info-not-available'); ?></div>

                                                        <!-- Info: Booking toggle: Too early -->
                                                        <div class="he-toggle-te--shown"><?= lang('subject-booking-info-too-early', array('<a href="#jump-to-contact-section" data-uk-scroll>', '</a>')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="he-rental-item__booking-price">
                                                    <div class="he-rental-item-price">
                                                        <span class="he-rental-item-price__currency">&euro;</span>
                                                        <span class="he-rental-item-price__amount"><span data-js-txt-rentals-item-price>0</span>,-</span>
                                                    </div>
                                                    <div>
                                                        <span class="he-rental-item__old-price"><s>&nbsp;&euro; <span data-js-txt-rentals-item-old-price></span>,-&nbsp;</s></span>
                                                        <span class="he-rental-item__price-discount-label uk-label uk-label-success">-<span data-js-txt-rentals-item-discount></span>%</span>
                                                    </div>
                                                </div>

                                            </div>										
                                        </div>										

                                        <div class="uk-card-body">
                                            <div class="he-rental-item__booking-buttons">
                                                <?php if(false === $item['isBookable']): ?>
                                                    <!-- Buttons: Not bookable -->
                                                    <div>
                                                        <a class="uk-button uk-button-default" href="#jump-to-contact-section" data-uk-scroll>
                                                            <?= lang('rentals-booking-btn-request-offer'); ?>
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- Buttons: Booking toggle: Regular -->
                                                    <div class="he-toggle-na--hidden he-toggle-te--hidden" data-uk-margin>
                                                        <button class="uk-button uk-button-primary" type="button" data-js-btn-rentals-book>
                                                            <?= lang('rentals-booking-btn-book-now'); ?>
                                                        </button>
                                                        <a class="uk-button uk-button-default" href="#jump-to-contact-section" data-uk-scroll>
                                                            <?= lang('rentals-booking-btn-contact'); ?>
                                                        </a>
                                                    </div>
                                                    <!-- Buttons: Booking toggle: Not available -->
                                                    <div class="he-toggle-na--shown">
                                                        <button class="uk-button uk-button-default" type="button" data-js-btn-rentals-change-dates>
                                                            <?= lang('rentals-booking-btn-change-dates'); ?>
                                                        </button>
                                                        <span class="uk-text-nowrap">
                                                            <?= lang('rentals-booking-link-contact', array('<a href="#jump-to-contact-section" data-uk-scroll>', '</a>')); ?>	
                                                        </span>
                                                    </div>
                                                    <!-- Buttons: Booking toggle: Too early -->
                                                    <div class="he-toggle-te--shown">
                                                        <a class="uk-button uk-button-default" href="#jump-to-contact-section" data-uk-scroll>
                                                            <?= lang('rentals-booking-btn-contact'); ?>
                                                        </a>
                                                        <span class="uk-text-nowrap">
                                                            <?= lang1('rentals-booking-link-change-dates', array(
                                                                '{{$btnOpenTag}}' => '<strong><a href="javascript:void(0)" data-js-btn-rentals-change-dates-to-mindate>',
                                                                '{{$dateTxt}}' => '<span data-js-txt-rental-item-first-available-date></span>',
                                                                '{{$btnCloseTag}}' => '</a></strong>'
                                                            )); ?>	
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="uk-card-body">
                                            <!-- Rental item description and specs -->
                                            <p class="he-rental-item__description"><?= $itemDescription; ?>.</p>
                                            <p class="he-rental-item__specs-detailed"><?= $itemSpecs; ?></p>
                                        </div>

                                    </article>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<div class="uk-section uk-padding-remove-top">
    <div class="uk-container">
        <div data-uk-grid class="uk-grid">
            <div class="uk-width-2-3@l">
                <!-- TODO: Translations -->
                <h2 id="jump-to-rentals-faq">FAQ</h2>
                <h3>As a tourist planning to visit Hvar island, you may be wondering if you need a boating license to rent a boat.</h3>
                <p><strong>When renting boats, RIBs, and speedboats</strong> (aka. motorboats) the boat license is legally required in Croatia. There is no exception for engine-powered boats in regards of the boat type, engine power or the boat length. The boat captain is fully responsible to possess and present a valid boating license when intercepted by the authority or otherwise bear the consequences personally (e.g. fines). On a request and for an additional fee of <strong>70 Euro we offer a licensed boat captain</strong>. It's a recommended option for a carefree relaxed holiday even when possessing a boating license.</p>
                <p><strong>For renting cars and scooters</strong>, a valid driving license is required. A regular car license is sufficient for 50cc scooters. However, for larger scooters, an appropriately categorized motorbike license is necessary.</p>
                
                <h3>Rental Period Guidelines:</h3>
                <ul>
                    <li>For most boat and speedboat rentals, the designated rental period spans from 9:00 am to 6:30 pm (18:30h). However, exceptions to these hours may be accommodated upon request, subject to availability, and may incur an additional surcharge.</li>
                    <li>For car and scooter rentals, the rental period extends until midnight (12:00 am) on the same day or for a full 24-hour duration.</li>
                    <li>Please note that any exceptions to the standard rental periods should be arranged in advance and may be subject to additional fees. Our team will be happy to assist you with any special requests you may have.</li>
                </ul>

                <h3>Hourly Rental Rate?</h3>
                <p>Hourly rentals are not typically available due to the high maintenance costs involved. As a result, the hourly rental rate is equivalent to one-third of the standard daily price. If you are interested in an hourly rental, please contact us directly to discuss the availability and pricing options.</p>
                
                <h3>What Affects the Rental Price?</h3>
                <p>The rental price depends on the season, current demand, availability, and the duration of the rental. Prices are usually lowest at the end of September, in October, and at the beginning of May. During the high season of July and August, prices tend to be higher due to increased demand.</p>

                <h3>Requesting a Special Rental Offer?</h3>
                <p>We understand the importance of flexibility. If you are a group or require a longer rental period, we are more than happy to accommodate your needs. Simply reach out to us directly, and we can discuss special offers and rental duration times tailored specifically to your requirements.</p>

                <h3>Cancellation Policy:</h3>
                <p>We offer refunds for booking deposits according to the following guidelines:</p>
                <ul>
                    <li><strong>A FULL REFUND</strong> (minus a 10-20 EUR service fee) is available if the cancellation is made up to 15 days before the pick-up date.</li>
                    <li><strong>A PARTIAL REFUND</strong> of up to 50% of the deposit amount is possible for cancellations made between 14 and 2 full days before the pick-up date.</li>
                    <li><strong>NO REFUND</strong> will be provided for cancellations made within one full day prior to the pick-up date or in the event of a no-show at the designated pick-up time (unless arranged otherwise).</li>
                </ul>         
                <p>We understand that certain circumstances may be beyond your control. In such cases, we offer penalty-free cancellations at any time before the pick-up date if we are unable to provide the service due to unfavorable weather conditions or technical/mechanical issues.</p>
                                        
            </div>
        </div>
    </div>
</div>
                                            

<?php
    // include contact form to each page
    $dir = config_item('global_layout_dir');
    $contact_form = APPPATH . 'views/'.$dir.'_global/include/paypal_form.php';
    include_once($contact_form);
?>
