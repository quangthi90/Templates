<?php
$modprd = $modSettings['prdboxStyle'];
$m = ' m3-col-2 m2-col-2 m1-col-1';
/* Mobile optimize view
******************************/	
if(
	$this->rgen->device == "m"
	&& $this->config->get('RGen_optimizemob') == 1 
	&& $this->config->get('RGen_reaponsive_status') == 1
	){
?>
	<div id="tb-<?php echo $modSettings['key'].$modSettings['moduleCount']; ?>" class="custom-tab-pane<?php 
		echo $modSettings['class'];
		echo $modSettings['css_class'];
		if ($modprd == 'prd1' || $modprd == '') { echo ' modprd1'; }
		if ($modprd == 'prd4') { echo ' modprd4'; }
		?>">
		<?php foreach ($modSettings['products'] as $product) {
			include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/common/RGen_mod_mprd1.tpl');
		} ?>
	</div>

<?php }else { 

	/* Tab view
	******************************/	
	?><div id="tb-<?php echo $modSettings['key'].$modSettings['moduleCount']; ?>" class="custom-tab-pane<?php 
		echo $modSettings['class'];
		echo $modSettings['css_class'];
		if ($modprd == 'prd1' || $modprd == '') { echo ' modprd1'; }
		if ($modprd == 'prd4') { echo ' modprd4'; }
		?>">
		<div class="box-product">
			<div class="grid-wrp gt-<?php echo isset($gridSettings['gutter']) ? $gridSettings['gutter'] : '20'; ?>">
				<div class="row<?php echo $modSettings['prdStyle'] == 'scroll' ? ' col-5' : $m; ?>" data-n=''>
					<?php echo $modSettings['prdStyle'] == 'scroll' ? '<div class="owl-carousel prdStyle-scroll">' : null; ?>
					<?php foreach ($modSettings['products'] as $product) { ?>
						<div class="col" <?php echo $modSettings['prdStyle'] != 'scroll' ? 'data-mh="'.$module.'-rgen_customproducts-prd"' : null; ?>>
							<?php
								if ($modprd == 'prd1' || $modprd == '') {
									include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/common/RGen_mod_productblock1.php');
								} elseif ($modprd == 'prd2') {
									include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/common/RGen_mod_productblock2.php');
								} elseif ($modprd == 'prd3') {
									include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/common/RGen_mod_productblock3.php');
								} elseif ($modprd == 'prd4') {
									include VQMod::modCheck('catalog/view/theme/rgen-opencart/template/common/RGen_mod_productblock4.php');
								}
							?>
						</div>
					<?php } ?>
					<?php echo $modSettings['prdStyle'] == 'scroll' ? '</div>' : null; ?>
					<b class="clearfix"></b>
				</div>
			</div>
		</div>
	</div>
<?php } ?>