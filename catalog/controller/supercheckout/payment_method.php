<?php

class ControllerSupercheckoutPaymentMethod extends Controller {

    public function index() {
        //setting for supercheckout plugin from database or from default settings
        $this->load->model('setting/setting');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/payment_method.tpl')) {
                $data['default_theme']=$this->config->get('config_template');
        }else{
                $data['default_theme']='default';
        }
        //$result = $this->model_setting_setting->getSetting('velocity_supercheckout', $this->config->get('config_store_id'));
        
        //$this->settings = $result['supercheckout'];
        $this->load->model('checkout/order');

        //$data['settings'] = $result['supercheckout'];
        
        /*if (empty($data['settings'])) {
            
            $settings = $this->model_setting_setting->getSetting('default_supercheckout', 0);            
            $data['settings'] = $settings['default_supercheckout'];
            $data['supercheckout']=$settings['default_supercheckout'];
            
        }*/

        $this->language->load('supercheckout/supercheckout');

        $this->load->model('account/address');
        // if customer is logged in whether through store or through facebook or google
        if ($this->customer->isLogged()) {
            
            $payment_address['country_id']=$this->session->data['payment_country_id'];
            $payment_address['zone_id']=$this->session->data['payment_zone_id'];
            $payment_address['iso_code_2']=isset($this->session->data['payment_iso_code_2'])?$this->session->data['payment_iso_code_2']:"";
            $payment_address['iso_code_3']=isset($this->session->data['payment_iso_code_3'])?$this->session->data['payment_iso_code_3']:"";
            $payment_address['postcode'] = isset($this->session->data['payment']['payment_postcode'])?$this->session->data['payment']['payment_postcode']:"";
            
        } elseif (isset($this->session->data['guest'])) {
            
            $payment_address = $this->session->data['guest']['payment'];
        }   

        if (!empty($payment_address)) {
            // Totals
            $total_data = array();
            $total = 0;
            $taxes = $this->cart->getTaxes();

            $this->load->model('setting/extension');

            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

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

            $this->load->model('setting/extension');

            $results = $this->model_setting_extension->getExtensions('payment');

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
        $get_first_method_payment = array();
        foreach ($this->session->data['payment_methods'] as $methods) {

            $get_first_method_payment[] = $methods['code'];
        }
        $default_payment = isset($this->settings['step']['payment_method']['default_option'])?$this->settings['step']['payment_method']['default_option']:array();
        
        if(isset($this->session->data['payment_method']['code']) && !in_array($this->session->data['payment_method']['code'],$get_first_method_payment)){
            
            if (!in_array($default_payment, $get_first_method_payment)) {

                $this->session->data['payment_method'] = $this->session->data['payment_methods'][$get_first_method_payment[0]];

            } else {

                $this->session->data['payment_method'] = $this->session->data['payment_methods'][$default_payment];

            }
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

        if (isset($this->session->data['comment'])) {
            $data['comment'] = $this->session->data['comment'];
        } else {
            $data['comment'] = '';
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

        $data['show_payment_details'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/payment_method.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/supercheckout/payment_method.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/supercheckout/payment_method.tpl', $data));
        }
    }

    public function validate() {
        
        //loading settings for supecheckout plugin from database or from default settings
        $this->load->model('setting/setting');
        
        //$result = $this->model_setting_setting->getSetting('velocity_supercheckout', $this->config->get('config_store_id'));
        
        //$this->settings = $result['supercheckout'];
        
        //$data['settings'] = $result['supercheckout'];
        
        if (empty($data['settings'])) {
            
            //$this->config->load('supercheckout_settings');
            //$settings = $this->config->get('supercheckout_settings');
            //$data['settings'] = $settings;
            
        }

        $this->language->load('supercheckout/supercheckout');

        $json = array();

        // Validate if payment address has been set.
        $this->load->model('account/address');
        
        // if customer is logged in whether through store or through facebook or google        
        if ($this->customer->isLogged()) {
            
            $payment_address['country_id']=$this->session->data['payment_country_id'];
            $payment_address['zone_id']=$this->session->data['payment_zone_id'];
            $payment_address['iso_code_2']=isset($this->session->data['payment_iso_code_2'])?$this->session->data['payment_iso_code_2']:"";
            $payment_address['iso_code_3']=isset($this->session->data['payment_iso_code_3'])?$this->session->data['payment_iso_code_3']:"";
            $payment_address['postcode'] = isset($this->session->data['payment']['payment_postcode'])?$this->session->data['payment']['payment_postcode']:"";
            
        } elseif (isset($this->session->data['guest'])) {
            
            $payment_address = $this->session->data['guest']['payment'];
            
        } 

        if (empty($payment_address)) {
            
            $json['redirect'] = $this->url->link('supercheckout/supercheckout', '', 'SSL');
            
        }

        // Validate cart has products and has stock.			
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            
            $json['redirect'] = $this->url->link('supercheckout/cart');
            
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
                $json['redirect'] = $this->url->link('supercheckout/cart');

                break;
            }
        }
        //if no error is found
        if (!$json) {
            if (!isset($this->request->post['payment_method'])) {
                
                $json['error']['warning'] = $this->language->get('error_payment');
                
            } else {                
                if (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
                    
                    $json['error']['warning'] = $this->language->get('error_payment');
                    
                }
            }
            if (!$json) {
                
                $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
                
            }
        }
        $this->response->setOutput(json_encode($json));
    }

}

?>