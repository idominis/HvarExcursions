<script type="text/javascript">

	<?php if(ENVIRONMENT === 'production'): ?>
		// Google Analytics
		// ==================================================================
		var ga_temp = (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		});
		ga_temp(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-52567332-1', 'auto');
		ga('send', 'pageview');
	<?php endif; ?>

</script>

<script src="<?= base_url('dist/bundle.js?v=1') ?>"></script>
<!--<script src="<?= base_url('dist/bundle.js?v=' . uniqid()); ?>"></script>-->
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
