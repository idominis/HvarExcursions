<div class="uk-section">
	<div class="uk-container">
		<p class="uk-text-lead">
			Vis is not one of those islands you just visit. <strong>Vis is the island you experience!</strong>
			<br>Craving for new adventures? You are in a right place.
		</p>
	</div>
</div>

<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<ul class="uk-list uk-text-center">
			<li><span data-uk-icon="icon: heart; ratio: 3"></span></li>
			<li><strong>Vis Island, Caves and Pakleni Islands tour highlights</strong></li>
			<li>Experience <strong>swimming in Green Cave</strong> – a place where sea shimmers in shades of emerald and jade</li>
			<li>Discover one of the world's most beautiful natural wonders – <strong>Blue Cave</strong></li>
			<li>Get impressed by <strong>Stiniva beach</strong> – voted the most beautiful European beach 2016</li>
			<li>Enjoy the spectacular shapes of color-drenched <strong>cliffs and lagoons of Vis Island</strong></li>
			<li>Spoil yourself with a <strong>speed boat ride</strong> - feel the wind in your hair and salty water on your face</li>
			<li>Explore the <strong>untouched nature</strong> and secluded beaches of Vis Island</li>
			<li>Finish your day of sightseeing on <strong>Pakleni Islands</strong> – famous Croatian natural monument</li>
		</ul>
	</div>
</div>

<div data-js-tour-vis-booking-scope>
	<div class="uk-section uk-section-muted">
		<div class="uk-container">
			<div class="uk-margin-large">
				<h2>Tour Booking</h2>
				<p><?= lang('tour-vis-form-intro', array('<a href="#jump-to-contact-section" data-uk-scroll>', '</a>')); ?></p>
			</div>
			<form class="uk-form-stacked">
				<div data-uk-grid class="uk-grid uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-divider">

					<div>
						<div class="uk-margin">
							<label for="fld-tour-vis-pax" class="uk-form-label"><?= lang('tour-vis-form-fld-pax'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-tour-vis-pax" class="uk-select" data-js-fld-pax>
									<?= $this->booking->getPaxOptionsHtml(lang('tour-vis-form-fld-pax-format')); ?>
								</select>
							</div>
						</div>

						<div class="uk-margin">
							<label for="fld-tour-vis-pickup-date" class="uk-form-label"><?= lang('tour-vis-form-pickup-date'); ?></label>
							<div class="uk-form-controls">
								<select id="fld-tour-vis-pickup-date" class="uk-select" data-js-fld-pickup-date>
									<?= $this->booking->getPickUpDateOptionsHtml('Y. M d. l'); ?>
								</select>
							</div>
						</div>

						<!--TODO: Here a link for private tour?-->
					</div>

					<div class="uk-width-expand">
						<div class="he-booking-price uk-text-nowrap">
							<span class="he-booking-price__currency">&euro;</span>
							<span class="he-booking-price__amount"><span data-js-txt-price>0</span>,-</span>
							<span class="he-booking-price__hint">Price per person (Total: &euro; <span data-js-txt-price-pp>0</span>,00)</span>
						</div>

						<button data-js-btn-book type="button" class="uk-button uk-button-primary">Book now</button>
					</div>
				</div>
			</form>			
		</div>

	</div>
</div>

<div class="uk-section">
	<div class="uk-container">
		<div data-uk-grid class="uk-grid uk-grid-divider">
			<div class="uk-width-2-3@l">
				<!-- TODO: Translations -->
				<h2>Tour Details</h2>

				<p>Our "Vis Island, Caves and Pakleni Islands" sea tour offers you an island-hopping adventure you will never forget.  This daily tour begins with a cozy 45 minutes speed boat sail from Hvar Island to Green Cave. We will enter Green Cave by boat so don't miss the opportunity to capture some memories. Cave's walls and water inside shimmer and sparkle in all possible shades of blue and green. It is a one-of-a-kind scene you don't want to miss. Memories shouldn't just be captured, they also should be made. Swimming in Green Cave is for sure a memory you will treasure for the rest of your life. If you are free spirit and a true adventurer you can even jump off the Green Cave. Recommended only for professionals. </p>
				<p>The next stop of our excursion is Blue Cave, located on Biševo Island. We will get there within a 45 minutes speedboat sail. Biševo Island is our first stop where you will be able to refresh yourself. Spoiling yourself with local homemade wines is a must-do. If you loved Green Cave wait to see how amazed you will be with Blue Cave. The local guide takes you into Blue Cave with a small boat. There is the second entrance under the sea level where sunlight gets in reflecting through the water. This creates dazzling blue effect all over the Cave.</p>
				<p>Before we reach the third stop of our daily tour – Stiniva beach, we will cruise the southern coast of Vis island where you will enjoy the spectacular view of color-drenched cliffs and lagoons. Very soon you will figure out why Stiniva is the most beautiful European beach. With its great location far away from busier beaches, crystal clear water and breathtaking cliff backdrop this secluded pebble beach proved to be Croatian seaside paradise. Budikovac Island is our last stop before lunch break. This is a gorgeous lagoon with crystal clear waters and pebbly beaches.</p>
				<p>After visiting Budikovac Island we will be heading to Stončica, beautiful sandy beach on Vis Island or to Palmižana, great pebble beach on St. Klement Island (Pakleni Islands). There you can enjoy authentic Dalmatian cuisine and great homemade wines. We stop for your lunch break you won't be sorry. At the end of our sea tour you will be blown away with beautiful bay of Ždrilca (Pakleni Islands).</p>
			</div>
			<div class="uk-width-1-3@l uk-margin-large-top">
				<!-- TODO: These can be panels (uk-card? + uk-grid-large) or divider is better -->
				<h3>Included in price</h3>
				<ul>
					<li>Speedboat day + fuel</li>
					<li>Friendly tour guide</li>
				</ul>	
				<h3>Not included</h3>
				<ul>
					<li>Caves entrance fees</li>
				</ul>
				<h3>Private tour?</h3>
				<ul>
					<li>Groups bigger than 4 people might want to request the offer for a private tour. Please <a href="#jump-to-contact-section" data-uk-scroll class="smooth-scrolling">contact us</a> directly</li>
				</ul>
        </div>
	</div>
</div>

<div class="uk-section">
	<div class="uk-container">	
		<h2>Tour Gallery</h2>
		<div></div><!-- for heading to get the spacing -->
	</div>
	<div data-uk-lightbox>
		<div data-uk-grid class="uk-grid uk-grid-collapse uk-child-width-1-3 uk-child-width-1-5@s uk-child-width-1-6@m">		
			<?php
				// Images:
				// TODO: Make some image loader class, like we have already in subjects 
				// 48 slika je taman, jer je djeljivo sa 12 (bootstrap grid)
				$imgDirectory = "img/excursions/tour-vis/gallery/thumb/";
				$images = glob($imgDirectory . "*.[jJ][pP]*[gG]"); // .jpg

			for ($imageIndex = 0, $cnt = count($images); $imageIndex < $cnt; $imageIndex++): ?>
			<a href="<?=base_url(str_replace('/thumb', '', $images[$imageIndex])) ?>" class="uk-inline-clip uk-transition-toggle">
				<img src="<?=base_url($images[$imageIndex]) ?>" alt="" class="uk-transition-scale-up uk-transition-opaque">
			</a>
			<?php endfor; ?>
		</div>
	</div>
</div>
		
<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<div data-uk-grid class="uk-grid uk-margin">
			<div class="uk-width-2-3@l">
				<!-- TODO: Translations -->
				<h2>Tour Idea</h2>
				<div>
					<p>Here is only an example of a proposed excursion to get the idea how it works. It is though very difficult to have a strict schedule once we are on the open sea. The get the best out of the excursion, the tour plan is regularly modified by the skipper on the spot. Depending on the boarding issues, timing, waiting queues at caves, weather and sea currents the skipper will decide the best options.
				</div>

				<table class="uk-table uk-table-small uk-text-small uk-table-responsive uk-table-divider">
					<tr>
						<th>Time</th>
						<th>Location</th>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">09:45 - 10:15 am</strong>
						</td>
						<td>
							Hvar harbor, departure
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 10:45 am</strong>
						</td>
						<td>
							Green Cave (Ravnik islet) – swimming, sightseeing
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 12:10 am</strong>
						</td>
						<td>
							Blue Cave (Biševo Island) + refreshment pause (bar, toilet etc.)
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 01:30 pm</strong>
						</td>
						<td>
							Cliffs (southern side of Vis Island) - sightseeing cruise. Possible shorter stops for photo shooting and swimming
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 01:50 pm</strong>
						</td>
						<td>
							Stiniva beach – swimming, relaxing, photo shooting
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 02:45 pm</strong>
						</td>
						<td>
							Budikovac islet lagoon – swimming, chilling
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 03:30 pm</strong>
						</td>
						<td>
							Arrival at one of the two optional lunch stops. The location will be chosen by skipper depending on weather conditions, arrangement, time schedule etc. Lunch break takes around 1:30h.
							<br>1.)	Stončica beach (Vis Island) or
							<br>2.)	Palmižana beach (St. Klement, Pakleni Islands)
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">~ 05:30 pm</strong>
						</td>
						<td>
							Ždrilca (Pakleni Islands) – last swimming, relaxing, sunbathing
						</td>
					</tr>
					<tr>
						<td>
							<strong class="uk-text-nowrap">05:45 - 06:30 pm</strong>
						</td>
						<td>
							Hvar harbor return, arrival
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="uk-container uk-padding-remove-top">
		<div></div><!-- for heading to get the spacing -->
		<h3>Vis Caves Excursion Ideal Route</h3>
		<div></div><!-- for heading to get the spacing -->
	</div>
	<div class="uk-cust-container-full-width">
		<div class="uk-cust-container-full-width__inner">
			<a target="_blank" href="https://www.google.com/maps/d/viewer?mid=15AAHnBBGgKQchBPHg2eewl5z0Jo" class="tour-map">
				<div class="tour-map__inner"></div>
			</a>
		</div>
	</div>
</div>

<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<div data-uk-grid class="uk-grid">
			<div class="uk-width-2-3@l">
				<!-- TODO: Translations -->
				<h2>FAQ</h2>
				<h3>Caves fees and waiting queues</h3>
				<p>As of recent few years we are witnessing rapidly changing trends. Hordes of tourists are now overwhelming the caves each day in the season (July-Aug). The waiting queues are majorly increased so it’s the best advice to be prepared for that, as judging by TripAdvisor it is still worth to visit despite of the crowds. You can kill the time in the bar or on the nearby beach swimming. Also now both caves have a separate fee with no option of group or combined tickets. Unfortunately we have no influence there. We can also propose giving-up one of the caves asking the skipper to explore other beautiful locations nearby instead.</p>
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
