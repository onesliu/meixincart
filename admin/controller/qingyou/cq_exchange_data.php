<?php
class ControllerQingyouCqExchangeData extends Controller {
    private $error = array();

    public function index() {

//        $this->load->model('qingyou/order');

        //$last_orderid = $this->request->get['last_orderid'];
//        $districtid = $this->request->get['districtid'];
//        $this->data['orders'] = $this->model_qingyou_order->getOrders(null, $districtid, $history);

//        $this->template = 'qingyou/order_query.tpl';

//        $this->response->setOutput($this->render());
    }

    public function upload()
    {
        $this->load->model('qingyou/mq_exchange_data');
        $type = $this->request->get['type'];
        $txt = sprintf("================= type=%d\n\n", $type);
        $this->log->write($txt);
        $this->data['upload'] = $this->model_qingyou_mq_exchange_data->updateData($type);

//        $this->response->setOutput($this->render());
    }
}