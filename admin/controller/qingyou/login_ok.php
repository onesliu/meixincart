<?php
class ControllerQingyouLoginOk extends Controller {
	private $error = array();

	public function index() {
		
		$user = $this->user->getUserInfo();
		$return = new stdClass();
		$return->status = 0;
		$return->token = $this->request->get['token'];
		$return->district_id = $user['district_id'];
		$this->response->setOutput(json_encode($return));
	}
}
?>