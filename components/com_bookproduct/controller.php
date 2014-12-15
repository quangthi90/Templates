<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class BookproductController extends JController
{  
	  function display()
	  {			
			$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'bookproduct');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
			$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
			
			$view->setLayout('default');
			$view->display();			
	  }	  
	  function bookroom()
	  {
	  		$document 	= &JFactory::getDocument();
			$viewName 	= JRequest::getVar('view', 'bookhotel');
			$viewType 	= $document->getType();
			$view		= &$this->getView($viewName, $viewType);
			
		
				$model	= &$this->getModel( $viewName );

			if (!JError::isError( $model )) {
				$view->setModel( $model, true );
			}
		
		
		
			$view->setLayout('default');
			$view->display();
	  }
	  
	   
	   
	   function send_mail()
	   {	   		
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_bookproduct'.DS.'tables');
			
			$db		=& JFactory::getDBO();
			
			if($_REQUEST['city']!=NULL && $_REQUEST['city']!=0)
			{
				$sql = 'select name from #__pl_city where id='.$_REQUEST['city'];
				$db->setQuery( $sql );
				$tentp = $db->loadResult();
			}
			
			if($_REQUEST['district']!=NULL && $_REQUEST['district']!=0)
			{
				$sql = 'select namedistrict from #__pl_district where id='.$_REQUEST['district'];
				$db->setQuery( $sql );
				$tenquan = $db->loadResult();
			}
			
			
			$khuvuc = $tentp." - ".$tenquan;
			$sql = "insert into #__bookproduct(hoten,email,diachi,sdt,ngaydathang,nguoinhan,khuvuc,diachinhan,sdtnhan,didong,chuthich,phuongthuc) values('".$_REQUEST['hoten']."','".$_REQUEST['email']."','".$_REQUEST['diachi']."','".$_REQUEST['sdt']."','".$_REQUEST['ngaydathang']."','".$_REQUEST['nguoinhan']."','".$khuvuc."','".$_REQUEST['diachinhan']."','".$_REQUEST['sdtnhan']."','".$_REQUEST['didong']."','".$_REQUEST['chuthich']."','".$_REQUEST['phuongthuc']."')";
			$db->setQuery( $sql );
			if (!$db->query()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}else{
				$hoadon_id = $db->insertid();
				
				$product_id 	= JRequest::getVar('proid_prod', array(0), 'post', 'array');
				JArrayHelper::toInteger($product_id);

				if (count( $product_id )) {
					$product_ids = implode( ',', $product_id );
					
					$product_id_array = split(',',$product_ids);
					
					foreach($product_id_array as $rid)
					{
						$sql = "insert into #__chitiethoadon(product_id,hoadon_id,soluong,hinhanh,dongia,tensp,tongcong) values(".$rid.",".$hoadon_id.",".$_REQUEST['soluong_'.$rid.'_prod'].",'".$_REQUEST['image_'.$rid.'_prod']."',".$_REQUEST['dongia_'.$rid.'_prod'].",'".$_REQUEST['productname_'.$rid.'_prod']."',".$_REQUEST['tongcong_'.$rid.'_prod'].")";
						$db->setQuery( $sql );
						$db->query();
					}
						
				}

				//echo $db->insertid();
			}
			

			Global $return,$option,$option2,$product_id,$category_id,$Itemid,$flypage;
			require_once('administrator/components/com_virtuemart/classes/ps_cart.php' );
			$ps_cart =& new ps_cart;

			$set = $ps_cart->reset();
			
			
			
			/*send mail*/
			$sql = 'select * from #__bookproduct_config';
			$db->setQuery( $sql );
			$row = $db->loadObject();
			
			$from = $row->from;
			$fromname = $row->fromname;
			$recipient = $row->recipient;
			$subject = $row->subject;
			
			$mode = 1;
			$cc = $row->cc;
			$bcc = $row->bcc;
			$attachment[] = $file_attach1;
			$attachment[] = $file_attach2;
			$replyto = $row->replyto;
			$replytoname = $row->replytoname;
			
			
			//$body = BookproductController::form_HTML($file_attach1_link,$file_attach2_link);
			$body = "Bạn có đơn đặt hàng mới từ '".$_REQUEST['hoten']."'. Mã HĐ: HD ".$hoadon_id;
		
			BookproductController::gui_mail($from, $fromname, $recipient, $subject, $body, 1, $cc, $bcc, $attachment, $replyto, $replytoname);
			
			/*/*send mail for customer*/
			/*$body = BookproductController::form_HTML1($file_attach1_link,$file_attach2_link);
			$recipient = $_POST['email'];
			BookproductController::gui_mail($from, $fromname, $recipient, $subject, $body, 1, $cc, $bcc, $attachment, $replyto, $replytoname);*/
			
			
			/*echo note*/
		/*	
			$sql = 'select note_mail from #__bookproduct_config';
			$db->setQuery( $sql );
			$note_mail = $db->loadResult();
			
			$note_mail .= '<br>';*/
			
			$product_id 	= JRequest::getVar('proid_prod', array(0), 'post', 'array');
				JArrayHelper::toInteger($product_id);
			if (count( $product_id )) {
					$product_ids = implode( ',', $product_id );
					
					$product_id_array = split(',',$product_ids);
					
					$str_ = '';
					$price_tottal = 0;
					foreach($product_id_array as $rid)
					{
						$price_tottal += $_REQUEST['tongcong_'.$rid.'_prod'];
						$str_ .='<tr>
                              <td width="15%" class="table_td_white"><img class="table_img" src="components/com_virtuemart/shop_image/product/'.$_REQUEST['image_'.$rid.'_prod'].'"></td>
                              <td width="20%" class="table_td_white"><strong>'.$_REQUEST['productname_'.$rid.'_prod'].'</strong><br>
                              </td>
                              <td width="20%" class="table_td_white">'.number_format($_REQUEST['dongia_'.$rid.'_prod'], 0, ',', '.').'</td>
                              <td width="20%" class="table_td_white">'.number_format($_REQUEST['soluong_'.$rid.'_prod'], 0, ',', '.').'
                              </td>
                              <td width="20%" class="table_td_white">'.number_format($_REQUEST['tongcong_'.$rid.'_prod'], 0, ',', '.').'</td>                             
							</tr>';
                    }
						
				}
			
			$note_mail = '<div class="left_box"><div class="product_top"><b>THÔNG TIN MUA HÀNG</b></div><div class="product_mid">
			<div class="product_list">
  <div class="ttnd1_right"> <div style="float:left; margin-left:30px; margin-bottom:10px; font-weight:bold;">Chúc mừng quý khách đã mua hàng thành công !!</div>
    <table width="100%" cellspacing="1" cellpadding="0" border="1" bgcolor="#ababab">
      <tbody>
        <tr>
          <td width="15%" class="table_td">Hình</td>
          <td width="20%" class="table_td">Tên sản phẩm</td>
          <td width="20%" class="table_td">Đơn giá</td>
          <td width="20%" class="table_td">Số lượng</td>
          <td width="20%" class="table_td">Tổng cộng</td>
        </tr>';
		
			$note_mail .= $str_;
			
			$note_mail .= ' <tr>
          <td width="50%" class="table_td_white" colspan="4"><b>Tổng cộng giỏ hàng</b></td>
          <td width="50%" class="table_td_white" ><b>'.number_format($price_tottal, 0, ',', '.').' VNĐ</b> </td>
        </tr>
      </tbody>
    </table>
    <div class="title_02">Thông Tin Người Mua&nbsp;</div>
    <div class="contact_left"> Họ và tên (*): <br>
      Email (*):<br>
      Địa chỉ:<br>
      Số điện thoại (*):<br>
    </div>
    <form method="post" id="userForm" name="form_application">
      <div class="contact_right"> '.$_REQUEST['hoten'].'<br>
        '.$_REQUEST['email'].'<br>
        '.$_REQUEST['diachi'].'<br>
        '.$_REQUEST['sdt'].'<br>
        <br>
      </div>
    </form>
  </div>
</div></div>
</div>';
			
			
			
			echo $note_mail;		
		
		
       }
	   
	   
	   /*
	   function sendMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null )
		We should take a look at each parameter that this function accepts and explain a little further.
		
		$from: This is the the email address that the email will look like it is coming from.
		$fromname: This is the name of the person or organization this email is coming from.
		$recipient: This is the email address (or array of email addresses) that the email will be going to.
		$subject: This is the Subject of the email.
		$body: The is the message body of the email.
		$mode: Set this to 1 for HTML email, set it to 0 for text email. This field is optional.
		$cc: This is the email address (or array of email addresses) that the email will be Carbon Copied to. This field is optional.
		$bcc: This is the email address (or array of email addresses) that the email will be Blind Carbon Copied to. This field is optional.
		$attachment: This is the full path and filename (or array of full paths and filenames) of the files that you wish to attach to the email. This field is optional.
		$replyto: This is the the email address that the email will go to if the recipient clicks reply. This field is optional.
		$replytoname: This is the name of the person or organization this email will go to if the recipient clicks reply. This field is optional.
	   */
	   function gui_mail($from, $fromname, $recipient_array, $subject, $body, $mode=0, $cc_array=null, $bcc_array=null, $attachment_array=null, $replyto=null, $replytoname=null )
	   {
	   		
			//$recipient[] = 'huulong2003@yahoo.com';
			//$recipient[] = 'jane@somewhere.com';
		
			//$cc = 'bob@somewhereelse.com';
			//$bcc[] = 'simon@somewhereelse.com';
			//$bcc[] = 'nick@somewhereelse.com';
			
			$recipient_str = split(";", $recipient_array);
			foreach ($recipient_str as $i => $value) {				
					if($recipient_str[$i]!='')
						$recipient[] = $recipient_str[$i];
			}
			
			
			$cc_str = split(";", $cc_array);
			foreach ($cc_str as $i => $value) {	
				if($cc_str[$i]!='')				
					$cc[] = $cc_str[$i];
			}
			
			
			$bcc_str = split(";", $bcc_array);
			foreach ($bcc_str as $i => $value) {
				if($bcc_str[$i]!='')						
					$bcc[] = $bcc_str[$i];
			}
			
						
			foreach ($attachment_array as $i => $value) {	
				if($attachment_array[$i]!='')				
					$attachment[] = $attachment_array[$i];
			}
			
			//$attachment[] = JPATH_SITE.DS."images".DS."stories".DS."file_attach".DS.$file_attach1;
			//$attachment[] = '/home/my_site/public_html/images/stories/food/milk.jpg';
		

			JUtility::sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname);
	   
	   }
	   
	   function form_HTML($file_attach1_link='',$file_attach2_link='')
	   {
	   		if($_POST['CoverLetter']=='Upload a letter')
			{
				$CoverLetter = 'Customer attachted file: '.$file_attach1_link;
				
			}elseif($_POST['CoverLetter']=="I will write one now")
			{				
				$CoverLetter = $_POST['messages'];	
				
			}elseif($_POST['CoverLetter']=='No cover letter')
			{
				$CoverLetter = $_POST['CoverLetter'];
			}
			
			
			if($_POST['resumes']=='Upload a resume')
			{
				$resumes = 'Customer attachted file: '.$file_attach2_link;
				
			}elseif($_POST['resumes']=='No resume')
			{
				$resumes = $_POST['resumes'];
			}
			
			
			
			$aaa = 'Bạn nhận được thư đặt hàng từ khách hàng:<p></p>';
	   		$aaa .= '<label for="contact_name">Họ &amp; Tên</label><br>'.$_REQUEST['fullname'].'<br><br><label for="contact_name">Địa chỉ</label><br>'.$_REQUEST['address'].'<br><br><label for="contact_name">Điện thoại</label><br>'.$_REQUEST['phone'].'<br><br><label for="contact_mail">Email</label><br>'.$_REQUEST['email'].'<br><br><label for="contact_mail">Tên sản phẩm</label><br>'.$_REQUEST['tourname'].'<br><br><label for="contact_text">Nội dung liên hệ</label><br>'.$_REQUEST['request'].'<br>';
			
			return $aaa;
			//return 'xxx';
	   }
	   
	   
	   
	   
	   
	   function form_HTML_Hotel($file_attach1_link='',$file_attach2_link='')
	   {
	   		if($_POST['CoverLetter']=='Upload a letter')
			{
				$CoverLetter = 'Customer attachted file: '.$file_attach1_link;
				
			}elseif($_POST['CoverLetter']=="I will write one now")
			{				
				$CoverLetter = $_POST['messages'];	
				
			}elseif($_POST['CoverLetter']=='No cover letter')
			{
				$CoverLetter = $_POST['CoverLetter'];
			}
			
			
			if($_POST['resumes']=='Upload a resume')
			{
				$resumes = 'Customer attachted file: '.$file_attach2_link;
				
			}elseif($_POST['resumes']=='No resume')
			{
				$resumes = $_POST['resumes'];
			}
			
			
			$curLanguage = JFactory::getLanguage();
			global $lang_current;
			
			if($curLanguage->getTag()=='vi-VN')
			{
				$aaa = JText::_('TITLE_CUSTOMER_BOOKED_ROOM_EMAIL');
				$aaa .= '<table class="tbl_booktour" border="0" width="480px" style="font-family:tahoma;font-size:13px;color:#202425;"><tbody>  <tr>    <td colspan="2" class="title_booktour" style="color:#1c86de;font-weight:bold;">'.JText::_('YOURINFORMATION').'</td>  </tr>  <tr>    <td width="150">'.JText::_('GENDER').' </td>    <td>'.$_REQUEST["gender"].'</td>  </tr>  <tr>    <td width="150">'.JText::_('FIRSTNAME').' </td>    <td>'.$_REQUEST["firstname"].'</td>  </tr>    <tr>    <td>'.JText::_('EMAIL').' </td>    <td>'.$_REQUEST["email"].'</td>  </tr>  <tr>    <td>'.JText::_('PHONE').' </td>    <td>'.$_REQUEST["phone"].'</td>  </tr>  <tr>    <td>'.JText::_('ADDRESS').' </td>    <td>'.$_REQUEST["address"].'</td>  </tr>  <tr>    <td>'.JText::_('COUNTRY').' </td>    <td> '.$_REQUEST["country"].' </td>  </tr>  <tr>    <td colspan="2" class="title_booktour">'.JText::_('YOURSERVICE').'</td>  </tr>  <tr>    <td valign="top">'.JText::_('HOTELNAME').'</td>    <td><span class="name_tour" style="color:#0773e0;">'.$_REQUEST["hotelname"].'</span></td>  </tr>  <tr>    <td width="150">'.JText::_('KINDROOM').' </td>    <td>'.$_REQUEST["kindroom"].'</td>  </tr>  <tr>    <td>'.JText::_('NUMBERROOM').'</td>    <td>'.$_REQUEST["numroom"].'</td>  </tr>  <tr>    <td>'.JText::_('NUMBERCUSTOMER').' </td>    <td>'.$_REQUEST["numcustom"].'</td>  </tr>    <tr>  <td colspan="2" class="title_booktour">'.JText::_('CHOOSEDATE').'</td></tr>  <tr>    <td>'.JText::_('STARTDAY').' </td>    <td>'.$_REQUEST["starday"].' </td>  </tr>  <tr>    <td>'.JText::_('ENDDAY').' </td>    <td>'.$_REQUEST["endday"].' </td>  </tr>  <tr>    <td valign="top">'.JText::_('REQUEST').'</td>    <td>'.$_REQUEST["request"].'</td>  </tr> </tbody></table>';
			}
			else
			{
				$aaa = JText::_('TITLE_CUSTOMER_BOOKED_ROOM_EMAIL');
				$aaa .= '<table class="tbl_booktour" border="0" width="480px" style="font-family:tahoma;font-size:13px;color:#202425;"><tbody>  <tr><td colspan="2" class="title_booktour" style="color:#1c86de;font-weight:bold;">'.JText::_('YOURINFORMATION').'</td>  </tr>  <tr><td width="150">'.JText::_('GENDER').' </td><td>'.$_REQUEST["gender"].'</td>  </tr>  <tr><td width="150">'.JText::_('FIRSTNAME').' </td><td>'.$_REQUEST["firstname"].'</td>  </tr>  <tr><td width="150">'.JText::_('LASTNAME').' </td><td>'.$_REQUEST["lastname"].'</td>  </tr>  <tr><td>'.JText::_('EMAIL').' </td><td>'.$_REQUEST["email"].'</td>  </tr>  <tr><td>'.JText::_('PHONE').' </td><td>'.$_REQUEST["phone"].'</td>  </tr>  <tr><td>'.JText::_('ADDRESS').' </td><td>'.$_REQUEST["address"].'</td>  </tr><tr><td>'.JText::_('CITY').' </td><td>'.$_REQUEST["city"].'</td>  </tr><tr><td>'.JText::_('STATE').' </td><td>'.$_REQUEST["state"].'</td>  </tr><tr><td>'.JText::_('COUNTRY').' </td><td> '.$_REQUEST["country"].' </td>  </tr>  <tr><td colspan="2" class="title_booktour">'.JText::_('YOURSERVICE').'</td>  </tr>  <tr><td valign="top">'.JText::_('HOTELNAME').'</td><td><span class="name_tour" style="color:#0773e0;">'.$_REQUEST["hotelname"].'</span></td>  </tr>  <tr><td width="150">'.JText::_('KINDROOM').' </td><td>'.$_REQUEST["kindroom"].'</td>  </tr>  <tr><td>'.JText::_('NUMBERROOM').'</td><td>'.$_REQUEST["numroom"].'</td>  </tr>  <tr><td>'.JText::_('NUMBERCUSTOMER').' </td><td>'.$_REQUEST["numcustom"].'</td>  </tr><tr>  <td colspan="2" class="title_booktour">'.JText::_('CHOOSEDATE').'</td></tr>  <tr><td>'.JText::_('STARTDAY').' </td><td>'.$_REQUEST["starday"].' </td>  </tr>  <tr><td>'.JText::_('ENDDAY').' </td><td>'.$_REQUEST["endday"].' </td>  </tr>  <tr><td valign="top">'.JText::_('REQUEST').'</td><td>'.$_REQUEST["request"].'</td>  </tr>   <tr><td valign="top">'.JText::_('SMOKE_CHOICE').'</td><td>'.$_REQUEST["smoke"].'</td>  </tr></tbody></table>';
			}
			
			
			return $aaa;
			//return 'xxx';
	   }
	   
	   
	   
	   
	   
	   
	   function form_HTML1($file_attach1_link='',$file_attach2_link='')
	   {
	   		if($_POST['CoverLetter']=='Upload a letter')
			{
				$CoverLetter = 'You attachted file: '.$file_attach1_link;
				
			}elseif($_POST['CoverLetter']=="I will write one now")
			{				
				$CoverLetter = $_POST['messages'];	
				
			}elseif($_POST['CoverLetter']=='No cover letter')
			{
				$CoverLetter = $_POST['CoverLetter'];
			}
			
			
			if($_POST['resumes']=='Upload a resume')
			{
				$resumes = 'You attachted file: '.$file_attach2_link;
				
			}elseif($_POST['resumes']=='No resume')
			{
				$resumes = $_POST['resumes'];
			}
			
			$aaa = 'Bạn đã gửi mail để liên hệ giá đến website hoachatdailongbinh.com. Đây là nội dung:<p></p>';

	   		$aaa .= '<label for="contact_name">Họ &amp; Tên</label><br>'.$_REQUEST['fullname'].'<br><br><label for="contact_name">Địa chỉ</label><br>'.$_REQUEST['address'].'<br><br><label for="contact_name">Điện thoại</label><br>'.$_REQUEST['phone'].'<br><br><label for="contact_mail">Email</label><br>'.$_REQUEST['email'].'<br><br><label for="contact_mail">Tên sản phẩm</label><br>'.$_REQUEST['tourname'].'<br><br><label for="contact_text">Nội dung liên hệ</label><br>'.$_REQUEST['request'].'<br>';
			
			return $aaa;
			//return 'xxx';
	   }
	   
	   
	    function form_HTML1_Hotel($file_attach1_link='',$file_attach2_link='')
	   {
	   		if($_POST['CoverLetter']=='Upload a letter')
			{
				$CoverLetter = 'You attachted file: '.$file_attach1_link;
				
			}elseif($_POST['CoverLetter']=="I will write one now")
			{				
				$CoverLetter = $_POST['messages'];	
				
			}elseif($_POST['CoverLetter']=='No cover letter')
			{
				$CoverLetter = $_POST['CoverLetter'];
			}
			
			
			if($_POST['resumes']=='Upload a resume')
			{
				$resumes = 'You attachted file: '.$file_attach2_link;
				
			}elseif($_POST['resumes']=='No resume')
			{
				$resumes = $_POST['resumes'];
			}
			
						
			
			$curLanguage = JFactory::getLanguage();
			global $lang_current;
			
			if($curLanguage->getTag()=='vi-VN')
			{
				$aaa = JText::_('TITLE_YOU_BOOKED_ROOM_EMAIL');
				$aaa .= '<table class="tbl_booktour" border="0" width="480px" style="font-family:tahoma;font-size:13px;color:#202425;"><tbody>  <tr>    <td colspan="2" class="title_booktour" style="color:#1c86de;font-weight:bold;">'.JText::_('YOURINFORMATION').'</td>  </tr>  <tr>    <td width="150">'.JText::_('GENDER').' </td>    <td>'.$_REQUEST["gender"].'</td>  </tr>  <tr>    <td width="150">'.JText::_('FIRSTNAME').' </td>    <td>'.$_REQUEST["firstname"].'</td>  </tr>    <tr>    <td>'.JText::_('EMAIL').' </td>    <td>'.$_REQUEST["email"].'</td>  </tr>  <tr>    <td>'.JText::_('PHONE').' </td>    <td>'.$_REQUEST["phone"].'</td>  </tr>  <tr>    <td>'.JText::_('ADDRESS').' </td>    <td>'.$_REQUEST["address"].'</td>  </tr>  <tr>    <td>'.JText::_('COUNTRY').' </td>    <td> '.$_REQUEST["country"].' </td>  </tr>  <tr>    <td colspan="2" class="title_booktour">'.JText::_('YOURSERVICE').'</td>  </tr>  <tr>    <td valign="top">'.JText::_('HOTELNAME').'</td>    <td><span class="name_tour" style="color:#0773e0;">'.$_REQUEST["hotelname"].'</span></td>  </tr>  <tr>    <td width="150">'.JText::_('KINDROOM').' </td>    <td>'.$_REQUEST["kindroom"].'</td>  </tr>  <tr>    <td>'.JText::_('NUMBERROOM').'</td>    <td>'.$_REQUEST["numroom"].'</td>  </tr>  <tr>    <td>'.JText::_('NUMBERCUSTOMER').' </td>    <td>'.$_REQUEST["numcustom"].'</td>  </tr>    <tr>  <td colspan="2" class="title_booktour">'.JText::_('CHOOSEDATE').'</td></tr>  <tr>    <td>'.JText::_('STARTDAY').' </td>    <td>'.$_REQUEST["starday"].' </td>  </tr>  <tr>    <td>'.JText::_('ENDDAY').' </td>    <td>'.$_REQUEST["endday"].' </td>  </tr>  <tr>    <td valign="top">'.JText::_('REQUEST').'</td>    <td>'.$_REQUEST["request"].'</td>  </tr> </tbody></table>';
			}
			else
			{
				$aaa = JText::_('TITLE_YOU_BOOKED_ROOM_EMAIL');
				$aaa .= '<table class="tbl_booktour" border="0" width="480px" style="font-family:tahoma;font-size:13px;color:#202425;"><tbody>  <tr><td colspan="2" class="title_booktour" style="color:#1c86de;font-weight:bold;">'.JText::_('YOURINFORMATION').'</td>  </tr>  <tr><td width="150">'.JText::_('GENDER').' </td><td>'.$_REQUEST["gender"].'</td>  </tr>  <tr><td width="150">'.JText::_('FIRSTNAME').' </td><td>'.$_REQUEST["firstname"].'</td>  </tr>  <tr><td width="150">'.JText::_('LASTNAME').' </td><td>'.$_REQUEST["lastname"].'</td>  </tr>  <tr><td>'.JText::_('EMAIL').' </td><td>'.$_REQUEST["email"].'</td>  </tr>  <tr><td>'.JText::_('PHONE').' </td><td>'.$_REQUEST["phone"].'</td>  </tr>  <tr><td>'.JText::_('ADDRESS').' </td><td>'.$_REQUEST["address"].'</td>  </tr><tr><td>'.JText::_('CITY').' </td><td>'.$_REQUEST["city"].'</td>  </tr><tr><td>'.JText::_('STATE').' </td><td>'.$_REQUEST["state"].'</td>  </tr><tr><td>'.JText::_('COUNTRY').' </td><td> '.$_REQUEST["country"].' </td>  </tr>  <tr><td colspan="2" class="title_booktour">'.JText::_('YOURSERVICE').'</td>  </tr>  <tr><td valign="top">'.JText::_('HOTELNAME').'</td><td><span class="name_tour" style="color:#0773e0;">'.$_REQUEST["hotelname"].'</span></td>  </tr>  <tr><td width="150">'.JText::_('KINDROOM').' </td><td>'.$_REQUEST["kindroom"].'</td>  </tr>  <tr><td>'.JText::_('NUMBERROOM').'</td><td>'.$_REQUEST["numroom"].'</td>  </tr>  <tr><td>'.JText::_('NUMBERCUSTOMER').' </td><td>'.$_REQUEST["numcustom"].'</td>  </tr><tr>  <td colspan="2" class="title_booktour">'.JText::_('CHOOSEDATE').'</td></tr>  <tr><td>'.JText::_('STARTDAY').' </td><td>'.$_REQUEST["starday"].' </td>  </tr>  <tr><td>'.JText::_('ENDDAY').' </td><td>'.$_REQUEST["endday"].' </td>  </tr>  <tr><td valign="top">'.JText::_('REQUEST').'</td><td>'.$_REQUEST["request"].'</td>  </tr>   <tr><td valign="top">'.JText::_('SMOKE_CHOICE').'</td><td>'.$_REQUEST["smoke"].'</td>  </tr> </tbody></table>';
			}
			
			return $aaa;
			//return 'xxx';
	   }
}
?>