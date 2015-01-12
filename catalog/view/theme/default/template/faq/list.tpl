<?php echo $header; ?>
<div class="container">
  	<div id="content" class="content-container">
  		<div class="content-up" id="content-up"></div>
  		<div id="content-mid">
  			<h2 class="heading-title"><?php echo $heading_title; ?></h2>
  			<div class="break"></div>
  			<div class="row">
  				<div class="col-xs-7">
  					<ul class="list-unstyled question-list">
  						<?php for ($i = 0; $i < 6 ; $i ++) { ?>
  							<li>
	  							<h3 class="question-title">
	  								<strong>Q:</strong>
	  								<a href="index.php?route=faq/detail" title="Làm sao chọn được Nấm Linh Chi đỏ chất lượng tốt nhất ?">Làm sao chọn được Nấm Linh Chi đỏ chất lượng tốt nhất ?</a>
	  							</h3>
	  							<div class="question-content">
	  								Chào Linh Chi Nông Lâm tôi xin được tư vấn cách chọn mua Nấm Linh Chi đỏ chất lượng nhất và cho xin cho biết hiện nay trên thị trường Nấm Linh Chi đỏ nào đã được kiểm định chất lượng tốt nhất và nơi bán nấm linh chi uy tín đáng tin cậy?Tôi đã dùng Nấm Linh.
	  							</div>
	  							<div class="pull-right">
	  								<a href="#" class="view-answer"><?php echo $txt_view_answer; ?></a>
	  							</div>
	  						</li>
  						<?php } ?>  						
  					</ul>
  				</div>
  				<div class="col-xs-5">
  					<div class="panel panel-black">
					  	<div class="panel-heading">
						    <h3 class="panel-title"><strong> ? </strong> <?php echo $txt_submit_question; ?></h3>
						  </div>
					  	<div class="panel-body">
						    <form action="<?php echo $submit_action; ?>" method="post">
							  <div class="form-group">
							    <input type="text" required class="form-control input-sm" id="txtFullName" placeholder="<?php echo $txt_full_name; ?>">
							  </div>
							  <div class="form-group">
							    <input type="email" required class="form-control input-sm" id="txtEmail" placeholder="<?php echo $txt_email; ?>">
							  </div>
							  <div class="form-group">
							    <input type="text" required class="form-control input-sm" id="txtQuestionTitle" placeholder="<?php echo $txt_question_title; ?>">
							  </div>
							  <div class="form-group">
							    <textarea rows="5" required class="form-control input-sm" placeholder="<?php echo $txt_question_content; ?>" style="resize: vertical;"></textarea>
							  </div>
							  <div class="form-group">
							  	<img src="<?php echo $captcha_link; ?>" style="margin-bottom: 5px;">
							    <input type="text" required class="form-control input-sm" placeholder="<?php echo $txt_security_code; ?>">
							  </div>
							  <div class="form-group">
							  	<input type="submit" value="<?php echo $btn_submit; ?>" class="btn btn-primary" />
							  </div>
						  	</form>
					  	</div>
					</div>
  				</div>
  			</div>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>
<?php echo $footer; ?>