<?php
/**
 * Elgg Search css
 * 
 */
?>

/**********************************
Search plugin
***********************************/
.elgg-page-header .elgg-search {
	bottom: 57px;
	height: 31px;
	position: absolute;
	right: 10px;
	background:#ffffff;
	padding-right:60px;
	-moz-border-radius:18px;
	-webkit-border-radius:18px;
	border-radius:18px;
	-moz-box-shadow:    inset 0 0 2px #000000;
	-webkit-box-shadow: inset 0 0 2px #000000;
	box-shadow:         inset 0 0 2px #000000;
}
.front_left {
	width:420px;
	margin-left:50px;
	}
.front_right {
	width:420px;
	margin-right:50px;
	}
.search-input {
	border:none;
	}
.elgg-page-header .elgg-search input[type=text] {
	width: 166px;
}
.elgg-page-header .elgg-search input[type=submit] {
	display: none;
}
.elgg-search input[type=text] {
	color: #333;
	font-size: 12px;
	font-weight: bold;
	padding: 2px 4px 2px 26px;
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat 2px -934px;
	margin-top:6px;
	margin-left:6px;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active {
	background-position: 2px -916px;
	color: #0054A7;
	border:none;
}

.search-list li {
	padding: 5px 0 0;
}
.search-heading-category {
	margin-top: 20px;
	color: #666666;
}

.search-highlight {
	background-color: #bbdaf7;
}
.search-highlight-color1 {
	background-color: #bbdaf7;
}
.search-highlight-color2 {
	background-color: #A0FFFF;
}
.search-highlight-color3 {
	background-color: #FDFFC3;
}
.search-highlight-color4 {
	background-color: #ccc;
}
.search-highlight-color5 {
	background-color: #4690d6;
}