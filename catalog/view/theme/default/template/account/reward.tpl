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
      <p><?php echo $text_total; ?> <b><?php echo $total; ?></b>.</p>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-left"><?php echo $column_description; ?></td>
              <td class="text-right"><?php echo $column_points; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($rewards) { ?>
            <?php foreach ($rewards  as $reward) { ?>
            <tr>
              <td class="text-left"><?php echo $reward['date_added']; ?></td>
              <td class="text-left"><?php if ($reward['order_id']) { ?>
                <a href="<?php echo $reward['href']; ?>"><?php echo $reward['description']; ?></a>
                <?php } else { ?>
                <?php echo $reward['description']; ?>
                <?php } ?></td>
              <td class="text-right"><?php echo $reward['points']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="3"><?php echo $text_empty; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <div class="content-down" id="content-down"></div>
  </div>
</div>
<?php echo $footer; ?>