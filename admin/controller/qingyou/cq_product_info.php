<?php
class ControllerQingyouCqProductInfo extends Controller {
    private $error = array();

    public function index() {
        $this->load->model('qingyou/mq_product_info');
        $productInfo = $this->model_qingyou_mq_product_info->getProductInfo();
        $this->response->setOutput(json_encode($productInfo));
    }
}