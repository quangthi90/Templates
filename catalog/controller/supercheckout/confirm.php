<?php

class ControllerSupercheckoutConfirm extends Controller {

    public function index() {
        $redirect = '';
        //setting variable for checking customer is logged in
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/confirm.tpl')) {
                $data['default_theme']=$this->config->get('config_template');
        }else{
                $data['default_theme']='default';
        }
        $data['logged'] = $this->customer->isLogged();
        // settings for supercheckout plugin
        $this->load->model('setting/setting');
        
        $result = $this->model_setting_setting->getSetting('supercheckout', $this->config->get('config_store_id'));
        
        $this->settings = $result['supercheckout'];
        
        $data['settings'] = $this->settings;
        if (empty($data['settings'])) {
            
            $settings = $this->model_setting_setting->getSetting('default_supercheckout', 0);            
            $data['settings'] = $settings['default_supercheckout'];
            $data['supercheckout']=$settings['default_supercheckout'];
            
        }
        
        if ($this->cart->hasShipping()) {
            // Validate if shipping address has been set.		
            $this->load->model('account/address');

            if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
                
                $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
                
            } elseif ($this->customer->isLogged() && !isset($this->session->data['shipping_address_id'])) {
                
                $shipping_address['country_id'] = $this->session->data['shipping_country_id'];
                $shipping_address['zone_id'] = $this->session->data['shipping_zone_id'];
                $shipping_address['postcode'] = isset($this->session->data['shipping']['shipping_postcode'])?$this->session->data['shipping']['shipping_postcode']:"";
                
            } elseif (isset($this->session->data['guest'])) {
                
                $shipping_address = $this->session->data['guest']['shipping'];
                
            }
            if (empty($shipping_address)) {
                
                $redirect = $this->url->link('supercheckout/supercheckout', '', 'SSL');
                
            }
        }

        // Validate if payment address has been set.
        $this->load->model('account/address');

        if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
            
            $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
            
        } elseif ($this->customer->isLogged() && !isset($this->session->data['payment_address_id'])) {
            
            $payment_address['country_id'] = $this->session->data['payment_country_id'];
            $payment_address['zone_id'] = $this->session->data['payment_zone_id'];
            
        } elseif (isset($this->session->data['guest'])) {
            
            $payment_address = $this->session->data['guest']['payment'];
            
        }
		
		if(isset($shipping_address['country_id']) && isset($shipping_address['country_id'])) {
            $this->tax->setShippingAddress($shipping_address['country_id'], $shipping_address['zone_id']);
        }
		if(isset($payment_address['country_id']) && isset($payment_address['country_id'])) {
            $this->tax->setPaymentAddress($payment_address['country_id'], $payment_address['zone_id']);
        }
        // Validate cart has products and has stock.	
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            
            $redirect = $this->url->link('checkout/cart');
            
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
            $data['text_coupon_code'] = $this->language->get('text_coupon_code');
            $data['text_voucher_code'] = $this->language->get('text_voucher_code');
            $data['column_action'] = $this->language->get('column_action');
            $data['text_coupon_success'] = $this->language->get('text_coupon_success');
            $data['text_remove'] = $this->language->get('text_remove');
            $data['button_update_link'] = $this->language->get('button_update_link');
            $data['text_voucher_success'] = $this->language->get('text_voucher_success');
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
                if($telephone==""){
                    $pdata['telephone'] = isset($this->session->data['payment']['payment_telephone'])?$this->session->data['payment']['payment_telephone']:"";
                }else{
                    $pdata['telephone'] = $telephone;
                }
                $pdata['fax'] = $this->customer->getFax();

                $this->load->model('account/address');
                if (isset($this->session->data['payment_address_id'])) {
                    
                    $payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
                    
                } else {
                    
                    $payment_address['firstname'] = isset($this->session->data['payment']['payment_firstname']) ? $this->session->data['payment']['payment_firstname'] : "";
                    $payment_address['lastname'] = isset($this->session->data['payment']['payment_lastname']) ? $this->session->data['payment']['payment_lastname'] : "";
                    $payment_address['country_id'] = $this->session->data['payment_country_id'];
                    $payment_address['zone_id'] = $this->session->data['payment_zone_id'];
                    $payment_address['company'] = isset($this->session->data['payment']['payment_company']) ? $this->session->data['payment']['payment_company'] : "";
                    $payment_address['company_id'] = isset($this->session->data['payment']['payment_company_id']) ? $this->session->data['payment']['payment_company_id'] : "";
                    $payment_address['tax_id'] = isset($this->session->data['payment']['payment_tax_id']) ? $this->session->data['payment']['payment_tax_id'] : "";
                    $payment_address['address_1'] = isset($this->session->data['payment']['payment_address_1']) ? $this->session->data['payment']['payment_address_1'] : "";
                    $payment_address['address_2'] = isset($this->session->data['payment']['payment_address_2']) ? $this->session->data['payment']['payment_address_2'] : "";
                    $payment_address['city'] = isset($this->session->data['payment']['payment_city']) ? $this->session->data['payment']['payment_city'] : "";
                    $payment_address['postcode'] = isset($this->session->data['payment']['payment_postcode']) ? $this->session->data['payment']['payment_postcode'] : "";
                    $payment_address['country_id'] = isset($this->session->data['payment_country_id']) ? $this->session->data['payment_country_id'] : "";
                    
                }
            } elseif (isset($this->session->data['guest'])) {
                
                $pdata['customer_id'] = isset($this->session->data['guestAccount_customer_id']) ? $this->session->data['guestAccount_customer_id'] : 0;
                $pdata['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
                $pdata['firstname'] = $this->session->data['guest']['firstname'];
                $pdata['lastname'] = $this->session->data['guest']['lastname'];
                $pdata['email'] = $this->session->data['guest']['email'];
                $pdata['telephone'] = $this->session->data['guest']['telephone'];
                $pdata['fax'] = $this->session->data['guest']['fax'];
                $payment_address = $this->session->data['guest']['payment'];
                
            }
            $pdata['payment_firstname'] = isset($payment_address['firstname']) ? $payment_address['firstname'] : "";
            $pdata['payment_lastname'] = isset($payment_address['lastname']) ? $payment_address['lastname'] : "";
            $pdata['payment_company'] = isset($payment_address['company']) ? $payment_address['company'] : "";
            $pdata['payment_company_id'] = isset($payment_address['company_id']) ? $payment_address['company_id'] : "";
            $pdata['payment_tax_id'] = isset($payment_address['tax_id']) ? $payment_address['tax_id'] : "";
            $pdata['payment_address_1'] = isset($payment_address['address_1']) ? $payment_address['address_1'] : "";
            $pdata['payment_address_2'] = isset($payment_address['address_2']) ? $payment_address['address_2'] : "";
            $pdata['payment_city'] = isset($payment_address['city']) ? $payment_address['city'] : "";
            $pdata['payment_postcode'] = isset($payment_address['postcode']) ? $payment_address['postcode'] : "";
            $pdata['payment_zone'] = isset($payment_address['zone']) ? $payment_address['zone'] : "";
            $pdata['payment_zone_id'] = isset($payment_address['zone_id']) ? $payment_address['zone_id'] : "";
            $pdata['payment_country'] = isset($payment_address['country']) ? $payment_address['country'] : "";
            $pdata['payment_country_id'] = isset($payment_address['country_id']) ? $payment_address['country_id'] : "";
            $pdata['payment_address_format'] = isset($payment_address['address_format']) ? $payment_address['address_format'] : "";

            if (isset($this->session->data['payment_method']['title'])) {
                
                $pdata['payment_method'] = $this->session->data['payment_method']['title'];
                
            } else {
                
                $pdata['payment_method'] = '';
                
            }

            if (isset($this->session->data['payment_method']['code'])) {
                
                $pdata['payment_code'] = $this->session->data['payment_method']['code'];
                
            } else {
                
                $pdata['payment_code'] = '';
                
            }

            if ($this->cart->hasShipping()) {
                
                if ($this->customer->isLogged()) {
                    
                    $this->load->model('account/address');
                    if (isset($this->session->data['shipping_address_id'])) {
                        
                        $shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
                        
                    } else {
                        
                        $shipping_address['country_id'] = $this->session->data['shipping_country_id'];
                        $shipping_address['zone_id'] = $this->session->data['shipping_zone_id'];
                        
                    }
                } elseif (isset($this->session->data['guest'])) {
                    
                    $shipping_address = $this->session->data['guest']['shipping'];
                    
                }
                //if shipping address is same as billing address
                if (isset($this->session->data['use_for_shipping'])) {
                                        
                    
                    $shipping_address = $payment_address;
                    
                }
                $pdata['shipping_firstname'] = isset($shipping_address['firstname']) ? $shipping_address['firstname'] : "";
                $pdata['shipping_lastname'] = isset($shipping_address['lastname']) ? $shipping_address['lastname'] : "";
                $pdata['shipping_company'] = isset($shipping_address['company']) ? $shipping_address['company'] : "";
                $pdata['shipping_address_1'] = isset($shipping_address['address_1']) ? $shipping_address['address_1'] : "";
                $pdata['shipping_address_2'] = isset($shipping_address['address_2']) ? $shipping_address['address_2'] : "";
                $pdata['shipping_city'] = isset($shipping_address['city']) ? $shipping_address['city'] : "";
                $pdata['shipping_postcode'] = isset($shipping_address['postcode']) ? $shipping_address['postcode'] : "";
                $pdata['shipping_zone'] = isset($shipping_address['zone']) ? $shipping_address['zone'] : "";
                $pdata['shipping_zone_id'] = isset($shipping_address['zone_id']) ? $shipping_address['zone_id'] : "";                
                $pdata['shipping_country'] = isset($shipping_address['country']) ? $shipping_address['country'] : "";
                $pdata['shipping_country_id'] = isset($shipping_address['country_id']) ? $shipping_address['country_id'] : "";
                $pdata['shipping_address_format'] = isset($shipping_address['address_format']) ? $shipping_address['address_format'] : "";


                if (isset($this->session->data['shipping_method']['title'])) {
                    
                    $pdata['shipping_method'] = $this->session->data['shipping_method']['title'];
                    
                } else {
                    
                    $pdata['shipping_method'] = '';
                    
                }

                if (isset($this->session->data['shipping_method']['code'])) {
                    
                    $pdata['shipping_code'] = $this->session->data['shipping_method']['code'];
                    
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
            } else {
                
                $pdata['affiliate_id'] = 0;
                $pdata['commission'] = 0;
                
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

            $this->load->model('supercheckout/order');
            $this->load->model('checkout/order');
            $this->load->model('tool/image');
            //creates order for the first time
            if (!isset($this->session->data['order_id'])) {
                // Marketing
                $this->load->model('checkout/marketing');

                if (isset($this->request->cookie['tracking'])) {
                    $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);
                    $pdata['tracking'] = $this->request->cookie['tracking'];
                } else {
                    $marketing_info = null;
                    $pdata['tracking'] = '';
                }

                if ($marketing_info) {
                    $pdata['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $pdata['marketing_id'] = 0;
                }
                
                $this->session->data['order_id'] = $this->model_checkout_order->addOrder($pdata);
                
            }
            //edits order if already created
            else {
                
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
                //load image if set from admin
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
        } else {
            $data['redirect'] = $redirect;
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/confirm.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/supercheckout/confirm.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/supercheckout/confirm.tpl', $data));
        }
    }

}

?>