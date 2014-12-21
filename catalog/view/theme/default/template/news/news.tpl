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
  			<div class="news-info" style="padding: 0 15px">
				<?php if($date_modified != $date_added){ ?>
				<span class="news-properties"><b><?php echo $text_updated_on; ?></b> <?php echo $date_modified; ?> | <b><?php echo $text_posted_on; ?></b> <?php echo $date_added; ?> | <?php echo $text_read; ?> <b><?php echo $count_read; ?></b> <?php echo $text_times; ?> | <b><?php echo $comment_total; ?></b> <?php echo $text_comments; ?></span><br /><br />
				<?php }else{ ?>
				<span class="news-properties"><b><?php echo $text_posted_on; ?></b> <?php echo $date_added; ?> | <?php echo $text_read; ?> <b><?php echo $count_read; ?></b> <?php echo $text_times; ?> | 0 Comments</span><br /><br />
				<?php } ?>
				<div class="news-intro" style="text-align: justify;"><?php echo $short_description; ?></div><br />
				<?php if($image){ ?><center><img src="<?php echo $image; ?>" border="0"/></center><br /><?php } ?>
				<div class="news-description" style="text-align: justify;"><?php echo $description; ?></div><br />  		
		  		<?php if ($related_newss) { ?>
		  		<h2><?php echo $text_related_news; ?></h2>
		  		<ul style="margin-top: 0px;">
		  			<?php foreach ($related_newss as $related_news) { ?>
		  			<li><a href="<?php echo $related_news['href']; ?>"><?php echo $related_news['title']; ?></a></li>
		  			<?php } ?>
		  		</ul>
		  		<?php } ?>		
			</div>	
		  	<?php if($allow_comment) { ?>
			<div id="tab-comment" style="padding: 0 15px">
				<a name="comment_area"></a> 
				<h2><?php echo $text_comments; ?></h2>
		  		<?php if ($comments) { ?>
					<?php foreach ($comments as $comment) { ?>
					<div class="comment"><b><?php echo $comment['name']; ?></b> | <?php echo $comment['date_added']; ?><br />
					<?php echo $comment['comment']; ?></div>
					<?php } ?>
					<div class="pagination"><?php echo $pagination; ?></div>
				<?php } else { ?>
					<div class="comment"><?php echo $text_no_comment; ?></div>
				<?php } ?>
						
		  		<?php if ($comment_permission == 0 || ($comment_permission == 1 && $logged)) { ?>
				<br /><h2 id="comment-title"><?php echo $text_write_comment; ?></h2>
				<b><?php echo $entry_name; ?></b><br />
				<input type="text" name="name" value="" />
			    <br /><br />

		        <b><?php echo $entry_email; ?></b><br />
		        <input type="text" name="email" value="" />
		        <br /><br />
				
				<b><?php echo $entry_comment; ?></b>
				<textarea name="comment" cols="40" rows="8" style="width: 98%;"></textarea>
				<span><?php echo $text_note; ?></span><br />

				<br />
				<b><?php echo $entry_captcha; ?></b><br />
		        	<input type="text" name="captcha" value="" autocomplete="off" />
				<br />
			        <img src="index.php?route=news/news/captcha" id="captcha" />
				<br />
				<div class="buttons">
				  <div class="right"><a id="button-comment" class="button"><span><?php echo $button_comment; ?></span></a></div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<!--  
			  <?php if ($tags) { ?>
			  <div class="tags"><b><?php echo $text_tags; ?></b>
			    <?php foreach ($tags as $tag) { ?>
			    <a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>,
			    <?php } ?>
			  </div>
			  <?php } ?>
			-->  
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