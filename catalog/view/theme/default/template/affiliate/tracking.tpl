<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div id="content" class="content-container">
    <div class="content-up" id="content-up"></div>
    <div id="content-mid">
      <h2 class="heading-title"><?php echo $heading_title; ?></h2>
      <div class="break"></div>
      <p><?php echo $text_description; ?></p>
      <form class="form-horizontal" action="<?php echo $continue; ?>" method="POST">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-code"><?php echo $entry_code; ?></label>
          <div class="col-sm-10">
            <textarea cols="40" rows="5" placeholder="<?php echo $entry_code; ?>" id="input-code" name="code" class="form-control"><?php echo $code; ?></textarea>
            <span><?php echo $help_generator; ?></span>
          </div>
        </div>
        <!--div class="form-group">
          <label class="col-sm-2 control-label" for="input-generator"><span data-toggle="tooltip" title="<?php echo $help_generator; ?>"><?php echo $entry_generator; ?></span></label>
          <div class="col-sm-10">
            <input type="text" name="product" value="" placeholder="<?php echo $entry_generator; ?>" id="input-generator" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-link"><?php echo $entry_link; ?></label>
          <div class="col-sm-10">
            <textarea name="link" cols="40" rows="5" placeholder="<?php echo $entry_link; ?>" id="input-link" class="form-control"></textarea>
          </div>
        </div-->
        <div class="buttons clearfix">
          <div class="pull-right"><button type="submit" class="btn btn-primary"><?php echo $button_continue; ?></button></div>
        </div>
      </form>
      <?php echo $content_bottom; ?>
    </div>
    <div class="content-down" id="content-down"></div>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=affiliate/tracking/autocomplete&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',     
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['link']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'product\']').val(item['label']);
    $('textarea[name=\'link\']').val(item['value']);  
  } 
});
//--></script> 
<?php echo $footer; ?> 