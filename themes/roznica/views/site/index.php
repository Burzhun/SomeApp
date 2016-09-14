<link href="/themes/roznica/js/nivo-slider/nivo-slider.css" rel="stylesheet" type="text/css">
<script src="/themes/roznica/js/nivo-slider/jquery.nivo.slider.pack.js"></script>
<?$banners = Carousel::model()->getByType(1, true);?>
<?if($banners){?>
	<div class='slide'>
		<div id="slider-wrapper">
			<div id="slider" class='loadNiva'>
				<?foreach ($banners as $data) {?>
					<a href="<?=$data->url?>"  class="bannerOnMan">
						<img src="/uploads/<?=$data->image;?>"  title=''>
					</a>
				<?}?>
			</div>
		</div>

		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').removeClass("loadNiva");
				$('#slider').nivoSlider({
					    effect: 'fade',

				});
			});
		</script>


	</div>
			<?}?>
<?/*
<a href="#" class="bannerOnMan">
	<img src="/themes/roznica/img/banner.png" alt="">
</a> */?>