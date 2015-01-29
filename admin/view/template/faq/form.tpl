<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-faq" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-question<?php echo $language['language_id']; ?>"><?php echo $entry_question; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="faq_data[<?php echo $language['language_id']; ?>][question]" value="<?php echo isset($faq_data[$language['language_id']]) ? $faq_data[$language['language_id']]['question'] : ''; ?>" placeholder="<?php echo $entry_question; ?>" id="input-question<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_question[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_question[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-answer<?php echo $language['language_id']; ?>"><?php echo $entry_answer; ?></label>
                    <div class="col-sm-10">
                      <textarea type="text" name="faq_data[<?php echo $language['language_id']; ?>][answer]" value="<?php echo isset($faq_data[$language['language_id']]) ? $faq_data[$language['language_id']]['answer'] : ''; ?>" placeholder="<?php echo $entry_answer; ?>" id="input-answer<?php echo $language['language_id']; ?>" class="form-control"></textarea> 
                      <?php if (isset($error_answer[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_answer[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>                 
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>