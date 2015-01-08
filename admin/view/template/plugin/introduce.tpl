<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-col-1" data-toggle="tab"><?php echo $tab_col_1; ?></a></li>
            <li><a href="#tab-col-2" data-toggle="tab"><?php echo $tab_col_2; ?></a></li>
            <li><a href="#tab-col-3" data-toggle="tab"><?php echo $tab_col_3; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-col-1">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_image_video; ?></label>
                <div class="col-sm-10">
                  <textarea name="introduce_col_1_html" placeholder="<?php echo $entry_image_video; ?>" class="form-control"><?php echo $introduce_col_1_html; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                  <input name="introduce_col_1_title" placeholder="<?php echo $entry_title; ?>" class="form-control" value="<?php echo $introduce_col_1_title; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="introduce_col_1_description" placeholder="<?php echo $entry_description; ?>" class="form-control"><?php echo $introduce_col_1_description; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_link; ?></label>
                <div class="col-sm-10">
                  <input name="introduce_col_1_link" placeholder="<?php echo $entry_link; ?>" class="form-control" value="<?php echo $introduce_col_1_link; ?>" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-col-2">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_image_video; ?></label>
                <div class="col-sm-10">
                  <textarea name="introduce_col_2_html" placeholder="<?php echo $entry_image_video; ?>" class="form-control"><?php echo $introduce_col_2_html; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_title; ?></label>
                <div class="col-sm-10">
                  <input name="introduce_col_2_title" placeholder="<?php echo $entry_title; ?>" class="form-control" value="<?php echo $introduce_col_2_title; ?>" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_description; ?></label>
                <div class="col-sm-10">
                  <textarea name="introduce_col_2_description" placeholder="<?php echo $entry_description; ?>" class="form-control"><?php echo $introduce_col_2_description; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_link; ?></label>
                <div class="col-sm-10">
                  <input name="introduce_col_2_link" placeholder="<?php echo $entry_link; ?>" class="form-control" value="<?php echo $introduce_col_2_link; ?>" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-col-3">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_image_video; ?></label>
                <div class="col-sm-10">
                  <textarea name="introduce_col_3_html" placeholder="<?php echo $entry_image_video; ?>" class="form-control"><?php echo $introduce_col_3_html; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_link; ?></label>
                <div class="col-sm-10">
                  <input name="introduce_col_3_link" placeholder="<?php echo $entry_link; ?>" class="form-control" value="<?php echo $introduce_col_3_link; ?>" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
  height: 300
});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image2&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
 <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>