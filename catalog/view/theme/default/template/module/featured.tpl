<!-- Product list -->
<div class="break"></div>
<div id="carousel-product-list" class="owl-carousel">
  <?php foreach ($products as $product) { ?>
    <div class="item product-item text-center">
        <a href="<?php echo $product['href']; ?>" class="product-image">
            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive" />
        </a>
        <div class="separator"></div>
        <div class="product-price">
          <?php if (!$product['special']) { ?>
            <?php echo $product['price']; ?>
          <?php } else { ?>
            <?php echo $product['special']; ?>
          <?php } ?>
        </div>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
    $('#carousel-product-list').owlCarousel({
      items: 7,
      autoPlay: 3000,
      navigation: true,
      navigationText: ['<i class="fa fa-angle-left fa-5x"></i>', '<i class="fa fa-angle-right fa-5x"></i>'],
      pagination: false
    });
</script>
<!-- End Product list -->
