<div class="prd-block-small">
	<div class="image">
		<?php if ($product['special']) { ?>
		<span class="offer-tag-wrp">
		<?php 
			$l_id 		= $this->config->get('config_language_id'); 
			$offerTag 	= $this->config->get('RGenTagData');
			if (isset($offerTag)) {
				$bg 		= isset($offerTag['bg']) && $offerTag['bg'] != '' ? 'background-color: #'.$offerTag['bg'].';' : null;
				$txtcolor	= isset($offerTag['txtcolor']) && $offerTag['txtcolor'] != '' ? 'color: #'.$offerTag['txtcolor'].';' : null;
				$cls 		= isset($offerTag['style']) && $offerTag['style'] == '0' ? 'discount-tag' : 'discount-tag'.$offerTag['style'];
				$tgstyle 	= ' style="'. $bg . $txtcolor . '"';

				if ($offerTag['style'] == 0) {
					$bdr = isset($offerTag['bg']) ? ' style="border-color: #'.$offerTag['bg'].' transparent;"' : null;	
				}elseif ($offerTag['style'] == 1) {
					$bdr = isset($offerTag['bg']) ? ' style="border-color: transparent transparent transparent #'.$offerTag['bg'].';"' : null;	
				}elseif ($offerTag['style'] == 4) {
					$bdr = isset($offerTag['bg']) ? ' style="border-color: transparent #'.$offerTag['bg'].';"' : null;	
				}elseif ($offerTag['style'] == 5) {
					$bdr = isset($offerTag['bg']) ? ' style="border-color: #'.$offerTag['bg'].' transparent transparent transparent;"' : null;
				}else{
					$bdr = null;
				}
			}

			if (!isset($offerTag) || $offerTag['type'] == "default" || $offerTag['type'] == "") { ?>
			<span class="offer-tag"><?php echo $this->language->get('text_offertag'); ?></span>
			<?php } ?>

			<?php if (isset($offerTag) && $offerTag['type'] == "txt") { ?>
			<span class="discount-tag2"<?php echo $tgstyle; ?>>
				<span><?php echo isset($offerTag['text'][$l_id]) ? $offerTag['text'][$l_id] : null; ?></span><i<?php echo $bdr; ?>></i>
			</span>
			<?php } ?>

			<?php if (isset($offerTag) && $offerTag['type'] == "dis") { ?>
			<span class="discount-tag2"<?php echo $tgstyle; ?>>
				<?php 
					$price1 = $product['price'];
					$price2 = $product['special'];
			
					$oldPrice = preg_replace( '#\D*?(\d+(\.\d+)?)\D*#', '$1', $price1);
					$newPrice = preg_replace( '#\D*?(\d+(\.\d+)?)\D*#', '$1', $price2);
			
					$diff = $oldPrice - $newPrice;
					
					$discuountCal = 100 * $diff / $oldPrice;
					$discuount = round($discuountCal, 2) . '%';
				?>
				<span><?php echo $discuount; ?></span><i<?php echo $bdr; ?>></i>
			</span>
			<?php } ?>
		</span>
		<?php } ?>

		<a href="<?php echo $product['href']; ?>">
			<?php if ($product['thumb']) { ?>
			<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
			<?php } ?>
		</a>
	</div>
	<div class="info">
		<a href="<?php echo $product['href']; ?>" class="name"><?php echo $product['name']; ?></a>
		<?php if ($product['price']) { ?>
		<div class="price-wrp">
			<?php if (!$product['special']) { ?>
			<?php echo $product['price']; ?>
			<?php } else { ?>
			<span class="price-old"><?php echo $product['price']; ?></span>
			<?php echo $product['special']; ?>
			<?php } ?>
		</div>
		<?php } ?>
		<?php if (isset($product['description'])) { ?>
		<div class="description"><?php echo $product['description']; ?></div>
		<?php } ?>
		<ul>
			<li><a class="addcart-bt link-bt" title="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></a></li>
			<li>
				<a class="wish-bt" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $this->language->get('button_wishlist'); ?> <span>&#8250;</span></a>
				<a class="compare-bt" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $this->language->get('button_compare'); ?> <span>&#8250;</span></a>
			</li>
		</ul>
	</div>
</div>