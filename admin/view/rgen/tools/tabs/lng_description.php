<?php /*
Use
==========
include 'view/rgen/tools/tabs/lng_description.php';

Than define below variables example in page
-------------
$tab_key        = "custom-html-lng-tabs";
$db_key         = $module['description'][$language['language_id']];
$name_key       = $module_key.'[description]';
$placehoder_key = $language['name'];
$description_arr_key = 'description';
*/

?>
<div class="lng-description-tabs" id="<?php echo $tab_key; ?>">
	<div class="btn-group lng-tabs">
		<?php foreach ($languages as $language) { ?>
		<a href="#lng-tab-content<?php echo $language['language_id'].'-'.$tab_key; ?>" class="btn-small btn active">
			<img src="view/image/flags/<?php echo $language['image']; ?>" alt="">
		</a>
		<?php } ?>
	</div>	
	<?php foreach ($languages as $language) { ?>
	<div id="lng-tab-content<?php echo $language['language_id'].'-'.$tab_key; ?>" class="tab-pn">
		<?php 
			$dbKey 			= isset($description_arr[$description_arr_key][$language['language_id']]) ? $description_arr[$description_arr_key][$language['language_id']] : '';
			$name			= $name_key.'['.$language['language_id'].']';
			$placeholder	= $language['name'] . $placehoder_key;
			$id 			= $tab_key."tab-pn".$language['language_id'];
		?><textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" cols="100" rows="4" style="width: 50%;" placeholder="<?php echo $placeholder; ?>"><?php echo $dbKey; ?></textarea>
		<script type="text/javascript">
		CKEDITOR.replace("<?php echo $id; ?>", {
			filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			height: '200px'
		});
		</script>
	</div>
	<?php } ?>
</div>
<script>
jQuery(document).ready(function($) {
	var obj = '#<?php echo $tab_key; ?>';
	$(obj + " .tab-pn").hide();
	$(window).on("click",obj+" .lng-tabs a",function(e){
		e.preventDefault();
		$(obj +" .tab-pn").hide();
		$(obj + " .lng-tabs a").removeClass('active');
		$(this).addClass('active');
		$($(this).attr("href")).show().addClass('active');
	});
	$(obj + " .lng-tabs a:first").click();
});
</script>