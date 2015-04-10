<?php echo $header; ?>
<?php if(($settings['step']['login']['option']['guest']['display']) && ($facebook_enable || $google_enable) ){ 
    $login_boxes_width=31.1;
}else{
    $login_boxes_width=47.7;
}
?>
<style>
    
.supercheckout_top_boxes{width:<?php echo $login_boxes_width; ?>%;}
.supercheckout_login_option_box{
    background-color:rgba(7, 8, 5, 0.02) !important
}
</style>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $default_theme; ?>/stylesheet/supercheckout-light.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $default_theme; ?>/stylesheet/supercheckout/theme/scripts/plugins/notifications/notyfy/jquery.notyfy.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $default_theme; ?>/stylesheet/supercheckout/theme/scripts/plugins/notifications/notyfy/themes/default.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $default_theme; ?>/stylesheet/supercheckout/theme/scripts/plugins/notifications/Gritter/css/jquery.gritter.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $default_theme; ?>/stylesheet/supercheckout/colorbox.css" />

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
      <div id="fb-root"></div>
        <?php if(isset($settings['step']['html_value']['value']['header']) && $settings['step']['html_value']['value']['header']!=""){ ?>
            <div id="supercheckout_html_content_header">        
                <?php echo  html_entity_decode( $settings['step']['html_value']['value']['header']); ?>
            </div>
        <?php } ?>
        <fieldset class="group-select" id="supercheckout-fieldset">
            <div class="supercheckout-threecolumns supercheckout-container supercheckout-skin-generic " id="supercheckout-columnleft">
                <?php 
                $layout_name='one-column';
                $multiplier=1;                
                ?>
                <div class="supercheckout-column-left columnleftsort" id="columnleft-1" style="width:<?php $i= $settings['general']['column_width'][$layout_name][1]*$multiplier; echo $i; ?>%"> 
                    <div  class="supercheckout-blocks" data-column="<?php echo $sort_block['login'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['login'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['login'][$layout_name]['column-inside']; ?>"  >
                        <ul class="headingCheckout">
                            <li>
                                <p class="supercheckout-numbers supercheckout-numbers-1"><?php if(!$logged){ echo $text_login_option;}else{echo 'Welcome '.$firstName. ' '.$lastName;} ?></p>

                            </li>
                        </ul>
                        <div id="checkoutLogin">
                            <div class="supercheckout-checkout-content">

                            </div>
                            <?php if(!$logged){  ?>
                            <div class="supercheckout-extra-wrap">
                                <b><?php echo $entry_email; ?><span class="supercheckout-required">*</span></b><br />
                                <input type="text" id="email" name="email" value="" class="supercheckout-large-field" />
                                <br/>
                            </div>    
                            <div id="loginDetails" style="display:<?php if($settings['step']['login']['option']['guest']['display'] ){ echo 'block'; }else{ echo 'none';} ?>;">
                                
                                <div class="supercheckout-extra-wrap">
                                    <label for="guest">
                                        <?php if ($account == 'guest') { ?>
                                        <input type="radio" name="account" value="guest" id="guest" checked="checked" />
                                        <?php } else { ?>
                                        <input type="radio" name="account" value="guest" id="guest" />
                                        <?php } ?>
                                        <b><?php echo $text_guest; ?></b></label>
                                    <br />
                                </div>
                                
                                <div class="supercheckout-extra-wrap">
                                    <label for="register">
                                        <?php if ($account == 'register') { ?>
                                        <input type="radio" name="account" value="register" id="register" checked="checked" />
                                        <?php } else { ?>
                                        <input type="radio" name="account" value="register" id="register" />
                                        <?php } ?>
                                        <b><?php echo $text_register; ?></b></label>
                                    <br />
                                </div>  
                                <?php if($settings['general']['guest_manual']){ ?>
                                <div class="supercheckout-extra-wrap">
                                    <label for="register_manual">
                                        <?php if ($account == 'register_manual') { ?>
                                        <input type="radio" name="account" value="register_manual" id="register_manual" checked="checked" />
                                        <?php } else { ?>
                                        <input type="radio" name="account" value="register_manual" id="register_manual" />
                                        <?php } ?>
                                        <b><?php echo $text_register_manual; ?></b></label>
                                    <br />
                                </div>  
                                <?php } ?>
                            </div>
                            <div id="supercheckout-login">
                                <div class="supercheckout-extra-wrap">
                                    <b><?php echo $entry_password; ?><span class="supercheckout-required">*</span></b><br />
                                    <input type="password" id="password" name="password" value="" class="supercheckout-large-field" />
                                    <br />
                                    <div id="forgotpasswordlink"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
                                    <br />
                                    <input type="button" value="<?php echo $button_login; ?>" id="button-login" class="orangebuttonsmall" /><br />
                                </div>                        
                            </div> 
                            <div id="supercheckout-login-register-manual">
                                <div class="supercheckout-extra-wrap supercheckout_password_fields">
                                    <span class="supercheckout-login-label supercheckout_password_fields"><b><?php echo $entry_password; ?><span class="supercheckout-required">*</span></b></span><br/>
                                    <span class="supercheckout-login-value"><input type="password" id="password" name="password_register" value="" class="supercheckout-large-field " /></span>
                                </div>

                                <div class="supercheckout-extra-wrap supercheckout_password_fields" style="/*float:left;*/">
                                        <span class="supercheckout-login-label"><b><?php echo $entry_confirm; ?><span class="supercheckout-required">*</span></b></span><br/>
                                        <span class="supercheckout-login-value"><input type="password" id="confirm_password" name="confirm_password" value="" class="supercheckout-large-field " /></span>
                                </div> 
                                <div class="supercheckout-clear"></div>
                            </div> 
                            <?php if($facebook_enable || $google_enable) {   ?>
                            <div class="orSeparator"><span><?php echo $text_OR_separator; ?></span></div>
                            <h3><?php echo $text_sign_in_with; ?></h3>
                            <div class="socialNetwork">
                                <?php if($facebook_enable){ ?>
                                <div class="fbButton" id="fb-auth" ></div>
                                <?php }if($google_enable){ ?>
                                <div class="googleButton" onclick="window.open('<?php echo $url; ?>', 'name','resizable=1,scrollbars=no,width=500,height=400')"></div>
                                <?php } ?>
                                <div class="supercheckout-clear"></div>
                            </div>
                            <?php } ?>
                            <?php }else{ ?>
                            <div class="myaccount">
                                <ol class="rectangle-list">                            
                                    <li>
                                        <a href="<?php echo $myAccount; ?>"><?php echo $text_my_account; ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $logoutLink; ?>"><?php echo $text_logout; ?></a>
                                    </li>
                                    <div class="supercheckout-clear"></div>

                                </ol>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div  class="supercheckout-blocks"  data-column="<?php echo $sort_block['payment_address'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['payment_address'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['payment_address'][$layout_name]['column-inside']; ?>">
                        <ul>
                            <li>
                                <p class="supercheckout-numbers supercheckout-numbers-2"><?php echo $text_billing_address; ?></p>
                            </li>
                        </ul>
                        <div id="checkoutBillingAddress">
                            <?php if ($addresses) { ?>
                                <div class="supercheckout-checkout-content">
                                </div>
                                <div class="supercheckout-extra-wrap">
                                    <input type="radio" name="payment_address" value="existing" id="payment-address-existing" checked="checked" />
                                    <label for="payment-address-existing"><?php echo $text_address_existing; ?></label>
                                </div>    
                                <div id="payment-existing">
                                    <select name="address_id" style="width: 92%; margin-bottom: 15px;">
                                        <?php foreach ($addresses as $address) { ?>
                                        <?php if ($address['address_id'] == $address_id) { ?>
                                        <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="supercheckout-extra-wrap">
                                    <p>
                                        <input type="radio" name="payment_address" value="new" id="payment-address-new" />
                                        <label for="payment-address-new"><?php echo $text_address_new; ?></label>
                                    </p>
                                </div>
                            <?php } ?>
                            <div id="payment-new" style="display: <?php echo ($addresses ? 'none' : 'block'); ?>;">
                                <table id="payment_address_table" class="supercheckout-form">
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['firstname']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['firstname']['display']){ echo'block';}else{ echo'none';}} ?>;"  data-percentage="<?php echo $payment_address_sort_order['fields']['firstname']['sort_order'] ?>" >
                                        <td> <?php echo $entry_firstname; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['firstname']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['firstname']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                            <input type="text" name="firstname" value="<?php if(isset($order_details['payment_firstname'])){ echo $order_details['payment_firstname']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['lastname']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['lastname']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['lastname']['sort_order'] ?>">
                                        <td> <?php echo $entry_lastname; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['lastname']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['lastname']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="lastname" value="<?php if(isset($order_details['payment_lastname'])){ echo $order_details['payment_lastname']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['telephone']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['telephone']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['telephone']['sort_order'] ?>">
                                        <td> <?php echo $entry_telephone; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['telephone']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['telephone']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="telephone" value="<?php if(isset($order_details['telephone'])){ echo $order_details['telephone']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['company']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['company']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['company']['sort_order'] ?>" >
                                        <td><?php echo $entry_company; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['company']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['company']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="company" value="<?php if(isset($order_details['payment_company'])){ echo $order_details['payment_company']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['company_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['company_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['company_id']['sort_order'] ?>" >
                                        <td><?php echo $entry_company_id; ?><span class="supercheckout-required" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['company_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['company_id']['require']){ echo'inline';}else{ echo'none';}} ?>;">*</span>
                                        <input type="text" name="company_id" value="" class="supercheckout-large-field" /></td>
                                    </tr>                            
                                    
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['tax_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['tax_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['tax_id']['sort_order'] ?>" >
                                        <td><?php echo $entry_tax_id; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['tax_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['tax_id']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                            
                                            <input type="text" name="tax_id" value="<?php if(isset($order_details['payment_firstname'])){ echo $order_details['payment_firstname']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['address_1']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['address_1']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['address_1']['sort_order'] ?>" >
                                        <td> <?php echo $entry_address_1; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['address_1']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['address_1']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="address_1" value="<?php if(isset($order_details['payment_address_1'])){ echo $order_details['payment_address_1']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['address_2']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['address_2']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['address_2']['sort_order'] ?>" >
                                        <td><?php echo $entry_address_2; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['address_2']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['address_2']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="address_2" value="<?php if(isset($order_details['payment_address_2'])){ echo $order_details['payment_address_2']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['city']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['city']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['city']['sort_order'] ?>" >
                                        <td><?php echo $entry_city; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['city']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['city']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="city" value="<?php if(isset($order_details['payment_city'])){ echo $order_details['payment_city']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['postcode']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['postcode']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['postcode']['sort_order'] ?>" >
                                        <td><?php echo $entry_postcode; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['postcode']['require'] && $country_info_guest['postcode_required']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['postcode']['require'] && $country_info_guest['postcode_required']){ echo'inline';}else{ echo'none';}} ?>;" id="payment-postcode-required" class="supercheckout-required">*</span>
                                        <input type="text" name="postcode" value="" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['country_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['country_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['country_id']['sort_order'] ?>" >
                                        <td> <?php echo $entry_country; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['country_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['country_id']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <select name="country_id" class="supercheckout-large-field">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php foreach ($countries as $country) { ?>                                        
                                                <?php if (($country['country_id'] == $country_id)) { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['zone_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['zone_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $payment_address_sort_order['fields']['zone_id']['sort_order'] ?>" >
                                        <td> <?php echo $entry_zone; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['payment_address']['fields']['zone_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['payment_address']['fields']['zone_id']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <select name="zone_id" class="supercheckout-large-field">
                                                <?php echo $zones_default; ?>
                                            </select></td>
                                    </tr>
                                    
                                </table>
                            </div>
                            <ul>
                                <li>
                                    <div class="input-box input-different-shipping" style="display:<?php if(!$logged){  if($settings['option']['guest']['payment_address']['fields']['shipping']['display']){echo 'block';}else{echo 'none';}}?>;">
                                        <input name="use_for_shipping" id="shipping_use"  checked="checked" type="checkbox">
                                        <label for="shipping_use"><b><?php echo $text_ship_same_address; ?></b></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <br/>
                    </div>      
                    <div class="supercheckout-blocks" data-column="<?php echo $sort_block['shipping_address'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['shipping_address'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['shipping_address'][$layout_name]['column-inside']; ?>">
                        <div id="checkoutShippingAddress">
                            <div class="supercheckout-checkout-content">
                            </div>                
                            <ul>
                                <li>
                                    <p class="supercheckout-numbers supercheckout-numbers-ship"><?php echo $text_shipping_address; ?></p>
                                </li>
                            </ul>
                            <?php if ($addresses) { ?>
                            <div class="supercheckout-extra-wrap">
                                <input type="radio" name="shipping_address" value="existing" id="shipping-address-existing" checked="checked" />
                                <label for="shipping-address-existing"><?php echo $text_address_existing; ?></label>
                            </div>
                            <div id="shipping-existing" class="styled-select">
                                <select name="address_id" style="width: 92%; margin-bottom: 15px;">
                                    <?php foreach ($addresses as $address) { ?>
                                    <?php if ($address['address_id'] == $address_id) { ?>
                                    <option value="<?php echo $address['address_id']; ?>" selected="selected"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname']; ?> <?php echo $address['lastname']; ?>, <?php echo $address['address_1']; ?>, <?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="supercheckout-extra-wrap">
                                <p>
                                    <input type="radio" name="shipping_address" value="new" id="shipping-address-new" />
                                    <label for="shipping-address-new"><?php echo $text_address_new; ?></label>
                                </p>
                            </div>
                            <?php } ?>
                            <div id="shipping-new"style="display: <?php echo ($addresses ? 'none' : 'block'); ?>;">
                                <table class="supercheckout-form" id="shipping_address_table">
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['firstname']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['firstname']['display']){ echo'block';}else{ echo'none';}} ?>;"   data-percentage="<?php echo $shipping_address_sort_order['fields']['firstname']['sort_order'] ?>" >
                                        <td> <?php echo $entry_firstname; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['firstname']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['firstname']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="firstname" value="<?php if(isset($order_details['shipping_firstname'])){ echo $order_details['shipping_firstname']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['lastname']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['lastname']['display']){ echo'block';}else{ echo'none';}} ?>;"  data-percentage="<?php echo $shipping_address_sort_order['fields']['lastname']['sort_order'] ?>">
                                        <td> <?php echo $entry_lastname; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['lastname']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['lastname']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="lastname" value="<?php if(isset($order_details['shipping_lastname'])){ echo $order_details['shipping_lastname']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>                           
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['address_1']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['address_1']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $shipping_address_sort_order['fields']['address_1']['sort_order'] ?>">
                                        <td><?php echo $entry_address_1; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['address_1']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['address_1']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span> 
                                        <input type="text" name="address_1" value="<?php if(isset($order_details['shipping_address_1'])){ echo $order_details['shipping_address_1']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['address_2']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['address_2']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $shipping_address_sort_order['fields']['address_2']['sort_order'] ?>">
                                        <td><?php echo $entry_address_2; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['address_2']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['address_2']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="address_2" value="<?php if(isset($order_details['shipping_address_2'])){ echo $order_details['shipping_address_2']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['city']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['city']['display']){ echo'block';}else{ echo'none';}} ?>;"  data-percentage="<?php echo $shipping_address_sort_order['fields']['city']['sort_order'] ?>">
                                        <td><?php echo $entry_city; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['city']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['city']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <input type="text" name="city" value="<?php if(isset($order_details['shipping_city'])){ echo $order_details['shipping_city']; } ?>" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['postcode']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['postcode']['display']){ echo'block';}else{ echo'none';}} ?>;"  data-percentage="<?php echo $shipping_address_sort_order['fields']['postcode']['sort_order'] ?>">
                                        <td><?php echo $entry_postcode; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['postcode']['require']&& $country_info_guest['postcode_required']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['postcode']['require']&& $country_info_guest['postcode_required']){ echo'inline';}else{ echo'none';}} ?>;" id="shipping-postcode-required" class="supercheckout-required">*</span>
                                        <input type="text" name="postcode" value="" class="supercheckout-large-field" /></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['country_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['country_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $shipping_address_sort_order['fields']['country_id']['sort_order'] ?>">
                                        <td><?php echo $entry_country; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['country_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['country_id']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <select name="country_id" class="supercheckout-large-field">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php foreach ($countries as $country) { ?>
                                                <?php if (($country['country_id'] == $country_id)) { ?>
                                                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr class="sort_data" style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['zone_id']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['zone_id']['display']){ echo'block';}else{ echo'none';}} ?>;" data-percentage="<?php echo $shipping_address_sort_order['fields']['zone_id']['sort_order'] ?>">
                                        <td><?php echo $entry_zone; ?><span style="display:<?php if($logged){ if($settings['option']['logged']['shipping_address']['fields']['zone_id']['require']){ echo'inline';}else{ echo'none';} }else{ if($settings['option']['guest']['shipping_address']['fields']['zone_id']['require']){ echo'inline';}else{ echo'none';}} ?>;" class="supercheckout-required">*</span>
                                        <select name="zone_id" class="supercheckout-large-field">
                                                <?php echo $zones_default; ?>
                                            </select></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php if($settings['step']['shipping_method']['display_options']){ ?>
                    <div  class="supercheckout-blocks" data-column="<?php echo $sort_block['shipping_method'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['shipping_method'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['shipping_method'][$layout_name]['column-inside']; ?>" >
                        
                        <ul>
                            <li style="display:inline;">
                                <p class="supercheckout-numbers supercheckout-numbers-3"><?php echo $text_shipping_method; ?></p>
                                <div class="loader" id="shippingMethodLoader"></div>
                            </li>                
                        </ul>
                        
                                       
                        <div id="shipping-method">
                            <?php if(!$shipping_required){ ?>
                            <div class="supercheckout-checkout-content" style="display:block">
                                <div class="permanent-warning" style="display: block;">No shipping required with these product(s).<img src="catalog/view/theme/<?php echo $default_theme; ?>/image/close.png" alt="" class="close" /></div>
                            </div>
                        <?php } ?> 
                            <?php if($error_warning_shipping){ ?>
                            <div class="supercheckout-checkout-content" style="display:block">
                                <div class="warning" style="display: block;"><?php echo $error_warning_shipping; ?><img src="catalog/view/theme/<?php echo $default_theme; ?>/image/close.png" alt="" class="close" /></div>
                            </div>
                            <?php } ?>
                            <div class="supercheckout-checkout-content">

                            </div>
                            <?php if ($error_warning) { ?>
                            <div class="warning"><?php echo $error_warning; ?></div>
                            <?php } ?>
                            <?php if ($shipping_methods && $shipping_required) { ?>

                            <table class="radio">
                                <?php foreach ($shipping_methods as $shipping_method) { ?>
                                <?php if($settings['step']['shipping_method']['display_title']){ ?>
                                <tr>
                                    <td colspan="3"><b><?php echo $shipping_method['title']; ?></b></td>
                                </tr>
                                <?php } ?>
                                <?php if (!$shipping_method['error']) { ?>
                                <?php foreach ($shipping_method['quote'] as $quote) { ?>
                                <tr class="highlight">
                                    <td><?php if(!isset($shipping_code)){ $shipping_code = ''; }if(($quote['code'] == $shipping_code) || !(isset($shipping_code))) { ?>
                                        <?php $codeShipping = $quote['code']; ?>
                                        <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
                                        <?php } else { ?>
                                        <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
                                        <?php } ?></td>
                                    <td><label for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?></label></td>
                                    <td style="text-align: right;" class="price"><label for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?></label></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="3"><div class="error"><?php echo $shipping_method['error']; ?></div></td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </table>
                            <br />
                            <?php } ?>
                        </div>
                        
                    </div>
                    <?php } ?>
                    <?php if($settings['step']['payment_method']['display_options']){ ?>
                    <div  class="supercheckout-blocks" data-column="<?php echo $sort_block['payment_method'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['payment_method'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['payment_method'][$layout_name]['column-inside']; ?>">
                        <ul>
                            <li>
                                <p class="supercheckout-numbers supercheckout-numbers-4"><?php echo $text_payment_method; ?></p>
                                <div class="loader" id="paymentMethodLoader"></div>
                            </li>                
                        </ul>
                        
                        <div id="payment-method">
                            <div class="supercheckout-checkout-content">

                            </div>
                            <?php if ($error_warning) { ?>
                            <div class="warning"><?php echo $error_warning; ?></div>
                            <?php } ?>
                            <?php if ($payment_methods) { ?>                 
                            <table class="radio">
                                <?php foreach ($payment_methods as $payment_method) { ?>
                                <tr class="highlight">
                                    <td><?php if ($payment_method['code'] == $payment_code || !$payment_code) { ?>
                                        <?php $code = $payment_method['code']; ?>
                                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>"  checked="checked" />
                                        <?php } else { ?>
                                        <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>"  />
                                        <?php } ?></td>
                                    <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label></td>
                                </tr>
                                <?php } ?>
                            </table>                 
                            <?php } ?>
                        </div>                
                    </div>
                    <?php } ?>
                    <div class="supercheckout-blocks confirmCheckoutBack" data-column="<?php echo $sort_block['cart'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['cart'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['cart'][$layout_name]['column-inside']; ?>" style="display:<?php if($logged){ if($settings['option']['logged']['cart']['display']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['display']){ echo' ';}else{ echo'none';}} ?>;">
                        <ul>
                            <li>
                                <p class="supercheckout-numbers supercheckout-check"><?php echo $text_confirm_order; ?></p>
                                <div class="loader" id="confirmLoader"></div>
                            </li>
                        </ul>
                        <div id="confirmCheckout">
                            <div class="supercheckout-checkout-content">

                            </div>
                            <?php if (!isset($redirect)) { ?>
                            
                            <table class="supercheckout-summary">
                                <thead>
                                    <tr>
                                        
                                        <th style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['name']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['name']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-name"><?php echo $column_name; ?></th>
                                        <th style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['model']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['model']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-qty"><?php echo $column_model; ?></th>
                                        <th style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['quantity']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['quantity']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-qty"><?php echo $column_quantity; ?></th>
                                        <th style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['price']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['price']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-total" style="text-align:center;"><?php echo $column_price; ?></th>
                                        <th style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['total']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['total']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-total"><?php echo $column_total; ?></th>
                                        <th class="supercheckout-qty"><?php echo $column_action; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) { ?>
                                    <tr>
                                        <td style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['name']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['name']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-name">
                                            
                                            <div ><a <?php if($logged){ if($settings['option']['logged']['cart']['columns']['image']){ echo'data-toggle="popover"';}else{ echo'';} }else{ if($settings['option']['guest']['cart']['columns']['image']){ echo'data-toggle="popover"';}else{ echo'';}} ?> data-title="<?php echo $product['name']; ?>" data-content="<img src='<?php echo $product['thumb']; ?>' />" data-placement="right" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                            <?php foreach ($product['option'] as $option) { ?>
                                            <br />
                                            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                                            <?php } ?></div>
                                        </td>
                                        <td style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['model']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['model']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-qty"><?php echo $product['model']; ?></td>
                                        <td style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['quantity']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['quantity']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-qty">
                                            <input class="quantitybox" type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" ><br>
                                            <a href="javascript://" id="<?php echo $product['key']; ?>" onclick="updateQuantity(this.id);" ><small><?php echo $button_update_link; ?></small></a>
                                        </td>
                                        <td style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['price']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['price']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-total"><?php echo $product['price']; ?></td>
                                        <td style="display:<?php if($logged){ if($settings['option']['logged']['cart']['columns']['total']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['columns']['total']){ echo' ';}else{ echo'none';}} ?>;" class="supercheckout-total"><?php echo $product['total']; ?></td>
                                        <td class="supercheckout-qty"><a href="javascript://" id="<?php echo $product['key']; ?>" onclick="removeProduct(this.id);" class="removeProduct"><div id="<?php echo $product['key']; ?>"  title="Delete"></div></a></td>
                                    </tr>
                                    <?php } ?>
                                    <?php foreach ($vouchers as $voucher) { ?>
                                    <tr>
                                        <td class="supercheckout-name"><?php echo $voucher['description']; ?></td>
                                        <td class="supercheckout-qty">1</td>
                                        <td class="supercheckout-total"><?php echo $voucher['amount']; ?></td>
                                        <td class="supercheckout-total"><?php echo $voucher['amount']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>                    
                            </table>
                            <table class="supercheckout-totals">
                                <tbody>
                                        <?php foreach ($totals as $total) { ?>
                                    <tr>
                                        <td class="title"><b><?php echo $total['title']; if($total['code']=='voucher' || $total['code']=='coupon'){echo'<a href="javascript://" id="'.$total['code'].'"  onclick="redeem(this.id);" ><div title="'.$text_redeem.'" class="removeProduct"></div></a></td>';} ?></b></td>
                                        <td class="value"><span class="price"><?php echo $total['text']; ?></span> </td>                                
                                    </tr>
                                    <?php } ?>
                                    <tr style="display:<?php if($logged){ if($settings['option']['logged']['cart']['option']['coupon']['display']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['option']['coupon']['display']){ echo' ';}else{ echo'none';}} ?>;">
                                        <td class="title"><b><?php echo $text_coupon_code; ?></b></td>
                                        <td class="value"><input  id="coupon_code" name="coupon" type="text" class="voucherText">
                                            <input type="hidden" value="coupon" name="next">
                                            <input id="button-coupon" type="button" onClick="if(window.couponBlur==true){ callCoupon(); }" class="orangebuttonapply" value="<?php echo $button_apply; ?>">
                                        </td>
                                    </tr>
                                    <tr style="display:<?php if($logged){ if($settings['option']['logged']['cart']['option']['voucher']['display']){ echo' ';}else{ echo'none';} }else{ if($settings['option']['guest']['cart']['option']['voucher']['display']){ echo' ';}else{ echo'none';}} ?>;">
                                        <td class="title"><b><?php echo $text_voucher_code; ?></b></td>
                                        <td class="value"><input  id="voucher_code" name="voucher" type="text" class="voucherText">
                                            <input type="hidden" value="voucher" name="next">
                                            <input id="button-voucher" type="button" onClick="if(window.voucherBlur==true){ callVoucher(); }" class="orangebuttonapply" value="<?php echo $button_apply; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>            
                            <?php } ?>
                        </div>

                    </div>
                    <div id="payment_display_block"  class="supercheckout-blocks" data-column="<?php echo $sort_block['confirm'][$layout_name]['column']; ?>" data-row="<?php echo $sort_block['confirm'][$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_block['confirm'][$layout_name]['column-inside']; ?>" >
                        <div class="supercheckout-checkout-content"> </div>
                        <div id="display_payment">
                            
                            <?php echo $payment_display; ?>
                        </div>
                
                        <div id="supercheckout-comments" style="display:<?php if($logged){ if($settings['option']['logged']['confirm']['fields']['comment']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['confirm']['fields']['comment']['display']){ echo'block';}else{ echo'none';}} ?>;">
                        <b><?php echo $text_comments; ?></b>
                        <textarea id="supercheckout-comment_order" name="comment" rows="8" ></textarea>
                        <br />
                        <br />
                        </div>
                        <?php if ($text_agree) { ?>                
                        <div id="supercheckout-agree" style="display:<?php if($logged){ if($settings['option']['logged']['confirm']['fields']['agree']['display']){ echo'block';}else{ echo'none';} }else{ if($settings['option']['guest']['confirm']['fields']['agree']['display']){ echo'block';}else{ echo'none';}} ?>;">
                            
                            <?php if ($agree) { ?>
                            <input type="checkbox" name="agree" value="1" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="agree" value="1" />
                            <?php } ?><?php echo " ".$text_agree; ?>
                        </div>                
                        <?php } ?>
                        <div id="placeorderButton">
                            <div id="buttonWithProgres" style="width:206px;">
                                <div id="confirm_order" class="orangebutton" >
                                    <?php echo $button_place_order; ?>
                                    <div id="progressbar" style="text-align:center;margin-top: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach($sort_block['html'] as $sort_html){ ?>
                    <div  class="supercheckout-blocks" data-column="<?php echo $sort_html[$layout_name]['column']; ?>" data-row="<?php echo $sort_html[$layout_name]['row']; ?>" data-column-inside="<?php echo $sort_html[$layout_name]['column-inside']; ?>">
                        <?php if(isset($sort_html['value'])){ echo html_entity_decode($sort_html['value'] ); } ?>                
                    </div>
                     <?php } ?>            
                </div>

                <div class="supercheckout-column-middle columnleftsort" id="columnleft-2"  style="width:<?php $i= $settings['general']['column_width'][$layout_name][2]*$multiplier; echo $i; ?>%;margin-right:0px;">
                    <div class="supercheckout-column-left columnleftsort" id="column-2-upper" style="width:100%;height:auto;"> 
                    </div>
                    <div class="supercheckout-column-left columnleftsort" id="column-1-inside" style="width:<?php $i= $settings['general']['column_width'][$layout_name]['inside'][1]*.914; echo $i; ?>%"> 
                    </div>
                    <div class="supercheckout-column-left columnleftsort" id="column-2-inside"  style="width:<?php $i= $settings['general']['column_width'][$layout_name]['inside'][2]*.914; echo $i; ?>%">
                    
                    </div>
                    <div class="supercheckout-column-left columnleftsort" id="column-2-lower"  style="width:100%;height:auto;">
                    
                    </div>
                </div>
                <div class="supercheckout-column-right columnleftsort" id="columnleft-3" style="width:<?php $i= $settings['general']['column_width'][$layout_name][3]*$multiplier; echo $i; ?>%">
                </div>
            </div>
        </fieldset>
        <?php if(isset($settings['step']['html_value']['value']['footer']) && $settings['step']['html_value']['value']['footer']!=""){ ?>
            <div id="supercheckout_html_content_footer">        
                <?php echo  html_entity_decode( $settings['step']['html_value']['value']['footer']); ?>
            </div>
        <?php } ?>
    </div>
    <div class="content-down" id="content-down"></div>
  </div>
</div>
<?php echo $footer; ?>