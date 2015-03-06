<?php echo $header; ?>
<div class="container">
    <div id="content" class="content-container">
        <?php echo $content_top; ?>
        <div class="order-ad" id="order-ad">
            <a href="<?php echo $faq; ?>" class="btn btn-main pull-left text-upper" id="link-qa">Hỏi Đáp</a>
            <p class="text-ad">VUI LÒNG GỌI <?php echo $phone; ?> HOẶC ĐẶT HÀNG TRỰC TUYẾN</p>
            <a href="<?php echo $product_catalog; ?>" class="btn btn-main pull-right text-upper" id="link-ordernow">Đặt Mua Ngay Bây Giờ</a>
            <div class="clearfix"></div>
        </div>
        <div class="content-up" id="content-up">            
        </div>
        <div id="content-mid">
            <div id="welcome" class="home-box">
                <div class="welcome-slogan">          
                </div>
                <div class="welcom-text">
                    <a href="<?php echo $home_url; ?>">Linh Chi Nông Lâm</a> được kiểm định tại phòng thí nghiệm Công Nghệ Sinh Học - Viện Nghiên cứu Công nghệ Sinh học và Môi trường - Trường ĐH Nông Lâm TP.HCM. Với mong muốn đem lại những sản phẩm uy tín, chất lượng được nghiên cứu, kiểm định, sản xuất theo đúng quy trình công nghệ khép kín đáp ứng đầy đủ các tiêu chí của dược phẩm thượng hạng Nấm Linh Chi.
                </div>
            </div>
            <div class="break"></div>
            <div id="topics" class="home-box">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="panel panel-flat home-topic">
                            <div class="panel-heading">
                                <h3 class="text-bold" title="Giới thiệu về linh chi đại học Nông Lâm"><a href="<?php echo $col_1_link; ?>">GIỚI THIỆU</a></h3>
                            </div>
                            <div class="panel-body">
                                <?php echo $col_1_html; ?>
                                <a href="#" class="topic-title text-bold"><?php echo $col_1_title; ?></a>
                                <div class="topic-content">
                                    <?php echo $col_1_description; ?>
                                </div>
                                <a href="<?php echo $col_1_link; ?>" class="btn btn-main btn-sm pull-right">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="panel panel-flat home-topic">
                            <div class="panel-heading">
                                <h3 class="text-bold" title="Sản phẩm của Linh Chi Nông Lâm"><a href="<?php echo $col_2_link; ?>">SẢN PHẨM</a></h3>
                            </div>
                            <div class="panel-body">
                                <a href="#">
                                    <?php echo $col_2_html; ?>
                                </a>
                                <a href="#" class="topic-title text-bold"><?php echo $col_2_title; ?></a>
                                <div class="topic-content">
                                    <?php echo $col_2_description; ?>
                                </div>
                                <a href="<?php echo $col_2_link; ?>" class="btn btn-main btn-sm pull-right">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="panel panel-flat home-topic">
                            <div class="panel-heading">
                                <h3 class="text-bold" title="Tin tức về nấm Linh Chi Nông Lâm"><a href="<?php echo $col_3_link; ?>">TIN TỨC</a></h3>
                            </div>
                            <div class="panel-body">
                                <a href="#">
                                    <?php echo $col_3_html; ?>
                                </a>
                                <div class="topic-content" style="margin-top: 10px; height: 165px;">
                                    <ul class="list-unstyled">
                                    <?php foreach ($newses as $news) { ?>
                                        <li>
                                            <a href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?><span class="mark-new"></a>
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                <a href="<?php echo $col_3_link; ?>" class="btn btn-main btn-sm pull-right">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>            
            <?php echo $content_bottom; ?>
        </div>        
        <div class="content-down" id="content-down">            
        </div>
    </div>
</div>
<?php echo $footer; ?>
  