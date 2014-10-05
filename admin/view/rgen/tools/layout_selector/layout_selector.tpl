<?php /*

$count - counter apply
$type - category, product, manufacturer or information
$class - custom class (cat-selection)
$selectType - array( 'On all categories' => 'allc', 'On selected category' => 'selc')
$status - $module['cat_status']
$nameVal - 'rgen_customproducts_module[' . $module_row . '][cat_status]';
$holderName
$autolist_v1 - 'name'
$autolist_v2 - 'category_id'
$autolist 

URLS 
============
'index.php?route=catalog/information/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),

*/ ?>
<div class="select-wrp<?php echo ' '.$type; ?>">
	<div class="<?php echo $class; ?>" id="autoSelect<?php echo $count . $type; ?>-sel">
		<?php 
			$ar 	= array( 'All' => 'all', 'Selected' => 'sel');
			$dbKey 	= $status;
			$name	= $nameVal;
			$id		= 'auto_status' . $type . $count;
		?>
		<div class="btn-group auto-selector" data-toggle="buttons-radio">
			<?php foreach ($ar as $key => $value) { ?>
				<?php ($value ==  $dbKey) ? $selected = ' active' : $selected=''; ?>
				<label for="<?php echo $id . '-' . $value; ?>" type="button" class="btn-small btn<?php echo $selected; ?>">
					<input type="radio" id="<?php echo $id . '-' . $value; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php if ($dbKey == $value) { ?>checked="checked"<?php }?>>
					<?php echo $key; ?>
				</label>
			<?php } ?>
		</div>

		<div class="selected-items" 
			id="auto-selected<?php echo $count.$type; ?>"
			data-array="<?php echo $holderName ?>"
			style="display:<?php echo isset($status) && $status == "sel" ? "block" : 'none'; ?>;">

			<input type="text" placeholder="Type category name to insert" class="auto-textbox<?php echo ' find-'.$count . $type; ?>" value="" /><br>
            <div class="select_scrollbox scrollbox">
				<?php 
				if (isset($status) && isset($autolist)) {
				foreach ($autolist as $k => $v) { ?>
				<div><?php echo $v[$autolist_v1]; ?>
					<img src="view/image/delete.png" class="remove" />
					<input type="hidden" name="<?php echo $holderName ?>" value="<?php echo $v[$autolist_v2]; ?>" />
				</div>
				<?php } } ?>
			</div>
		</div>
	</div>
</div>
<script>
autocompleteTool(".<?php echo 'find-'.$count . $type; ?>", "<?php echo $type; ?>", "<?php echo $token; ?>");
</script>