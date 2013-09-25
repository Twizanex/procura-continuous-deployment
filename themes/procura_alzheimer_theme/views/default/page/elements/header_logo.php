<?php
/**
 * Procura header logo
 * sdrortega
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = elgg_get_site_url();
$site_description = $site->description;
?>
<div>   
<h1>
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
            <img src="<?php echo $site_url . 'mod/procura_alzheimer_theme/graphics/procura.png'; ?>" alt="<? echo $site_name;?>">
	</a>    
</h1>
<p class="procura-descripcion"><?php echo $site_description; ?></p> 
</div>
