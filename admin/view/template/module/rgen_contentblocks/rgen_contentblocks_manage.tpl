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

	$(window).off('click', '.popup');
	$(window).on('click', '.popup', function(event) {
		event.preventDefault();
		blockSection(".mod-wrapper", '#d8d1c7');
		var source = this;
		var getTitle = $(this).attr('data-title');

		$(source).addClass('pop-active');
		$.ajax({
			type: "POST",
			url: $(this).attr('data-url'),
			dataType: "html",
			success: function(data, source) {
				$('#dialog-data').html('');
				$('#dialog-data').html(data);

				$('#dialog-data').dialog({
					title: getTitle,
					dialogClass: "model-box",
					open: function(event, ui) {
						var popup = this;
						$(popup).find('.apply').click(function(event) {
							var bnrLayout = 'view/image/rgen_theme/rgen_bnr_mod_typ'+$('.pop-active + input[type="hidden"].bannerSettings').attr('data-style')+'.png';
							$('.pop-active + .bannerSettings + br + img').attr('src', bnrLayout);

							var obj = '.pop-active + input[type="hidden"]';
							$(obj).summary({
								dbkey: $(obj).val(),
								labels: $(obj).attr('data-labels'),
								place: obj,
								callback: function(index, val){
									if (val == 't') { val = 'Top'; };
									if (val == 'l') { val = 'Left'; };
									if (val == 'n') { val = 'No'; };
									if (val == 'y') { val = 'Yes'; };
									if (val == 'ico') { val = 'Icon'; };
									if (val == 'img') { val = 'Image'; };
									if (val == 'b') { val = 'Below image'; };
									if (val == 't') { val = 'Above image'; };
									if (val == 'c') { val = 'Center'; };
									if (val == 'l') { val = 'Left'; };
									if (val == 'r') { val = 'Right'; };
									return val; 
								}
							});
							$(popup).dialog("close");
						});
					},
					close: function (event, ui) {
						setTimeout(function(){
							$('#dialog-data').html('');
							$('.pop-active').removeClass('pop-active');
						}, 100);
					},
					width: 800,
					resizable: false,
					modal: true
				});

				$('.mod-wrapper').unblock();
			}
		});
	});

	// Add new module
	$("#module-add").rgenPost({
		before: function(){
			blockSection(".main-sd-tb-wrp", '#d8d1c7');
		},
		after: function(){
			catAutocomplete('.cat-auto');
			prdAutocomplete('.prd-auto');
			brandAutocomplete('.brn-auto');
			infoAutocomplete('.inf-auto');
			
			$('.main-sd-tb-wrp').unblock();
		}
	});

	// Edit module
	$("#main-sd-tb a").rgenPost({
		before: function(){
			$('#main-sd-tb li:first').addClass('active');
			blockSection(".main-sd-tb-wrp", '#d8d1c7');
		},
		after: function(){
			catAutocomplete('.cat-auto');
			prdAutocomplete('.prd-auto');
			brandAutocomplete('.brn-auto');
			infoAutocomplete('.inf-auto');

			$('.main-sd-tb-wrp').unblock();
		},
		firstClick: true
	});
	$(window).on('click', '#main-sd-tb a', function() {
		blockSection("", '#d8d1c7');
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
					blockSection(".main-sd-tb-wrp", '#d8d1c7');
					$('#main-sd-tb li:first a').click();

					var container = $(obj).attr("data-container");
					var url = $(obj).attr("data-url");

					$.post(url, function(data) {
						$(container).html(data);
						$('.main-sd-tb-wrp').unblock();
					});
				};
			}
		});
	});

});
</script>