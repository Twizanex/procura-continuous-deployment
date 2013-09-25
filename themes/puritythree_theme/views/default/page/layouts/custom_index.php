<?php
if (elgg_get_config('allow_registration') != false) {
	$friend_guid = (int) get_input('friend_guid', 0);
	$invitecode = get_input('invitecode');
	$register_url = elgg_get_site_url() . 'action/register';
	if (elgg_get_config('https_login')) {
		$register_url = str_replace("http:", "https:", $register_url);
	}
	$form_params = array(
		'action' => $register_url,
		'class' => 'elgg-form-account float',
	);
	$body_params = array(
		'friend_guid' => $friend_guid,
		'invitecode' => $invitecode
	);
	$content = elgg_view_form('register', $form_params, $body_params);
	$content .= elgg_view('help/register');
} else {
	$content = '';
}
$image1 = elgg_get_plugin_setting('image1','puritythree_theme');
	if (!$image1) $image1 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img1.jpg';
$image2 = elgg_get_plugin_setting('image2','puritythree_theme');
	if (!$image2) $image2 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img2.jpg';
$image3 = elgg_get_plugin_setting('image3','puritythree_theme');
	if (!$image3) $image3 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img3.jpg';

?>

<div class="custom-index elgg-main elgg-grid clearfix">
	<div class="elgg-col elgg-col-1of2">
		<div class="elgg-inner pvm phm prl">
			<div class="front_left">
				<?php echo elgg_view('puritythree_theme/leftside'); ?>
				<?php if (!elgg_is_logged_in()) echo $content;?>
			</div>
		</div>
	</div>
	<div class="elgg-col elgg-col-1of2">
		<div class="elgg-inner pvm">
			<div class="front_right">
							<div style="margin-left:40px;">

				<?php echo elgg_view('puritythree_theme/rightside'); ?>
				<div class="slider-wrapper theme-default">
					<div id="slider" class="nivoSlider">
						<img src="<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/slider/img1.jpg" alt="" />
						<img src="<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/slider/img2.jpg" alt="" />
						<img src="<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/slider/img3.jpg" alt="" />
					</div>
				</div>
				</div>

    </div>
    <script type="text/javascript" src="<?php echo $vars['url']; ?>mod/puritythree_theme/js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>