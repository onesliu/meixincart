<?php
class ControllerQingyouLoginOk extends Controller {
	private $error = array();

	public function index() {
		
		$return = new stdClass();
		$return->status = 0;
		$return->token = $this->request->get['token'];
		$this->response->setOutput(json_encode($return));
	}
	
}