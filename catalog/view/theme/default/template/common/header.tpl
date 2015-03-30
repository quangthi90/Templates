<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<?php //<meta name="viewport" content="width=device-width, initial-scale=1"> ?>
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

<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />

<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/javascript/jquery/sm/jquery.smartmenus.bootstrap.css" rel="stylesheet" type="text/css" />
<?php //<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" /> ?>
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<link href="catalog/view/theme/default/stylesheet/custom.css" rel="stylesheet">
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/sm/jquery.smartmenus.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/sm/jquery.smartmenus.bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/scrollTop.js" type="text/javascript"></script>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script type="text/javascript">
  setTimeout(function(){
    AppUtils.generateFixBanner({
      htmlContent: '<img src="<?php echo $left_bottom_banners[0]["image"]; ?>" />',
      position: 3
    });
  }, 1000);
</script>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<header>
  <div class="container">
    <div class="header-logo">
        <a id="logo" href="<?php echo $home; ?>">
          <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
        </a>
        <div id="topbar">
          <?php if ( isset($href_home) ) { ?>
          <h3 class="affiliate-label">Đơn Vị Ủy Quyền Phân Phối</h3>
          <?php } ?>
          <ul>
            <?php if($logged){ ?>
              <li>Xin chào <strong> <a href="<?php echo $account; ?>"><?php echo $text_logged; ?></a> </strong> !</li>
              <li><a href="<?php echo $logout; ?>" class="btn btn-xs btn-default"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
              <li>
                <div class="btn-group login-btns">
                  <a class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?php echo $text_login; ?>&nbsp;&nbsp;<span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo $login; ?>" class="btn btn-primary"><?php echo $text_login_user; ?></a>
                    <li><a href="<?php echo $login_affiliate; ?>" class="btn btn-primary"><?php echo $text_login_affiliate; ?></a>
                  </ul>
                </div>
              </li>
              <li>
                <div class="btn-group login-btns">
                  <a class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?php echo $text_register; ?>&nbsp;&nbsp;<span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo $register; ?>" class="btn btn-primary"><?php echo $text_register_user; ?></a>
                    <li><a href="<?php echo $register_affiliate; ?>" class="btn btn-primary"><?php echo $text_register_affiliate; ?></a>
                  </ul>
                </div>              
              </li>
            <?php } ?>
            <li>
              <?php echo $cart; ?>
            </li>
          </ul>
        </div>
    </div>    
    <nav id="menu" class="navbar">
      <ul class="nav navbar-nav">
        <?php if ( isset($href_home) ) { ?>
        <li><a href="<?php echo $href_home; ?>" class="icon-home-sm"></a></li>
        <?php } ?>
        <li><a href="<?php echo $home; ?>"><i class="fa fa-home fa-4x" style="font-size: 20px;"></i></a></li>
        <li><a href="#"><?php echo $text_product; ?></a>
          <ul class="dropdown-menu">
          <?php foreach ($categories as $category) { ?>
            <li class=""><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
              <?php if (!empty($category['children'])){ ?>
              <ul class="dropdown-menu">
                <?php foreach ($category['children'] as $child) { ?>
                <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
                  <?php if (!empty($child['children'])){ ?>
                  <ul class="dropdown-menu">
                    <?php foreach ($child['children'] as $child_cat) { ?>
                    <li><a href="<?php echo $child_cat['href']; ?>"><?php echo $child_cat['name']; ?></a></li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php foreach ($news_categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
          <?php if (!empty($category['children'])){ ?>
          <ul class="dropdown-menu">
            <?php foreach ($category['children'] as $child) { ?>
            <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
              <?php if (!empty($child['children'])){ ?>
              <ul class="dropdown-menu">
                <?php foreach ($child['children'] as $child_news) { ?>
                <li><a href="<?php echo $child_news['href']; ?>"><?php echo $child_news['name']; ?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
        <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
        <li></li>
      </ul>
    </nav>
    <?php if ($class !='common-home') { ?>
      <div class="order-ad" id="order-ad">
        <a href="<?php echo $faq_link; ?>" class="btn btn-main pull-left text-upper" id="link-qa"><?php echo $text_faq; ?></a>
        <p class="text-ad">VUI LÒNG GỌI <?php echo $phone; ?> HOẶC ĐẶT HÀNG TRỰC TUYẾN</p>
        <a href="<?php echo $product_catalog; ?>" class="btn btn-main pull-right text-upper" id="link-ordernow">Đặt Mua Ngay Bây Giờ</a>
        <div class="clearfix"></div>
      </div>
    <?php } ?>    
  </div>  
</header>
