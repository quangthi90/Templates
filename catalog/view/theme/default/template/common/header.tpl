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
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="catalog/view/javascript/jquery/sm/jquery.smartmenus.bootstrap.css" rel="stylesheet" type="text/css" />
<?php //<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" /> ?>
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<link href="catalog/view/theme/default/stylesheet/custom.css" rel="stylesheet">
<script src="catalog/view/javascript/jquery/sm/jquery.smartmenus.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/sm/jquery.smartmenus.bootstrap.min.js" type="text/javascript"></script>
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
        <li><a href="#">Sản phẩm</a>
          <ul class="dropdown-menu">
            <li class=""><a href="http://linhchinonglam.com/danh-muc/9/nam-linh-chi-nong-lam.html">Nấm Linh Chi Nông Lâm</a></li>
            <li class=""><a href="http://linhchinonglam.com/danh-muc/131/dong-trung-ha-thao-nong-lam.html">Đông Trùng Hạ Thảo Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/113/linh-chi-nhat-thuong-hang.html">Linh Chi Nhật Thượng Hạng</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/99/nam-lim-xanh-nong-lam.html">Nấm Lim Xanh Nông Lâm</a></li>
            <li class=""><a href="http://linhchinonglam.com/danh-muc/112/nam-thuong-hoang-nong-lam.html">Nấm Thượng Hoàng Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/156/nam-van-chi-nong-lam.html">Nấm Vân Chi Nông Lâm</a></li>
            <li class=""><a href="http://linhchinonglam.com/danh-muc/157/nam-hau-thu-nong-lam.html">Nấm Hầu Thủ Nông Lâm</a></li>
            <li class=""><a href="http://linhchinonglam.com/danh-muc/122/nam-linh-chi-han-quoc.html">Nấm Linh Chi Hàn Quốc</a></li>
            <li class=""><a href="http://linhchinonglam.com/danh-muc/10/bao-tu-nam-linh-chi-nong-lam.html">Bào Tử Linh Chi Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/104/tra-bot-linh-chi-nong-lam.html">Trà - Bột Linh Chi Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/12/ruou-linh-chi-nhan-sam-hai-ma.html">Rượu Linh Chi-Sâm-Hải Mã</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/196/gao-thao-duoc-nong-lam.html">Gạo Thảo Dược Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/168/chum-ngay-nong-lam.html">Chùm Ngây Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/11/mat-ong-nong-lam.html">Mật Ong Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/13/to-yen.html">Tổ Yến Sào Cao Cấp</a></li><li><a href="http://linhchinonglam.com/danh-muc/141/phu-lieu-la-han-qua-co-ngot.html">Phụ Liệu La Hán Quả - Cỏ Ngọt</a></li>
          </ul>
        </li>
        <li><a href="#">Giới thiệu</a>
          <ul class="dropdown-menu">
            <li><a href="http://linhchinonglam.com/tin-tuc/5/hinh-anh-hoat-dong.html">Hình Ảnh &amp; Hoạt Động</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/233/phong-su.html">Phóng Sự</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/2/gioi-thieu.html">Chúng Tôi Là Ai ?</a></li><li><a href="http://linhchinonglam.com/tin-tuc/6/giay-kiem-dinh-phan-tich.html">Giấy Kiểm Định Phân Tích</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/113/giay-chung-nhan-cong-bo-san-pham.html">Giấy Chứng Nhận, Công Bố SP</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="http://linhchinonglam.com/danh-muc/116/tin-tuc-su-kien.html">Tin Tức &amp; Sự Kiện</a>
              <div class="dropdown-menu">
                <div class="dropdown-inner">
                  <ul class="list-unstyled">
                      <li><a href="http://linhchinonglam.com/tin-tuc/79/thong-diep-nhan-ai.html">Thông Điệp Nhân Ái</a></li><li><a href="http://linhchinonglam.com/tin-tuc/80/chuong-trinh-nhan-dao.html">Chương Trình Nhân Đạo</a></li><li><a href="http://linhchinonglam.com/danh-muc/187/nhung-manh-doi-bat-hanh.html">Những Mảnh Đời Bất Hạnh</a></li>
                  </ul>
                </div>
              </div>
            </li>
        </ul>
        </li>
        <li><a href="#">Dịch vụ</a>
          <ul class="dropdown-menu">
            <li class=""><a href="http://linhchinonglam.com/tin-tuc/7/cung-cap-meo-giong-nam.html">Cung Cấp Meo Giống Nấm</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/9/trang-thiet-bi-trong-nam.html">Trang Thiết Bị Trồng Nấm</a></li><li><a href="http://linhchinonglam.com/tin-tuc/8/dao-tao-chuyen-giao-cong-nghe.html">Đào Tạo &amp; Chuyển Giao CN</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/10/huong-dan-xay-dung-trang-trai-trong-nam.html">Xây Dựng Trang Trại</a></li>
        </ul>
        </li>
        <li><a href="#">Đại lý</a>
          <ul class="dropdown-menu">
            <li class=""><a href="http://linhchinonglam.com/tin-tuc/99/he-thong-showroom.html">Hệ Thống Showroom Linh Chi Nông Lâm</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/11/dai-ly-mien-nam.html">Danh Sách Đại Lý Miền Nam</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/51/dai-ly-mien-bac.html">Danh Sách Đại Lý Miền Bắc</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/49/dai-ly-nam-linh-chi-o-tay-nguyen.html">Danh Sách Đại Lý Tây Nguyên</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/62/khu-vuc-mien-trung.html">Danh Sách Đại Lý Miền Trung</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/111/danh-sach-dai-ly-ban-hang-on-line.html">Danh Sách Đại Lý Bán Hàng Online</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/107/danh-sach-chuoi-cua-hang-medicare.html">Danh Sách Chuỗi Cửa Hàng Medicare</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/53/tuyen-dai-ly-nha-phan-phoi-nam-linh-chi.html">Tuyển Đại Lý - Nhà Phân Phối Nấm Linh Chi</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/95/tuyen-dung-nhan-su-cap-cao.html">Tuyển Dụng Nhân Sự Cấp Cao</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/61/tuyen-nhan-vien-kinh-doanh-phat-trien-thi-truong.html">Tuyển Nhân Viên Kinh Doanh Phát Triển Thị Trường</a></li>
        </ul>
        </li>
        <li><a href="#">Sức khỏe</a>
          <ul class="dropdown-menu">
            <li><a href="http://linhchinonglam.com/danh-muc/71/duoc-tinh-nam-linh-chi-do.html">Dược Tính Nấm Linh Chi Đỏ</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/29/tin-tuc-suc-khoe.html">Tin Tức Sức Khỏe</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/122/ban-tin-24h.html">Bản Tin 24H</a></li>
          </ul>
        </li>
        <li><a href="#">Tư vấn</a>
          <ul class="dropdown-menu">
            <li><a href="http://linhchinonglam.com/danh-muc/80/cach-lua-chon-va-su-dung-san-pham.html">Cách Lựa Chọn Và Sử Dụng Sản Phẩm</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/236/cau-hoi-thuong-gap.html">Câu Hỏi Thường Gặp</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/79/cau-hoi-thuong-gap-ve-nam-linh-chi.html">Kiến thức chuyên ngành Nấm Linh Chi</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/74/tu-van-su-dung.html">Sử Dụng Nấm Linh Chi</a></li>
          </ul>
        </li>
        <li><a href="#">Từ thiện</a>
          <ul class="dropdown-menu">
            <li><a href="http://linhchinonglam.com/tin-tuc/79/thong-diep-nhan-ai.html">Thông Điệp Nhân Ái</a></li>
            <li><a href="http://linhchinonglam.com/tin-tuc/80/chuong-trinh-nhan-dao.html">Chương Trình Nhân Đạo</a></li>
            <li><a href="http://linhchinonglam.com/danh-muc/187/nhung-manh-doi-bat-hanh.html">Những Mảnh Đời Bất Hạnh</a></li>
          </ul>
        </li>
        <li style="width: 100px;"><a href="#">Liên hệ</a></li>
      </ul>
    </nav>
  </div>  
</header>
