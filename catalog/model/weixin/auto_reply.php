<?php

class ModelWeixinAutoReply extends Model {
	
	public function getReply($msg_content) {
		if ($msg_content == null)
			return false;

		$this->db->query(sprintf("select * from %sauto_message where locate(pattern, '%s')>0", DB_PREFIX, $msg_content));
		if ($query->num_rows > 0) {
			return $query->row;
		}
		
		return false;
	}
	
}
?>