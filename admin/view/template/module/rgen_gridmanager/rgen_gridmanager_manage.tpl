<style>
.grid-preview {
	padding: 0px;
}
.grid-preview > div {
	background-color: rgba(0,0,0,0.05);
	max-width: 1320px;
	min-width: 600px;
	margin-left: auto;
	margin-right: auto;
	padding: 30px 0 30px 0;
}
.grid-preview > div h4 {
	text-align: center;
	margin-bottom: 20px
}
.grid-preview .rw {
	max-width: 1180px;
	min-width: 500px;
	margin: auto;
}
.grid-preview .rw .size {
	font-size: 11px;
	color: #999;
	padding-bottom: 5px;
	margin-bottom: 5px;
	border-bottom: 1px solid #eee;
}
.grid-preview .rw .mod {
	color: #666;
}

</style>
<div class="tabs-left tabbable main-sd-tb-wrp" data-theme="tab1" style="background-color:#776b5f; border-radius:5px;">

	<a class='btn btn-success btn-large create-btn' id="module-add" data-container="#mod-data" data-url="index.php?route=module/<?php echo $modSettings['modKey']; ?>/add&token=<?php echo $token; ?>"><i class="icon-plus icon-white"></i><?php echo $button_add_module; ?></a>
	
	<ul id="main-sd-tb" class="nav nav-tabs" style="background-color: transparent;">
		<?php $i = 0; foreach ($modules as $k => $module) { ?>
		<li class="tab-module-<?php echo $i; ?>">
			<span class='btn btn-danger btn-mini mod-remove' data-url="index.php?route=module/<?php echo $modSettings['modKey']; ?>/delete&token=<?php echo $token; ?>&mod_name=<?php echo $k; ?>">&times;</span>
			<a data-tab="#tab-module-<?php echo $i; ?>" data-id="<?php //echo $module['mod_id']; ?>" data-url="index.php?route=module/<?php echo $modSettings['modKey']; ?>/edit&token=<?php echo $token; ?>&mod_name=<?php echo $k; ?>" data-container="#mod-data" id="module-<?php echo $i; ?>">
				<?php if(isset($module['modName']) && $module['modName'] != "") { ?>
				<b><?php echo $module['modName']; ?></b>
				<?php } else { ?>
				<b><?php echo 'Module' . ' ' . $i; ?></b>
				<?php } ?>
			</a>
		</li>
		<?php $i++; } ?>
	</ul>
	<div class="tab-content mod-wrp" style="min-height:800px;">
		<div id="mod-data"></div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {

	// Add new module
	$("#module-add").rgenPost({
		before: function(){
			blockSection(".tabs-left", '#d8d1c7');
		},
		after: function(){
			catAutocomplete('.cat-auto');
			prdAutocomplete('.prd-auto');
			brandAutocomplete('.brn-auto');
			infoAutocomplete('.inf-auto');
			
			$('.tabs-left').unblock();
		}
	});

	// Edit module
	$("#main-sd-tb a").rgenPost({
		before: function(){
			$('#main-sd-tb li:first').addClass('active');
			blockSection(".tabs-left", '#d8d1c7');
		},
		after: function(){
			catAutocomplete('.cat-auto');
			prdAutocomplete('.prd-auto');
			brandAutocomplete('.brn-auto');
			infoAutocomplete('.inf-auto');

			$('.tabs-left').unblock();
		},
		firstClick: true
	});
	$(window).on('click', '#main-sd-tb a', function() {
		blockSection(".tabs-left", '#d8d1c7');
		$('#main-sd-tb li').removeClass('active');
		$(this).parent().addClass('active');
	});

	$("#main-sd-tb .mod-remove").on('click', function(event) {
		event.preventDefault();
		var obj = this;
		new Messi(
			'<p>Are you sure you wish to remove selected module.</p>', {
			title: 'Remove module alert', titleClass: 'msg-title', modal: true, modalOpacity: 0.5,
			buttons: [{id: 0, val: 'y', label: 'Yes', class: 'btn-small btn-danger'}, {id: 0, val: 'n', label: 'No', class: 'btn-small'}],
			callback: function(val) {
				if (val == 'y') {

					$('#mod-data').html('');
					$(obj).parent().remove();
					blockSection(".tabs-left", '#d8d1c7');
					$('#main-sd-tb li:first a').click();

					var container = $(obj).attr("data-container");
					var url = $(obj).attr("data-url");

					$.post(url, function(data) {
						$(container).html(data);
						$('.tabs-left').unblock();
					});
				};
			}
		});
	});

});
</script>