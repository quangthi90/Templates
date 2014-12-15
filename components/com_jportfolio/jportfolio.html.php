<?php
/**
* JPortfolio for Joomla 1.0.13
*
* @version 1.3  2008-02-04
* @Copyright (C) 2008 Konrad Gretkiewicz - kgretk@anetus.com, www.anetus.com
* @ All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License (GPL).
* as published by the Free Software Foundation.
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
* See the GNU General Public License for more details.
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function display_categories( $option, &$rows, &$pageNav )
{
  global $jportfolioConf, $Itemid, $mosConfig_live_site,$mainframe;
  $params = clone($mainframe->getParams('com_jportfolio'));
?>  


<div id="vmMainPage">
  <div class="tour_title"><?php echo $params->get('page_title'); ?></div>
  
  <?php
  $j=$pageNav->limitstart;
  	for($i=$pageNav->limitstart; $i < ($pageNav->limitstart+$pageNav->limit) && $i < $pageNav->total; $i++)	{

	?>
		  <div class="hotel_box">
			<div class="destination_title">
			  <div class="destination_title_left"><?php echo ++$j;?></div>
			  <div class="destination_title_right"><b><a title="<?php echo $rows[$i]->cat_name;?>" href="<?php echo JRoute::_('index.php?option='.$option.'&amp;cat='.$rows[$i]->id.'-'.$rows[$i]->alias.'&amp;Itemid='.$Itemid);?>"><?php echo $rows[$i]->cat_name;?></a></b></div>
			</div>
			<p><a title="<?php echo $rows[$i]->cat_name;?>" href="<?php echo JRoute::_('index.php?option='.$option.'&amp;cat='.$rows[$i]->id.'-'.$rows[$i]->alias.'&amp;Itemid='.$Itemid);?>"> <img border="0" alt="<?php echo $rows[$i]->cat_name;?>" title="<?php echo $rows[$i]->cat_name;?>s" class="hotel_img5" src="<?php echo $mosConfig_live_site.'/'.$jportfolioConf->base_path.$rows[$i]->cat_image?>"></a></p>
			<div class="hotel_detail_text"> <?php echo $rows[$i]->cat_info;;?> </div>
		  </div>
   <?php 
    }
   ?>
  
  
  	<div class="page">
						<div class="page_left"><img src="<?php echo $mosConfig_live_site;?>/templates/huongbang/images/page_left.gif" width="4" height="28" /></div>
						<div class="page_mid">
							<div class="page_ml"><?php echo $pageNav->getPagesCounterCustom();?></div>
							<div class="page_mc">Pages: 
								<?php
                                    $link='index.php?option=com_jportfolio';
                                    echo $pageNav->getPagesLinks($link);
                                ?>
                            </div>
                            <form method="post" action="index.php" name="adminForm">
							<div class="page_ml">Show 
                                        
                                            <?php echo $pageNav->getLimitBoxCustom( 3 ); ?> &nbsp;Items
                                            <input type="hidden" value="com_jportfolio" name="option">
                                                        <input type="hidden" value="12" name="cat">		
                                      
                               </div>
                                </form>
						</div>
						<div class="page_left"><img src="<?php echo $mosConfig_live_site;?>/templates/huongbang/images/page_right.gif" width="4" height="28" /></div>
					</div>
                    
                    
                    
                    
                    
                    
</div>

<?php

} 





function display_one_cat( &$rows, &$params, &$pageNav , &$cat_name, &$catid)
{

global $jportfolioConf, $option, $Itemid, $mosConfig_absolute_path, $mosConfig_live_site;



?>
<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/components/com_jportfolio/highslide/highslide-with-gallery.js"></script>

<!-- 
	2) Optionally override the settings defined at the top
	of the highslide.js file. The parameter hs.graphicsDir is important!
-->

<script type="text/javascript">
	hs.graphicsDir = '<?php echo $mosConfig_live_site;?>/components/com_jportfolio/highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;
	
	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 10000,
		repeat: false,
		useControls: true,
		fixedControls: false,
		overlayOptions: {
			opacity: 1,
			position: 'top right',
			hideOnMouseOut: false
		}
	});
</script>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site;?>/components/com_jportfolio/css/css.css" type="text/css" />





<div class="tour_title"><?php echo $cat_name;?></div>

<?php

 if (!$rows) echo '<div class="updating_product">'.JText::_('NO_RESULT').'</div>';
 $j=0;
 for($i=$pageNav->limitstart; $i < ($pageNav->limitstart+$pageNav->limit) && $i < $pageNav->total; $i++)
 {
 	$j++;
    $classname = 'hotel_box1';
	if($j==1)								
		echo '<div class="hotel_box">';									
	elseif($j==3)
		$classname = 'hotel_box2';
									
			$src1=$jportfolioConf->base_path.$rows[$i]->cat_path.'/'.$rows[$i]->proj_image;
			$src = 'includes/thumbnail1.php?photo='.$rows[$i]->proj_image.'&sw=gallery/'.$rows[$i]->cat_path;
			if (!file_exists($mosConfig_absolute_path.'/'.$src1))
			{
				  $src='includes/thumbnail1.php?photo=no_image.png';
			}
			$link2=sefRelToAbs('index.php?option='.$option.'&amp;cat='.$rows[$i]->catid.'&amp;project='.$rows[$i]->id.'&amp;Itemid='.$Itemid);
			$prname=$rows[$i]->name;
			$url = $rows[$i]->url;
	
			$height_photo = 500;
			$width_photo = 500;

			if (file_exists($src1)) 
			{
				list($width_photo, $height_photo, $type, $attr) = getimagesize($src1);				
			}

?>


    <div class="<?php echo $classname;?>">
        <p>
            <a href="<?php echo $mosConfig_live_site;?>/<?php echo $src;?>&width=<?php echo $width_photo;?>&height=<?php echo $height_photo;?>" title="<?php echo $prname;?>" class="highslide" onclick="return hs.expand(this)">
				<img src="<?php echo $mosConfig_live_site;?>/<?php echo $src;?>&width=135&height=102" border="0" alt="<?php echo $prname;?>" width="135" height="102"   class="hotel_img2" align="left" />
             </a>
         </p>
        <div class="hotel_text">
        	<a href="<?php echo $mosConfig_live_site;?>/<?php echo $src;?>&width=<?php echo $width_photo;?>&height=<?php echo $height_photo;?>"><?php echo $prname;?></a>
        </div>
	</div>  
  
<?php 
		if($j==3)
		{
			echo '</div>';
			$j=0;
		}
  }
		 if($j>0)
			echo '</div>'; 
 ?>  
  


<div class="page">
						<div class="page_left"><img src="<?php echo $mosConfig_live_site;?>/templates/huongbang/images/page_left.gif" width="4" height="28" /></div>
						<div class="page_mid">
							<div class="page_ml"><?php echo $pageNav->getPagesCounterCustom();?></div>
							<div class="page_mc">Pages: 
								<?php
                                    $link='index.php?option=com_jportfolio&cat='.$catid;
                                    echo $pageNav->getPagesLinks($link);
                                ?>
                            </div>
                            <form method="post" action="index.php" name="adminForm">
							<div class="page_ml">Show 
                                        
                                            <?php echo $pageNav->getLimitBoxCustom( 3 ); ?> &nbsp;Items
                                            <input type="hidden" value="com_jportfolio" name="option">
                                                        <input type="hidden" value="12" name="cat">		
                                      
                               </div>
                                </form>
						</div>
						<div class="page_left"><img src="<?php echo $mosConfig_live_site;?>/templates/huongbang/images/page_right.gif" width="4" height="28" /></div>
					</div>
                    
                    
<?php
  
 

}



function display_project( $catid, $catname, $catpath, &$proj, &$params, &$prev, &$next )
{
global $database, $option,$Itemid, $jportfolioConf, $mosConfig_absolute_path, $mosConfig_live_site;

echo '<div id="jp_front">';

  echo '<h2 class="jp_cattitle">'._COM_JP_CAT_NAME.$catname.'</h2>';
  echo '<h3 class="jp_projtop" >'._COM_JP_PROJ_NAME.$proj->name.'</h3>';

  echo '<div id="jp_projcont" >';
    $src=$jportfolioConf->base_path.$catpath.'/'.$proj->proj_image;
		$file = explode('.',$proj->proj_image);
		if (substr($file[0],-1,1) == '1')
		{
			// image name ends with "1" so there may be more images for the project
			// first image
			echo '<div id="jp_projimage" >';
			if (!file_exists($mosConfig_absolute_path.'/'.$src))
			{
				$src='components/com_jportfolio/images/no_image.png';
			}
			echo '<img src="'.$mosConfig_live_site.'/'.$src.'" border="0" alt="'._COM_JP_PROJ_NAME.$proj->name.'" />';
			echo '</div>';
			// rest of images, from 2 to 9
			$name = substr($proj->proj_image,0,strlen($file[0])-1);
			$i = 2;
			for ($i;$i<10;$i++)
			{
				$name2 = $name.$i.'.'.$file[1]; 
				$src=$jportfolioConf->base_path.$catpath.'/'.$name2;
				if (file_exists($mosConfig_absolute_path.'/'.$src))
				{
					echo '<div id="jp_projimage" >';
					echo '<img src="'.$mosConfig_live_site.'/'.$src.'" border="0" alt="'._COM_JP_PROJ_NAME.$proj->name.'" />';
					echo '</div>';
				}
			}
			
		}
		else
		{
			// just one image
			echo '<div id="jp_projimage" >';
			if (!file_exists($mosConfig_absolute_path.'/'.$src))
			{
				$src='components/com_jportfolio/images/no_image.png';
			}
			echo '<img src="'.$mosConfig_live_site.'/'.$src.'" border="0" alt="'._COM_JP_PROJ_NAME.$proj->name.'" />';
			echo '</div>';
		}
		
    echo '<div id="jp_projdesc" >';
    echo $proj->description.'<br />';
    echo '</div>';
    
    
  echo '</div>';
  
  if ( $params->get( 'item_navigation' )  )
  {
    echo '<div class="jp_proj_pagination">';

	if ($prev)
	{
		$prevlink = sefRelToAbs('index.php?option='.$option.'&amp;cat='.$catid.'&amp;project='.$prev.'&amp;Itemid='.$Itemid);
		echo '<a href="'.$prevlink.'" class="pagenav">'._COM_JP_PREV.'</a>';
	}
	else
		echo '<span class="pagenav">'._COM_JP_PREV.'</span>';
		
	if ($next)
	{
		$nextlink = sefRelToAbs('index.php?option='.$option.'&amp;cat='.$catid.'&amp;project='.$next.'&amp;Itemid='.$Itemid);
		echo '<a href="'.$nextlink.'  " class="pagenav">'._COM_JP_NEXT.'</a>';
	}
	else
		echo '<span class="pagenav">'._COM_JP_NEXT.'</span>';

    echo '</div>';   
  }
  
  if ( $params->get( 'back_button' ))
  {
  	echo '<div class="jp_back">';
    mosHTML::BackButton ( $params );
    echo '</div>';
  }
  
  bottom();
echo '</div>';

}


function bottom()
{
?>	
	<div id="jp_bottom">
	<a href="" target="_blank" title=""></a>
	</div>
<?php
}


?>