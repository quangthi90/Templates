<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr style="background: #EFEFEF; border: 1px solid #DDDDDD;">
          <td colspan="2"><?php echo $text_for_category; ?></td>
        </tr>	  	  
        <tr>
          <td><?php echo $entry_news_per_page; ?></td>
          <td><input type="text" name="news_setting_news_per_page" value="<?php echo $news_setting_news_per_page; ?>" size="2" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_category_thumbnail; ?></td>
          <td><?php echo $entry_width; ?><input type="text" name="news_setting_thumbnail_width" value="<?php echo $news_setting_thumbnail_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_thumbnail_height" value="<?php echo $news_setting_thumbnail_height; ?>" size="3" /></td>
        </tr>
        <tr style="background: #EFEFEF; border: 1px solid #DDDDDD;">
          <td colspan="2"><?php echo $text_for_article; ?></td>
        </tr>	        <tr>
          <td><?php echo $entry_comments_per_page; ?></td>
          <td><input type="text" name="news_setting_comments_per_page" value="<?php echo $news_setting_comments_per_page; ?>" size="2" /></td>
        </tr>        
        <tr>
          <td><?php echo $entry_article_image; ?></td>
          <td><?php echo $entry_width; ?><input type="text" name="news_setting_image_width" value="<?php echo $news_setting_image_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_image_height" value="<?php echo $news_setting_image_height; ?>" size="3" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>