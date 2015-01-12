<?php echo $header; ?>
<div class="container">
  	<div id="content" class="content-container">
  		<div class="content-up" id="content-up"></div>
  		<div id="content-mid">
  			<h2 class="heading-title">Question title</h2>
  			<div class="break"></div>
  			<div class="faq-info">
				<div class="question" style="text-align: justify;">
					<strong class="question-label"><?php echo $txt_question; ?> </strong> Tại sao giá bán nấm linh chi có sự khác biệt? làm sao phân biệt nấm linh chi thật giả?
				</div>
				<div class="answer" style="text-align: justify;">
					Chào Bạn!
					Giá nấm linh chi trên thị trường tùy theo chủng loại mà có giá khác nhau, nếu nấm linh chi đỏ việt nam thì gía thấp thấp nhất cũng trên 1 triệu, và cũng  tùy theo chất lượng của nấm mà giá khác biệt nhau, có những đơn vị làm không đảm bảo quy trình và chỉ đem phơi nắng thì không đảm báo chất lượng dược tính và an toàn vệ sinh thực phẩm, Giá nấm linh chi nhật thì cũng có nhiều chủng loại, loại này giá cao hơn xích chi đỏ việt nam nhiều vì thời gian nuôi trồng nấm linh chi nhật bản dài hơn và chủng loại này năng xuất thấp do giống không mạnh nên tỉ lệ nấm ra quả thể không cao. Tỷ lệ dược tính của nấm linh chi đỏ nhật bản cũng cao hơn.
					Để phân biệt được nấm linh chi thật giả cách chính xác nhất là phân tích thành phần dược tính, nếu khong có điều kiện thì bằng cảm quan uy nhiên nếu nhận biết bàng cảm quan thì khó vì công nghệ làm nấm linh chi giả hiện nay rất tinh vi mà người không có chuyên môn rất khó để nhận biết.
				</div>
				<div class="break"></div>
		  		<div class="related-question">
		  			<h2 class="heading-title" style="margin-bottom: 10px;"><?php echo $txt_related_question; ?></h2>
		  			<div class="break"></div>
			  		<ul class="list-unstyled question-list">
  						<?php for ($i = 0; $i < 5 ; $i ++) { ?>
  							<li>
	  							<h3 class="question-title" style="font-size: 16px;">
	  								<strong>Q:</strong>
	  								<a href="index.php?route=faq/detail" title="Làm sao chọn được Nấm Linh Chi đỏ chất lượng tốt nhất ?">Làm sao chọn được Nấm Linh Chi đỏ chất lượng tốt nhất ?</a>
	  							</h3>
	  							<div class="question-content" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
	  								Chào Linh Chi Nông Lâm tôi xin được tư vấn cách chọn mua Nấm Linh Chi đỏ chất lượng nhất và cho xin cho biết hiện nay trên thị trường Nấm Linh Chi đỏ nào đã được kiểm định chất lượng tốt nhất và nơi bán nấm linh chi uy tín đáng tin cậy?Tôi đã dùng Nấm Linh.
	  							</div>
	  						</li>
  						<?php } ?>  						
  					</ul>
		  		</div>
			</div>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>
<?php echo $footer; ?>