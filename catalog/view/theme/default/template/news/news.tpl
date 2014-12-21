<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
	    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    	<?php } ?>
  	</ul>
  	<div id="content" class="content-container">
  		<div class="content-up" id="content-up"></div>
  		<div id="content-mid">
  			<h2 class="heading-title"><?php echo $heading_title; ?></h2>
  			<div class="break"></div>
  			<div class="news-info">
				<div class="news-intro" style="text-align: justify;"><?php echo $short_description; ?></div><br />
				<div class="news-description" style="text-align: justify;"><?php echo $description; ?></div>
				<!-- end content -->
		  		<?php if ($related_newss) { ?>
		  		<div class="news-related">
		  			<div class="break"></div>
			  		<!--h2 class="heading-title" style="margin-bottom: 10px;"><?php echo $text_related_news; ?></h2-->
			  		<ul class="content-list">
			  			<?php foreach ($related_newss as $related_news) { ?>
			  			<li><a href="<?php echo $related_news['href']; ?>"><?php echo $related_news['title']; ?></a></li>
			  			<?php } ?>
			  		</ul>
		  		</div>		  		
		  		<?php } ?>		
			</div>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript">
	<!--
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}
	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
	//-->
</script> 
<?php echo $footer; ?>