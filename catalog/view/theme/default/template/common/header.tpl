<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet_green.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<nav id="top">
  <div class="container">
    <?php //echo $currency; ?>
    <?php //echo $language; ?>
    <div class="row">
      <div class="col-xs-7">
        <div class="row header-logo">
          <div class="col-sm-4">
            <div id="logo">
              <?php if ($logo) { ?>
              <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive img-logo" /></a>
              <?php } else { ?>
              <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
              <?php } ?>
            </div>
          </div>
          <div class="col-sm-7 col-sm-offset-1"><?php echo $search; ?>
          </div>          
        </div>
      </div>
      <div class="col-xs-5">
        <div class="row">
          <div class="col-xs-9">
            <div id="top-links" class="nav pull-right">
              <ul class="list-inline">
                <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><i class="fa fa-heart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
                <?php if ($logged) { ?>
                <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span class="caret"></span></a>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                    <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                    <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
                    <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
                  </ul>
                </li>
                <?php } ?>
                <?php if (!$logged) { ?>
                <li><a href="<?php echo $register; ?>" title="<?php echo $text_register; ?>"><i class="fa fa-user-plus"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_register; ?></span></a></li>
                <li><a href="<?php echo $login; ?>" title="<?php echo $text_login; ?>"><i class="fa fa-sign-in"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_login; ?></span></a></li>
                <?php } else { ?>
                <li><a href="<?php echo $logout; ?>" title="<?php echo $text_logout; ?>"><i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span></a></li>
                <?php } ?>       
              </ul>          
            </div>
          </div>
          <div class="col-xs-3">
            <div class="cart-wrapper pull-right"><?php echo $cart; ?></div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</nav>
<nav id="top-float">
  <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <button type="button" class="btn btn-primary btn-lg btn-navbar" id="btn-category-trigger">
          <i class="fa fa-bars"></i> Sản phẩm
          </button>
        </div>
        <div class="col-sm-5">
          <?php echo $search; ?>
        </div>
        <div class="col-sm-2">
          <?php echo $cart; ?>
        </div>
        <div class="col-sm-2">
          <ul class="list-inline user-menu">
            <?php if (!$logged) { ?>
              <li><a href="<?php echo $register; ?>" title="<?php echo $text_register; ?>"><i class="fa fa-user-plus"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_register; ?></span></a></li>
              <li><a href="<?php echo $login; ?>" title="<?php echo $text_login; ?>"><i class="fa fa-sign-in"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_login; ?></span></a></li>
              <?php } else { ?>
              <li><a href="<?php echo $logout; ?>" title="<?php echo $text_logout; ?>"><i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
  </div>
</nav>
<header>
  <div class="container">    
    <div class="row header-category">
      <div class="col-md-2" style="padding-right: 0;">
        <a id="category" class="btn btn-primary btn-lg block"><i class="fa fa-bars"></i> Sản phẩm</a>
      </div>
      <div class="col-md-10" style="padding-left: 0;">
        <div class="row">
          <div class="col-sm-9">
            <ul class="list-inline links">
              <li><a href="#" title="<?php echo $text_news; ?>"><i class="fa fa-newspaper-o"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_news; ?></span></a></li>
              <li><a href="#" title="<?php echo $text_contact; ?>"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_shops; ?></span></a></li>
              <li><a href="<?php echo $contact; ?>" title="<?php echo $text_contact; ?>"><i class="fa fa-phone"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_contact; ?></span></a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <a href="#" class="btn btn-primary btn-lg text-uppercase block"><i class="fa fa-plus"></i> Khởi tạo gian hàng</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<?php if ($categories) { ?>
<div id="main-menu">
  <div class="container">
    <div class="row">
      <div class="col-md-2" style="padding-right: 0;">
        <nav id="menu" class="navbar">          
          <ul class="nav navbar-nav">
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['children']) { ?>
              <li class="dropdown">
                <a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
                <div class="dropdown-menu" style="width: 965px;">
                  <div class="dropdown-inner">
                    <a class="dropdown-inner-header" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a> 
                    <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                    <ul class="list-unstyled">
                      <?php foreach ($children as $child) { ?>
                      <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                      <?php } ?>
                    </ul>
                    <?php } ?>
                  </div>
                  <div class="category-ads">
                    <a href="#" class="ad-item">
                      <img src="http://thitruongnongnghiep.vn/Portals/0/SanPham/cai-xanh-con-sach-j141110172052910.jpg">
                    </a>
                    <a href="#" class="ad-item">
                      <img src="http://thitruongnongnghiep.vn/Portals/0/SanPham/dua-sap-hqs-02616461626.jpg">
                    </a>
                  </div>               
                </div>
              </li>
              <?php } else { ?>
              <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
        </nav>
      </div>
      <div class="col-md-10" style="padding-left: 0;">
        <div id="slideshow_homepage">
          <div class="item">
            <img src="image/catalog/demo/banners/banner1.jpg" alt="dasf" class="img-responsive" />
          </div>
          <div class="item">
            <img src="image/catalog/demo/banners/banner2.jpg" alt="dasf" class="img-responsive" />
          </div>
          <div class="item">
            <img src="image/catalog/demo/banners/banner3.jpg" alt="dasf" class="img-responsive" />
          </div>
          <div class="item">
            <img src="image/catalog/demo/banners/banner4.jpg" alt="dasf" class="img-responsive" />
          </div>
          <div class="item">
            <img src="image/catalog/demo/banners/banner5.jpg" alt="dasf" class="img-responsive" />
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $('#slideshow_homepage').owlCarousel({
          items: 6,
          autoPlay: 5000,
          singleItem: true,
          navigation: true,
          navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
          pagination: false
        });
      </script>  
    </div>  
  </div>
</div>
<?php } ?>
