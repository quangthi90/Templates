<?php 
/* Section full block style
******************************/
if (isset($setting['fullB']) && $setting['fullB'] == 'y') {
	
	$this->data['fullB_class'] = isset($setting['fullB_class']) && $setting['fullB_class'] != '' ? ' '.$setting['fullB_class'] : null;

	$setting['fullB_bgps1'] = isset($setting['fullB_bgps1']) ? $setting['fullB_bgps1'] : null;
	$setting['fullB_bgps2'] = isset($setting['fullB_bgps2']) ? $setting['fullB_bgps2'] : null;
	
	if (isset($setting['fullB_bgposition']) && $setting['fullB_bgposition'] != "other" && $setting['fullB_bgimg'] != '') {
		$bgPosition = $setting['fullB_bgposition'] != '' ? 'background-position: '.$setting['fullB_bgposition'].';' : 'background-position: left top;';
	}else{
		$bgPosition = $setting['fullB_bgposition'] == 'other' ? 'background-position: '.$setting['fullB_bgps1'].' '.$setting['fullB_bgps2'].';' : 'background-position: left top;';
	}

	$this->data['fullB_settings'] = isset($setting['fullB_bgcolor']) && $setting['fullB_bgcolor'] != '' ? 'background-color: '.$setting['fullB_bgcolor'].';' : null;
	$this->data['fullB_settings'] .= isset($setting['fullB_bgimg']) && $setting['fullB_bgimg'] != '' ? 'background-image: url(image/'.$setting['fullB_bgimg'].');' : null;
	$this->data['fullB_settings'] .= isset($setting['fullB_bgrepeat']) && $setting['fullB_bgimg'] != '' && $setting['fullB_bgrepeat'] != '' ? 'background-repeat: '.$setting['fullB_bgrepeat'].';' : 'background-repeat: repeat;';
	$this->data['fullB_settings'] .= $bgPosition;
	$this->data['fullB_settings'] .= isset($setting['fullB_bgAttachment']) && $setting['fullB_bgimg'] != '' && $setting['fullB_bgAttachment'] != '' ? 'background-attachment: '.$setting['fullB_bgAttachment'].';' : 'background-attachment: inherit;';
}
?>