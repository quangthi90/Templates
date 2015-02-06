<?php echo $header; ?>
<div class="container">
  	<div id="content" class="content-container">
  		<div class="content-up" id="content-up"></div>
  		<div id="content-mid">
  			<h2 class="heading-title"><?php echo $title; ?></h2>
  			<div class="question" style="text-align: justify;">
				</div>
  			<div class="break"></div>
  			<div class="faq-info">
				<div class="question" style="text-align: justify;">
					<strong class="question-label"><?php echo $txt_question; ?> </strong> <?php echo $question; ?>
				</div>
				<div class="answer" style="text-align: justify;">
					<?php echo $answer; ?>
				</div>
				<div class="break"></div>
		  		<div class="related-question">
		  			<h2 class="heading-title" style="margin-bottom: 10px;"><?php echo $txt_related_question; ?></h2>
		  			<div class="break"></div>
			  		<ul class="list-unstyled question-list">
			  			<?php if ($faqs) { ?>
			                <?php foreach ($faqs as $faq) { ?>
			                <li>
	  							<h3 class="question-title">
	  								<strong>Q:</strong>
	  								<a href="<?php echo $faq['href']; ?>" title="<?php echo $faq['question']; ?>"><?php echo $faq['question']; ?></a>
	  							</h3>
	  							<div class="answer-content" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
	  								<?php echo $faq['cut_answer']; ?>
	  							</div>	  							
	  						</li>			                
			                <?php } ?>
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