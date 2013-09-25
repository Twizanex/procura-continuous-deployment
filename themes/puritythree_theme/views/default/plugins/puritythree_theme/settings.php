<?php
	$frontleft = $vars['entity']->frontleft;
		if (!$frontleft) $frontleft='<h2>You can edit this information in the admin section of this theme.</h2>';
	$frontright = $vars['entity']->frontright;
		if (!$frontright) $frontright='<h2>You can edit this information in the admin section of this theme.</h2>';
	$bodyc = $vars['entity']->bodyc;
		if (!$bodyc) $bodyc = 'ffffff';
	$pagec = $vars['entity']->pagec;
		if (!$pagec) $pagec = 'dddddd';
	$logoc = $vars['entity']->logoc;
		if (!$logoc) $logoc = 'ffffff';
	$desc = $vars['entity']->desc;
		if (!$desc) $desc = '333333';
	$socc = $vars['entity']->socc;
		if (!$socc) $socc = '3B5998';
	$page = $vars['entity']->page;
		if (!$page) $page = '1E9833';
	$pagea = $vars['entity']->page;
		if (!$pagea) $pagea = '3B5998';
	$pagepattern = $vars['entity']->pagepattern;
		if (!$pagepattern) $pagepattern = '10';
	$bodypattern = $vars['entity']->bodypattern;
		if (!$bodypattern) $bodypattern = '13';
	$smpattern = $vars['entity']->smpattern;
		if (!$smpattern) $smpattern = '11';
	$image1 = $vars['entity']->image1;
		if (!$image1) $image1 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img1.jpg';
	$image2 = $vars['entity']->image2;
		if (!$image2) $image2 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img2.jpg';
	$image3 = $vars['entity']->image3;
		if (!$image3) $image3 = $vars['url'] . 'mod/puritythree_theme/graphics/slider/img3.jpg';
?>
<style>
.pattern {
	text-align:center;
	font-size:30px;
	width:100px;
	height:56px;
	border:1px solid #000000;
	padding-top:44px;
	color:#ffffff;
	text-shadow:1px 1px 0px #000000;
	margin:5px;
	float:left;
	}
.one {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/1.png) #<?php echo $bodyc; ?>;
	}
.two {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/2.png) #<?php echo $bodyc; ?>;
	}
.three {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/3.png) #<?php echo $bodyc; ?>;
	}
.four {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/4.png) #<?php echo $bodyc; ?>;
	}
.five {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/5.png) #<?php echo $bodyc; ?>;
	}
.six {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/6.png) #<?php echo $bodyc; ?>;
	}
.seven {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/7.png) #<?php echo $bodyc; ?>;
	}
.eight {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/8.png) #<?php echo $bodyc; ?>;
	}
.nine {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/9.png) #<?php echo $bodyc; ?>;
	}
.ten {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/10.png) #<?php echo $bodyc; ?>;
	}
.eleven {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/11.png) #<?php echo $bodyc; ?>;
	}
.twelve {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/12.png) #<?php echo $bodyc; ?>;
	}
.thirteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/13.png) #<?php echo $bodyc; ?>;
	}
.fourteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/14.png) #<?php echo $bodyc; ?>;
	}
.fifteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/15.png) #<?php echo $bodyc; ?>;
	}
.sixteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/16.png) #<?php echo $bodyc; ?>;
	}
.seventeen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/17.png) #<?php echo $bodyc; ?>;
	}
.eightteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/18.png) #<?php echo $bodyc; ?>;
	}
.nineteen {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/19.png) #<?php echo $bodyc; ?>;
	}
.twenty {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/patterns/20.png) #<?php echo $bodyc; ?>;
	}
.none {
	background:url(<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/slash.png) center center no-repeat #ffffff;
	}
	
</style>
<div style="width:100%;">
		<label>Front left text area:</label>
		<?php
			echo elgg_view('input/longtext', array('name'=>'params[frontleft]','value'=>$frontleft));
		?>
		<br/>
		<label>Front right text area:</label>
		<?php
			echo elgg_view('input/longtext', array('name'=>'params[frontright]','value'=>$frontright));
		?>
</div>
<center><img src="<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/map1.png"></img></center>
<center><img src="<?php echo $vars['url']; ?>mod/puritythree_theme/graphics/map2.png"></img></center>
<div style="width:210px;float:left;margin:10px;">
		<label>1.  Social menu background:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[socc]','value'=>$socc,'class'=>'color'));
		?>


</div>
<div style="clear:both;"></div>
<div style="width:210px;float:left;margin:10px;">
		<label>2.  Body background:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[bodyc]','value'=>$bodyc,'class'=>'color'));
		?>
		<label>3.  Page background:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[pagec]','value'=>$pagec,'class'=>'color'));
		?>
</div>
<div style="width:210px;float:left;margin:10px;">
		<label>4.  Logo color:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[logoc]','value'=>$logoc,'class'=>'color'));
		?>

		<label>5.  Site description:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[desc]','value'=>$desc,'class'=>'color'));
		?>
</div>
<div style="width:210px;float:left;margin:10px;">
		<label>6.  Page menu hover:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[page]','value'=>$page,'class'=>'color'));
		?>
		<label>7.  Page menu active:</label>
		<?php
			echo elgg_view('input/text', array('name'=>'params[pagea]','value'=>$pagea,'class'=>'color'));
		?>
	</div>
	<div style="clear:both;"></div>
	<div>
		<label>8.  Body background pattern:</label>
		<div style="clear:both;"></div>
		<div class="pattern none"><input type="radio" <?php if ($bodypattern == 'none') echo 'checked = "checked"'; ?> name="params[bodypattern]" value="none"></input></div>
		<div class="pattern one"><input type="radio" <?php if ($bodypattern == '1') echo 'checked = "checked"'; ?>    name="params[bodypattern]" value="1"></input></div>
		<div class="pattern two"><input type="radio" <?php if ($bodypattern == '2') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="2"></input></div>
		<div class="pattern three"><input type="radio" <?php if ($bodypattern == '3') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="3"></input></div>
		<div class="pattern four"><input type="radio" <?php if ($bodypattern == '4') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="4"></input></div>
		<div class="pattern five"><input type="radio" <?php if ($bodypattern == '5') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="5"></input></div>
		<div class="pattern six"><input type="radio" <?php if ($bodypattern == '6') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="6"></input></div>
		<div class="pattern seven"><input type="radio" <?php if ($bodypattern == '7') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="7"></input></div>
		<div class="pattern eight"><input type="radio" <?php if ($bodypattern == '8') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="8"></input></div>
		<div class="pattern nine"><input type="radio" <?php if ($bodypattern == '9') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="9"></input></div>
		<div class="pattern ten"><input type="radio" <?php if ($bodypattern == '10') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="10"></input></div>
		<div class="pattern eleven"><input type="radio" <?php if ($bodypattern == '11') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="11"></input></div>
		<div class="pattern twelve"><input type="radio" <?php if ($bodypattern == '12') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="12"></input></div>
		<div class="pattern thirteen"><input type="radio" <?php if ($bodypattern == '13') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="13"></input></div>
		<div class="pattern fourteen"><input type="radio" <?php if ($bodypattern == '14') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="14"></input></div>
		<div class="pattern fifteen"><input type="radio" <?php if ($bodypattern == '15') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="15"></input></div>
		<div class="pattern sixteen"><input type="radio" <?php if ($bodypattern == '16') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="16"></input></div>
		<div class="pattern seventeen"><input type="radio" <?php if ($bodypattern == '17') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="17"></input></div>
		<div class="pattern eightteen"><input type="radio" <?php if ($bodypattern == '18') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="18"></input></div>
		<div class="pattern nineteen"><input type="radio" <?php if ($bodypattern == '19') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="19"></input></div>
		<div class="pattern twenty"><input type="radio" <?php if ($bodypattern == '20') echo 'checked = "checked"'; ?>  name="params[bodypattern]" value="20"></input></div>
		<div style="clear:both;"></div>
		
		<label>9.  Page background pattern:</label>
		<div style="clear:both;"></div>
		<div class="pattern none"><input type="radio" <?php if ($pagepattern == 'none') echo 'checked = "checked"'; ?>  name="params[pagepattern]" value="none"></input></div>
		<div class="pattern one"><input type="radio" <?php if ($pagepattern == '1') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="1"></input></div>
		<div class="pattern two"><input type="radio" <?php if ($pagepattern == '2') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="2"></input></div>
		<div class="pattern three"><input type="radio" <?php if ($pagepattern == '3') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="3"></input></div>
		<div class="pattern four"><input type="radio" <?php if ($pagepattern == '4') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="4"></input></div>
		<div class="pattern five"><input type="radio" <?php if ($pagepattern == '5') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="5"></input></div>
		<div class="pattern six"><input type="radio" <?php if ($pagepattern == '6') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="6"></input></div>
		<div class="pattern seven"><input type="radio" <?php if ($pagepattern == '7') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="7"></input></div>
		<div class="pattern eight"><input type="radio" <?php if ($pagepattern == '8') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="8"></input></div>
		<div class="pattern nine"><input type="radio" <?php if ($pagepattern == '9') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="9"></input></div>
		<div class="pattern ten"><input type="radio" <?php if ($pagepattern == '10') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="10"></input></div>
		<div class="pattern eleven"><input type="radio" <?php if ($pagepattern == '11') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="11"></input></div>
		<div class="pattern twelve"><input type="radio" <?php if ($pagepattern == '12') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="12"></input></div>
		<div class="pattern thirteen"><input type="radio" <?php if ($pagepattern == '13') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="13"></input></div>
		<div class="pattern fourteen"><input type="radio" <?php if ($pagepattern == '14') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="14"></input></div>
		<div class="pattern fifteen"><input type="radio" <?php if ($pagepattern == '15') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="15"></input></div>
		<div class="pattern sixteen"><input type="radio" <?php if ($pagepattern == '16') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="16"></input></div>
		<div class="pattern seventeen"><input type="radio" <?php if ($pagepattern == '17') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="17"></input></div>
		<div class="pattern eightteen"><input type="radio" <?php if ($pagepattern == '18') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="18"></input></div>
		<div class="pattern nineteen"><input type="radio" <?php if ($pagepattern == '19') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="19"></input></div>
		<div class="pattern twenty"><input type="radio" <?php if ($pagepattern == '20') echo 'checked = "checked"'; ?>   name="params[pagepattern]" value="20"></input></div>
		<div style="clear:both;"></div>
		
		<label>10.  Social menu background pattern:</label>
		<div style="clear:both;"></div>
		<div class="pattern none"><input type="radio" <?php if ($smpattern == 'none') echo 'checked = "checked"'; ?>  name="params[smpattern]" value="none"></input></div>
		<div class="pattern one"><input type="radio" <?php if ($smpattern == '1') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="1"></input></div>
		<div class="pattern two"><input type="radio" <?php if ($smpattern == '2') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="2"></input></div>
		<div class="pattern three"><input type="radio" <?php if ($smpattern == '3') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="3"></input></div>
		<div class="pattern four"><input type="radio" <?php if ($smpattern == '4') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="4"></input></div>
		<div class="pattern five"><input type="radio" <?php if ($smpattern == '5') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="5"></input></div>
		<div class="pattern six"><input type="radio" <?php if ($smpattern == '6') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="6"></input></div>
		<div class="pattern seven"><input type="radio" <?php if ($smpattern == '7') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="7"></input></div>
		<div class="pattern eight"><input type="radio" <?php if ($smpattern == '8') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="8"></input></div>
		<div class="pattern nine"><input type="radio" <?php if ($smpattern == '9') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="9"></input></div>
		<div class="pattern ten"><input type="radio" <?php if ($smpattern == '10') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="10"></input></div>
		<div class="pattern eleven"><input type="radio" <?php if ($smpattern == '11') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="11"></input></div>
		<div class="pattern twelve"><input type="radio" <?php if ($smpattern == '12') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="12"></input></div>
		<div class="pattern thirteen"><input type="radio" <?php if ($smpattern == '13') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="13"></input></div>
		<div class="pattern fourteen"><input type="radio" <?php if ($smpattern == '14') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="14"></input></div>
		<div class="pattern fifteen"><input type="radio" <?php if ($smpattern == '15') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="15"></input></div>
		<div class="pattern sixteen"><input type="radio" <?php if ($smpattern == '16') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="16"></input></div>
		<div class="pattern seventeen"><input type="radio" <?php if ($smpattern == '17') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="17"></input></div>
		<div class="pattern eightteen"><input type="radio" <?php if ($smpattern == '18') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="18"></input></div>
		<div class="pattern nineteen"><input type="radio" <?php if ($smpattern == '19') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="19"></input></div>
		<div class="pattern twenty"><input type="radio" <?php if ($smpattern == '20') echo 'checked = "checked"'; ?>   name="params[smpattern]" value="20"></input></div>
		<div style="clear:both;"></div>
	</div>
	<div>
	<label>Path to slider image 1:</label>
	<?php
		echo elgg_view('input/text', array('name'=>'params[image1]','value'=>$image1));
	?>
	<label>Path to slider image 2:</label>
	<?php
		echo elgg_view('input/text', array('name'=>'params[image2]','value'=>$image2));
	?>
	<label>Path to slider image 3:</label>
	<?php
		echo elgg_view('input/text', array('name'=>'params[image3]','value'=>$image3));
	?>