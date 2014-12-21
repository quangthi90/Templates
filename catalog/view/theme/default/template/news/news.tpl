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
				<div class="news-description" style="text-align: justify;"><?php echo $description; ?></div><br />		
		  		<?php if ($related_newss) { ?>
			  		<div class="break"></div>
			  		<h2 class="heading-title" style="margin-bottom: 10px;"><?php echo $text_related_news; ?></h2>
			  		<ul class="content-list">
			  			<?php foreach ($related_newss as $related_news) { ?>
			  			<li><a href="<?php echo $related_news['href']; ?>"><?php echo $related_news['title']; ?></a></li>
			  			<?php } ?>
			  		</ul>
		  		<?php } ?>		
			</div>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>

<script type="text/javascript">
<!--  
	$('#comment').load('index.php?route=news/news/comment&news_id=<?php echo $news_id; ?>');

	$('#button-comment').bind('click', function() {
		$.ajax({
			type: 'POST',
			url: 'index.php?route=news/news/write&news_id=<?php echo $news_id; ?>',
			dataType: 'json',
			data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&email=' + $('input[name=\'email\']').val() + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
			beforeSend: function() {
				$('.success, .warning').remove();
				$('#button-comment').attr('disabled', true);
				$('#comment-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
			},
			complete: function() {
				$('#button-comment').attr('disabled', false);
				$('.attention').remove();
			},
			success: function(data) {
				if (data.error) {
					$('#comment-title').after('<div class="warning">' + data.error + '</div>');
				}
				
				if (data.success) {
					$('#comment-title').after('<div class="success">' + data.success + '</div>');
					$('input[name=\'email\']').val('');
					$('input[name=\'name\']').val('');
					$('textarea[name=\'comment\']').val('');
					$('input[name=\'captcha\']').val('');
				}
			}
		});
	});
//-->
</script> 
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