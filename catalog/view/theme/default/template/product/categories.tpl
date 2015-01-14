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
      <?php foreach($categories as $category) { ?>
      <h2 class="heading-title"><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h2>
      <div class="break"></div>
      <div class="product-list">
        <?php foreach($products[$category['id']] as $product) { ?>
        <div class="product-item">
          <div class="image">
            <a href="<?php echo $product['href']; ?>" class="detail-link">
              <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
            </a>
          </div>
          <div class="caption">
            <h4 class="product-heading" title="<?php echo $product['name']; ?>"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
          </div>
          <p class="text-center price">
            <?php echo $product['price']; ?>
          </p>
          <div class="actions">
            <button type="button" class="btn btn-info btn-sm" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
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
