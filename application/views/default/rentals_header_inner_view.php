<div class="uk-position-center">
    <div class="uk-container uk-light">
        <h1 class="he-header-section__title"><?= lang('rentals-header-title'); ?></h1>
        <div class="he-header-section__subtitle"><?= lang('rentals-header-subtitle'); ?></div>
    </div>
    <div class="he-rentals-datepicker-section" data-js-rentals-datepicker-scope>
        <div class="uk-container">
            <input type="hidden" data-js-conf-rentals-season-begin-date value="<?= $this->pricelist->getBookableDatePeriodString()['seasonBeginDate']; ?>">
            <input type="hidden" data-js-conf-rentals-bookable-min-date value="<?= $this->pricelist->getBookableDatePeriodString()['startDate']; ?>">
            <input type="hidden" data-js-conf-rentals-bookable-max-date value="<?= $this->pricelist->getBookableDatePeriodString()['endDate']; ?>">
            <input type="hidden" data-js-ajax-url-rentals-get-rates value="<?= site_url('rentals/ajax_get_range_rates'); ?>">
            
            <div class="uk-form-horizontal uk-cust-from--transparent" data-uk-margin>
                <div class="uk-inline">
                    <label for="fld-rentals-date-from" class="sr-only"><?= lang('rentals-fld-date-from'); ?></label>
                    <input data-js-fld-rentals-date-from id="fld-rentals-date-from" type="text" placeholder="<?= lang('rentals-fld-date-from'); ?>" class="uk-input he-rentals-datepicker-input">
                    <a data-js-toggle-icon-rentals-date-from class="uk-form-icon uk-form-icon-flip" href="javascript:void(0)" uk-icon="icon: calendar"></a>
                </div>
                <div class="uk-inline">
                    <label for="fld-rentals-date-to" class="sr-only"><?= lang('rentals-fld-date-to'); ?></label>
                    <input data-js-fld-rentals-date-to id="fld-rentals-date-to" type="text" placeholder="<?= lang('rentals-fld-date-to'); ?>" class="uk-input he-rentals-datepicker-input">
                    <a data-js-toggle-icon-rentals-date-to class="uk-form-icon uk-form-icon-flip" href="javascript:void(0)" uk-icon="icon: calendar"></a>
                </div>
                
                <a data-js-btn-with-loading-state data-js-btn-container-is-loading-class="he-transparent-container"
                   data-js-btn-rental-search
                   data-uk-scroll href="#jump-to-rentals-content"
                   class="uk-button uk-button-highlighted he-rentals-datepicker-btn" role="button">
                    <span data-js-btn-icon-toggle data-uk-spinner="ratio: 0.8" hidden></span>
                    <span data-js-btn-text-toggle=""><?= lang('rentals-btn-submit'); ?></span>
                </a>
            </div>
    
        </div>   
    </div>
</div>
