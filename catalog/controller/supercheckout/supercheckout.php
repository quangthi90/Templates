<?php
class ControllerSupercheckoutSuperCheckout extends Controller {

    public function index() {

        $browser = ($this->request->server['HTTP_USER_AGENT']);
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/supercheckout.tpl')) {
                $data['default_theme']=$this->config->get('config_template');
        }else{
                $data['default_theme']='default';
        }
        
        //flag for IE 1-7
        if (preg_match('/(?i)msie [1-7]/', $browser)) {

            $data['IE7'] = true;

        } else {

            $data['IE7'] = false;

        }
        //adding script to the page<!-- Gritter Notifications Plugin -->
        $this->load->model('checkout/order');
        $this->document->addScript('catalog/view/javascript/supercheckout/tinysort/jquery.tinysort.min.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/common.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/bootstrap.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/jquery.colorbox.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/theme/plugins/notifications/Gritter/js/jquery.gritter.min.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/theme/plugins/notifications/notyfy/jquery.notyfy.js');
        $this->document->addScript('catalog/view/javascript/supercheckout/theme/demo/notifications.js');

        $this->load->model('setting/setting');

        $result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        if(!empty($result)) {
            $this->settings = $result['supercheckout'];

            $data['settings'] = $result['supercheckout'];
        }
        if (!isset($data['settings'])) {
            $settings = $this->model_setting_setting->getSetting('default_supercheckout', 0);
            $data['settings'] = $settings['default_supercheckout'];

        }
        if(empty($data['settings']) || !$data['settings']['general']['enable']){
            $this->response->redirect($this->url->link('checkout/checkout','','SSL'));
        }

        if (isset($data['settings']['general']['default_option'])) { //for setting default value for guest or login
            $data['account'] = $data['settings']['general']['default_option'];
        } else {
            $data['account'] = 'guest';
        }
        
        foreach ($data['settings']['step'] as $key => $step) {
            $sort_block[$key] = $step;
        }
        $redirect = "";
        
        //unsetting methods
        unset($this->session->data['payment_method']);
        unset($this->session->data['shipping_method']);
        unset($this->session->data['shipping_country_id']);
        unset($this->session->data['shipping_zone_id']);
        unset($this->session->data['payment_country_id']);
        unset($this->session->data['payment_zone_id']);
        unset($this->session->data['shipping_address_id']);
        unset($this->session->data['payment_address_id']);
        unset($this->session->data['payment']);
        unset($this->session->data['shipping']);
        unset($this->session->data['set_add_shipping_address_check']);
        unset($this->session->data['set_add_payment_address_check']);
        unset($this->session->data['guestAccount_customer_id']);

        $data['sort_block'] = $sort_block;

        $data['payment_address_sort_order'] = $this->settings['step']['payment_address'];
        $data['shipping_address_sort_order'] = $this->settings['step']['shipping_address'];
        $data['address_id'] = 0;
        //zone code fix
        $this->load->model('localisation/country');

        $country_info_guest = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));            
        $this->session->data['country_info_guest']=$country_info_guest;
        $data['country_info_guest']=$country_info_guest;
        //zone code fix
        if (!$this->customer->isLogged()) {
            
            $this->session->data['guest']['shipping']['country_id'] = $this->config->get('config_country_id');
            $this->session->data['guest']['shipping']['zone_id'] = $this->config->get('config_zone_id');
            $this->session->data['guest']['payment']['country_id'] = $this->config->get('config_country_id');
            $this->session->data['guest']['payment']['zone_id'] = $this->config->get('config_zone_id');
            $this->session->data['guest']['payment']['firstname'] = "";
            $this->session->data['guest']['payment']['lastname'] = "";
            $this->session->data['guest']['payment']['company'] = "";
            $this->session->data['guest']['payment']['company_id'] = "";
            $this->session->data['guest']['payment']['tax_id'] = "";
            $this->session->data['guest']['payment']['address_1'] = "";
            $this->session->data['guest']['payment']['address_2'] = "";
            $this->session->data['guest']['payment']['city'] = "";
            $this->session->data['guest']['payment']['postcode'] = "";
            $this->session->data['guest']['payment']['zone'] = "";
            $this->session->data['guest']['payment']['zone_code'] = "";
            $this->session->data['guest']['payment']['country'] = "";
            $this->session->data['guest']['payment']['iso_code_2'] = $country_info_guest['iso_code_2'];
            $this->session->data['guest']['payment']['iso_code_3'] = $country_info_guest['iso_code_3'];
            $this->session->data['guest']['payment']['address_format'] = $country_info_guest['address_format'];

            $this->session->data['guest']['shipping']['firstname'] = "";
            $this->session->data['guest']['shipping']['lastname'] = "";
            $this->session->data['guest']['shipping']['company'] = "";
            $this->session->data['guest']['shipping']['company_id'] = "";
            $this->session->data['guest']['shipping']['tax_id'] = "";
            $this->session->data['guest']['shipping']['address_1'] = "";
            $this->session->data['guest']['shipping']['address_2'] = "";
            $this->session->data['guest']['shipping']['city'] = "";
            $this->session->data['guest']['shipping']['postcode'] = "";
            $this->session->data['guest']['shipping']['zone'] = "";
            $this->session->data['guest']['shipping']['zone_code'] = "";
            $this->session->data['guest']['shipping']['country'] = "";
            $this->session->data['guest']['shipping']['iso_code_2'] =$country_info_guest['iso_code_2'];;
            $this->session->data['guest']['shipping']['iso_code_3'] = $country_info_guest['iso_code_3'];			
            $this->session->data['guest']['shipping']['address_format'] = $country_info_guest['address_format'];

            $this->session->data['guest']['customer_group_id'] = "";
            $this->session->data['guest']['firstname'] = "";
            $this->session->data['guest']['lastname'] = "";
            $this->session->data['guest']['email'] = "";
            $this->session->data['guest']['telephone'] = "";
            $this->session->data['guest']['fax'] = "";
        } else {
            $address_default_id = $this->customer->getAddressId();
            $data['address_id'] = $this->customer->getAddressId();
        }

        /*** Settting default values to county and zone stored in database */
        $this->session->data['shipping_country_id'] = $this->config->get('config_country_id');
        $this->session->data['payment_country_id'] = $this->config->get('config_country_id');
        $this->session->data['shipping_zone_id'] = $this->config->get('config_zone_id');
        $this->session->data['payment_zone_id'] = $this->config->get('config_zone_id');
        //iso fix
        $this->session->data['shipping_iso_code_2'] = $this->session->data['country_info_guest']['iso_code_2'];
        $this->session->data['shipping_iso_code_3'] = $this->session->data['country_info_guest']['iso_code_3'];
        $this->session->data['payment_iso_code_2'] = $this->session->data['country_info_guest']['iso_code_2'];
        $this->session->data['payment_iso_code_3'] = $this->session->data['country_info_guest']['iso_code_3'];

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {

            $this->response->redirect($this->url->link('checkout/cart'));

        }

        //validate login
        if ($this->customer->isLogged()) {            
            $data['firstName'] = $this->customer->getFirstName();
            if(!isset($data['firstName'])|| $data['firstName']==""){
                $data['firstName']="";
            }
            $data['lastName'] = $this->customer->getLastName();
            if(!isset($data['lastName'])|| $data['lastName']==""){
                $data['lastName']="";
            }
            $data['logoutLink'] = $this->url->link('account/logout', '', 'SSL');
            if(!isset($data['logoutLink'])|| $data['logoutLink']==""){
                $data['logoutLink']="";
            }
            $data['myAccount'] = $this->url->link('account/account', '', 'SSL');
            if(!isset($data['myAccount'])|| $data['myAccount']==""){
                $data['myAccount']="";
            }
            $data['myOrder'] = $this->url->link('account/order', '', 'SSL');
            if(!isset($data['myOrder'])|| $data['myOrder']==""){
                $data['myOrder']="";
            }
        }

        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $this->response->redirect($this->url->link('checkout/cart'));
            }
        }

        $this->language->load('supercheckout/supercheckout');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home'),
                'separator' => false
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_cart'),
                'href' => $this->url->link('checkout/cart'),
                'separator' => $this->language->get('text_separator')
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('supercheckout/supercheckout', '', 'SSL'),
                'separator' => $this->language->get('text_separator')
        );  
        if(isset($this->session->data['order_id'])){
            $this->load->model('checkout/order');
            $data['order_details']=$this->model_checkout_order->getOrder($this->session->data['order_id']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////  LOGIN PART  //////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data['login_options'] = $this->language->get('login_options');
        $data['text_login_option'] = $this->language->get('text_login_option');
        $data['text_my_account'] = $this->language->get('text_my_account');
        $data['text_my_orders'] = $this->language->get('text_my_orders');
        $data['text_logout'] = $this->language->get('text_logout');
        $data['text_new_customer'] = $this->language->get('text_new_customer');
        $data['text_returning_customer'] = $this->language->get('text_returning_customer');
        $data['text_checkout'] = $this->language->get('text_checkout');
        $data['text_register'] = $this->language->get('text_register');
        $data['text_register_manual'] = $this->language->get('text_register_manual');
        $data['text_guest'] = $this->language->get('text_guest');
        $data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
        $data['text_register_account'] = $this->language->get('text_register_account');
        $data['text_forgotten'] = $this->language->get('text_forgotten');
        $data['text_register_account'] = $this->language->get('text_register_account');
        $data['text_create_account'] = $this->language->get('text_create_account');
        $data['entry_confirm'] = $this->language->get('entry_confirm');
        $data['text_OR_separator'] = $this->language->get('text_OR_separator');
        $data['text_notification'] = $this->language->get('text_notification');
        $data['voucher_deleted'] = $this->language->get('voucher_deleted');
        $data['coupon_deleted'] = $this->language->get('coupon_deleted');
        $data['heading_title'] = $this->language->get('heading_title');

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_password'] = $this->language->get('entry_password');
        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_login'] = $this->language->get('button_login');
        //bug fix
        $data['button_place_order'] = $this->language->get('button_place_order');
        $data['button_update_link'] = $this->language->get('button_update_link');
        $data['text_coupon_code'] = $this->language->get('text_coupon_code');
        $data['text_voucher_code'] = $this->language->get('text_voucher_code');
        $data['text_billing_address'] = $this->language->get('text_billing_address');
        $data['text_sign_in_with'] = $this->language->get('text_sign_in_with');
        $data['column_action'] = $this->language->get('column_action');
        $data['registered_user'] = $this->language->get('registered_user');
        $data['text_guest_checkout'] = $this->language->get('text_guest_checkout');
        $data['social_login'] = $this->language->get('social_login');
        
        $data['guest_checkout'] = ($this->config->get('config_guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());

        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['error_login_require'] = $this->language->get('error_login_require');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');

        //guest
        if (isset($this->session->data['guest']['firstname'])) {
            $data['firstname'] = $this->session->data['guest']['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($this->session->data['guest']['lastname'])) {
            $data['lastname'] = $this->session->data['guest']['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->session->data['guest']['email'])) {
            $data['email'] = $this->session->data['guest']['email'];
        } else {
            $data['email'] = '';
        }

        //admin control
        if ($this->settings['step']['facebook_login']['display']) {
            $data['facebook_enable'] = $this->settings['step']['facebook_login']['display'];
        } else {
            $data['facebook_enable'] = $this->settings['step']['facebook_login']['display'];
        }
        if ($this->settings['step']['google_login']['display']) {
            $data['google_enable'] = $this->settings['step']['google_login']['display'];
        } else {
            $data['google_enable'] = $this->settings['step']['google_login']['display'];
        }

        //facebook login settings
        $appId = $this->settings['step']['facebook_login']['app_id'];
        $secret = $this->settings['step']['facebook_login']['app_secret'];
        $data['appId'] = $appId;
        $data['secret'] = $secret;

        //google login settings
        $this->load->library('googleSetup');

        $client = new apiClient();

        $redirect_url = $this->url->link('supercheckout/supercheckout','','SSL');

        $client->setClientId($this->settings['step']['google_login']['client_id']);
        $client->setClientSecret($this->settings['step']['google_login']['app_secret']);
        $client->setDeveloperKey($this->settings['step']['google_login']['app_id']);
        $client->setRedirectUri($redirect_url);
        $client->setApprovalPrompt(false);

        $oauth2 = new apiOauth2Service($client);

        $data['client'] = $client;
        $url = ($client->createAuthUrl());
        $data['url'] = $url;

        if (isset($this->request->get['code'])) {

            $client->authenticate();
            $info = $oauth2->userinfo->get();
            if (isset($info['given_name']) && $info['given_name'] != "") {

                $name = $info['given_name'];

            } else {

                $name = $info['name'];

            }

            $user_table = array(
                    'firstname' => $name,
                    'lastname' => $info['family_name'],
                    'email' => $info['email'],
                    'telephone' => '',
                    'fax' => '',
                    'password' => substr(md5(uniqid(rand(), true)), 0, 9),
                    'company' => '',
                    'company_id' => '',
                    'tax_id' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => '',
                    'zone_id' => '',
                    'customer_group_id' => 1,
                    'status' => 1,
                    'approved' => 1
            );

            $this->load->model('account/customer');
            $this->load->model('supercheckout/customer');

            //getting customer info if already exists
            $users_check = $this->model_account_customer->getCustomerByEmail($info['email']);

            //adding customer if new
            if (empty($users_check)) {

                $this->model_supercheckout_customer->addFacebookGoogleCustomer($user_table);

            }

            $users_check = $this->model_account_customer->getCustomerByEmail($info['email']);

            //loging in the customer
            $users_pass = $this->customer->login($info['email'], '', true);

            $this->session->data['customer_id'] = $users_check['customer_id'];

            if ($users_pass == true) {

                echo'<script>window.opener.location.href ="' . $redirect_url . '"; window.close();</script>';

            } else {

                echo'<script>window.opener.location.href ="' . $redirect_url . '"; window.close();</script>';

            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////  BILLING /SHIPPING ADDRESS //////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data['text_address_existing'] = $this->language->get('text_address_existing');
        $data['text_address_new'] = $this->language->get('text_address_new');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_ship_same_address'] = $this->language->get('text_ship_same_address');
        $data['text_shipping_address'] = $this->language->get('text_shipping_address');

        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_company_id'] = $this->language->get('entry_company_id');
        $data['entry_tax_id'] = $this->language->get('entry_tax_id');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_address_2'] = $this->language->get('entry_address_2');
        $data['entry_postcode'] = $this->language->get('entry_postcode');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_zone'] = $this->language->get('entry_zone');


        $data['addresses'] = array();
        $addressess = array();
        $this->load->model('account/address');

        if ($this->customer->isLogged()) {
            $addressess = $this->model_account_address->getAddresses();
        }
        
        $address_data_new = array();
		if(count($addressess) > 0)	{
			foreach ($addressess as $add => $key) {
				if ($key['address_1'] != "" && $key['country_id'] != "" && $key['zone_id'] != "")
					$address_data_new[$add] = array(
							'address_id' => isset($key['address_id'])?$key['address_id']:"",
							'firstname' => isset($key['firstname'])?$key['firstname']:"",
							'lastname' => isset($key['lastname'])?$key['lastname']:"",
							'company' => isset($key['company'])?$key['company']:"",
							'company_id' => isset($key['company_id'])?$key['company_id']:"",
							'tax_id' => isset($key['tax_id'])?$key['tax_id']:"",
							'address_1' => isset($key['address_1'])?$key['address_1']:"",
							'address_2' => isset($key['address_2'])?$key['address_2']:"",
							'postcode' => isset($key['postcode'])?$key['postcode']:"",
							'city' => isset($key['city'])?$key['city']:"",
							'zone_id' => isset($key['zone_id'])?$key['zone_id']:"",
							'zone' => isset($key['zone'])?$key['zone']:"",
							'zone_code' => isset($key['zone_code'])?$key['zone_code']:"",
							'country_id' => isset($key['country_id'])?$key['country_id']:"",
							'country' => isset($key['country'])?$key['country']:"",
							'iso_code_2' => isset($key['iso_code_2'])?$key['iso_code_2']:"",
							'iso_code_3' => isset($key['iso_code_3'])?$key['iso_code_3']:"",
							'address_format' => isset($key['address_format'])?$key['address_format']:""
					);
			}
		}

        //getting first address_id to set default values for shipping and payment method to load
        $get_first_address_id = array();
        $get_first_address=array();
        $cut_index = 0;
        foreach ($address_data_new as $key=>$address) {
            if($key == $address_default_id){
                $use_index = $cut_index;
            }
            $get_first_address_id[] = $key;
            $get_first_address[]=$address;
            $cut_index++;
        }

        if(!empty($address_data_new)) {
            
            $this->session->data['shipping_address_id']= isset($use_index)?$get_first_address_id[$use_index]:$get_first_address_id[0];
            $this->session->data['payment_address_id']=isset($use_index)?$get_first_address_id[$use_index]:$get_first_address_id[0];
            $this->session->data['shipping_country_id']=isset($use_index)?$get_first_address[$use_index]['country_id']:$get_first_address[0]['country_id'];
            $this->session->data['shipping_zone_id']=isset($use_index)?$get_first_address[$use_index]['zone_id']:$get_first_address[0]['zone_id'];
            $this->session->data['payment_country_id']=isset($use_index)?$get_first_address[$use_index]['country_id']:$get_first_address[0]['country_id'];
            $this->session->data['payment_zone_id']=isset($use_index)?$get_first_address[$use_index]['zone_id']:$get_first_address[0]['zone_id'];

        }
        $this->tax->setShippingAddress($this->session->data['shipping_country_id'], $this->session->data['shipping_zone_id']);

        $this->tax->setPaymentAddress($this->session->data['payment_country_id'], $this->session->data['payment_zone_id']);
        $data['addresses'] = $address_data_new;
        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());

        /*if ($customer_group_info) {
            $data['company_id_display'] = $customer_group_info['company_id_display'];
        } else {
            $data['company_id_display'] = '';
        }

        if ($customer_group_info) {
            $data['company_id_required'] = $customer_group_info['company_id_required'];
        } else {
            $data['company_id_required'] = '';
        }

        if ($customer_group_info) {
            $data['tax_id_display'] = $customer_group_info['tax_id_display'];
        } else {
            $data['tax_id_display'] = '';
        }

        if ($customer_group_info) {
            $data['tax_id_required'] = $customer_group_info['tax_id_required'];
        } else {
            $data['tax_id_required'] = '';
        }*/

        if (isset($this->session->data['payment_country_id'])) {
            $data['country_id'] = $this->session->data['payment_country_id'];
        } else {
            $data['country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->session->data['payment_zone_id'])) {
            $data['zone_id'] = $this->session->data['payment_zone_id'];
        } else {
            $data['zone_id'] = $this->config->get('config_zone_id');
        }

        $this->load->model('localisation/country');

        $data['countries'] = $this->model_localisation_country->getCountries();

        //getting default zone
        $data['zones_default'] = $this->zoneDefault($data['country_id']);

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////  SHIPPIG METHOD /////////// //////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->load->model('account/address');
        $data['text_shipping_method'] = $this->language->get('text_shipping_method');
        $data['error_no_shipping_product'] = $this->language->get('error_no_shipping_product');

        //if customer is logged in and has entry in addres book
        if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {

            $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);

        }
        //if customer is logged in and DOES NOT has entry in addres book
        elseif($this->customer->isLogged() && !isset($this->session->data['shipping_address_id'])) {

            $shipping_address['country_id'] = $this->session->data['shipping_country_id'];
            $shipping_address['zone_id'] = $this->session->data['shipping_zone_id'];
            $shipping_address['postcode'] = isset($this->session->data['shipping']['shipping_postcode'])?$this->session->data['shipping']['shipping_postcode']:"";

        }
        elseif (isset($this->session->data['guest'])) {

            $shipping_address = $this->session->data['guest']['shipping'];
        }
        
        if (!empty($shipping_address)) {

            // Shipping Methods
            $quote_data = array();

            $this->load->model('extension/extension');

            $results = $this->model_extension_extension->getExtensions('shipping');
            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('shipping/' . $result['code']);

                    $quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);

                    if ($quote) {
                        $quote_data[$result['code']] = array(
                                'title' => $quote['title'],
                                'quote' => $quote['quote'],
                                'sort_order' => $quote['sort_order'],
                                'error' => $quote['error']
                        );
                    }
                }
            }

            $sort_order = array();

            foreach ($quote_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $quote_data);

            $this->session->data['shipping_methods'] = $quote_data;
        }
        $data['text_shipping_method'] = $this->language->get('text_shipping_method');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['button_continue'] = $this->language->get('button_continue');

        if (empty($this->session->data['shipping_methods'])) {

            $data['error_warning_shipping'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));

        } else {

            $data['error_warning_shipping'] = '';

        }

        if (isset($this->session->data['shipping_methods'])) {

            $data['shipping_methods'] = $this->session->data['shipping_methods'];

        } else {

            $data['shipping_methods'] = array();

        }

        if (isset($this->session->data['shipping_method']['code'])) {

            $data['codeShipping'] = $this->session->data['shipping_method']['code'];

        } else {

            $data['codeShipping'] = '';

        }
        
        $get_first_method_shipping = array();
        foreach ($this->session->data['shipping_methods'] as $methods => $key) {
            $get_first_method_shipping[] = $methods;
        }

        $default_shipping = isset($this->settings['step']['shipping_method']['default_option']) ? $this->settings['step']['shipping_method']['default_option'] : array();

        
		
        if(!empty ($get_first_method_shipping)) {
            if (!in_array($default_shipping, $get_first_method_shipping)) {
                if(isset($this->session->data['shipping_methods'][$get_first_method_shipping[0]]['quote'][$get_first_method_shipping[0]])) {
                    $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$get_first_method_shipping[0]]['quote'][$get_first_method_shipping[0]];
                }
            } else {
                foreach($this->session->data['shipping_methods'][$default_shipping]['quote'] as $shipping_methods_key => $shipping_methods_val) {
                    $this->session->data['shipping_method'] = $shipping_methods_val;
                    break;
                }
            }
        } else {
            unset($this->session->data['shipping_method']);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////  PAYMENT METHOD ////////// //////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->load->model('account/address');
        $data['text_payment_method'] = $this->language->get('text_payment_method');

        //if customer is logged in and has entry in addres book
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {

            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);

        }
        //if customer is logged in and DOES NOT has entry in addres book
        elseif($this->customer->isLogged() && !isset($this->session->data['payment_address_id'])) {

            $payment_address['country_id']=$this->session->data['payment_country_id'];
            $payment_address['zone_id']=$this->session->data['payment_zone_id'];

        } elseif (isset($this->session->data['guest'])) {

            $payment_address = $this->session->data['guest']['payment'];

        }        
        if (!empty($payment_address)) {
            // Totals
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {

                    $this->load->model('total/' . $result['code']);

                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                }
            }

            // Payment Methods
            $method_data = array();

            $this->load->model('extension/extension');

            $results = $this->model_extension_extension->getExtensions('payment');

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('payment/' . $result['code']);

                    $method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

                    if ($method) {
                        $method_data[$result['code']] = $method;
                    }
                }
            }

            $sort_order = array();

            foreach ($method_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $method_data);

            $this->session->data['payment_methods'] = $method_data;
        }

        $data['text_payment_method'] = $this->language->get('text_payment_method');
        $data['text_comments'] = $this->language->get('text_comments');
        $data['button_continue'] = $this->language->get('button_continue');

        if (empty($this->session->data['payment_methods'])) {

            $data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));

        } else {

            $data['error_warning'] = '';

        }

        if (isset($this->session->data['payment_methods'])) {

            $data['payment_methods'] = $this->session->data['payment_methods'];

        } else {

            $data['payment_methods'] = array();

        }

        if (isset($this->session->data['payment_method']['code'])) {

            $data['code'] = $this->session->data['payment_method']['code'];

        } else {

            $data['code'] = '';

        }



        if ($this->config->get('config_checkout_id')) {

            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

            if ($information_info) {

                $data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);

            } else {

                $data['text_agree'] = '';

            }
        } else {

            $data['text_agree'] = '';

        }

        if (isset($this->session->data['agree'])) {

            $data['agree'] = $this->session->data['agree'];

        } else {

            $data['agree'] = '';

        }
        $get_first_method_payment = array();
        foreach ($this->session->data['payment_methods'] as $methods) {
            $get_first_method_payment[] = $methods['code'];
        }
        $default_payment = isset($this->settings['step']['payment_method']['default_option']) ? $this->settings['step']['payment_method']['default_option'] : array();
        if (!in_array($default_payment, $get_first_method_payment)) {
            $this->session->data['payment_method'] = $this->session->data['payment_methods'][$get_first_method_payment[0]];
        } else {
            $this->session->data['payment_method'] = $this->session->data['payment_methods'][$default_payment];
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////  CART / CONFIRM ORDER //////////// ///////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $data['text_confirm_order'] = $this->language->get('text_confirm_order');
        $data['button_paynow'] = $this->language->get('button_paynow');
        $data['button_apply'] = $this->language->get('button_apply');
        $data['text_coupon_success'] = $this->language->get('text_coupon_success');
        $data['text_remove'] = $this->language->get('text_remove');
        $data['text_voucher_success'] = $this->language->get('text_voucher_success');
        $data['text_action'] = $this->language->get('text_action');
        $data['text_update'] = $this->language->get('text_update');
        $data['text_redeem'] = $this->language->get('text_redeem');

        if ($this->cart->hasShipping()) {

            // Validate if shipping address has been set.
            $this->load->model('account/address');

            //if customer is logged in and has entry in addres book
            if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {

                $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);

            }

            //if customer is logged in and DOES NOT has entry in addres book
            elseif($this->customer->isLogged() && !isset($this->session->data['shipping_address_id'])) {

                $shipping_address['country_id']=$this->session->data['shipping_country_id'];
                $shipping_address['zone_id']=$this->session->data['shipping_zone_id'];

            }elseif (isset($this->session->data['guest'])) {

                $shipping_address = $this->session->data['guest']['shipping'];

            }

            if (empty($shipping_address)) {

                $redirect = $this->url->link('supercheckout/supercheckout', '', 'SSL');

            }
        }

        // Validate if payment address has been set.
        $this->load->model('account/address');

        //if customer is logged in and has entry in addres book
        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {

            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);

        }

        //if customer is logged in and DOES NOT has entry in addres book
        elseif($this->customer->isLogged() && !isset($this->session->data['payment_address_id'])) {

            $payment_address['country_id']=$this->session->data['payment_country_id'];
            $payment_address['zone_id']=$this->session->data['payment_zone_id'];

        } elseif (isset($this->session->data['guest'])) {

            $payment_address = $this->session->data['guest']['payment'];

        }

        if (empty($payment_address)) {

            $redirect = $this->url->link('supercheckout/supercheckout', '', 'SSL');

        }
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {

        }

        // Validate minimum quantity requirments.
        
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $redirect = $this->url->link('checkout/cart');
                break;
            }
        }

        if (!$redirect) {
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('extension/extension');
            $sort_order = array();
            $results = $this->model_extension_extension->getExtensions('total');
            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {

                if ($this->config->get($result['code'] . '_status')) {

                    $this->load->model('total/' . $result['code']);

                    $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                }
            }

            $sort_order = array();

            foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data);

            $this->language->load('supercheckout/supercheckout');

            $pdata = array();

            $pdata['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $pdata['store_id'] = $this->config->get('config_store_id');
            $pdata['store_name'] = $this->config->get('config_name');

            if ($pdata['store_id']) {
                $pdata['store_url'] = $this->config->get('config_url');
            } else {
                $pdata['store_url'] = HTTP_SERVER;
            }

            if ($this->customer->isLogged()) {

                $pdata['customer_id'] = $this->customer->getId();
                $pdata['customer_group_id'] = $this->customer->getGroupId();
                $pdata['firstname'] = $this->customer->getFirstName();
                $pdata['lastname'] = $this->customer->getLastName();
                $pdata['email'] = $this->customer->getEmail();
                $telephone=$this->customer->getTelephone();
                if($telephone=="") {
                    $pdata['telephone'] = isset($this->session->data['payment']['payment_telephone'])?$this->session->data['payment']['payment_telephone']:"";
                } else {
                    $pdata['telephone'] = $telephone;
                }
                $pdata['fax'] = $this->customer->getFax();
                $this->load->model('account/address');
                if (isset($this->session->data['payment_address_id'])) {
                    $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
                } else {
                    $payment_address['country_id']=$this->session->data['payment_country_id'];
                    $payment_address['zone_id']=$this->session->data['payment_zone_id'];

                }
            } elseif (isset($this->session->data['guest'])) {

                $pdata['customer_id'] = 0;
                $pdata['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
                $pdata['firstname'] = $this->session->data['guest']['firstname'];
                $pdata['lastname'] = $this->session->data['guest']['lastname'];
                $pdata['email'] = $this->session->data['guest']['email'];
                $pdata['telephone'] = $this->session->data['guest']['telephone'];
                $pdata['fax'] = $this->session->data['guest']['fax'];

                $payment_address = $this->session->data['guest']['payment'];

            }

            $pdata['payment_firstname'] = isset($payment_address['firstname'])?$payment_address['firstname']:"";
            $pdata['payment_lastname'] = isset($payment_address['lastname'])?$payment_address['lastname']:"";
            $pdata['payment_company'] = isset($payment_address['company'])?$payment_address['company']:"";
            $pdata['payment_company_id'] = isset($payment_address['company_id'])?$payment_address['company_id']:"";
            $pdata['payment_tax_id'] = isset($payment_address['tax_id'])?$payment_address['tax_id']:"";
            $pdata['payment_address_1'] = isset($payment_address['address_1'])?$payment_address['address_1']:"";
            $pdata['payment_address_2'] = isset($payment_address['address_2'])?$payment_address['address_2']:"";
            $pdata['payment_city'] = isset($payment_address['city'])?$payment_address['city']:"";
            $pdata['payment_postcode'] = isset($payment_address['postcode'])?$payment_address['postcode']:"";
            $pdata['payment_zone'] = isset($payment_address['zone'])?$payment_address['zone']:"";
            $pdata['payment_zone_id'] = isset($payment_address['zone_id'])?$payment_address['zone_id']:"";
            $pdata['payment_country'] = isset($payment_address['country'])?$payment_address['country']:"";
            $pdata['payment_country_id'] = isset($payment_address['country_id'])?$payment_address['country_id']:"";
            $pdata['payment_address_format'] = isset($payment_address['address_format'])?$payment_address['address_format']:"";

            if (isset($this->session->data['payment_method']['title'])) {

                $pdata['payment_method'] = $this->session->data['payment_method']['title'];

            } else {

                $pdata['payment_method'] = '';

            }

            if (isset($this->session->data['payment_method']['code'])) {

                $pdata['payment_code'] = $this->session->data['payment_method']['code'];
                $data['payment_code'] = $this->session->data['payment_method']['code'];

            } else {

                $pdata['payment_code'] = '';

            }
            if ($this->cart->hasShipping()) {

                if ($this->customer->isLogged()) {
                    $this->load->model('account/address');
                    if(isset($this->session->data['shipping_address_id'])) {
                        $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
                    } else {
                        $shipping_address['country_id']=$this->session->data['shipping_country_id'];
                        $shipping_address['zone_id']=$this->session->data['shipping_zone_id'];
                    }
                } elseif (isset($this->session->data['guest'])) {
                    $shipping_address = $this->session->data['guest']['shipping'];
                }

                $pdata['shipping_firstname'] = isset($shipping_address['firstname'])?$shipping_address['firstname']:"";
                $pdata['shipping_lastname'] = isset($shipping_address['lastname'])?$shipping_address['lastname']:"";
                $pdata['shipping_company'] = isset($shipping_address['company'])?$shipping_address['company']:"";
                $pdata['shipping_address_1'] = isset($shipping_address['address_1'])?$shipping_address['address_1']:"";
                $pdata['shipping_address_2'] = isset($shipping_address['address_2'])?$shipping_address['address_2']:"";
                $pdata['shipping_city'] = isset($shipping_address['city'])?$shipping_address['city']:"";
                $pdata['shipping_postcode'] = isset($shipping_address['postcode'])?$shipping_address['postcode']:"";
                $pdata['shipping_zone'] = isset($shipping_address['zone'])?$shipping_address['zone']:"";
                $pdata['shipping_zone_id'] = isset($shipping_address['zone_id'])?$shipping_address['zone_id']:"";
                $pdata['shipping_country'] = isset($shipping_address['country'])?$shipping_address['country']:"";
                $pdata['shipping_country_id'] = isset($shipping_address['country_id'])?$shipping_address['country_id']:"";
                $pdata['shipping_address_format'] = isset($shipping_address['address_format'])?$shipping_address['address_format']:"";

                if (isset($this->session->data['shipping_method']['title'])) {
                    $pdata['shipping_method'] = $this->session->data['shipping_method']['title'];
                } else {
                    $pdata['shipping_method'] = '';
                }
                if (isset($this->session->data['shipping_method']['code'])) {
                    $pdata['shipping_code'] = $this->session->data['shipping_method']['code'];
                    $data['shipping_code'] = $this->session->data['shipping_method']['code'];
                } else {
                    $pdata['shipping_code'] = '';
                }
            } else {
                $pdata['shipping_firstname'] = '';
                $pdata['shipping_lastname'] = '';
                $pdata['shipping_company'] = '';
                $pdata['shipping_address_1'] = '';
                $pdata['shipping_address_2'] = '';
                $pdata['shipping_city'] = '';
                $pdata['shipping_postcode'] = '';
                $pdata['shipping_zone'] = '';
                $pdata['shipping_zone'] = '';
                $pdata['shipping_zone_id'] = '';
                $pdata['shipping_country'] = '';
                $pdata['shipping_country_id'] = '';
                $pdata['shipping_address_format'] = '';
                $pdata['shipping_method'] = '';
                $pdata['shipping_code'] = '';
            }

            $product_data = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {

                        $value = $option['option_value'];

                    } else {

                        $value = $this->encryption->decrypt($option['option_value']);

                    }

                    $option_data[] = array(
                            'product_option_id' => $option['product_option_id'],
                            'product_option_value_id' => $option['product_option_value_id'],
                            'option_id' => $option['option_id'],
                            'option_value_id' => $option['option_value_id'],
                            'name' => $option['name'],
                            'value' => $value,
                            'type' => $option['type']
                    );
                }

                $product_data[] = array(
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'download' => $product['download'],
                        'quantity' => $product['quantity'],
                        'subtract' => $product['subtract'],
                        'price' => $product['price'],
                        'total' => $product['total'],
                        'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                        'reward' => $product['reward']
                );
            }

            // Gift Voucher
            $voucher_data = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $voucher_data[] = array(
                            'description' => $voucher['description'],
                            'code' => substr(md5(mt_rand()), 0, 10),
                            'to_name' => $voucher['to_name'],
                            'to_email' => $voucher['to_email'],
                            'from_name' => $voucher['from_name'],
                            'from_email' => $voucher['from_email'],
                            'voucher_theme_id' => $voucher['voucher_theme_id'],
                            'message' => $voucher['message'],
                            'amount' => $voucher['amount']
                    );
                }
            }

            $pdata['products'] = $product_data;
            $pdata['vouchers'] = $voucher_data;
            $pdata['totals'] = $total_data;
            $this->session->data['comment'] = "";
            $pdata['comment'] = $this->session->data['comment'];
            $pdata['total'] = $total;

            if (isset($this->request->cookie['tracking'])) {
                $this->load->model('affiliate/affiliate');

                $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

                $subtotal = $this->cart->getSubTotal();

                if ($affiliate_info) {
                    $pdata['affiliate_id'] = $affiliate_info['affiliate_id'];
                    $pdata['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                } else {
                    $pdata['affiliate_id'] = 0;
                    $pdata['commission'] = 0;
                }

                // Marketing
                $this->load->model('checkout/marketing');

                if (isset($this->request->cookie['tracking'])) {
                    $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);
                } else {
                    $marketing_info = null;
                }

                if ($marketing_info) {
                    $order_data['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $order_data['marketing_id'] = 0;
                }
            } else {
                $pdata['affiliate_id'] = 0;
                $pdata['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
            }

            $pdata['language_id'] = $this->config->get('config_language_id');
            $pdata['currency_id'] = $this->currency->getId();
            $pdata['currency_code'] = $this->currency->getCode();
            $pdata['currency_value'] = $this->currency->getValue($this->currency->getCode());
            $pdata['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {

                $pdata['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];

            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {

                $pdata['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];

            } else {

                $pdata['forwarded_ip'] = '';

            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {

                $pdata['user_agent'] = $this->request->server['HTTP_USER_AGENT'];

            } else {

                $pdata['user_agent'] = '';

            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {

                $pdata['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];

            } else {

                $pdata['accept_language'] = '';

            }
            $this->load->model('checkout/order');
            $this->load->model('supercheckout/order');
            $this->load->model('tool/image');
            if (!isset($this->session->data['order_id'])) {
                // Marketing
                $this->load->model('checkout/marketing');

                if (isset($this->request->cookie['tracking'])) {
                    $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);
                } else {
                    $marketing_info = null;
                }

                if ($marketing_info) {
                    $order_data['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $order_data['marketing_id'] = 0;
                }
                
                $this->session->data['order_id'] = $this->model_checkout_order->addOrder($pdata);
            } else {
                $this->model_supercheckout_order->editOrder($this->session->data['order_id'], $pdata);
            }

            $data['column_name'] = $this->language->get('column_name');
            $data['column_model'] = $this->language->get('column_model');
            $data['column_quantity'] = $this->language->get('column_quantity');
            $data['column_price'] = $this->language->get('column_price');
            $data['column_total'] = $this->language->get('column_total');

            $data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['option_value'];
                    } else {
                        $filename = $this->encryption->decrypt($option['option_value']);

                        $value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
                    }

                    $option_data[] = array(
                            'name' => $option['name'],
                            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }
                if (isset($data['settings']['step']['cart']['image_width']) && isset($data['settings']['step']['cart']['image_height'])) {
                    if ($product['image']) {

                        $image = $this->model_tool_image->resize($product['image'], $data['settings']['step']['cart']['image_width'], $data['settings']['step']['cart']['image_height']);

                    } else {

                        $image = '';

                    }
                } else {
                    if ($product['image']) {

                        $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));

                    } else {

                        $image = '';

                    }
                }
                $data['products'][] = array(
                        'key' => $product['key'],
                        'thumb' => $image,
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'subtract' => $product['subtract'],
                        'price' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
                        'total' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),
                        'href' => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                        'remove' => $this->url->link('supercheckout/supercheckout/cart', 'remove=' . $product['key'])
                );
            }

            // Gift Voucher
            $data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $data['vouchers'][] = array(
                            'description' => $voucher['description'],
                            'amount' => $this->currency->format($voucher['amount'])
                    );
                }
            }

            $data['totals'] = array();

            foreach ($total_data as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value']),
                    'code'  => $total['code']
                );
            }

            if (isset($this->session->data['payment_method']['code'])) {
                $data['payment_display'] = $this->load->controller('supercheckout/payment_display');
            }
        } else {
            $data['redirect'] = $redirect;
        }

        $data['text_checkout_option'] = $this->language->get('text_checkout_option');
        $data['text_checkout_account'] = $this->language->get('text_checkout_account');
        $data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
        $data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
        $data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
        $data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
        $data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');
        $data['text_modify'] = $this->language->get('text_modify');

        $data['logged'] = $this->customer->isLogged();
        $data['shipping_required'] = $this->cart->hasShipping();

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/supercheckout.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/supercheckout/supercheckout.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/supercheckout/supercheckout.tpl', $data));
        }

    }

    public function zoneDefault($country_id) {//for getting default zone
        $output = '<option value="">' . $this->language->get('text_select') . '</option>';

        $this->load->model('localisation/zone');

        $results = $this->model_localisation_zone->getZonesByCountryId($country_id);

        foreach ($results as $result) {
            $output .= '<option value="' . $result['zone_id'] . '"';

//            if (($this->config->get('config_zone_id') == $result['zone_id'])) {
//                $output .= ' selected="selected"';
//            }

            $output .= '>' . $result['name'] . '</option>';
        }

        if (!$results) {
            $output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
        }

        return $output;
    }

    // validate login

    public function loginValidate() {
        $this->language->load('supercheckout/supercheckout');

        $json = array();

        if ($this->customer->isLogged()) {

            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');

        }

        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {

            $json['redirect'] = $this->url->link('checkout/cart');

        }

        if (!$json) {

            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {

                $json['error']['warning'] = $this->language->get('error_login');

            }

            $this->load->model('account/customer');

            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

            if ($customer_info && !$customer_info['approved']) {

                $json['error']['warning'] = $this->language->get('error_approved');

            }
        }

        if (!$json) {
            unset($this->session->data['guest']);

            // Default Addresses
            $this->load->model('account/address');

            $address_info = $this->model_account_address->getAddress($this->customer->getAddressId());

            if ($address_info) {
                if ($this->config->get('config_tax_customer') == 'shipping') {
                    $this->session->data['shipping_country_id'] = $address_info['country_id'];
                    $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                    $this->session->data['shipping_postcode'] = $address_info['postcode'];
                }

                if ($this->config->get('config_tax_customer') == 'payment') {
                    $this->session->data['payment_country_id'] = $address_info['country_id'];
                    $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                }
            } else {
                unset($this->session->data['shipping_country_id']);
                unset($this->session->data['shipping_zone_id']);
                unset($this->session->data['shipping_postcode']);
                unset($this->session->data['payment_country_id']);
                unset($this->session->data['payment_zone_id']);
            }

            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');
        }

        $this->response->setOutput(json_encode($json));
    }
    public function validateEmailAndPassword() {
        //validating email
        $this->language->load('supercheckout/supercheckout');
        $json = array();
        if (!isset($this->request->post['email'])) {

            $json['error']['warning'] = $this->language->get('error_email');

        } elseif ((utf8_strlen(trim($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', trim($this->request->post['email']))) {

            $json['error']['warning'] = $this->language->get('error_email');

        }
        if(utf8_strlen(trim($this->request->post['password_register']))>3 && utf8_strlen(trim($this->request->post['password_register']))<32){
            if($this->request->post['password_register']!=$this->request->post['confirm_password']){
                $json['error']['mismatch'] = $this->language->get('error_confirm');
            }
        }else{
            $json['error']['password'] = $this->language->get('error_password');
        }
        $this->response->setOutput(json_encode($json));
    }
    public function country() { //loading countries for shipping and payment address
        $json = array();

        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);


        if ($country_info) {
            $this->load->model('localisation/zone');
            $json = array(
                    'country_id' => $country_info['country_id'],
                    'name' => $country_info['name'],
                    'iso_code_2' => $country_info['iso_code_2'],
                    'iso_code_3' => $country_info['iso_code_3'],
                    'address_format' => $country_info['address_format'],
                    'postcode_required' => $country_info['postcode_required'],
                    'zone' => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
                    'status' => $country_info['status']
            );
        }
//        var_dump($json['postcode_required']);
        $this->response->setOutput(json_encode($json));
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////  FUNCTIONS FOR FACEBOOK LOGIN///////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function validateEmail() {
        //validating email
        $this->language->load('supercheckout/supercheckout');
        $json = array();
        if (!isset($this->request->post['email'])) {

            $json['error']['warning'] = $this->language->get('error_email');

        } elseif ((utf8_strlen(trim($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', trim($this->request->post['email']))) {

            $json['error']['warning'] = $this->language->get('error_email');

        }
        $this->response->setOutput(json_encode($json));
    }

    public function checkUser() {   //check for registered users
        if (isset($this->session->data['customer_id'])) {
            echo "loggedin";
        } else {
            $email = $this->request->get['email'];
            $this->load->model('account/customer');
            $users = $this->model_account_customer->getCustomerByEmail($email);

            if (isset($users['customer_id'])) {
                echo'registered';
            } else {
                echo'notregistered';
            }
        }
    }

    public function doLogin() {// logging into store
        //for loging in the customer registered through facebook

        $email = $this->request->get['emailLogin'];
        $this->load->model('account/customer');
        $users = $this->model_account_customer->getCustomerByEmail($email);
        $this->session->data['customer_id'] = $users['customer_id'];
        $users_pass = $this->customer->login($email, '', true);

        $this->session->data['customer_id'] = $users['customer_id'];
        if ($users_pass == true) {

            echo "supercheckout"; //SETTING RESPONSE

        } else {

            echo "account"; //SETTING RESPONSE

        }
    }

    public function getvalue() {//for facebook registration
        $checkpoint_email = $this->request->request['useremail'];

        if ($checkpoint_email) {
            //for registring user to the store
            $user_table = array(
                    'firstname' => $this->request->request['firstname'],
                    'lastname' => $this->request->request['last_name'],
                    'email' => $this->request->request['useremail'],
                    'telephone' => '',
                    'fax' => '',
                    'password' => substr(md5(uniqid(rand(), true)), 0, 9),
                    'company' => '',
                    'company_id' => '',
                    'tax_id' => '',
                    'address_1' => '',
                    'address_2' => '',
                    'city' => '',
                    'postcode' => '',
                    'country_id' => '',
                    'zone_id' => '',
                    'customer_group_id' => 1,
                    'status' => 1,
                    'approved' => 1
            );

            $this->load->model('account/customer');
            $this->load->model('supercheckout/customer');
            $this->model_supercheckout_customer->addFacebookGoogleCustomer($user_table);
            $users = $this->model_account_customer->getCustomerByEmail($this->request->request['useremail']);
            $this->session->data['customer_id'] = $users['customer_id'];
            $users_pass = $this->customer->login($this->request->request['useremail'], '', true);

            $this->session->data['customer_id'] = $users['customer_id'];
            if ($users_pass == true) {

                echo "supercheckout";   //SETTING RESPONSE

            } else {

                echo "account"; //SETTING RESPONSE

            }
            die();
        } else {
            echo 'Something Went Wrong ! :(';
        }
    }

    public function cart() { //for cart actions
        //updating quantity
        if (!empty($this->request->post['quantity'])) {

            foreach ($this->request->post['quantity'] as $key => $value) {

                $this->cart->update($key, $value);

            }
        }

        // Remove product
        if (isset($this->request->post['remove'])) {

            $this->cart->remove($this->request->post['remove']);

            unset($this->session->data['vouchers'][$this->request->post['remove']]);

//            $this->session->data['success'] = $this->language->get('text_remove');
        }
        if(!$this->cart->hasProducts()){
            
        }
    }

    public function validateVoucher() { //validating voucher
        $this->load->model('checkout/voucher');
        $this->language->load('supercheckout/supercheckout');
        $json = array();

        if (!isset($this->session->data['voucher'])) {

            $voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);
            $this->session->data['voucher_id'] = $voucher_info['voucher_id'];
            if ($voucher_info) {

                $this->session->data['voucher'] = $this->request->post['voucher'];
//                $this->session->data['success'] = $this->language->get('text_voucher_success');

            } else {

                $json['warning'] = $this->language->get('error_voucher');

            }
        } else {

            $json['warning'] = $this->language->get('error_voucher_used');

        }

        $this->response->setOutput(json_encode($json));
    }

    public function redeem() { //for redeem amount from coupons and vouchers
        if (isset($this->request->post['redeem'])) {
            $value = $this->request->post['redeem'];
            if ($value == 'voucher') {

                unset($this->session->data['voucher']);

            } elseif ($value == 'coupon') {

                unset($this->session->data['coupon']);

            }
        }
    }

    public function validateCoupon() { //validating and applying coupons

        $this->load->model('checkout/coupon');
        $this->language->load('supercheckout/supercheckout');
        $json = array();

        if (!isset($this->session->data['coupon'])) {

            $coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);
            if ($coupon_info) {

                $this->session->data['coupon'] = $this->request->post['coupon'];
//                $this->session->data['success'] = $this->language->get('text_coupon_success');

            } else {

                $json['warning'] = $this->language->get('error_coupon');
            }
        } else {

            $json['warning'] = $this->language->get('error_coupon_used');

        }

        $this->response->setOutput(json_encode($json));
    }

    public function guestShippingAddressValidate() { //for validating guest shipping address

        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];
        $json = array();

        // Validate if customer is logged in.
        if ($this->customer->isLogged()) {

            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');

        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {

            $json['redirect'] = $this->url->link('checkout/cart');

        }

        if (!$json) {
            if ($this->settings['option']['guest']['shipping_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {
                $json['error']['firstname'] = $this->language->get('error_firstname');
            }

            if ($this->settings['option']['guest']['shipping_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {
                $json['error']['lastname'] = $this->language->get('error_lastname');
            }

            if ($this->settings['option']['guest']['shipping_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                $json['error']['address_1'] = $this->language->get('error_address_1');
            }
            if ($this->settings['option']['guest']['shipping_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                $json['error']['address_2'] = $this->language->get('error_address_2');
            }

            if ($this->settings['option']['guest']['shipping_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128) ) {
                $json['error']['city'] = $this->language->get('error_city');
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info && ($this->settings['option']['guest']['shipping_address']['fields']['postcode']['require'] && $country_info['postcode_required']) && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                $json['error']['postcode'] = $this->language->get('error_postcode');
            }

            if ($this->settings['option']['guest']['shipping_address']['fields']['country_id']['require'] && $this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('error_country');
            }

            if ($this->settings['option']['guest']['shipping_address']['fields']['zone_id']['require'] &&  $this->request->post['zone_id'] == '') {
                $json['error']['zone'] = $this->language->get('error_zone');
            }
        }

        if (!$json) {
            if(isset($this->request->post['firstname'])) {
                $this->session->data['guest']['shipping']['firstname'] = trim($this->request->post['firstname']);
            }else {
                $this->session->data['guest']['shipping']['firstname'] = "";
            }
            if(isset($this->request->post['lastname'])) {
                $this->session->data['guest']['shipping']['lastname'] = trim($this->request->post['lastname']);
            }else {
                $this->session->data['guest']['shipping']['lastname'] = "";
            }
            if(isset($this->request->post['company'])) {
                $this->session->data['guest']['shipping']['company'] = trim($this->request->post['company']);
            }else {
                $this->session->data['guest']['shipping']['company'] = "";
            }
            if(isset($this->request->post['address_1'])) {
                $this->session->data['guest']['shipping']['address_1'] = trim($this->request->post['address_1']);
            }else {
                $this->session->data['guest']['shipping']['address_1'] = "";
            }
            if(isset($this->request->post['address_2'])) {
                $this->session->data['guest']['shipping']['address_2'] = trim($this->request->post['address_2']);
            }else {
                $this->session->data['guest']['shipping']['address_2'] = "";
            }
            if(isset($this->request->post['postcode'])) {
                $this->session->data['guest']['shipping']['postcode'] = trim($this->request->post['postcode']);
            }else {
                $this->session->data['guest']['shipping']['postcode'] = "";
            }
            if(isset($this->request->post['city'])) {
                $this->session->data['guest']['shipping']['city'] = trim($this->request->post['city']);
            }else {
                $this->session->data['guest']['shipping']['city'] = "";
            }
            if(isset($this->request->post['country_id'])) {
                $this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
            }else {
                $this->session->data['guest']['shipping']['country_id'] = "";
            }
            if(isset($this->request->post['zone_id'])) {
                $this->session->data['guest']['shipping']['zone_id'] = $this->request->post['zone_id'];
            }else {
                $this->session->data['guest']['shipping']['zone_id'] = "";
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {
                $this->session->data['guest']['shipping']['country'] = $country_info['name'];
                $this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
            } else {
                $this->session->data['guest']['shipping']['country'] = '';
                $this->session->data['guest']['shipping']['iso_code_2'] = '';
                $this->session->data['guest']['shipping']['iso_code_3'] = '';
                $this->session->data['guest']['shipping']['address_format'] = '';
            }

            $this->load->model('localisation/zone');

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {
                $this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
                $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
            } else {
                $this->session->data['guest']['shipping']['zone'] = '';
                $this->session->data['guest']['shipping']['zone_code'] = '';
            }

            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
        }

        $this->response->setOutput(json_encode($json));
    }

    public function loginShippingAddressValidate() { //for validating shipping address for logged in customer

        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];

        $json = array();

        // Validate if customer is logged in.
        if (!$this->customer->isLogged()) {
            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');
        }

        // Validate if shipping is required. If not the customer should not have reached this page.
        if (!$this->cart->hasShipping()) {
            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');
        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $json['redirect'] = $this->url->link('checkout/cart');

                break;
            }
        }

        if (!$json) {
            if (isset($this->request->post['shipping_address'])) {
                if ($this->request->post['shipping_address'] == 'existing') {
                    $this->load->model('account/address');

                    if (empty($this->request->post['address_id'])) {

                        $json['error']['warning'] = $this->language->get('error_address');

                    } elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {

                        $json['error']['warning'] = $this->language->get('error_address');

                    }

                    if (!$json) {
                        $this->session->data['shipping_address_id'] = $this->request->post['address_id'];

                        // Default Shipping Address
                        $this->load->model('account/address');

                        $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);
                        if (!isset($address_info['address_1']) || $address_info['address_1'] == "") {

                            $json['error']['warning'] = $this->language->get('error_address_fb_google');

                        }
                        if ($address_info) {

                            $this->session->data['shipping_country_id'] = $address_info['country_id'];
                            $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                            $this->session->data['shipping_postcode'] = $address_info['postcode'];

                        } else {

                            unset($this->session->data['shipping_country_id']);
                            unset($this->session->data['shipping_zone_id']);
                            unset($this->session->data['shipping_postcode']);

                        }
                    }
                } else {
                    if ($this->settings['option']['logged']['shipping_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {
                        $json['error']['firstname'] = $this->language->get('error_firstname');
                    }

                    if ($this->settings['option']['logged']['shipping_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {
                        $json['error']['lastname'] = $this->language->get('error_lastname');
                    }

                    if ($this->settings['option']['logged']['shipping_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                        $json['error']['address_1'] = $this->language->get('error_address_1');
                    }
                    if ($this->settings['option']['logged']['shipping_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                        $json['error']['address_2'] = $this->language->get('error_address_2');
                    }
                    if ($this->settings['option']['logged']['shipping_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128) ) {
                        $json['error']['city'] = $this->language->get('error_city');
                    }

                    $this->load->model('localisation/country');

                    $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

                    if ($country_info && ($this->settings['option']['logged']['shipping_address']['fields']['postcode']['require'] && $country_info['postcode_required']) && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                        $json['error']['postcode'] = $this->language->get('error_postcode');
                    }

                    if ($this->settings['option']['logged']['shipping_address']['fields']['country_id']['require'] && $this->request->post['country_id'] == '') {
                        $json['error']['country'] = $this->language->get('error_country');
                    }

                    if ($this->settings['option']['logged']['shipping_address']['fields']['zone_id']['require'] && $this->request->post['zone_id'] == '') {
                        $json['error']['zone'] = $this->language->get('error_zone');
                    }

                    if (!$json) {
                        // Default Shipping Address
                        $pdata = array();
                        if (isset($this->request->post['firstname'])) {
                            $pdata['firstname'] = trim($this->request->post['firstname']);
                        } else {
                            $pdata['firstname'] = "";
                        }
                        if (isset($this->request->post['lastname'])) {
                            $pdata['lastname'] = trim($this->request->post['lastname']);
                        } else {
                            $pdata['lastname'] = "";
                        }
                        if (isset($this->request->post['company'])) {
                            $pdata['company'] = trim($this->request->post['company']);
                        } else {
                            $pdata['company'] = "";
                        }
                        if (isset($this->request->post['address_1'])) {
                            $pdata['address_1'] = trim($this->request->post['address_1']);
                        } else {
                            $pdata['address_1'] = "";
                        }
                        if (isset($this->request->post['address_2'])) {
                            $pdata['address_2'] = trim($this->request->post['address_2']);
                        } else {
                            $pdata['address_2'] = "";
                        }
                        if (isset($this->request->post['tax_id'])) {
                            $pdata['tax_id'] = trim($this->request->post['tax_id']);
                        } else {
                            $pdata['tax_id'] = "";
                        }
                        if (isset($this->request->post['postcode'])) {
                            $pdata['postcode'] = trim($this->request->post['postcode']);
                        } else {
                            $pdata['postcode'] = "";
                        }
                        if (isset($this->request->post['city'])) {
                            $pdata['city'] = trim($this->request->post['city']);
                        } else {
                            $pdata['city'] = "";
                        }
                        if (isset($this->request->post['zone_id'])) {
                            $pdata['zone_id'] = $this->request->post['zone_id'];
                        } else {
                            $pdata['zone_id'] = "";
                        }
                        if (isset($this->request->post['country_id'])) {
                            $pdata['country_id'] = $this->request->post['country_id'];
                        } else {
                            $pdata['country_id'] = "";
                        }
                        $this->load->model('account/address');

                        //edits address if session is set else add new address
                        if (isset($this->session->data['set_add_shipping_address_check'])) {

                            $this->model_account_address->editAddress($this->session->data['shipping_address_id'], $pdata);

                        } else {

                            $this->session->data['shipping_address_id'] = $this->model_account_address->addAddress($pdata);
                            $this->session->data['set_add_shipping_address_check']=$this->session->data['shipping_address_id'];

                        }

                        $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                        $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                        $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                    }
                }
            } else {

                if ($this->settings['option']['logged']['shipping_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {
                    $json['error']['firstname'] = $this->language->get('error_firstname');
                }

                if ($this->settings['option']['logged']['shipping_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {
                    $json['error']['lastname'] = $this->language->get('error_lastname');
                }

                if ($this->settings['option']['logged']['shipping_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                    $json['error']['address_1'] = $this->language->get('error_address_1');
                }
                if ($this->settings['option']['logged']['shipping_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                    $json['error']['address_2'] = $this->language->get('error_address_2');
                }
                if ($this->settings['option']['logged']['shipping_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city']) < 2)) || (utf8_strlen(trim($this->request->post['city'])) > 128) ) {
                    $json['error']['city'] = $this->language->get('error_city');
                }

                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

                if ($country_info && ($this->settings['option']['logged']['shipping_address']['fields']['postcode']['require'] && $country_info['postcode_required']) && (utf8_strlen(trim($this->request->post['postcode']) < 2)) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                    $json['error']['postcode'] = $this->language->get('error_postcode');
                }

                if ($this->settings['option']['logged']['shipping_address']['fields']['country_id']['require'] && $this->request->post['country_id'] == '') {
                    $json['error']['country'] = $this->language->get('error_country');
                }

                if ($this->settings['option']['logged']['shipping_address']['fields']['zone_id']['require'] && $this->request->post['zone_id'] == '') {
                    $json['error']['zone'] = $this->language->get('error_zone');
                }

                if (!$json) {
                    // Default Shipping Address
                    $pdata = array();
                    if (isset($this->request->post['firstname'])) {
                        $pdata['firstname'] = trim($this->request->post['firstname']);
                    } else {
                        $pdata['firstname'] = "";
                    }
                    if (isset($this->request->post['lastname'])) {
                        $pdata['lastname'] = trim($this->request->post['lastname']);
                    } else {
                        $pdata['lastname'] = "";
                    }
                    if (isset($this->request->post['company'])) {
                        $pdata['company'] = trim($this->request->post['company']);
                    } else {
                        $pdata['company'] = "";
                    }
                    if (isset($this->request->post['address_1'])) {
                        $pdata['address_1'] = trim($this->request->post['address_1']);
                    } else {
                        $pdata['address_1'] = "";
                    }
                    if (isset($this->request->post['address_2'])) {
                        $pdata['address_2'] = trim($this->request->post['address_2']);
                    } else {
                        $pdata['address_2'] = "";
                    }
                    if (isset($this->request->post['tax_id'])) {
                        $pdata['tax_id'] = trim($this->request->post['tax_id']);
                    } else {
                        $pdata['tax_id'] = "";
                    }
                    if (isset($this->request->post['postcode'])) {
                        $pdata['postcode'] = trim($this->request->post['postcode']);
                    } else {
                        $pdata['postcode'] = "";
                    }
                    if (isset($this->request->post['city'])) {
                        $pdata['city'] = trim($this->request->post['city']);
                    } else {
                        $pdata['city'] = "";
                    }
                    if (isset($this->request->post['zone_id'])) {
                        $pdata['zone_id'] = $this->request->post['zone_id'];
                    } else {
                        $pdata['zone_id'] = "";
                    }
                    if (isset($this->request->post['country_id'])) {
                        $pdata['country_id'] = $this->request->post['country_id'];
                    } else {
                        $pdata['country_id'] = "";
                    }
                    $this->load->model('account/address');
                    if (isset($this->session->data['set_add_shipping_address_check'])) {
                        $this->model_account_address->editAddress($this->session->data['shipping_address_id'], $pdata);
                    } else {
                        $this->session->data['shipping_address_id'] = $this->model_account_address->addAddress($pdata);
                        $this->session->data['set_add_shipping_address_check']=$this->session->data['shipping_address_id'];
                    }
                    $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                    $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                    $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                }
            }
        }


        $this->response->setOutput(json_encode($json));
    }

    public function loginPaymentAddressValidate() { //for validating payment address for logged in user

        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];

        $json = array();

        // Validate if customer is logged in.
        if (!$this->customer->isLogged()) {

        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Validate minimum quantity requirments.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $json['redirect'] = $this->url->link('checkout/cart');

                break;
            }
        }

        if (!$json) {
            if (isset($this->request->post['payment_address']) && $this->request->post['payment_address'] == 'existing') {
                $this->load->model('account/address');

                if (empty($this->request->post['address_id'])) {
                    $json['error']['warning'] = $this->language->get('error_address');
                } elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
                    $json['error']['warning'] = $this->language->get('error_address');
                } else {
                    // Default Payment Address
                    $this->load->model('account/address');

                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);

                    if ($address_info) {
                        $this->load->model('account/customer_group');

                        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());

                        // Company ID
                        if (isset($customer_group_info['company_id_display']) && $this->settings['option']['logged']['payment_address']['fields']['company_id']['require'] && $customer_group_info['company_id_required'] && !$address_info['company_id']) {
                            $json['error']['warning'] = $this->language->get('error_company_id');
                        }

                        // Tax ID
                        if (isset($customer_group_info['tax_id_display']) && $this->settings['option']['logged']['payment_address']['fields']['tax_id']['require'] && $customer_group_info['tax_id_required'] && !$address_info['tax_id']) {
                            $json['error']['warning'] = $this->language->get('error_tax_id');
                        }
                        //Facebook and Google Registered
                        if (!isset($address_info['address_1']) || $address_info['address_1'] == "") {

                            $json['error']['warning'] = $this->language->get('error_address_fb_google');
                        }
                    }
                }

                if (!$json) {
                    $this->session->data['payment_address_id'] = $this->request->post['address_id'];

                    if ($address_info) {

                        $this->session->data['payment_country_id'] = $address_info['country_id'];
                        $this->session->data['payment_zone_id'] = $address_info['zone_id'];

                    } else {

                        unset($this->session->data['payment_country_id']);
                        unset($this->session->data['payment_zone_id']);

                    }
                }
            } else {
                if ($this->settings['option']['logged']['payment_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {
                    $json['error']['firstname'] = $this->language->get('error_firstname');
                }

                if ($this->settings['option']['logged']['payment_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {
                    $json['error']['lastname'] = $this->language->get('error_lastname');
                }
                if ($this->settings['option']['logged']['payment_address']['fields']['telephone']['require'] && (utf8_strlen(trim($this->request->post['telephone'])) < 1) || (utf8_strlen(trim($this->request->post['telephone'])) > 32) || preg_match('/[^0-9+-, ]+/i', $this->request->post['telephone'])) {
                    $json['error']['telephone'] = $this->language->get('error_telephone');
                }

                // Customer Group
                $this->load->model('account/customer_group');

                $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());

                if ($customer_group_info) {
                    // Company
                    if (($this->settings['option']['logged']['payment_address']['fields']['company']['require']) && (utf8_strlen(trim($this->request->post['company'])) < 3) || (utf8_strlen(trim($this->request->post['company'])) > 32)  ) {
                        $json['error']['company'] = $this->language->get('error_company');
                    }

                    // Company ID
                    if (($this->settings['option']['logged']['payment_address']['fields']['company_id']['require'])&& (utf8_strlen(trim($this->request->post['company_id'])) < 3) || (utf8_strlen(trim($this->request->post['company_id'])) > 32) ) {
                        $json['error']['company_id'] = $this->language->get('error_company_id');
                    }

                    // Tax ID
                    if (($this->settings['option']['logged']['payment_address']['fields']['tax_id']['require']) && (utf8_strlen(trim($this->request->post['tax_id'])) < 3) || (utf8_strlen(trim($this->request->post['tax_id'])) > 32) ) {
                        $json['error']['tax_id'] = $this->language->get('error_tax_id');
                    }
                }

                if ($this->settings['option']['logged']['payment_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                    $json['error']['address_1'] = $this->language->get('error_address_1');
                }
                if ($this->settings['option']['logged']['payment_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                    $json['error']['address_2'] = $this->language->get('error_address_2');
                }
                if ($this->settings['option']['logged']['payment_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 32) ) {
                    $json['error']['city'] = $this->language->get('error_city');
                }

                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

                if ($country_info) {
                    if (($this->settings['option']['logged']['payment_address']['fields']['postcode']['require'] && $country_info['postcode_required']) && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                        $json['error']['postcode'] = $this->language->get('error_postcode');
                    }

                    // VAT Validation
                    $this->load->helper('vat');

                    if ($this->config->get('config_vat') && !empty($this->request->post['tax_id']) && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                        $json['error']['tax_id'] = $this->language->get('error_vat');
                    }
                }

                if ($this->settings['option']['logged']['payment_address']['fields']['country_id']['require'] && $this->request->post['country_id'] == '') {

                    $json['error']['country'] = $this->language->get('error_country');
                }

                if ($this->settings['option']['logged']['payment_address']['fields']['zone_id']['require'] && (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '')) {
                    $json['error']['zone'] = $this->language->get('error_zone');
                }

                if (!$json) {
                    $pdata = array();
                    if (isset($this->request->post['firstname'])) {
                        $pdata['firstname'] = trim($this->request->post['firstname']);
                    } else {
                        $pdata['firstname'] = "";
                    }
                    if (isset($this->request->post['lastname'])) {
                        $pdata['lastname'] = trim($this->request->post['lastname']);
                    } else {
                        $pdata['lastname'] = "";
                    }
                    if (isset($this->request->post['telephone'])) {
                        $pdata['telephone'] = trim($this->request->post['telephone']);
                    } else {
                        $pdata['telephone'] = "";
                    }
                    if (isset($this->request->post['company'])) {
                        $pdata['company'] = trim($this->request->post['company']);
                    } else {
                        $pdata['company'] = "";
                    }
                    if (isset($this->request->post['address_1'])) {
                        $pdata['address_1'] = trim($this->request->post['address_1']);
                    } else {
                        $pdata['address_1'] = "";
                    }
                    if (isset($this->request->post['address_2'])) {
                        $pdata['address_2'] = trim($this->request->post['address_2']);
                    } else {
                        $pdata['address_2'] = "";
                    }
                    if (isset($this->request->post['tax_id'])) {
                        $pdata['tax_id'] = trim($this->request->post['tax_id']);
                    } else {
                        $pdata['tax_id'] = "";
                    }
                    if (isset($this->request->post['postcode'])) {
                        $pdata['postcode'] = trim($this->request->post['postcode']);
                    } else {
                        $pdata['postcode'] = "";
                    }
                    if (isset($this->request->post['city'])) {
                        $pdata['city'] = trim($this->request->post['city']);
                    } else {
                        $pdata['city'] = "";
                    }
                    if (isset($this->request->post['zone_id'])) {
                        $pdata['zone_id'] = $this->request->post['zone_id'];
                    } else {
                        $pdata['zone_id'] = "";
                    }
                    if (isset($this->request->post['country_id'])) {
                        $pdata['country_id'] = $this->request->post['country_id'];
                    } else {
                        $pdata['country_id'] = "";
                    }
                    $this->load->model('account/address');
                    if(isset($this->session->data['set_add_payment_address_check'])) {
                        $this->model_account_address->editAddress($this->session->data['set_add_payment_address_check'],$pdata);
                    }else {
                        $this->session->data['payment_address_id'] = $this->model_account_address->addAddress($pdata);
                        $this->session->data['set_add_payment_address_check']=$this->session->data['payment_address_id'];
                    }

                    $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                    $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
                }
            }
        }
        if (isset($this->request->post['use_for_shipping'])) {

            $this->session->data['use_for_shipping'] = true;

            if(isset($this->session->data['payment_address_id'])) {

                $this->session->data['shipping_address_id']=$this->session->data['payment_address_id'];

            }elseif(isset($this->session->data['payment_country_id'])) {

                $this->session->data['shipping_country_id']=$this->session->data['payment_country_id'];

            }

        } else {
            unset($this->session->data['use_for_shipping']);
        }

        $this->response->setOutput(json_encode($json));
    }

    public function guestPaymentAddressValidate() { //for validation billing/ shippng addres for guest
        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];
        $json = array();

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $json['redirect'] = $this->url->link('checkout/cart');
        }

        // Check if guest checkout is avaliable.

        if (!$json) {

            if ($this->settings['option']['guest']['payment_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {
                $json['error']['firstname'] = $this->language->get('error_firstname');
            }

            if ($this->settings['option']['guest']['payment_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {
                $json['error']['lastname'] = $this->language->get('error_lastname');
            }
            if ($this->settings['option']['guest']['payment_address']['fields']['telephone']['require'] && (utf8_strlen(trim($this->request->post['telephone'])) < 1) || (utf8_strlen(trim($this->request->post['telephone'])) > 32) || preg_match('/[^0-9+-, ]+/i', $this->request->post['telephone'])) {
                $json['error']['telephone'] = $this->language->get('error_telephone');
            }
            // Customer Group
            $this->load->model('account/customer_group');

            if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                $customer_group_id = $this->request->post['customer_group_id'];
            } else {
                $customer_group_id = $this->config->get('config_customer_group_id');
            }

            $customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

            if ($customer_group) {
                if (($this->settings['option']['guest']['payment_address']['fields']['company']['require']) && (utf8_strlen(trim($this->request->post['company'])) < 3) || (utf8_strlen(trim($this->request->post['company'])) > 32)  ) {
                    $json['error']['company'] = $this->language->get('error_company');
                }

                // Company ID
                if (($this->settings['option']['guest']['payment_address']['fields']['company_id']['require'])&& (utf8_strlen(trim($this->request->post['company_id'])) < 3) || (utf8_strlen(trim($this->request->post['company_id'])) > 32) ) {
                    $json['error']['company_id'] = $this->language->get('error_company_id');
                }

                // Tax ID
                if (($this->settings['option']['guest']['payment_address']['fields']['tax_id']['require']) && (utf8_strlen(trim($this->request->post['tax_id'])) < 3) || (utf8_strlen(trim($this->request->post['tax_id'])) > 32) ) {
                    $json['error']['tax_id'] = $this->language->get('error_tax_id');
                }

            }

            if ($this->settings['option']['guest']['payment_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                $json['error']['address_1'] = $this->language->get('error_address_1');
            }
            if ($this->settings['option']['guest']['payment_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                $json['error']['address_2'] = $this->language->get('error_address_2');
            }
            if ($this->settings['option']['guest']['payment_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128) ) {
                $json['error']['city'] = $this->language->get('error_city');
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {
                if (($this->settings['option']['guest']['payment_address']['fields']['postcode']['require'] && $country_info['postcode_required']) && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                    $json['error']['postcode'] = $this->language->get('error_postcode');
                }

                // VAT Validation
                $this->load->helper('vat');

                if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                    $json['error']['tax_id'] = $this->language->get('error_vat');
                }
            }

            if ($this->settings['option']['guest']['payment_address']['fields']['country_id']['require'] && $this->request->post['country_id'] == '') {
                $json['error']['country'] = $this->language->get('error_country');
            }

            if ($this->settings['option']['guest']['payment_address']['fields']['zone_id']['require'] && (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '')) {
                $json['error']['zone'] = $this->language->get('error_zone');
            }
        }

        if (!$json) {
            $this->session->data['guest']['customer_group_id'] = $customer_group_id;
            $this->session->data['guest']['firstname'] = isset($this->request->post['firstname'])?$this->request->post['firstname']:"";
            $this->session->data['guest']['lastname'] = isset($this->request->post['lastname'])?$this->request->post['lastname']:"";
            $this->session->data['guest']['email'] = isset($this->request->post['email'])?$this->request->post['email']:"";
            $this->session->data['guest']['telephone'] = isset($this->request->post['telephone'])?$this->request->post['telephone']:"";
            $this->session->data['guest']['fax'] = "";
            if (isset($this->request->post['firstname'])) {
                $this->session->data['guest']['payment']['firstname'] = $this->request->post['firstname'];
            }
            if (isset($this->request->post['lastname'])) {
                $this->session->data['guest']['payment']['lastname'] = $this->request->post['lastname'];
            }
            if (isset($this->request->post['telephone'])) {
                $this->session->data['guest']['telephone'] = $this->request->post['telephone'];
            }
            if (isset($this->request->post['company'])) {
                $this->session->data['guest']['payment']['company'] = $this->request->post['company'];
            }
            if (isset($this->request->post['company_id'])) {
                $this->session->data['guest']['payment']['company_id'] = $this->request->post['company_id'];
            }
            if (isset($this->request->post['tax_id'])) {
                $this->session->data['guest']['payment']['tax_id'] = $this->request->post['tax_id'];
            }
            if (isset($this->request->post['address_1'])) {
                $this->session->data['guest']['payment']['address_1'] = $this->request->post['address_1'];
            }
            if (isset($this->request->post['address_2'])) {
                $this->session->data['guest']['payment']['address_2'] = $this->request->post['address_2'];
            }
            if (isset($this->request->post['postcode'])) {
                $this->session->data['guest']['payment']['postcode'] = $this->request->post['postcode'];
            }
            if (isset($this->request->post['city'])) {
                $this->session->data['guest']['payment']['city'] = $this->request->post['city'];
            }
            if (isset($this->request->post['country_id'])) {
                $this->session->data['guest']['payment'][''] = $this->request->post['country_id'];
            }
            if (isset($this->request->post['zone_id'])) {
                $this->session->data['guest']['payment']['zone_id'] = $this->request->post['zone_id'];
            }

            $this->load->model('localisation/country');

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {

                $this->session->data['guest']['payment']['country'] = $country_info['name'];
                $this->session->data['guest']['payment']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['payment']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];

            } else {

                $this->session->data['guest']['payment']['country'] = '';
                $this->session->data['guest']['payment']['iso_code_2'] = '';
                $this->session->data['guest']['payment']['iso_code_3'] = '';
                $this->session->data['guest']['payment']['address_format'] = '';

            }

            $this->load->model('localisation/zone');

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {

                $this->session->data['guest']['payment']['zone'] = $zone_info['name'];
                $this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];

            } else {

                $this->session->data['guest']['payment']['zone'] = '';
                $this->session->data['guest']['payment']['zone_code'] = '';

            }

            if (!empty($this->request->post['shipping_address'])) {

                $this->session->data['guest']['shipping_address'] = true;

            } else {

                $this->session->data['guest']['shipping_address'] = false;

            }

            // Default Payment Address
            $this->session->data['payment_country_id'] = $this->request->post['country_id'];
            $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];

            if ($this->session->data['guest']['shipping_address']) {

                $this->session->data['guest']['shipping']['firstname'] = $this->request->post['firstname'];
                $this->session->data['guest']['shipping']['lastname'] = $this->request->post['lastname'];
                $this->session->data['guest']['shipping']['company'] = $this->request->post['company'];
                $this->session->data['guest']['shipping']['address_1'] = $this->request->post['address_1'];
                $this->session->data['guest']['shipping']['address_2'] = $this->request->post['address_2'];
                $this->session->data['guest']['shipping']['postcode'] = $this->request->post['postcode'];
                $this->session->data['guest']['shipping']['city'] = $this->request->post['city'];
                $this->session->data['guest']['shipping']['country_id'] = $this->request->post['country_id'];
                $this->session->data['guest']['shipping']['zone_id'] = $this->request->post['zone_id'];

                if ($country_info) {
                    $this->session->data['guest']['shipping']['country'] = $country_info['name'];
                    $this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                    $this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                    $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                } else {
                    $this->session->data['guest']['shipping']['country'] = '';
                    $this->session->data['guest']['shipping']['iso_code_2'] = '';
                    $this->session->data['guest']['shipping']['iso_code_3'] = '';
                    $this->session->data['guest']['shipping']['address_format'] = '';
                }

                if ($zone_info) {
                    $this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
                    $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
                } else {
                    $this->session->data['guest']['shipping']['zone'] = '';
                    $this->session->data['guest']['shipping']['zone_code'] = '';
                }

                // Default Shipping Address
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
            }

            $this->session->data['account'] = 'guest';
            if (isset($this->session->data['guest']['payment_address'])) {

                $this->session->data['guest']['shipping_address'] = $this->session->data['guest']['payment_address'];

            }
        }
        if (isset($this->request->post['use_for_shipping'])) {

            $this->session->data['use_for_shipping'] = true;

            if(isset($this->session->data['payment_country_id'])) {
                $this->session->data['shipping_country_id']=$this->session->data['payment_country_id'];
            }
        } else {
            unset($this->session->data['use_for_shipping']);
        }
        $this->response->setOutput(json_encode($json));
    }

    public function createGuestAccount() { //for creating guest account
        $this->language->load('supercheckout/supercheckout');
        $json = array();
        if(isset($this->request->get['use_password'])&& $this->request->get['use_password']==1){
            $password=$this->request->post['password_register'];
        }else{
            //setting random password
            $password = substr(sha1(uniqid(mt_rand(), true)), 0, 10);
        }

        //setting value of user information
        $user_table = array(
                'firstname' => isset($this->session->data['guest']['payment']['firstname'])?$this->session->data['guest']['payment']['firstname']:"",
                'lastname' => isset($this->session->data['guest']['payment']['lastname'])?$this->session->data['guest']['payment']['lastname']:"",
                'email' => $this->request->post['email'],
                'telephone' => isset($this->session->data['guest']['telephone'])?$this->session->data['guest']['telephone']:"",
                'fax' => isset($this->session->data['guest']['payment']['fax'])?$this->session->data['guest']['payment']['fax']:"",
                'password' => $password,
                'company' => isset($this->session->data['guest']['payment']['company'])?$this->session->data['guest']['payment']['company']:"",
                'company_id' =>isset( $this->session->data['guest']['payment']['company_id'])?$this->session->data['guest']['payment']['company_id']:"",
                'tax_id' => isset($this->session->data['guest']['payment']['tax_id'])?$this->session->data['guest']['payment']['tax_id']:"",
                'address_1' =>isset($this->session->data['guest']['payment']['address_1'])?$this->session->data['guest']['payment']['address_1']:"",
                'address_2' => isset($this->session->data['guest']['payment']['address_2'])?$this->session->data['guest']['payment']['address_2']:"",
                'city' => isset($this->session->data['guest']['payment']['city'])?$this->session->data['guest']['payment']['city']:"",
                'postcode' => isset($this->session->data['guest']['payment']['postcode'])?$this->session->data['guest']['payment']['postcode']:"",
                'country_id' =>isset( $this->session->data['guest']['payment']['country_id'])?$this->session->data['guest']['payment']['country_id']:"",
                'zone_id' => isset($this->session->data['guest']['payment']['zone_id'])?$this->session->data['guest']['payment']['zone_id']:"",
                'customer_group_id' => 1,
                'status' => 1,
                'approved' => 1
        );

        $this->load->model('supercheckout/customer');
        $users_check = $this->model_supercheckout_customer->getCustomerByEmail($this->request->post['email']);
        if (empty($users_check)) {
            $this->session->data['account_created']=1;
            $customer_id = $this->model_supercheckout_customer->addGuestAsCustomer($user_table);
            

        } else {
            $customer_id = $users_check['customer_id'];
            if(!isset($this->session->data['account_created'])){
                
                if(isset($this->request->get['use_password'])){
                    $json['error']['warning'] = $this->language->get('error_already_exists');
                }
            }

        }
        if (isset($customer_id)) {

            $this->load->model('supercheckout/order');
            $pdata =array();
            $pdata['customer_id'] = $customer_id;
            $this->session->data['guestAccount_customer_id']=$customer_id;
            $this->model_supercheckout_order->editCustomerId($this->session->data['order_id'], $pdata);

        }
        $this->response->setOutput(json_encode($json));
    }

    public function validateAgree() { //for validating agree to the terms in confirm section

        //loading setting from database or from default settings for supercheckout plugin
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];
        //$data['settings'] = $result['supercheckout'];

        /*if (empty($data['settings'])) {

            $settings = $this->model_setting_setting->getSetting('default_supercheckout', 0);            
            $data['settings'] = $settings['default_supercheckout'];
            $data['supercheckout']=$settings['default_supercheckout'];

        }*/
        $this->language->load('supercheckout/supercheckout');


        $json = array();
        if ($this->config->get('config_checkout_id')) {
            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));
            if ($this->customer->isLogged()) {

                if ($data['settings']['option']['logged']['confirm']['fields']['agree']['require']) {

                    if ($information_info && !isset($this->request->post['agree'])) {

                        $json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);

                    }

                }

            } else {
                if ($data['settings']['option']['guest']['confirm']['fields']['agree']['require']) {

                    if ($information_info && !isset($this->request->post['agree'])) {

                        $json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);

                    }
                }
            }


            $this->response->setOutput(json_encode($json));
        }
    }

    public function setCommentSession() { //setting comment session for comment in confirm section
        $json= array();
        if (isset($this->request->post['comment'])) {

            $this->session->data['comment'] = $this->request->post['comment'];
        } else {

            $this->session->data['comment'] = "";
        }
    }
    public function setValueForGuestPayment() { //for setting values for guest payment address for checkout
        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];
        $json = array();



        $this->load->model('localisation/country');
        if (isset($this->request->post['country_id'])) {
            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {

                $this->session->data['guest']['payment']['country'] = $country_info['name'];
                $this->session->data['guest']['payment']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['payment']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['payment']['address_format'] = $country_info['address_format'];
                $this->session->data['guest']['payment']['country_id'] = $country_info['country_id'];
            } else {

                $this->session->data['guest']['payment']['country'] = '';
                $this->session->data['guest']['payment']['iso_code_2'] = '';
                $this->session->data['guest']['payment']['iso_code_3'] = '';
                $this->session->data['guest']['payment']['address_format'] = '';
                $this->session->data['guest']['payment']['country_id'] = '';
            }
            $this->session->data['payment_country_id'] = $this->request->post['country_id'];

            //for setting use of shipping
            if (isset($this->request->post['use_for_shipping'])) {

                $this->session->data['use_for_shipping'] = true;

                if (isset($this->session->data['payment_country_id'])) {

                    $this->session->data['shipping_country_id'] = $this->session->data['payment_country_id'];
                    $this->session->data['guest']['shipping']['country'] = $country_info['name'];
                    $this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                    $this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                    $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
                    $this->session->data['guest']['shipping']['country_id'] = $country_info['country_id'];
                }
            } else {
                unset($this->session->data['use_for_shipping']);
            }
        }
        $this->load->model('localisation/zone');
        if (isset($this->request->post['zone_id'])) {

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {

                $this->session->data['guest']['payment']['zone'] = $zone_info['name'];
                $this->session->data['guest']['payment']['zone_code'] = $zone_info['code'];
                $this->session->data['guest']['payment']['zone_id'] = $zone_info['zone_id'];
            } else {

                $this->session->data['guest']['payment']['zone'] = '';
                $this->session->data['guest']['payment']['zone_code'] = '';
                $this->session->data['guest']['payment']['zone_id'] = '';
            }

            // Default Payment Address
            $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
            //for setting use of shipping
            if (isset($this->request->post['use_for_shipping'])) {

                $this->session->data['use_for_shipping'] = true;
                if (isset($this->session->data['payment_zone_id'])) {
					if ($zone_info) {
						$this->session->data['shipping_zone_id'] = $this->session->data['payment_zone_id'];
						$this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
						$this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
						$this->session->data['guest']['shipping']['zone_id'] = $zone_info['zone_id'];
					} else {
						$this->session->data['shipping_zone_id'] = $this->session->data['payment_zone_id'];
						$this->session->data['guest']['shipping']['zone'] = '';
						$this->session->data['guest']['shipping']['zone_code'] = '';
						$this->session->data['guest']['shipping']['zone_id'] = '';
					}
                }
            } else {
                unset($this->session->data['use_for_shipping']);
            }
        }
        if (isset($this->request->post['firstname']) && $this->request->post['firstname'] != "") {
            if ($this->settings['option']['guest']['payment_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {

                $json['error']['firstname'] = $this->language->get('error_firstname');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['firstname'] = $this->request->post['firstname'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['firstname'])) {
                        $this->session->data['guest']['shipping']['firstname'] = $this->session->data['guest']['payment']['firstname'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['lastname']) && $this->request->post['lastname'] != "") {

            if ($this->settings['option']['guest']['payment_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {

                $json['error']['lastname'] = $this->language->get('error_lastname');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['lastname'] = $this->request->post['lastname'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['lastname'])) {
                        $this->session->data['guest']['shipping']['lastname'] = $this->session->data['guest']['payment']['lastname'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['telephone']) && $this->request->post['telephone'] != "") {

            if ($this->settings['option']['guest']['payment_address']['fields']['telephone']['require'] && (utf8_strlen(trim($this->request->post['telephone'])) < 1) || (utf8_strlen(trim($this->request->post['telephone'])) > 32) || preg_match('/[^0-9+-, ]+/i', $this->request->post['telephone'])) {

                $json['error']['telephone'] = $this->language->get('error_telephone');
            } else {
                // Default Payment Address
                $this->session->data['guest']['telephone'] = $this->request->post['telephone'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['telephone'])) {
                        $this->session->data['guest']['shipping']['telephone'] = $this->session->data['guest']['telephone'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['company']) && $this->request->post['company'] != "" ) {

            // Company
            if (($this->settings['option']['guest']['payment_address']['fields']['company']['require']) && (utf8_strlen(trim($this->request->post['company'])) < 1) || (utf8_strlen(trim($this->request->post['company'])) > 32)) {

                $json['error']['company'] = $this->language->get('error_company');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['company'] = $this->request->post['company'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['company'])) {
                        $this->session->data['guest']['shipping']['company'] = $this->session->data['guest']['payment']['company'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['company_id']) && $this->request->post['company_id'] != "") {

            // Company ID
            if (($this->settings['option']['guest']['payment_address']['fields']['company_id']['require'])&& (utf8_strlen(trim($this->request->post['company_id'])) < 1) || (utf8_strlen(trim($this->request->post['company_id'])) > 32) ) {

                $json['error']['company_id'] = $this->language->get('error_company_id');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['company_id'] = $this->request->post['company_id'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['company_id'])) {
                        $this->session->data['guest']['shipping']['company_id'] = $this->session->data['guest']['payment']['company_id'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['tax_id']) && $this->request->post['tax_id'] != "") {
            if (($this->settings['option']['guest']['payment_address']['fields']['tax_id']['require']) && (utf8_strlen(trim($this->request->post['tax_id'])) < 3) || (utf8_strlen(trim($this->request->post['tax_id'])) > 128) ) {

                $json['error']['tax_id'] = $this->language->get('error_tax_id');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['tax_id'] = $this->request->post['tax_id'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['tax_id'])) {
                        $this->session->data['guest']['shipping']['tax_id'] = $this->session->data['guest']['payment']['tax_id'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['address_1']) && $this->request->post['address_1'] != "") {
            if ($this->settings['option']['guest']['payment_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                $json['error']['address_1'] = $this->language->get('error_address_1');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['address_1'] = $this->request->post['address_1'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['address_1'])) {
                        $this->session->data['guest']['shipping']['address_1'] = $this->session->data['guest']['payment']['address_1'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['address_2']) && $this->request->post['address_2'] != "") {
            if ($this->settings['option']['guest']['payment_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                $json['error']['address_2'] = $this->language->get('error_address_2');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['address_2'] = $this->request->post['address_2'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['address_2'])) {
                        $this->session->data['guest']['shipping']['address_2'] = $this->session->data['guest']['payment']['address_2'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['city']) && $this->request->post['city'] != "") {
            if ($this->settings['option']['guest']['payment_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 32) ) {
                $json['error']['city'] = $this->language->get('error_city');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['city'] = $this->request->post['city'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['city'])) {
                        $this->session->data['guest']['shipping']['city'] = $this->session->data['guest']['payment']['city'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['postcode']) && $this->request->post['postcode'] != "") {
            if ($this->settings['option']['guest']['payment_address']['fields']['postcode']['require'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
                $json['error']['postcode'] = $this->language->get('error_postcode');
            } else {
                // Default Payment Address
                $this->session->data['guest']['payment']['postcode'] = $this->request->post['postcode'];
                //for setting use of shipping
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['guest']['payment']['postcode'])) {
                        $this->session->data['guest']['shipping']['postcode'] = $this->session->data['guest']['payment']['postcode'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
        }
        if (isset($this->request->post['email'])) {

            $this->session->data['guest']['email'] = $this->request->post['email'];
        }
        $this->response->setOutput(json_encode($json));
    }

    public function setValueForGuestShipping() { //for setting values for shipping address for guest checkout
        $this->load->model('localisation/country');
        if (isset($this->request->post['country_id'])) {

            $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

            if ($country_info) {

                $this->session->data['guest']['shipping']['country_id'] = $country_info['country_id'];
                $this->session->data['guest']['shipping']['country'] = $country_info['name'];
                $this->session->data['guest']['shipping']['iso_code_2'] = $country_info['iso_code_2'];
                $this->session->data['guest']['shipping']['iso_code_3'] = $country_info['iso_code_3'];
                $this->session->data['guest']['shipping']['address_format'] = $country_info['address_format'];
            } else {

                $this->session->data['guest']['shipping']['country'] = '';
                $this->session->data['guest']['shipping']['iso_code_2'] = '';
                $this->session->data['guest']['shipping']['iso_code_3'] = '';
                $this->session->data['guest']['shipping']['address_format'] = '';
            }

            $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
        }
        $this->load->model('localisation/zone');

        if (isset($this->request->post['zone_id'])) {

            $zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

            if ($zone_info) {

                $this->session->data['guest']['shipping']['zone_id'] = $zone_info['zone_id'];
                $this->session->data['guest']['shipping']['zone'] = $zone_info['name'];
                $this->session->data['guest']['shipping']['zone_code'] = $zone_info['code'];
            } else {

                $this->session->data['guest']['shipping']['zone'] = '';
                $this->session->data['guest']['shipping']['zone_code'] = '';
            }

            $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
        }
        if(isset($this->request->post['postcode'])&& $this->request->post['postcode'] != ""){
            $this->session->data['guest']['shipping']['postcode']=$this->request->post['postcode'];
        }else{
            $this->session->data['guest']['shipping']['postcode']="";
        }
        if (isset($this->request->post['zone_id'])) {

            $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
        }
    }

    public function setValueForLoginShipping() { //set value for shipping address for logged in customer
        if (isset($this->request->post['shipping_address'])) {

            if ($this->request->post['shipping_address'] == 'existing') {

                if (isset($this->request->post['address_id'])) {

                    $this->session->data['shipping_address_id'] = $this->request->post['address_id'];

                    // Default Shipping Address
                    $this->load->model('account/address');

                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);

                    if (isset($address_info['address_1']) || $address_info['address_1'] != "") {

                        if ($address_info) {
                            $this->load->model('localisation/country');
                            $country_info_login = $this->model_localisation_country->getCountry($address_info['country_id']);            
                            $this->session->data['shipping_country_id'] = $address_info['country_id'];
                            $this->session->data['shipping_iso_code_2'] = $country_info_login['iso_code_2'];
                            $this->session->data['shipping_iso_code_3'] = $country_info_login['iso_code_3'];
                            $this->session->data['shipping_zone_id'] = $address_info['zone_id'];
                            $this->session->data['shipping_postcode'] = $address_info['postcode'];
                            $this->session->data['shipping']['shipping_postcode'] = $address_info['postcode'];;
                        } else {

                            unset($this->session->data['shipping_country_id']);
                            unset($this->session->data['shipping_zone_id']);
                            unset($this->session->data['shipping_postcode']);
                            unset($this->session->data['shipping_iso_code_2']);
                            unset($this->session->data['shipping_iso_code_3']);
                        }
                    }
                }
            } else {
                if (isset($this->request->post['country_id'])) {
                    $this->load->model('localisation/country');
                    $country_info_login = $this->model_localisation_country->getCountry($this->request->post['country_id']); 
                    $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                    $this->session->data['shipping_iso_code_2'] = $country_info_login['iso_code_2'];
                    $this->session->data['shipping_iso_code_3'] = $country_info_login['iso_code_3'];
                }
                if (isset($this->request->post['zone_id'])) {

                    $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                }
                if (isset($this->request->post['postcode'])&& $this->request->post['postcode']!="") {

                    $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                    $this->session->data['shipping']['shipping_postcode'] = $this->request->post['postcode'];
                }else{
                    $this->session->data['shipping_postcode'] = "";
                    $this->session->data['shipping']['shipping_postcode'] = "";
                }
                unset($this->session->data['shipping_address_id']);
            }
        } else {
            if (isset($this->request->post['country_id'])) {

                $this->load->model('localisation/country');
                $country_info_login = $this->model_localisation_country->getCountry($this->request->post['country_id']); 
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_iso_code_2'] = $country_info_login['iso_code_2'];
                $this->session->data['shipping_iso_code_3'] = $country_info_login['iso_code_3'];
            }
            if (isset($this->request->post['zone_id'])) {

                $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
            }
            if (isset($this->request->post['postcode'])&& $this->request->post['postcode']!="") {

                $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
                $this->session->data['shipping']['shipping_postcode'] = $this->request->post['postcode'];
            }else{
                
                $this->session->data['shipping_postcode'] = "";
                $this->session->data['shipping']['shipping_postcode'] = "";
            }
            unset($this->session->data['shipping_address_id']);
        }
    }

    public function setValueForLoginPayment() {

        $this->language->load('supercheckout/supercheckout');

        //loading settings for supercheckout
        $this->load->model('setting/setting');
        //$result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        //$this->settings = $result['supercheckout'];
        $json = array();

        // Customer Group
        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($this->customer->getGroupId());

        if (isset($this->request->post['payment_address'])) {

            if ($this->request->post['payment_address'] == 'existing') { 

                if (isset($this->request->post['address_id'])) { // its about default_config_tax
                    $this->session->data['payment_address_id'] = $this->request->post['address_id'];

                    // Default Shipping Address
                    $this->load->model('account/address');

                    $address_info = $this->model_account_address->getAddress($this->request->post['address_id']);

                    if (isset($address_info['address_1']) || $address_info['address_1'] != "") {
                        if ($address_info) {
                            $this->load->model('localisation/country');
                            $country_info_login = $this->model_localisation_country->getCountry($address_info['country_id']);
                            $this->session->data['payment_country_id'] = $address_info['country_id'];
                            $this->session->data['payment_zone_id'] = $address_info['zone_id'];
                            $this->session->data['payment_iso_code_2'] = $country_info_login['iso_code_2'];
                            $this->session->data['payment_iso_code_3'] = $country_info_login['iso_code_3'];
                            $this->session->data['payment_postcode'] = $address_info['postcode'];
                            $this->session->data['payment']['payment_postcode'] = $address_info['postcode'];
                            
                        } else {

                            unset($this->session->data['payment_country_id']);
                            unset($this->session->data['payment_zone_id']);
                            unset($this->session->data['payment_iso_code_2']);
                            unset($this->session->data['payment_iso_code_3']);
                            unset($this->session->data['payment_postcode']);
                        }
                    }
                }
                if (isset($this->request->post['use_for_shipping'])) {

                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['payment_zone_id']) && isset($this->session->data['payment_country_id'])) {

                        $this->session->data['shipping_zone_id'] = $this->session->data['payment_zone_id'];
                        $this->session->data['shipping_country_id'] = $this->session->data['payment_country_id'];
                        $this->session->data['shipping_iso_code_2'] = $this->session->data['payment_iso_code_2'];
                        $this->session->data['shipping_iso_code_3'] = $this->session->data['payment_iso_code_3'];
                        $this->session->data['shipping_postcode'] = $this->session->data['payment_postcode'];
                        $this->session->data['shipping']['shipping_postcode'] = $this->session->data['payment']['payment_postcode'];
                    }
                } else {

                    unset($this->session->data['use_for_shipping']);
                }
                if(isset($this->session->data['use_for_shipping']) && $this->session->data['use_for_shipping']==true){
                    unset($this->session->data['shipping_address_id']);
                }
            } elseif (!$json) {
                if (isset($this->request->post['country_id'])) {

                    $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                    $this->load->model('localisation/country');
                    $country_info_login = $this->model_localisation_country->getCountry($this->request->post['country_id']);                     
                    $this->session->data['payment_iso_code_2'] = $country_info_login['iso_code_2'];
                    $this->session->data['payment_iso_code_3'] = $country_info_login['iso_code_3'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment_country_id'])) {

                            $this->session->data['shipping_country_id'] = $this->session->data['payment_country_id'];
                            $this->session->data['shipping_iso_code_2'] = $this->session->data['payment_iso_code_2'];
                            $this->session->data['shipping_iso_code_3'] = $this->session->data['payment_iso_code_3'];                            
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
                if (isset($this->request->post['zone_id'])) {

                    $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment_country_id'])) {

                            $this->session->data['shipping_zone_id'] = $this->session->data['payment_zone_id'];
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
                if (isset($this->request->post['firstname']) && $this->request->post['firstname'] != "") {

                    if ($this->settings['option']['logged']['payment_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {

                        $json['error']['firstname'] = $this->language->get('error_firstname');
                    } else {

                        $this->session->data['payment']['payment_firstname'] = $this->request->post['firstname'];
                        if (isset($this->request->post['use_for_shipping'])) {

                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_firstname'])) {

                                $this->session->data['shipping']['shipping_firstname'] = $this->session->data['payment']['payment_firstname'];
                            }
                        } else {

                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['lastname']) && $this->request->post['lastname'] != "") {

                    if ($this->settings['option']['logged']['payment_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {

                        $json['error']['lastname'] = $this->language->get('error_lastname');
                    } else {

                        $this->session->data['payment']['payment_lastname'] = $this->request->post['lastname'];
                        if (isset($this->request->post['use_for_shipping'])) {

                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_lastname'])) {

                                $this->session->data['shipping']['shipping_lastname'] = $this->session->data['payment']['payment_lastname'];
                            }
                        } else {

                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['telephone']) && $this->request->post['telephone'] != "") {

                    if ($this->settings['option']['logged']['payment_address']['fields']['telephone']['require'] && (utf8_strlen(trim($this->request->post['telephone'])) < 1) || (utf8_strlen(trim($this->request->post['telephone'])) > 32) || preg_match('/[^0-9+-, ]+/i', $this->request->post['telephone'])) {

                        $json['error']['telephone'] = $this->language->get('error_telephone');
                    } else {

                        $this->session->data['payment']['payment_telephone'] = $this->request->post['telephone'];
                        
                    }
                }
                if (isset($this->request->post['company'])&& $this->request->post['company'] != "") {
                    if ($customer_group_info) {
                        // Company
                        if (($this->settings['option']['logged']['payment_address']['fields']['company']['require']) && (utf8_strlen(trim($this->request->post['company'])) < 1) || (utf8_strlen(trim($this->request->post['company'])) > 32) ) {

                            $json['error']['company'] = $this->language->get('error_company');
                        } else {
                            $this->session->data['payment']['payment_company'] = $this->request->post['company'];

                            if (isset($this->request->post['use_for_shipping'])) {

                                $this->session->data['use_for_shipping'] = true;
                                if (isset($this->session->data['payment']['payment_company'])) {

                                    $this->session->data['shipping']['shipping_company'] = $this->session->data['payment']['payment_company'];
                                }
                            } else {

                                unset($this->session->data['use_for_shipping']);
                            }
                        }
                    }
                }
                if (isset($this->request->post['company_id']) && $this->request->post['company_id'] != "") {
                    if ($customer_group_info) {
                        // Company ID
                        if (($this->settings['option']['logged']['payment_address']['fields']['company_id']['require']) && (utf8_strlen(trim($this->request->post['company_id'])) < 1) || (utf8_strlen(trim($this->request->post['company_id'])) > 32) ) {

                            $json['error']['company_id'] = $this->language->get('error_company_id');
                        } else {

                            $this->session->data['payment']['payment_company_id'] = $this->request->post['company_id'];
                            if (isset($this->request->post['use_for_shipping'])) {

                                $this->session->data['use_for_shipping'] = true;
                                if (isset($this->session->data['payment']['payment_company_id'])) {

                                    $this->session->data['shipping']['shipping_company_id'] = $this->session->data['payment']['payment_company_id'];
                                }
                            } else {

                                unset($this->session->data['use_for_shipping']);
                            }
                        }
                    }
                }
                if (isset($this->request->post['tax_id']) && $this->request->post['tax_id'] != "") {
                    if (($this->settings['option']['logged']['payment_address']['fields']['tax_id']['require'])&& (utf8_strlen(trim($this->request->post['tax_id'])) < 1) || (utf8_strlen(trim($this->request->post['tax_id'])) > 32) ) {

                        $json['error']['tax_id'] = $this->language->get('error_tax_id');
                    } else {
                        $this->session->data['payment']['payment_tax_id'] = $this->request->post['tax_id'];
                        if (isset($this->request->post['use_for_shipping'])) {

                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_tax_id'])) {

                                $this->session->data['shipping']['shipping_tax_id'] = $this->session->data['payment']['payment_tax_id'];
                            }
                        } else {

                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['address_1']) && $this->request->post['address_1'] != "") {
                    if ($this->settings['option']['logged']['payment_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                        $json['error']['address_1'] = $this->language->get('error_address_1');
                    } else {
                        $this->session->data['payment']['payment_address_1'] = $this->request->post['address_1'];
                        if (isset($this->request->post['use_for_shipping'])) {
                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_address_1'])) {
                                $this->session->data['shipping']['shipping_address_1'] = $this->session->data['payment']['payment_address_1'];
                            }
                        } else {
                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['address_2']) && $this->request->post['address_2'] != "") {
                    if ($this->settings['option']['logged']['payment_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                        $json['error']['address_2'] = $this->language->get('error_address_2');
                    } else {
                        $this->session->data['payment']['payment_address_2'] = $this->request->post['address_2'];
                        if (isset($this->request->post['use_for_shipping'])) {
                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_address_2'])) {
                                $this->session->data['shipping']['shipping_address_2'] = $this->session->data['payment']['payment_address_2'];
                            }
                        } else {
                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['city']) && $this->request->post['city'] != "") {
                    if ($this->settings['option']['logged']['payment_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 1) || (utf8_strlen(trim($this->request->post['city'])) > 32)) {
                        $json['error']['city'] = $this->language->get('error_city');
                    } else {
                        $this->session->data['payment']['payment_city'] = $this->request->post['city'];
                        if (isset($this->request->post['use_for_shipping'])) {
                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_city'])) {
                                $this->session->data['shipping']['shipping_city'] = $this->session->data['payment']['payment_city'];
                            }
                        } else {
                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
                if (isset($this->request->post['postcode']) && $this->request->post['postcode'] != "") {
                    if ($this->settings['option']['logged']['payment_address']['fields']['postcode']['require'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
                        $json['error']['postcode'] = $this->language->get('error_postcode');
                    } else {
                        $this->session->data['payment']['payment_postcode'] = $this->request->post['postcode'];
                        if (isset($this->request->post['use_for_shipping'])) {
                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_postcode'])) {
                                $this->session->data['shipping']['shipping_postcode'] = $this->session->data['payment']['payment_postcode'];                                
                            }
                        } else {
                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }

                if (isset($this->request->post['use_for_shipping'])) {
                    unset($this->session->data['payment_address_id']);
                    unset($this->session->data['shipping_address_id']);
                } else {
                    unset($this->session->data['payment_address_id']);

                }
            }
            
        } elseif (!$json) {
            if (isset($this->request->post['country_id'])) {
                $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                $this->load->model('localisation/country');
                $country_info_login = $this->model_localisation_country->getCountry($this->request->post['country_id']);                     
                $this->session->data['payment_iso_code_2'] = $country_info_login['iso_code_2'];
                $this->session->data['payment_iso_code_3'] = $country_info_login['iso_code_3'];
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['payment_country_id'])) {
                        $this->session->data['shipping_country_id'] = $this->session->data['payment_country_id'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
            if (isset($this->request->post['zone_id'])) {
                $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
                if (isset($this->request->post['use_for_shipping'])) {
                    $this->session->data['use_for_shipping'] = true;
                    if (isset($this->session->data['payment_country_id'])) {
                        $this->session->data['shipping_zone_id'] = $this->session->data['payment_zone_id'];
                    }
                } else {
                    unset($this->session->data['use_for_shipping']);
                }
            }
            if (isset($this->request->post['firstname']) && $this->request->post['firstname'] != "") {

                if ($this->settings['option']['logged']['payment_address']['fields']['firstname']['require'] && (utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32) ) {

                    $json['error']['firstname'] = $this->language->get('error_firstname');
                } else {

                    $this->session->data['payment']['payment_firstname'] = $this->request->post['firstname'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_firstname'])) {

                            $this->session->data['shipping']['shipping_firstname'] = $this->session->data['payment']['payment_firstname'];
                        }
                    } else {

                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['lastname']) && $this->request->post['lastname'] != "") {

                if ($this->settings['option']['logged']['payment_address']['fields']['lastname']['require'] && (utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32) ) {

                    $json['error']['lastname'] = $this->language->get('error_lastname');
                } else {

                    $this->session->data['payment']['payment_lastname'] = $this->request->post['lastname'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_lastname'])) {

                            $this->session->data['shipping']['shipping_lastname'] = $this->session->data['payment']['payment_lastname'];
                        }
                    } else {

                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['telephone']) && $this->request->post['telephone'] != "") {

                if ($this->settings['option']['logged']['payment_address']['fields']['telephone']['require'] && (utf8_strlen(trim($this->request->post['telephone']))< 1) || (utf8_strlen(trim($this->request->post['telephone'])) > 32) || preg_match('/[^0-9+-, ]+/i', $this->request->post['telephone'])) {

                    $json['error']['telephone'] = $this->language->get('error_telephone');
                } else {

                    $this->session->data['payment']['payment_telephone'] = $this->request->post['telephone'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_telephone'])) {

                            $this->session->data['shipping']['shipping_telephone'] = $this->session->data['payment']['payment_telephone'];
                        }
                    } else {

                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['company'])) {
                if ($customer_group_info) {
                    // Company
                    if (($this->settings['option']['logged']['payment_address']['fields']['company']['require'])&& (utf8_strlen(trim($this->request->post['company'])) < 1) || (utf8_strlen(trim($this->request->post['company'])) > 32)) {

                        $json['error']['company'] = $this->language->get('error_company');
                    } else {
                        $this->session->data['payment']['payment_company'] = $this->request->post['company'];

                        if (isset($this->request->post['use_for_shipping'])) {

                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_company'])) {

                                $this->session->data['shipping']['shipping_company'] = $this->session->data['payment']['payment_company'];
                            }
                        } else {

                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
            }
            if (isset($this->request->post['company_id'])) {
                if ($customer_group_info) {
                    // Company ID
                    if (($this->settings['option']['logged']['payment_address']['fields']['company_id']['require']) && (utf8_strlen(trim($this->request->post['company_id'])) < 1) || (utf8_strlen(trim($this->request->post['company_id'])) > 32)) {

                        $json['error']['company_id'] = $this->language->get('error_company_id');
                    } else {

                        $this->session->data['payment']['payment_company_id'] = $this->request->post['company_id'];
                        if (isset($this->request->post['use_for_shipping'])) {

                            $this->session->data['use_for_shipping'] = true;
                            if (isset($this->session->data['payment']['payment_company_id'])) {

                                $this->session->data['shipping']['shipping_company_id'] = $this->session->data['payment']['payment_company_id'];
                            }
                        } else {

                            unset($this->session->data['use_for_shipping']);
                        }
                    }
                }
            }
            if (isset($this->request->post['tax_id'])) {
                if (($this->settings['option']['logged']['payment_address']['fields']['tax_id']['require'])  && (utf8_strlen(trim($this->request->post['tax_id']) < 1)) || (utf8_strlen(trim($this->request->post['tax_id'])) > 32)) {

                    $json['error']['tax_id'] = $this->language->get('error_tax_id');
                } else {
                    $this->session->data['payment']['payment_tax_id'] = $this->request->post['tax_id'];
                    if (isset($this->request->post['use_for_shipping'])) {

                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_tax_id'])) {

                            $this->session->data['shipping']['shipping_tax_id'] = $this->session->data['payment']['payment_tax_id'];
                        }
                    } else {

                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['address_1']) && $this->request->post['address_1'] != "") {
                if ($this->settings['option']['logged']['payment_address']['fields']['address_1']['require'] && (utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128) ) {
                    $json['error']['address_1'] = $this->language->get('error_address_1');
                } else {
                    $this->session->data['payment']['payment_address_1'] = $this->request->post['address_1'];
                    if (isset($this->request->post['use_for_shipping'])) {
                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_address_1'])) {
                            $this->session->data['shipping']['shipping_address_1'] = $this->session->data['payment']['payment_address_1'];
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['address_2']) && $this->request->post['address_2'] != "") {
                if ($this->settings['option']['logged']['payment_address']['fields']['address_2']['require'] && (utf8_strlen(trim($this->request->post['address_2'])) < 3) || (utf8_strlen(trim($this->request->post['address_2'])) > 128) ) {
                    $json['error']['address_2'] = $this->language->get('error_address_2');
                } else {
                    $this->session->data['payment']['payment_address_2'] = $this->request->post['address_2'];
                    if (isset($this->request->post['use_for_shipping'])) {
                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_address_2'])) {
                            $this->session->data['shipping']['shipping_address_2'] = $this->session->data['payment']['payment_address_2'];
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['city']) && $this->request->post['city'] != "") {
                if ($this->settings['option']['logged']['payment_address']['fields']['city']['require'] && (utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 32) ) {
                    $json['error']['city'] = $this->language->get('error_city');
                } else {
                    $this->session->data['payment']['payment_city'] = $this->request->post['city'];
                    if (isset($this->request->post['use_for_shipping'])) {
                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_city'])) {
                            $this->session->data['shipping']['shipping_city'] = $this->session->data['payment']['payment_city'];
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            if (isset($this->request->post['postcode']) && $this->request->post['postcode'] != "") {
                if ($this->settings['option']['logged']['payment_address']['fields']['postcode']['require'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2) || (utf8_strlen(trim($this->request->post['postcode'])) > 10) ) {
                    $json['error']['postcode'] = $this->language->get('error_postcode');
                } else {
                    $this->session->data['payment']['payment_postcode'] = $this->request->post['postcode'];
                    if (isset($this->request->post['use_for_shipping'])) {
                        $this->session->data['use_for_shipping'] = true;
                        if (isset($this->session->data['payment']['payment_postcode'])) {
                            $this->session->data['shipping']['shipping_postcode'] = $this->session->data['payment']['payment_postcode'];                            
                        }
                    } else {
                        unset($this->session->data['use_for_shipping']);
                    }
                }
            }
            unset($this->session->data['payment_address_id']);
        }
        $this->response->setOutput(json_encode($json));
    }

}
?>