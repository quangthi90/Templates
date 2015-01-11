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
      <?php echo $content_top; ?>
      <?php for($j = 0; $j < 4; $j ++) { ?>
      <h2 class="heading-title">Category <?php echo ($j + 1); ?></h2>
      <div class="break"></div>
      <div class="product-list">
        <?php for($i = 0; $i < 8; $i ++) { ?>
        <div class="product-item">
          <div class="image">
            <a href="/" class="detail-link">
              <img src="image/no_image.png" alt="Product Name" title="Product Name" class="img-responsive" />
            </a>
          </div>
          <div class="caption">
            <h4 class="product-heading" title="Product Name"><a href="/">Product Name <?php echo ($i + 1); ?></a></h4>
          </div>
          <p class="text-center price">
            1,333.222 VND
          </p>
          <div class="actions">
            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm hidden-md">Add to cart</span></button>
          </div>
        </div>
        <?php } ?>
      </div>
      <div style="height: 25px;"></div>
      <?php } ?>
      <?php echo $content_bottom; ?>
    </div>
    <div class="content-down" id="content-down"></div>
  </div>
</div>
<?php echo $footer; ?>
