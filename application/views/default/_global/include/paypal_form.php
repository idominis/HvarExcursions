<div data-uk-modal data-js-booking-form-scope
	 data-js-lang-booking-form-remaining="<?=lang('pp-remaining')?>"
	 data-js-lang-booking-form-total="<?=lang('pp-total')?>"
	>
    <div class="uk-modal-dialog uk-modal-body">
		<button data-uk-close class="uk-modal-close-default" type="button"></button>
		
		<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">-->
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

			<!--<input type="hidden" name="business" value="5HL7FEY5G6VTY">-->
			<input type="hidden" name="business" value="27DKX5DHMHKFG">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="charset" value="UTF-8">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="currency_code" value="EUR">
			<input type="hidden" name="button_subtype" value="services">
			<input type="hidden" name="item_name" value="" data-js-fld-booking-form-item-name>
			<input type="hidden" name="custom" value="" data-js-fld-booking-form-pp-custom>
			<input type="hidden" name="item_number" value="" data-js-fld-booking-form-item-number>
			<input type="hidden" name="amount" value="" data-js-fld-booking-form-pp-amount>
			<input type="hidden" name="memo" value="TODO: TEST: Luka javi ako ovo vidis...">


			<div class="he-bookingform-header">
				<div class="he-bookingform-header__featured">
					<input class="he-bookingform-header__image" type="image" src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="Submit" />
					<button type="submit" class="he-bookingform-submit-btn he-bookingform-header__btn uk-button uk-button-primary">
						<span class="he-bookingform-submit-btn__icon" data-uk-icon="icon: cart; ratio: 1.25"></span>
						<?=lang('booking_btn_paypal_checkout')?>
					</button>
				</div>
				<h2 class="he-bookingform-header__heading">
					<small class="he-bookingform-header__heading-category"><span data-js-txt-booking-form-item-category-name></span>:</small>
					<span data-js-txt-booking-form-item-name></span>
				</h2>
			</div>

			<div class="he-bookingform-details">
				<strong><?=lang('booking_deposit')?></strong>
				<div class="he-bookingform-price uk-text-nowrap">
					<span class="he-bookingform-price__currency">&euro;</span>
					<span class="he-bookingform-price__amount"><span data-js-txt-booking-form-pp-amount></span>,-</span>
				</div>
				<div>
					<strong class="uk-text-nowrap"><?=lang('total_price')?></strong>
					<span class="uk-text-nowrap">&euro; <span data-js-txt-booking-form-total-amount></span>,00</span>
				</div>
				<div>
					<strong class="uk-text-nowrap"><?=lang('remaining_amount')?></strong>
					<span class="uk-text-nowrap">&euro; <span data-js-txt-booking-form-remaining-amount></span>,00</span>
				</div>
				<div data-js-cont-booking-form-pax>
					<strong class="uk-text-nowrap"><?=lang('total_persons')?></strong>
					<span data-js-txt-booking-form-pax></span>
				</div>
				<div>
					<strong class="uk-text-nowrap"><?=lang('date')?></strong>
					<span data-js-txt-booking-form-date></span>
				</div>
				<div data-js-cont-booking-form-fuel
					 data-js-lang-booking-form-fuel-incl="<?=lang('fuel_policy_incl')?>"
					 data-js-lang-booking-form-fuel-excl="<?=lang('fuel_policy_excl')?>">
					<strong class="uk-text-nowrap"><?=lang('fuel_policy')?></strong>
					<span data-js-txt-booking-form-fuel></span>
				</div>		
			</div>

			<div data-uk-alert class="uk-alert-warning">
				<div data-uk-grid class="uk-grid uk-grid-collapse">
					<div data-uk-icon="icon: warning; ratio: 1.4" class="uk-margin-right"></div>
					<div class="uk-width-expand"><?=lang('booking_note')?></div>
				</div>
			</div>

			<ul data-uk-accordion class="he-bookingform-instructions">
				<li class="uk-open">
					<a class="uk-accordion-title" href="#">
						<?=lang('booking_info1_title')?>
					</a>
					<div class="uk-accordion-content">
						<?=lang('booking_info1_text')?>
					</div>
				</li>
				<li>
					<a class="uk-accordion-title" href="#">
						<?=lang('booking_info2_title')?>
					</a>
					<div class="uk-accordion-content">
						<?=lang('booking_info2_text')?>
					</div>
				</li>
				<li>
					<a class="uk-accordion-title" href="#">
						<?=lang('booking_info3_title')?>
					</a>
					<div class="uk-accordion-content">
						<?=lang('booking_info3_text')?>
					</div>
				</li>
			</ul>

			<div class="he-bookingform-footer" data-uk-margin>
				<button data-js-btn--booking-form-cancel type="button" class="uk-button uk-button-default">
					<?=lang('booking_btn_cancel')?>
				</button>
				<button type="submit" class="he-bookingform-submit-btn uk-button uk-button-primary">
					<span class="he-bookingform-submit-btn__icon" data-uk-icon="icon: cart; ratio: 1.25"></span>
					<?=lang('booking_btn_continue_paypal')?>
				</button>
			</div>

		</form>
    </div>
</div>
