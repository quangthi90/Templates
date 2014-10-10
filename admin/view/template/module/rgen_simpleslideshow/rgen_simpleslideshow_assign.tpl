<?php 

$module_key = $modSettings['modKey'].'_module'; 
include 'view/rgen/tools/positions/positions.php';
$sectionSettings = 'y|y|t|y|y|3000|fade|sfl|str|Power0.easeIn|40|40|n|n';
$fullBsettings = 'n||rgb(0, 0, 0)|data/cart.png|inherit|no-repeat|left top|||0|0||n';
// Extra positions
/*$this->data['positions']['Header - Bottom'] = 'header_bottom';
$this->data['positions']['Slideshow full'] = 'slideshow_full';*/

?>
<div class="section-title" style="margin: 0px; border-radius: 5px 5px 0 0;">
	Assign modules
	<div class="buttons pull-right" style="margin: -9px -10px 0 0;">
		<a id="saveBtn" class="btn btn-success btn-large">Save</a>
	</div>
</div>
<div class="mod-content" id="mod-settings">
	<table class="table table-bordered extra-pd">
		<thead>
			<tr class="table-header tbl-vm">
				<th>Section settings</th>
				<th>Other settings</th>
				<th style="width:50px;" class="tc">Status</th>
				<th style="width:75px;" class="tc">Sort order</th>
				<th style="width:30px;" class="tc"><a class='btn btn-success mod-add'><i class="icon-plus icon-white"></i></a></th>
			</tr>
		</thead>
		<tbody class="assign-container">
			<?php 
			$module_row=0;
			if (isset($module_list)) {
				if (isset(${$modSettings['modKey']."_module"})) {
				foreach (${$modSettings['modKey']."_module"} as $key => $module) { ?>
				<tr id="row<?php echo $module_row; ?>">
					<td class="section-settings">
						<div class="form-horizontal frm-small">
							<div class="control-group">
								<label class="control-label">Select module</label>
								<div class="controls">
									<?php
										$ar 	= $module_list;
										$dbKey	= isset($module['mod_id']) ? $module['mod_id'] : null;
										$name	= $module_key.'['.$module_row.'][mod_id]';
									?>
									<span class='select'>
										<select name="<?php echo $name; ?>">
											<?php foreach ($ar as $key => $value) { ?>
												<?php ($value['mod_id'] == $dbKey) ? $selected = 'selected' : $selected=''; ?>
												<option value="<?php echo $value['mod_id']; ?>" <?php echo $selected; ?>><?php echo $value['modName']; ?></option>
											<?php } ?>
										</select>
									</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Settings</label>
								<div class="controls">
									<a data-url="view/template/module/<?php echo $modSettings['modKey']; ?>/settings.php" data-title="Module display settings" class="popup btn mb10">Edit</a>
									<?php 
										$dbKey 	= isset($module['bannerSettings']) ? $module['bannerSettings'] : $sectionSettings;
										$name	= $module_key.'['.$module_row.'][bannerSettings]';
									?>
									<input type="hidden" class="bannerSettings" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Display in full block</label>
								<div class="controls">
									<a data-url="view/rgen/tools/full_block/full_block_settings.php" data-type="fullb" data-title="Display in full block" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn">Edit</a>
									<?php 
										$dbKey 	= isset($module['fullB']) && $module['fullB'] != '' ? $module['fullB'] : $fullBsettings;
										$name	= $module_key.'['.$module_row.'][fullB]';
									?>
									<input type="hidden" class="fullB" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
									<div class="help-block">
										Display in full block settings will not apply with grid manager access.
									</div>
								</div>
							</div>

						</div>
					</td>
					<td>
						<div class="form-horizontal frm-small">
							<div class="control-group">
								<label class="control-label">Image width x height</label>
								<div class="controls mb10">
									<?php 
										$dbKey 	= isset($module['img_w']) ? $module['img_w'] : '100';
										$name	= $module_key.'['.$module_row.'][img_w]';
									?>
									<input type="text" class="input-mini mb0" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />

									<?php 
										$dbKey 	= isset($module['img_h']) ? $module['img_h'] : '100';
										$name	= $module_key.'['.$module_row.'][img_h]';
									?>
									<input type="text" class="input-mini mb0" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
									<a class="helpbtn" style="vertical-align: middle; margin-left: 10px;" data-type="img" data-info="view/image/rgen_theme/rgen_bnr_mod_img_size.png">?</a>
								</div>
								<div class="controls">
									<?php 
										$dbKey 	= isset($module['imgfill']) ? $module['imgfill'] : 'n';
										$name	= $module_key.'['.$module_row.'][imgfill]';
									?>
									<label class="lbl-1" style="display: inline-block;">
										<input type="checkbox" style="margin:-2px 3px 0 0;" name="<?php echo $name; ?>" value="y"<?php echo $dbKey == 'y' ? ' checked="checked"' : null; ?> />
										Fill banner image in banner block
									</label>
								</div>
							</div>
							
							<?php 
							// Generate extension access
							include 'view/rgen/tools/ext_access/ext_access_assign.tpl'; ?>
							
							<div class="mod-setting-wrp"<?php echo $extStatus == 'y' ? ' style="display:none;"' : null; ?>>
							<div class="control-group">
								<label class="control-label">Select position</label>
								<div class="controls">
									<?php 
										$ar 	= $positions;
										$dbKey 	= isset($module['position']) ? $module['position'] : 'content_top';
										$name	= $module_key.'['.$module_row.'][position]';
									?>
									<span class='select'>
										<select name="<?php echo $name; ?>" data-clone="position" class="input-medium">
											<?php foreach ($ar as $key => $value) { ?>
												<?php ($value ==  $dbKey) ? $selected = 'selected' : $selected=''; ?>
												<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
											<?php } ?>
										</select>
									</span>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Select layout</label>
								<div class="controls">
									<?php 
										$ar 	= $layouts;
										$dbKey 	= isset($module['layout_id']) ? $module['layout_id'] : null;
										$name	= $module_key.'['.$module_row.'][layout_id]';
									?>
									<span class='select'>
										<select name="<?php echo $name; ?>" class="input-medium layout-select">
											<?php foreach ($ar as $key => $value) { 
												isset($value['route'][0]) ? $routeInfo = $value['route'][0]['route'] : $routeInfo = '';
												$modLayoutID = isset($module['layout_id']) ? $module['layout_id'] : null;
											?>
												<?php ($value['layout_id'] ==  $dbKey) ? $selected = 'selected' : $selected=''; ?>
												<option data-container="#auto-complete-wrp<?php echo $module_row ?>" data-route="<?php echo $routeInfo; ?>" value="<?php echo $value['layout_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
										<?php 
											$ar 	= $layouts;
											$dbKey 	= isset($module['routeInfo']) ? $module['routeInfo'] : null;
											$name	= $module_key.'['.$module_row.'][routeInfo]';
										?>
										<input type="hidden" class="layoutRoute" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
									</span>
								</div>
							</div>

							<div id="auto-complete-wrp<?php echo $module_row ?>">
								<?php 
									$selectedRoute = isset($module['routeInfo']) && $module['routeInfo'] != '' ? $module['routeInfo'] : null;
									$catRoute = $selectedRoute == 'product/category' ? 'block' : 'none';
									$prdRoute = $selectedRoute == 'product/product' ? 'block' : 'none';
									$brdRoute = $selectedRoute == 'product/manufacturer' ? 'block' : 'none';
									$infRoute = $selectedRoute == 'information/information' ? 'block' : 'none';
									
								?>
								<div class="control-group" data-auto="product/category" style="display:<?php echo $catRoute; ?>;">
									<label class="control-label">Display content</label>
									<div class="controls">
										<?php 
											$count       = $module_row;
											$type        = 'category'; //category, product, manufacturer or information
											$class       = 'cat-selection';
											$status      = isset($module['cat_status']) ? $module['cat_status'] : 'all';
											$nameVal     = $module_key.'['.$module_row.'][cat_status]';
											$holderName  = $module_key.'['.$module_row.'][category][]';
											$autolist 	 = isset($module['catData']) ? $module['catData'] : null;
											$autolist_v1 = 'name';
											$autolist_v2 = 'category_id';
											include 'view/rgen/tools/layout_selector/layout_selector.tpl';
										?>
									</div>
								</div>

								<div class="control-group" data-auto="product/product" style="display: <?php echo $prdRoute; ?>;">
									<label class="control-label">Display content</label>
									<div class="controls">
										<?php 
											$count       = $module_row;
											$type        = 'product'; //category, product, manufacturer or information
											$class       = 'prd-selection';
											$status      = isset($module['prd_status']) ? $module['prd_status'] : 'all';
											$nameVal     = $module_key.'['.$module_row.'][prd_status]';
											$holderName  = $module_key.'['.$module_row.'][product][]';
											$autolist 	 = isset($module['prdData']) ? $module['prdData'] : null;
											$autolist_v1 = 'name';
											$autolist_v2 = 'product_id';
											include 'view/rgen/tools/layout_selector/layout_selector.tpl';
										?>
									</div>
								</div>

								<div class="control-group" data-auto="product/manufacturer" style="display: <?php echo $brdRoute; ?>;">
									<label class="control-label">Display content</label>
									<div class="controls">
										<?php 
											$count       = $module_row;
											$type        = 'manufacturer'; //category, product, manufacturer or information
											$class       = 'brd-selection';
											$status      = isset($module['brd_status']) ? $module['brd_status'] : 'all';
											$nameVal     = $module_key.'['.$module_row.'][brd_status]';
											$holderName  = $module_key.'['.$module_row.'][manufacturer][]';
											$autolist 	 = isset($module['brdData']) ? $module['brdData'] : null;
											$autolist_v1 = 'name';
											$autolist_v2 = 'manufacturer_id';
											include 'view/rgen/tools/layout_selector/layout_selector.tpl';
										?>
									</div>
								</div>

								<div class="control-group" data-auto="information/information" style="display: <?php echo $infRoute; ?>;">
									<label class="control-label">Display content</label>
									<div class="controls">
										<?php 
											$count       = $module_row;
											$type        = 'information'; //category, product, manufacturer or information
											$class       = 'info-selection';
											$status      = isset($module['info_status']) ? $module['info_status'] : 'all';
											$nameVal     = $module_key.'['.$module_row.'][info_status]';
											$holderName  = $module_key.'['.$module_row.'][information][]';
											$autolist 	 = isset($module['infoData']) ? $module['infoData'] : null;
											$autolist_v1 = 'name';
											$autolist_v2 = 'information_id';
											include 'view/rgen/tools/layout_selector/layout_selector.tpl';
										?>
									</div>
								</div>
							</div>
							</div>

						</div>
					</td>
					<td class="tc">
						<?php 
							$dbKey 	= isset($module['status']) ? $module['status'] : '0';
							$name	= $module_key.'['.$module_row.'][status]';
							$id		= 'status'.$module_row;
						?>
						<span class="switch">
							<input type="checkbox" id="<?php echo $id; ?>" data-clone="status" name="<?php echo $name; ?>" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">
							<label for="<?php echo $id; ?>" class="switch-img"></label>
							<?php if (!$dbKey) { ?><input type="hidden" name="<?php echo $name; ?>" data-clone="status" value="0"><?php }?>
						</span>
					</td>
					<td class="tc">
						<?php 
							$dbKey 	= isset($module['sort_order']) ? $module['sort_order'] : '0';
							$name	= $module_key.'['.$module_row.'][sort_order]';
						?>
						<input type="text" class="input-mini" data-clone="sort_order" name="<?php echo $name; ?>" value="<?php echo $dbKey; ?>" />
					</td>
					<td class="tc"><a class='btn btn-danger mod-del'><i class="icon-remove icon-white"></i></a></td>
				</tr>
				<?php $module_row++; } } ?>
			<?php } else { ?>
				<input type="hidden" id="no-modules" val="demo">
			<?php } ?>
		</tbody>
	</table>
</div>
<div id="dialog-data"></div>

<script><!--
$(window).off('click', '.popup');
$(window).on('click', '.popup', function(event) {
	event.preventDefault();
	blockSection("#mod-settings", '#d8d1c7');
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
						blockSection(".ui-dialog", '#d8d1c7');
						setTimeout(function(){
							$(popup).dialog("close");
							$('.ui-dialog').unblock();
						}, 500);
					});
				},
				close: function (event, ui) {
					$('#dialog-data').html('');
					$('.pop-active').removeClass('pop-active');
				},
				width: 800,
				resizable: false,
				modal: true
			});

			$('#mod-settings').unblock();
		}
	});
});


$(window).off( "click", "#saveBtn");
$(window).on('click', '#saveBtn', function(event) {
	event.preventDefault();
	var urlVal = "index.php?route=module/<?php echo $modSettings['modKey']; ?>/save&token=<?php echo $token; ?>&t=assign";
	var dataContent = '#mod-settings';
	var reLoad = false;
	var msg = "<?php echo $this->language->get('text_success'); ?>";
	save(urlVal, dataContent, reLoad, msg);
});

var module_row = <?php echo $module_row; ?>;
var name = '';
var placeholder = '';

var token 		= '<?php echo $token; ?>';
var count		= module_row;	//counter apply
var type 		= '';	//category, product, manufacturer or information
var cssClass	= '';	//custom class (cat-selection)
var nameVal		= '';	//'rgen_customproducts_module[' . $module_row . '][cat_status]';
var holderName	= '';	//$module_key.'['.$module_row.'][category][]';
var autolist_v1	= '';	//'name'
var autolist_v2	= '';	//'category_id'

function addModule() {	
	html = '<tr id="row'+module_row+'">';
	html += '	<td class="section-settings">';
	html += '		<div class="form-horizontal frm-small">';
	html += '			<div class="control-group">';
	html += '				<label class="control-label">Select module</label>';
	html += '				<div class="controls">';

								<?php if (isset($module_list)) { $ar = $module_list; ?>
								name = '<?php echo $module_key ?>['+module_row+'][mod_id]';
	html += '					<span class="select">';
	html += '						<select name="'+name+'">';
										<?php  foreach ($ar as $key => $value) { ?>
	html += '								<option value="<?php echo $value['mod_id']; ?>"><?php echo $value['modName']; ?></option>';
										<?php } ?>
	html += '						</select>';
	html += '					</span>';
								<?php } ?>
	html += '				</div>';
	html += '			</div>';

	html += '			<div class="control-group">';
	html += '				<label class="control-label">Settings</label>';
	html += '				<div class="controls">';
	html += '					<a data-url="view/template/module/<?php echo $modSettings['modKey']; ?>/settings.php" data-title="Module display settings" class="popup btn mb10">Edit</a>';
								name = '<?php echo $module_key ?>['+module_row+'][bannerSettings]';
	html += '					<input type="hidden" class="bannerSettings" name="'+name+'" value="<?php echo $sectionSettings; ?>" />';
	html += '				</div>';
	html += '			</div>';

	html += '			<div class="control-group">';
	html += '				<label class="control-label">Display in full block</label>';
	html += '				<div class="controls">';
	html += '					<a data-url="view/rgen/tools/full_block/full_block_settings.php" data-type="fullb" data-title="Display in full block" data-token="<?php echo $token; ?>" data-image="<?php echo $no_img; ?>" data-h="800" class="popup btn">Edit</a>';
								name = '<?php echo $module_key ?>['+module_row+'][fullB]';
	html += '					<input type="hidden" class="fullB" name="'+name+'" value="<?php echo $fullBsettings; ?>" />';
	html += '					<div class="help-block">Display in full block settings will not apply with grid manager access.</div></div>';
	html += '			</div>';

	html += '		</div>';

	html += '	</td><td>';
	html += '		<div class="form-horizontal frm-small">';
	html += '			<div class="control-group">';
	html += '				<label class="control-label">Image width x height</label>';
	html += '				<div class="controls mb10">';
								name = '<?php echo $module_key ?>['+module_row+'][img_w]';
	html += '					<input type="text" class="input-mini mb0" name="'+name+'" value="100" />';
								name = '<?php echo $module_key ?>['+module_row+'][img_h]';
	html += '					<input type="text" class="input-mini mb0" name="'+name+'" value="100" />';
	html += '					<a class="helpbtn" style="vertical-align: middle; margin-left: 10px;" data-type="img" data-info="view/image/rgen_theme/rgen_bnr_mod_img_size.png">?</a>';
	html += '				</div>';
	html += '				<div class="controls">';
								name = '<?php echo $module_key ?>['+module_row+'][imgfill]';
	html += '					<label class="lbl-1" style="display: inline-block;">';
	html += '						<input type="checkbox" style="margin:-2px 3px 0 0;" name="'+name+'" value="y" />';
	html += '						Fill banner image in banner block'
	html += '					</label>';
	html += '				</div>';
	html += '			</div>';

	<?php 
	// Generate extension access
	include 'view/rgen/tools/ext_access/ext_access_assign_js.tpl'; ?>

	html += '			<div class="mod-setting-wrp"><div class="control-group">';
	html += '				<label class="control-label">Select position</label>';
	html += '				<div class="controls">';
								<?php $ar 	= $positions; ?>
								name = '<?php echo $module_key ?>['+module_row+'][position]';
	html += '					<span class="select">';
	html += '						<select name="'+name+'" data-clone="position" class="input-medium">';
										<?php foreach ($ar as $key => $value) { ?>
	html += '							<option value="<?php echo $value; ?>"><?php echo $key; ?></option>';
										<?php } ?>
	html += '						</select>';
	html += '					</span>';
	html += '				</div>';
	html += '			</div>';

	html += '			<div class="control-group">';
	html += '				<label class="control-label">Select layout</label>';
	html += '				<div class="controls">';
								<?php $ar = $layouts; ?>
								name = '<?php echo $module_key ?>['+module_row+'][layout_id]';
	html += '					<span class="select">';
	html += '						<select name="'+name+'" class="input-medium layout-select">';
										<?php foreach ($ar as $key => $value) { 
											isset($value['route'][0]) ? $routeInfo = $value['route'][0]['route'] : $routeInfo = '';
											$modLayoutID = isset($module['layout_id']) ? $module['layout_id'] : null;
										?>
	html += '							<option data-container="#auto-complete-wrp'+module_row+'" data-route="<?php echo $routeInfo; ?>" value="<?php echo $value["layout_id"]; ?>"><?php echo $value["name"]; ?></option>';
										<?php } ?>
	html += '						</select>';
									name = '<?php echo $module_key ?>['+module_row+'][routeInfo]';
	html += '						<input type="hidden" class="layoutRoute" name="'+name+'" value="" />';
	html += '					</span>';
	html += '				</div>';
	html += '			</div>';


	html += '			<div id="auto-complete-wrp'+module_row+'">';
	html += '				<div class="control-group" data-auto="product/category" style="display: none;">';
	html += '					<label class="control-label">Display content</label>';
	html += '					<div class="controls">';
								type 		= 'category';
								cssClass	= 'cat-selection';
								nameVal		= '<?php echo $module_key ?>['+module_row+'][cat_status]';
								holderName	= '<?php echo $module_key ?>['+module_row+'][category][]';
								autolist_v1	= 'name';
								autolist_v2	= 'category_id';
								<?php include 'view/rgen/tools/layout_selector/layout_selector_js.tpl'; ?>
	html += '					</div>';
	html += '				</div>';

	html += '				<div class="control-group" data-auto="product/product" style="display: none;">';
	html += '					<label class="control-label">Display content</label>';
	html += '					<div class="controls">';
								type 		= 'product';
								cssClass	= 'prd-selection';
								nameVal		= '<?php echo $module_key ?>['+module_row+'][prd_status]';
								holderName	= '<?php echo $module_key ?>['+module_row+'][product][]';
								autolist_v1	= 'name';
								autolist_v2	= 'product_id';
								<?php include 'view/rgen/tools/layout_selector/layout_selector_js.tpl'; ?>
	html += '					</div>';
	html += '				</div>';

	html += '				<div class="control-group" data-auto="product/manufacturer" style="display: none;">';
	html += '					<label class="control-label">Display content</label>';
	html += '					<div class="controls">';
								type 		= 'manufacturer';
								cssClass	= 'brd-selection';
								nameVal		= '<?php echo $module_key ?>['+module_row+'][brd_status]';
								holderName	= '<?php echo $module_key ?>['+module_row+'][manufacturer][]';
								autolist_v1	= 'name';
								autolist_v2	= 'manufacturer_id';
								<?php include 'view/rgen/tools/layout_selector/layout_selector_js.tpl'; ?>
	html += '					</div>';
	html += '				</div>';

	html += '				<div class="control-group" data-auto="information/information" style="display: none;">';
	html += '					<label class="control-label">Display content</label>';
	html += '					<div class="controls">';
								type 		= 'information';
								cssClass	= 'info-selection';
								nameVal		= '<?php echo $module_key ?>['+module_row+'][info_status]';
								holderName	= '<?php echo $module_key ?>['+module_row+'][information][]';
								autolist_v1	= 'name';
								autolist_v2	= 'information_id';
								<?php include 'view/rgen/tools/layout_selector/layout_selector_js.tpl'; ?>
	html += '					</div>';
	html += '				</div>';
	html += '			</div></div>';
	html += '		</div>';
	html += '	</td>';
	html += '	<td class="tc">';
					<?php $dbKey 	= '0'; ?>
					name = '<?php echo $module_key ?>['+module_row+'][status]';
					id = 'status'+module_row;
	html += '		<span class="switch">';
	html += '			<input type="checkbox" id="'+id+'" data-clone="status" name="'+name+'" <?php if ($dbKey) { ?>checked="checked"<?php }?> value="1">';
	html += '			<label for="'+id+'" class="switch-img"></label>';
	html += '			<?php if (!$dbKey) { ?><input type="hidden" name="'+name+'" data-clone="status" value="0"><?php }?>';
	html += '		</span>';
	html += '	</td>';
	html += '	<td class="tc">';
					name = '<?php echo $module_key ?>['+module_row+'][sort_order]';
	html += '		<input type="text" class="input-mini" data-clone="sort_order" name="'+name+'" value="0" />';
	html += '	</td>';
	html += '	<td class="tc"><a class="btn btn-danger mod-del"><i class="icon-remove icon-white"></i></a></td>';
	html += '</tr>';

	$('.assign-container').append(html);
	
	layoutSelector();
	//$('.block-settings').implodeData({ dataHolder: '.dataHolder' });

	var route = $('#row'+module_row).find(".layout-select option:first").attr('data-route');
	$('#row'+module_row).find('.layout-select').next('.layoutRoute').attr('value', route);

	module_row++;
}

$(window).off( "click", ".mod-add");
$(window).on('click', '.mod-add', function() {
	if ($('#no-modules').length > 0) {
		new Messi('No any module available to assign. <br>Click on <strong>"Manage Modules"</strong> to create new module.', {
			title: 'Alert', titleClass: 'msg-title', modal: true, modalOpacity: 0.5,
			buttons: [{id: 0, val: 'C', label: 'Close', class: 'btn-small'}]
		});
	}else{
		addModule();
	};
});

$(window).off( "click", ".mod-del");
$(window).on('click', '.mod-del', function() {
	$(this).parent().parent().remove();
});

function layoutSelector() {
	$(window).off("change", ".layout-select");
	$(window).on('change', '.layout-select', function() {
		$(this).next('.layoutRoute').val($(this).find("option:selected").attr('data-route'));
		$($(this).find("option:selected").attr('data-container')).find('[data-auto]').hide();
		$($(this).find("option:selected").attr('data-container')).find('[data-auto="'+$(this).find("option:selected").attr('data-route')+'"]').show();

		$($(this).find("option:selected").attr('data-container')).find('.scrollbox').html(null);
		$($(this).find("option:selected").attr('data-container')).find(".btn").removeClass('active');
		$($(this).find("option:selected").attr('data-container')).find("input[value='all']").prop('checked', true).parent().addClass('active');
	});	
} layoutSelector();
$('.layout-select').each(function() {
	$(this).next('.layoutRoute').val($(this).find("option:selected").attr('data-route'));	
});

<?php
// Generate extension access
include 'view/rgen/tools/ext_access/ext_access_assign_fn.tpl'; ?>

//--></script>