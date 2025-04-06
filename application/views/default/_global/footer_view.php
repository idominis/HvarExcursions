</main>

<footer class="he-footer-section uk-section uk-light">
    <div class="he-footer-section__bg-setter uk-container">

		<h2 id="jump-to-contact-section" class="he-footer-section__heading"><?=lang('header-contact')?></h2>

		<div data-uk-grid
			 class="uk-grid uk-grid-collapse uk-flex-center">

			<form class="he-contact-form uk-width-3-5@l uk-form-stacked"
				action="<?= site_url('homepage/ajax_contact_form_submit') ?>" method="POST"
				data-js-contact-form>

				<div data-uk-grid class="uk-grid">

					<div class="uk-width-2-5@s cust-width-expand-xs-down">
						<div class="he-contact-form__input-group">
							<label for="he-fld-email" class="he-contact-form__label sr-only">
								<?=lang('form-your-email')?>
								<span class="he-contact-form__label-arrow" aria-hidden="true"></span>
							</label>
							<input class="uk-input uk-form-blank uk-form-small"
								id="he-fld-email" name="fld_email" type="email" maxlength="60"
								value="<?=set_value('fld_email')?>"
								placeholder="<?=lang('form-your-email')?>"
								data-js-fld-is-required="<?=lang('form-error-fld-email-is-required')?>"
								data-js-fld-to-focus-on-scroll>
						</div>
						<div class="he-contact-form__input-group">
							<label for="he-fld-phone" class="he-contact-form__label sr-only">
								<?=lang('form-your-phone')?>
								<span class="he-contact-form__label-arrow" aria-hidden="true"></span>
							</label>
							<input class="uk-input uk-form-blank uk-form-small"
								id="he-fld-phone" name="fld_phone" type="tel" maxlength="60"
								value="<?=set_value('fld_phone')?>"
								placeholder="<?=lang('form-your-phone-optional')?>">
						</div>
						<div class="he-contact-form__input-group">
							<label for="he-fld-subject" class="he-contact-form__label sr-only">
								<?=lang('form-subject')?>
								<span class="he-contact-form__label-arrow" aria-hidden="true"></span>
							</label>
							<input class="uk-input uk-form-blank uk-form-small"
								data-js-fld-contact-form-subject
								id="he-fld-subject" name="fld_subject" type="text" maxlength="60"
								value="<?=set_value('fld_subject')?>"
								placeholder="<?=lang('form-subject-optional')?>">
						</div>
					</div>
					<div data-uk-margin
						 class="he-contact-form__fld-message-wrapper uk-width-3-5@s uk-margin-remove-vertical cust-width-expand-xs-down">
						<div class="he-contact-form__input-group">
							<label for="he-fld-message" class="he-contact-form__label sr-only">
								<?=lang('form-message')?>
								<span class="he-contact-form__label-arrow" aria-hidden="true"></span>
							</label>
							<textarea class="he-contact-form__fld-message uk-textarea uk-form-blank uk-form-small"
								id="he-fld-message" name="fld_message" maxlength="6000" rows="8"
								placeholder="<?=lang('form-message')?>"
								data-js-fld-is-required="<?=lang('form-error-fld-message-is-required')?>"
								data-js-fld-to-toggle-captcha-on-focus><?=set_value('fld_message')?></textarea>
						</div>
						
						<div>
							<div id="g-recaptcha" class="he-contact-form-captcha" tabindex="-1"
								 data-js-captcha-is-required="<?=lang('form-error-captcha-is-required')?>"></div>
						</div>

						<div data-uk-alert class="he-contact-form__alert uk-alert-success" role="alert"
							 data-js-alert-success hidden>
							<p><?=lang('form-sent')?></p>
						</div>
						<div data-uk-alert class="he-contact-form__alert uk-alert-danger" role="alert"
							 data-js-alert-error hidden>
							<p><?=lang('form-failed')?></p>
							<p data-js-alert-error-response-text></p>
						</div>
		
						<div>
							<button data-js-btn-submit
								data-js-btn-with-loading-state data-js-btn-container-is-loading-class="he-transparent-container"
								class="uk-button uk-button-primary uk-width-2-5@s uk-width-1-2@l uk-width-expand he-btn-with-icon"
								type="submit">
								<span data-js-btn-icon-toggle data-uk-spinner="ratio: 0.8" hidden></span>
								<span data-js-btn-text-toggle="<?=lang('form-sending')?>"><?=lang('form-send')?></span>
							</button>
							<button data-js-btn-reset 
								class="uk-button uk-button-primary uk-width-2-5@s uk-width-1-2@l uk-width-expand he-btn-with-icon"
								type="reset" hidden>
								<span data-uk-icon="icon: check; ratio: 1.1"></span>
								<span><?=lang('form-reset')?></span>
							</button>
						</div>

					</div>
				</div>
			</form>

			<div class="he-info-cards uk-width-2-5@l">
				<div data-uk-grid
					 class="uk-grid uk-child-width-expand@s"
					 data-uk-toggle="media: @l; cls: uk-grid-collapse; mode: media">

					<div class="he-info-cards__item">
						<div class="he-info-cards__icon-wrapper">
							<a class="he-info-cards__icon" aria-hidden="true" href="<?=lang('general-contact-phone-href')?>">
								<span data-uk-icon="icon: receiver; ratio: 1.6"></span>
							</a>
						</div>
						<div>
							<a href="<?=lang('general-contact-phone-href')?>"><strong><?=lang('general-contact-phone')?></strong></a><br>
							<small><?=lang('general-contact-whatsapp-friendly-text')?></small>
						</div>
					</div>
					<div class="he-info-cards__item">
						<div class="he-info-cards__icon-wrapper">
							<a class="he-info-cards__icon" aria-hidden="true" href="<?=lang('general-contact-email-href')?>">
								<span data-uk-icon="icon: mail; ratio: 1.7"></span>
							</a>
						</div>
						<div>
							<a href="<?=lang('general-contact-email-href')?>"><?=lang('general-contact-email-footer')?></a>
						</div>
					</div>
					<div class="he-info-cards__item">
						<div class="he-info-cards__icon-wrapper">
							<a class="he-info-cards__icon" aria-hidden="true" href="<?=lang('general-contact-location-href')?>" target="_blank">
								<span data-uk-icon="icon: location; ratio: 1.6"></span>
							</a>
						</div>
						<div>
							<a target="_blank" href="<?=lang('general-contact-location-href')?>">
								<address>
									<strong>Bumbar Rent</strong><br>
									<small>
										<span class="uk-text-nowrap">Biskupa Dubokovića 22,</span>
										<span class="uk-text-nowrap">21450 Hvar</span>
									</small>
								</address>
							</a>
						</div>
					</div>
	
				</div>
			</div>
		</div>
	</div>

	<div class="he-footer-imprint-section">
		<div class="uk-container">
			<small>
				<address>
					<span class="uk-text-nowrap">U.O. "BUMBAR"</span>
					<span class="uk-text-nowrap">Vl. Filip Barišić;</span>
					<span class="uk-text-nowrap">MB: 92448291; OIB: 34454779189</span>
					<br>
					Address:
					<span class="uk-text-nowrap">Biskupa Dubokovića 22,</span>
					<span class="uk-text-nowrap">21450 Hvar, Croatia</span>
					<br>
					<!--IBAN HRK HR9823400093101925478;-->
					IBAN EUR
					<span class="uk-text-nowrap">HR0823400093112330445;</span>
					<span class="uk-text-nowrap">Swift: PBZGHR2X;</span>
					<span class="uk-text-nowrap">Bank name:</span>
					<span class="uk-text-nowrap">Privredna Banka Zagreb dd</span>
					<br>
					paypal:
					<span class="uk-text-nowrap">invoices@hvarexcursions.com</span>
				</address>
				<br>
				<br>
				<strong>
					<?= lang('footer_copyrightNote') ?>
					<span class="uk-text-nowrap">&copy; 2006-<?=date('Y')?></span>
					<span class="uk-text-nowrap">U.O. Bumbar</span>
					<br>
					<span class="uk-text-nowrap">www.hvarexcursions.com</span>
				</strong>
			</small>
		</div>
	</div>
</footer>


<?php

	$site_path = config_item('site_path'); // was set by rendering method argument
	$dir = config_item('global_layout_dir');

	// LOAD BOTTOM SCRIPTS
	// ===================================================================
	$default_js = APPPATH . 'views/'.$dir.'_global/include/default_footer.php';
	$lookup_js = APPPATH . 'views/'.$site_path.'_footer.php';

	if(file_exists($lookup_js)) include_once($lookup_js); // it might include() default one
	else include_once($default_js);

?>

</body>
</html>
