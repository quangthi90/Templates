<?php
class ControllerSupercheckoutPaymentDisplay extends Controller {
    public function index(){

        $this->load->model('checkout/order');
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/payment_display.tpl')) {
                $data['default_theme']=$this->config->get('config_template');
        }else{
                $data['default_theme']='default';
        }
        //getting payment method for displaying on supercheckout page
        if (isset($this->session->data['payment_method']['code'])) {
            
            $data['payment'] = $this->load->controller('payment/' . $this->session->data['payment_method']['code']);
        }
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/supercheckout/payment_display.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/supercheckout/payment_display.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/supercheckout/payment_display.tpl', $data));
        }
    }
    
}
?>
