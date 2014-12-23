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
  				<?php if(count($newss) > 3) { ?>
  					<div class="news-featured">
  						<?php for ($i = 0; $i < 3; $i++) { $news = $newss[$i]; ?>
							<div class="news-item">
								<?php if($news['image']){ ?>
									<a href="<?php echo $news['href']; ?>">
										<img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" title="<?php echo $news['title']; ?>" />
									</a>
								<?php } ?>
								<a href="<?php echo $news['href']; ?>" class="text-bold news-title"><?php echo $news['title']; ?></a>
							</div>
						<?php } ?>
						<div style="clear:both"></div>
  					</div>
  					<div class="break"></div>
  					<div class="news-list">
  						<ul class="content-list">
  							<?php for ($j = 3; $j < count($newss); $j++) { $news = $newss[$j]; ?>
								<li>
									<a href="<?php echo $news['href']; ?>" class="text-bold">
										<?php echo $news['title']; ?>
									</a>
								</li>
							<?php } ?>
  						</ul>  						
  					</div>  					
  				<?php } else { ?>
  					<div class="news-featured">
  						<?php for ($i = 0; $i < count($newss); $i++) { $news = $newss[$i]; ?>
							<div class="news-item">
								<?php if($news['image']){ ?>
									<a href="<?php echo $news['href']; ?>">
										<img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" title="<?php echo $news['title']; ?>" />
									</a>
								<?php } ?>
								<a href="<?php echo $news['href']; ?>" class="text-bold"><?php echo $news['title']; ?></a>
							</div>							
						<?php } ?>
						<div style="clear:both"></div>
  					</div>
  				<?php } ?>
			<?php } else { ?>
				<?php echo $text_news_not_found; ?>
			<?php } ?>
		  	<?php echo $content_bottom; ?>
  		</div>
  		<div class="content-down" id="content-down"></div>
  	</div>
</div>
<?php echo $footer; ?> 