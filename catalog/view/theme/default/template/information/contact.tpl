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
        <div class="panel">
          <div class="panel-heading">
            <h4 class="panel-title text-bold"><?php echo $store; ?></h4>
          </div>
          <div class="panel-body" style="padding: 0px 15px;">
            <p style="margin: 0;">
              <strong><?php echo $text_address; ?>: </strong><?php echo $address; ?>
            </p>
            <p>
              <strong><?php echo $text_telephone; ?>: </strong> <?php echo $telephone; ?> - 
              <strong>Email: </strong> <?php echo $email; ?>
            </p>
            <p style="text-align: center;">
              <iframe frameborder="0" height="600" longdesc="GoogleMaps Linh Chi Nông Lâm" scrolling="no" src="<?php echo $map_link?>" width="800"></iframe>
            </p>
          </div>
        </div>
        <div class="panel">
          <div class="panel-heading" style="border-bottom: 1px solid #F0F0F0;">
            <h4 class="panel-title text-bold"><?php echo $text_contact; ?></h4>
          </div>
          <div class="panel-body" style="padding: 15px;">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <fieldset>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                    <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
                    <?php if ($error_email) { ?>
                    <div class="text-danger"><?php echo $error_email; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                  <div class="col-sm-10">
                    <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
                    <?php if ($error_enquiry) { ?>
                    <div class="text-danger"><?php echo $error_enquiry; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-captcha"><?php echo $entry_captcha; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="captcha" id="input-captcha" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <img src="index.php?route=tool/captcha" alt="" />
                    <?php if ($error_captcha) { ?>
                      <div class="text-danger"><?php echo $error_captcha; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-10 pull-right">
                    <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>        
        <?php echo $content_bottom; ?>
      </div>
      <div class="content-down" id="content-down"></div>
    </div>
</div>
<?php echo $footer; ?> 