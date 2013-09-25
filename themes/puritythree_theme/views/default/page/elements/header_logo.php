<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();
$site_description = $site->description;

?>
<div style="width:100%;height:68px;">

	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<?php echo $site_name; ?>
	</a>


<div style="clear:left;"></div>
<p style="float:left;margin-left:60px;" class="site_description"><?php echo $site_description; ?></p>
</div>