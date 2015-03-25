<?php echo $header; ?>
<div class="container">
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>">
            <?php echo $content_top; ?>
            <!-- Start First Product Block -->
            <div class="row">
                <!--cols:9   -->
                <div class="col-md-9  ">
                    <div class="tabs">
                        <ul class="nav nav-tabs" id="prod_0_2_3_tabs">
                            <li class="active"><a href="#tab-prod-lastest" data-toggle="tab" aria-expanded="true">Sản phẩm mới</a></li>
                            <li class=""><a href="#tab-prod-bestseller" data-toggle="tab" aria-expanded="false">Bán chạy</a></li>
                            <li class=""><a href="#tab-prod-specials" data-toggle="tab" aria-expanded="false">Khuyến mãi</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-prod-lastest">
                                <div class="row products">
                                    <?php for ($i=0; $i < 8; $i++) { ?>
                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 product">
                                            <div class="pro-img">
                                                <a href="#"> 
                                                    <img class="img-responsive" src="http://thitruongnongnghiep.vn/Portals/0/SanPham/t-Chim-tri-thit-2-14310119615.jpg" alt="" style="display: inline-block;">
                                                </a>
                                            </div>
                                            <div class="pro-name"><a href="#">Chim Trĩ đỏ thịt <?php echo ($i + 1); ?></a></div>
                                            <div class="pro-price">Giá: Liên hệ</div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-prod-bestseller">
                                <div class="row products">
                                    <?php for ($i=0; $i < 8; $i++) { ?>
                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 product">
                                            <div class="pro-img">
                                                <a href="#"> 
                                                    <img class="img-responsive" src="http://thitruongnongnghiep.vn/Portals/0/SanPham/t-ca-bo-hom-1-z141216145245227.jpg">
                                                </a>
                                            </div>
                                            <div class="pro-name"><a href="#">Cá Bò Hòm <?php echo ($i + 1); ?></a></div>                                        
                                            <div class="pro-price">185.000 đ</div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-prod-specials">
                                <div class="row products">
                                    <?php for ($i=0; $i < 8; $i++) { ?>
                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 product">
                                            <div class="pro-img">
                                                <a href="#"> 
                                                    <img class="img-responsive" src="http://thitruongnongnghiep.vn/Portals/0/SanPham/t-buoi-nam-roi-02616161656.jpg">
                                                </a>
                                            </div>
                                            <div class="pro-name"><a href="#">Bưởi Năm Roi FC014 <?php echo ($i + 1); ?></a></div>
                                            <div class="pro-price">60.000 đ</div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <!--cols:3   -->
                <div class="col-md-3  ">
                    <div class="heading clearfix">
                        <h2>Phổ biến</h2>
                    </div>
                    <div class="carousel" id="prod_0_7_2">
                        Phổ biến
                    </div>
                </div>
            </div>
            <!-- End First Product Block -->
            <?php echo $content_bottom; ?>
        </div>
        <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>