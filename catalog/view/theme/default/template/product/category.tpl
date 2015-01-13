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
      <h2 class="heading-title"><?php echo $heading_title; ?></h2>
      <div class="break"></div>
      <?php if ($products) { ?>
      <div class="product-list">
        <?php foreach ($products as $product) { ?>
        <div class="product-item">
          <div class="image">
            <a href="<?php echo $product['href']; ?>" class="detail-link">
              <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
            </a>
          </div>
          <div class="caption">
            <h4 class="product-heading" title="<?php echo $product['name']; ?>"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
            <p class="hidden"><?php echo $product['description']; ?></p>            
          </div>
          <?php if ($product['price']) { ?>
            <p class="text-center price">
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
              <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
              <?php } ?>
            </p>
          <?php } ?>
          <div class="actions">
            <button type="button" class="btn btn-info btn-sm" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
        <p><?php echo $text_empty; ?></p>
        <div class="buttons">
          <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>
      <?php } ?>
      <?php echo $content_bottom; ?>
    </div>
    <div class="content-down" id="content-down"></div>
  </div>
</div>
<?php echo $footer; ?>
