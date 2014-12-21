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
  			<?php if($newss) { ?>
				<?php foreach ($newss as $news) { ?>
					<div style="min-height:<?php echo $min_height; ?>px;padding: 10px 20px; border-bottom:1px dotted;">
						<?php if($news['image']){ ?><a href="<?php echo $news['href']; ?>"><img src="<?php echo $news['image']; ?>" border="0" align="left" style="margin-right: 10px;" alt="<?php echo $news['title']; ?>" title="<?php echo $news['title']; ?>" /></a><?php } ?>
						<p>
							<a href="<?php echo $news['href']; ?>"><b><?php echo $news['title']; ?></b></a><br />
							<?php if($news['date_modified'] != $news['date_added']){ ?>
							<span class="news-properties" style="font-size: 11px; color: #aaaaaa;"><b><?php echo $text_updated_on; ?></b> <?php echo $news['date_modified']; ?> | <b><?php echo $text_posted_on; ?></b> <?php echo $news['date_added']; ?></span><br />
							<?php }else{ ?>
							<span class="news-properties" style="font-size: 11px; color: #aaaaaa;"><b><?php echo $text_posted_on; ?></b> <?php echo $news['date_added']; ?></span><br />
							<?php } ?>
						</p>
						<p style="text-align: justify;">
							<?php echo $news['short_description']; ?><br />
							<span class="news-properties" style="font-size: 11px; color: #aaaaaa;"><?php echo $text_read; ?> <b><?php echo $news['count_read']; ?></b> <?php echo $text_times; ?> | <a href="<?php echo $news['href_comment']; ?>" style="font-size: 11px;"><?php echo $news['news_comment_count']; ?> <?php echo $text_comments; ?></a></span>
						</p>
					</div>
					<div style="clear:both"></div>
				<?php } ?>
				<div class="pagination"><?php echo $pagination; ?></div>
			<?php } else{ ?>
				<?php echo $text_news_not_found; ?>
			<?php } ?>  
			<div class="buttons">
				<div class="pull-right">
					<a href="<?php echo $continue; ?>" class="btn btn-primary btn-sm"><span><?php echo $button_continue; ?></span></a>
				</div>
			</div>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>
<?php echo $footer; ?> 