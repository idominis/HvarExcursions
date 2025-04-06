<div class="uk-section">
	<div class="uk-container">
		<p class="uk-text-lead"><?=lang('homepage-teaser'); ?></p>
	</div>
</div>

<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<h2 data-uk-toggle="media: @m; cls: sr-only; mode: media"><?=lang('header-our-services')?></h2>

		<div data-uk-grid
			 class="uk-grid uk-child-width-expand@m">
			<div class="he-our-services">
				<a class="he-our-services__a uk-light" href="<?= site_url('rentals') ?>">
					<div class="hexagon he-our-services-hexagon he-our-services-hexagon--rentals">
						<div class="hexagon-in1">
							<div class="hexagon-in2">
								<div class="hexagon-inner">
									<h3 class="he-our-services__title uk-h2" data-uk-toggle="media: @m; cls: uk-h3; mode: media">
										<?=lang('rentals')?>
										<span aria-hidden="true" class="he-our-services__title-hexagon"></span>
									</h3>
									<ul class="he-our-services__content uk-list">
										<li><span><?=lang('rentals-bolt1')?></span></li>
										<li><span><?=lang('rentals-bolt2')?></span></li>
										<li><span><?=lang('rentals-bolt3')?></span></li>
										<li class="uk-hidden@m"><span class="uk-link"><?=lang('our-services-item-see-more')?></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</a>
				<p class="he-our-services__teaser"><?=lang('rentals-teaser')?>.</p>
			</div>
			<div class="he-our-services">
				<a class="he-our-services__a uk-light" href="<?= site_url('excursions') ?>">
					<div class="hexagon he-our-services-hexagon he-our-services-hexagon--excursions">
						<div class="hexagon-in1">
							<div class="hexagon-in2">
								<div class="hexagon-inner">
									<h3 class="he-our-services__title uk-h2" data-uk-toggle="media: @m; cls: uk-h3; mode: media">
										<?=lang('excursions')?>
										<span aria-hidden="true" class="he-our-services__title-hexagon"></span>
									</h3>
									<ul class="he-our-services__content uk-list">
										<li><span><?=lang('excursions-bolt1')?></span></li>
										<li><span><?=lang('excursions-bolt2')?></span></li>
										<li><span><?=lang('excursions-bolt3')?></span></li>
										<li class="uk-hidden@m"><span class="uk-link"><?=lang('our-services-item-see-more')?></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</a>
				<p class="he-our-services__teaser"><?=lang('excursions-teaser')?>.</p>
			</div>
			<div class="he-our-services">
				<a class="he-our-services__a uk-light" href="<?= site_url('homepage/transfers') ?>">
					<div class="hexagon he-our-services-hexagon he-our-services-hexagon--transfers">
						<div class="hexagon-in1">
							<div class="hexagon-in2">
								<div class="hexagon-inner">
									<h3 class="he-our-services__title uk-h2" data-uk-toggle="media: @m; cls: uk-h3; mode: media">
										<?=lang('transfers')?>
										<span aria-hidden="true" class="he-our-services__title-hexagon"></span>
									</h3>
									<ul class="he-our-services__content uk-list">
										<li><span><?=lang('transfers-bolt1')?></span></li>
										<li><span><?=lang('transfers-bolt2')?></span></li>
										<li><span><?=lang('transfers-bolt3')?></span></li>
										<li class="uk-hidden@m"><span class="uk-link"><?=lang('our-services-item-see-more')?></span></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</a>
				<p class="he-our-services__teaser"><?=lang('transfers-teaser')?>.</p>
			</div>
		
		</div>
	</div>
</div>

<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<h2><?=lang('header-explore')?></h2>
		<div></div><!-- for heading to get the spacing -->
	</div>
	<div class="uk-cust-container-full-width">
		<div class="uk-cust-container-full-width__inner">
			<div class="uk-light">
				<div data-uk-grid class="uk-grid uk-grid-collapse uk-child-width-1-2 uk-child-width-1-3@s">
					<div>
						<div class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-hvar.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">HVAR</div>
						</div>
					</div>
					<div>
						<div class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-pakleni.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">PAKLENI ISLANDS</div>
						</div>
					</div>
					<div>
						<div class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-korcula.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">KORCULA</div>
						</div>
					</div>
					<div>
						<a href="<?= site_url('excursions/tour_vis'); ?>" class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-modra.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">BLUE CAVE</div>
						</a>
					</div>
					<div>
						<div class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-brac.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">BOL</div>
						</div>
					</div>
					<div>
						<div class="uk-inline-clip uk-transition-toggle">
							<img class="uk-transition-scale-up uk-transition-opaque" alt="" src="<?=base_url()?>img/explore-dubrovnik.jpg">
							<div class="he-explore__title uk-transition-fade uk-position-cover uk-overlay uk-overlay-primary uk-flex uk-flex-center uk-flex-middle">DUBROVNIK</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="uk-section uk-padding-remove-top">
	<div class="uk-container">
		<div data-uk-grid class="uk-grid">
			<div class="uk-width-2-3@l">
				<h2><?=lang('header-experience')?></h2>
				<p>
					<?=lang('experience-teaser-line1')?>
					<br class="uk-hidden@m"><!-- A break only for smartphone -->
					<?=lang('experience-teaser-line2')?>
				</p>
				<last-element></last-element>
			</div>
		</div>
		<div class="he-yt-video">
			<!-- TODO: Re-uploadaj video u boljoj kvaliteti -->
			<iframe class="he-yt-video__inner" src="https://www.youtube-nocookie.com/embed/Xveg6s-j5c0" frameborder="0"
				allow="autoplay; encrypted-media" width="100%" height="100%" allowfullscreen></iframe>
		</div>
	</div>
</div>








			

	
			

