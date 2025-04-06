<div class="uk-section">
	<div class="uk-container">
		<p class="uk-text-lead"><?= lang('transfers-intro', array('<br>', '<strong>', '</strong>')); ?></p>
	</div>
</div>

<div data-js-transfers-form-scope>
	<div class="uk-section uk-section-muted">
		<div class="uk-container">
			<div class="uk-margin-large">
				<h2>Sea Transfer Booking</h2>
				<p><?= lang('transfers-intro-instruction', array('<a href="#jump-to-contact-section" data-uk-scroll>', '</a>')); ?></p>
			</div>
			<form class="uk-form-stacked" id="jump-to-transfers-booking-form">
				<input type="hidden" data-js-transfer-rates value="<?= $this->transfers->getTransferRatesJson() ?>">
				<input type="hidden" data-js-transfer-php-config value="<?= $this->transfers->getJsTransfersConfigJson() ?>">
				<input type="hidden" data-js-txt-alert-transfer-destination-error value="<?= lang('transfers-alert-destination-error'); ?>">
				<input type="hidden" data-js-txt-alert-other-destinations value="<?= lang('transfers-alert-other-destinations'); ?>">

				<div data-uk-grid class="uk-grid uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-divider">
					<div>
						<div class="uk-margin">
							<label for="fld-transfer-from" class="uk-form-label"><?= lang('transfers-form-fld-from'); ?></label>
							<div class="uk-button-group he-input-group">
								<div class="uk-form-controls">
									<select id="fld-transfer-from" class="uk-select" data-js-fld-transfer-from>
										<?= $this->transfers->getDestinationOptionsHtml($this->transfers->config('DEFAULT_OPTION')); ?>
									</select>
								</div>
								<div class="uk-inline">
									<button type="button" data-js-btn-fld-reverse class="uk-input uk-button uk-button-default"
										title="<?= lang('transfers-form-btn-reverse'); ?>">
										<span aria-hidden="true" data-uk-icon="icon: arrow-down; ratio: 1.3"></span>
										<span class="sr-only"><?= lang('transfers-form-btn-reverse'); ?></span>
										<span aria-hidden="true" data-uk-icon="icon: arrow-up; ratio: 1.3"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="uk-margin">
							<label for="fld-transfer-to" class="uk-form-label"><?= lang('transfers-form-fld-to'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-transfer-to" class="uk-select" data-js-fld-transfer-to>
									<?= $this->transfers->getDestinationOptionsHtml($this->transfers->config('DEFAULT_SECONDARY_OPTION')); ?>
								</select>
							</div>
						</div>

						<span class="he-link-with-icon">
							&nbsp;
							<span data-uk-icon="icon: info; ratio: 1.3" class="he-link-with-icon__icon uk-icon"></span>
							<a class="he-link-with-icon__link" href="#jump-to-contact-section" data-uk-scroll data-js-other-transfer-destinations><?= lang('transfers-link-other-destinations'); ?></a>
						</span>
					</div>

					<div>
						<div class="uk-margin">
							<label for="fld-transfer-pax" class="uk-form-label"><?= lang('transfers-form-fld-pax'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-transfer-pax" class="uk-select" data-js-fld-transfer-pax>
									<?= $this->transfers->getPaxOptionsHtml(lang('transfers-form-fld-pax-format')); ?>
								</select>
							</div>
						</div>

						<div class="uk-margin">
							<label for="fld-transfer-pickup-time" class="uk-form-label"><?= lang('transfers-form-pickup-time'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-transfer-pickup-time" class="uk-select" data-js-fld-transfer-pickup-time>
									<?= $this->transfers->getPickUpTimeOptionsHtml('%02d:%02d%s (%02d:%02dh)'); ?>
								</select>
							</div>
						</div>

						<div class="uk-margin">
							<label for="fld-transfer-pickup-date" class="uk-form-label"><?= lang('transfers-form-pickup-date'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-transfer-pickup-date" class="uk-select" data-js-fld-transfer-pickup-date>
									<?= $this->transfers->getPickUpDateOptionsHtml('Y. M d. l'); ?>
								</select>
							</div>
						</div>
					</div>

					<div class="uk-width-expand uk-text-center">
						<div class="he-booking-price uk-text-nowrap">
							<span class="he-booking-price__currency">&euro;</span>
							<span class="he-booking-price__amount"><span data-js-txt-transfer-price>0</span>,-</span>
						</div>
						
						<?php
						//<button data-js-btn-book-transfer type="button" class="uk-button uk-button-primary">Book now</button>
						?>
						<a class="uk-button uk-button-primary" href="#jump-to-contact-section" data-uk-scroll> Contact Us</a>
					</div>
				</div>
			</form>
			
			<div data-uk-alert class="uk-alert-primary" data-js-alert-transfer-price-hint hidden>
				<a data-uk-close class="uk-alert-close"></a>
				<div data-uk-grid class="uk-grid uk-grid-collapse">
					<div data-uk-icon="icon: happy; ratio: 1.4" class="uk-margin-right"></div>
					<div class="uk-width-expand">
						<p><?= lang('transfers-alert-price-hint', array(
							'<strong>',
							'</strong>',
							$this->transfers->config('OFFTIME_MIN_AM'),
							$this->transfers->config('OFFTIME_MAX_AM'),
							$this->transfers->config('OFFTIME_MIN_PM'),
							$this->transfers->config('OFFTIME_MAX_PM'),
						)); ?></p>
					</div>
				</div>
			</div>
			<div data-uk-alert class="uk-alert-primary" data-js-alert-transfer-price-hint-night hidden>
				<a data-uk-close class="uk-alert-close"></a>
				<div data-uk-grid class="uk-grid uk-grid-collapse">
					<div data-uk-icon="icon: clock; ratio: 1.4" class="uk-margin-right"></div>
					<div class="uk-width-expand">
						<p><?= lang('transfers-alert-price-hint-night', array(
							'<strong>',
							'</strong>',
							$this->transfers->config('OFFTIME_MIN_AM'),
							$this->transfers->config('OFFTIME_MAX_AM'),
							$this->transfers->config('OFFTIME_MIN_PM'),
							$this->transfers->config('OFFTIME_MAX_PM'),
						)); ?></p>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>

<div class="uk-section">
	<div class="uk-container">
		<div data-uk-grid class="uk-grid">
			<div class="uk-width-2-3@l">
				<!-- TODO: Translations -->
				<h2>FAQ</h2>
				<h3>Why sea transfer?</h3>
				<p>Comfort and flexibility is the main advantage of a private sea transfer over the local transport, ferries
				and catamarans. No stress about planning or luggage handling across several means of
				transportation. You are picked-up in the time and place of your choice and dropped-off at any
				desired destination (e.g. port, airport vicinity, fuel station, sailing club, hotel...). Allow Croatian crystal
				blue sea to surprise you with an unforgettable unique experience. Could you imagine a feeling of a
				wind in your hair and drops of salty water in the air while enjoying the view of beautiful Croatian
				coast? Spoil yourself with your very own fully private speedboat.</p>
				<h3>Difference between sea transfer and public transport?</h3>
				<p>Sea transfer is an “on demand” taxi service on the water. You choose the pick-up and drop-off times
				and destinations according to your preferences. Sea transfer is fully private and flexible.</p>
				<h3>What’s included in the transfer price?</h3>
				<p>Sea transfer price includes a private speedboat, professional skipper, fuel cost and all other operative
				expenses for the transport of selected number of passengers and the luggage. There are no extra
				charges to the online price.</p>
				<h3>What’s not included in the transfer price?</h3>
				<p>There are no extra charges. Total price you see is all you will pay.</p>
				<h3>Does the prices includes the luggage transport?</h3>
				<p>The price does include the transport of hand luggage for all passengers free of charge.</p>
				<h3>How affordable is a private sea transfer?</h3>
				<p>Often, especially for groups a private sea transfer can be the most convenient and affordable option
				to reach Hvar from Split Airport, Dubrovnik or similar. Taking into account notably shorter travel time
				and only a single mean of transportation the price difference might be a no brainier. After all having
				a private boat is considered a luxurious service and an experience that could not be comparable to
				the local transport by no means. Treat yourself with an added value to your holiday.</p>
				<h3>Duration of a private sea transfer?</h3>
				<p>Private sea transfer is the fastest transportation option to reach Hvar from the coast and vice versa.
				Those high class speedboats are equipped with powerful engines that cannot be outperformed by
				any of public transportation boats, ferries or catamarans. Additionally taking into account that only
				loading or unloading times of public boats are approximately 30min, aside not being dropped-off at
				the nearest desired location you can be sure there is no faster option. If you want to get there fast,
				avoid queues and use only one mean of transport, sea transfer is the way to go.</p>
				<h3>Sea transfer: Hvar – Split Airport</h3>
				<p>Sea transfer is surely the most convenient and time-efficient option for the route Split Airport – Hvar
				and vice versa. This is due to a fact that the airport is located in the near proximity to the sea what
				makes it directly accessible to Hvar Island. Closest sea dock Divulje is only 700 meters (0.5mi) from
				the airport which one could reach simply by foot or ordering a taxi service (we can arrange). By using
				a private boat transfer you eliminate the necessity of switching between a taxi and bus between Split
				harbor, traffic, waiting queues and slow local ferry transport. In the end you would probably spend
				half a day to reach the destination while paying total not much less than the cost of a direct sea
				transfer. Duration of the sea transfer is usually 60-75min for Split Airport and 45-60min for Split
				harbor. Have more time to enjoy your holiday!</p>
				<h3>Sea transfer: Hvar – Dubrovnik</h3>
				<p>The given price includes a regular 7-8m long boat with 150-200hp engine capable of the sea transfer
				route Hvar – Dubrovnik and vice versa. On request, even for smaller groups there is an option to pay
				a surcharge of total 250-300€ for a bigger 300hp boat. Bigger boat is generally more comfortable on
				the open sea and a bit faster. But both will do a good job for you. In case you wish to do so please
				contact us directly after the booking. Duration of the sea transfer is usually 3.5-4h directly but often
				the passengers would request a refreshment on the way, swimming or lunch stop in the town of
				Korcula, Mljet Island, Peljesac or similar.</p>
				<h3>Who operates the sea transfer?</h3>
				<p>We are direct owners of the website and the boats so the transfers are organized and operated
				exclusively by us. The advantage is that there are no mediation fees and we can guarantee that the
				boats operating sea transfers from Hvar are in a perfect shape.</p>
				<h3>Can you have a boat of your choice?</h3>
				<p>For the purpose of the sea transfer we use the most appropriate boat depending on the number of
				passengers, distance, weather condition and the boat availability. There is no option to choose the
				boat specifically in the regular price of a sea transfer service. If you want to choose the specific boat
				you should consider a renting option. You can rent a desired boat regularly with an additional
				payment for the skipper and the fuel. If you wish to rent a boat please visit our
				<a href="<?= site_url('rentals') ?>">rental page</a> or contact us directly.</p>
				<h3>Combining sea transfer and excursion</h3>
				<p>It’s great idea to combine sea transfer and excursion because you only pay one service with an extra
				charge for the fuel depending on the planned route and the engine power. It works the same as a
				renting a boat with skipper. You can rent a desired boat regularly with an additional payment for the
				skipper and the fuel. If you wish to rent a boat please visit our
				<a href="<?= site_url('rentals') ?>">rental page</a> or contact us directly.</p>
				<h3>Can I get a discount?</h3>
				<p>Online price is the lowest it gets unless the larger groups are in question or you inquire for the
				return transfer too. In those cases please contact us directly. In general the lower prices
				for the sea transfer directions Split and Split Airport are achieved by choosing off-peak hours 6am-
				9am or 6pm-9pm. It’s getting more expensive in the night or rush hours during the day. This is
				something one might consider to cut down the price. The total price is defined per boat amortization,
				licensing, skipper cost and other operative costs but the major part goes to the fuel which is
				enormous for these powerful engines. That’s why the price is thoroughly calculated based on the
				distance and number of passengers.</p>
				<h3>How do I book sea transfer?</h3>
				<p>To confirm a reservation we require a deposit payment of up to 30% total amount upfront. To
				complete the booking please follow these steps: 1. Choose sea transfer origin and destination; 2.
				Select the desired date, time and number of passengers; 3. Check the price and click the booking
				button. You will be now forwarded to secure PayPal payment page in order to complete your
				booking by paying a deposit. Remaining amount will be charged upon the succeeded sea transfer
				in cash.</p>
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