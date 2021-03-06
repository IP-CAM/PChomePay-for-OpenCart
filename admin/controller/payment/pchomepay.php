<?php
/**
 * Created by PhpStorm.
 * User: Jerry
 * Date: 2017/11/21
 * Time: 上午10:16
 */

class ControllerPaymentPChomePay extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('payment/pchomepay');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('pchomepay', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_card'] = $this->language->get('text_card');
        $data['text_atm'] = $this->language->get('text_atm');
        $data['text_each'] = $this->language->get('text_each');
        $data['text_acct'] = $this->language->get('text_acct');
        $data['text_card_0'] = $this->language->get('text_card_0');
        $data['text_card_3'] = $this->language->get('text_card_3');
        $data['text_card_6'] = $this->language->get('text_card_6');
        $data['text_card_12'] = $this->language->get('text_card_12');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_appid'] = $this->language->get('entry_appid');
        $data['entry_secret'] = $this->language->get('entry_secret');
        $data['entry_sandbox_secret'] = $this->language->get('entry_sandbox_secret');
        $data['entry_test'] = $this->language->get('entry_test');
        $data['entry_debug'] = $this->language->get('entry_debug');
//        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
//        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_payment_methods'] = $this->language->get('entry_payment_methods');
        $data['entry_card_installment'] = $this->language->get('entry_card_installment');
        $data['entry_atm_expiredate'] = $this->language->get('entry_atm_expiredate');
        $data['entry_card_last_number'] = $this->language->get('entry_card_last_number');

        $data['entry_completed_status'] = $this->language->get('entry_completed_status');
        $data['entry_expired_status'] = $this->language->get('entry_expired_status');
        $data['entry_failed_status'] = $this->language->get('entry_failed_status');
        $data['entry_pending_status'] = $this->language->get('entry_pending_status');
        $data['entry_processed_status'] = $this->language->get('entry_processed_status');
        $data['entry_refunded_status'] = $this->language->get('entry_refunded_status');

        $data['help_test'] = $this->language->get('help_test');
        $data['help_debug'] = $this->language->get('help_debug');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

//        $data['tab_general'] = $this->language->get('tab_general');
//        $data['tab_order_status'] = $this->language->get('tab_order_status');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['appid'])) {
            $data['error_appid'] = $this->error['appid'];
        } else {
            $data['error_appid'] = '';
        }

        if (isset($this->error['secret'])) {
            $data['error_secret'] = $this->error['secret'];
        } else {
            $data['error_secret'] = '';
        }

        if (isset($this->error['atm_expiredate'])) {
            $data['error_atm_expiredate'] = $this->error['atm_expiredate'];
        } else {
            $data['error_atm_expiredate'] = '';
        }

        if (isset($this->error['payment_methods'])) {
            $data['error_payment_methods'] = $this->error['payment_methods'];
        } else {
            $data['error_payment_methods'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/pchomepay', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('payment/pchomepay', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true);

        # Get PChomePay setting
        $pchomepay_settings = array(
            'status',
            'appid',
            'secret',
            'sandbox_secret',
            'test',
            'debug',
            'payment_methods',
            'card_installment',
            'atm_expiredate',
            'geo_zone_id',
            'sort_order',
            'card_last_number'
        );

        foreach ($pchomepay_settings as $setting_name) {
            $pchomepay_setting_name = 'pchomepay_' . $setting_name;

            if (isset($this->request->post[$pchomepay_setting_name])) {
                $data[$pchomepay_setting_name] = $this->request->post[$pchomepay_setting_name];
            } else {
                $data[$pchomepay_setting_name] = $this->config->get($pchomepay_setting_name);
            }
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/pchomepay', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/pchomepay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['pchomepay_appid'] || !$this->request->post['pchomepay_secret'] || !$this->request->post['pchomepay_atm_expiredate'] || !$this->request->post['pchomepay_payment_methods']) {
            $this->error['appid'] = $this->language->get('error_appid');
            $this->error['secret'] = $this->language->get('error_secret');
            $this->error['atm_expiredate'] = $this->language->get('error_atm_expiredate');
            $this->error['payment_methods'] = $this->language->get('error_payment_methods');
        }

        if (isset($this->request->post['pchomepay_atm_expiredate']) && (!preg_match('/^\d*$/', $this->request->post['pchomepay_atm_expiredate']) || $this->request->post['pchomepay_atm_expiredate'] < 1 || $this->request->post['pchomepay_atm_expiredate'] > 5)) {
            $this->error['atm_expiredate'] = $this->language->get('error_atm_expiredate_number');
        }

        return !$this->error;
    }
}