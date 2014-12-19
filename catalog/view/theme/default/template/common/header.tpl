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
<link href="catalog/view/javascript/jquery/sm/jquery.smartmenus.bootstrap.css" rel="stylesheet" type="text/css
" />
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
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>">
<header>
  <div class="container">
    <div class="header-logo">
        <a id="logo" href="<?php echo $home; ?>">
          <img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
        </a>
    </div>
    <nav id="menu" class="navbar">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo $home; ?>"><i class="fa fa-home fa-4x" style="font-size: 20px;"></i></a></li>
        <li><a href="#"><?php echo $text_product; ?></a>
          <ul class="dropdown-menu">
          <?php foreach ($categories as $category) { ?>
            <li class=""><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
          <?php } ?>
          </ul>
        </li>
        <?php foreach ($news_categories as $category) { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
          <ul class="dropdown-menu">
            <li><a href="http://linhchinonglam.com/tin-tuc/5/hinh-anh-hoat-dong.html">Hình Ảnh &amp; Hoạt Động</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/233/phong-su.html">Phóng Sự</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/2/gioi-thieu.html">Chúng Tôi Là Ai ?</a></li><li><a href="http://linhchinonglam.com/tin-tuc/6/giay-kiem-dinh-phan-tich.html">Giấy Kiểm Định Phân Tích</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/113/giay-chung-nhan-cong-bo-san-pham.html">Giấy Chứng Nhận, Công Bố SP</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/116/tin-tuc-su-kien.html">Tin Tức &amp; Sự Kiện</a>
              <ul class="dropdown-menu">
                  <li><a href="http://linhchinonglam.com/tin-tuc/79/thong-diep-nhan-ai.html">Thông Điệp Nhân Ái</a></li>
                  <li><a href="http://linhchinonglam.com/tin-tuc/80/chuong-trinh-nhan-dao.html">Chương Trình Nhân Đạo</a></li>
                  <li><a href="http://linhchinonglam.com/danh-muc/187/nhung-manh-doi-bat-hanh.html">Những Mảnh Đời Bất Hạnh</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <?php } ?>
        <li style="width: 100px;"><a href="#">Liên hệ</a></li>
      </ul>
    </nav>
  </div>  
</header>
