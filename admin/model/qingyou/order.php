<?php
class ModelQingyouOrder extends Model {
	public function getOrders($last_orderid, $districtid, $history) {
		
		$condition = "";
		if ($history == null || $history == 0) {
			$condition = "where o.order_status_id < 4";
		}
		else {
			$condition = "where o.order_status_id >= 4";
		}
		
		if ($last_orderid != null) {
			$condition .= " and o.order_id > $last_orderid";
		}
		
		if ($districtid != null) {
			$condition .= " and shipping_districtid = $districtid";
		}
		
		$data = array();
		$sql = "select order_id, date_added as order_createtime, o.order_status_id, os.name as order_status, customer_id, CONCAT(firstname,lastname) as customer_name, telephone as customer_phone,
		CONCAT(shipping_firstname,shipping_lastname) as shipping_name, shipping_telephone, comment, shipping_address_1 as shipping_addr, shipping_time
		from " .DB_PREFIX. "order o join " .DB_PREFIX. "order_status os on o.order_status_id = os.order_status_id $condition order by order_id;";
		
		$query = $this->db->query($sql);
		//$this->log->write($history);
		foreach ($query->rows as $result) {
			$o = new stdClass();
			foreach($result as $key => $val) {
				$o->$key = $val;
			}
			$o->products = $this->getProducts($o->order_id);
			$data[] = $o;
		}

		return $data;
	}
	
	public function getOrderCustomer($orderid) {
		$q = $this->db->query("select email from oc_customer where customer_id=(select customer_id from oc_order where order_id=$orderid)");
		if ($q->num_rows != 0) {
			return $q->row['email'];
		}
		return false;
	}
	
	public function updateOrder($order) {
		$query = $this->db->query("select order_status_id from " .DB_PREFIX. "order where order_id=".$order->order_id);
		if ($query->num_rows != 0) {
			if ($query->row['order_status_id'] == $order->order_status)
				return false;
		}
		$sql = "update " .DB_PREFIX. "order set order_status_id=".$order->order_status." where order_id=".$order->order_id;
		$this->db->query($sql);
		$sql = "insert into ".DB_PREFIX."order_history set order_id=".$order->order_id.
			",order_status_id=".$order->order_status.
			",date_added=NOW(),notify=1";
		$this->db->query($sql);
		return true;
	}
	
	public function getProducts($orderid) {
		
		$condition = "";
		if ($orderid != null) {
			$condition = "where order_id = $orderid";
		}
		
		$data = array();
		
		$query = $this->db->query("select op.product_id, op.name as product_name, p.ean, p.jan, 
		op.quantity, round(op.price,2) as price, round(op.total,2) as total, realweight, 
		round(realtotal,2) as realtotal, p.product_type from " .DB_PREFIX. "order_product op 
		join " .DB_PREFIX. "product p on p.product_id=op.product_id $condition");
		
		foreach ($query->rows as $result) {
			$o = new stdClass();
			foreach($result as $key => $val) {
				$o->$key = $val;
			}
			$data[] = $o;
		}
		
		return $data;
	}
	
	public function updateProduct($orderid, $product) {
		$sql = "update " .DB_PREFIX. "order_product set realweight=".$product->realweight.", realtotal=".$product->realtotal." where order_id=".$orderid." and product_id=".$product->product_id;
		$query = $this->db->query($sql);
	}
	
	public function getStatus() {
		
		$query = $this->db->query("select order_status_id,name from " .DB_PREFIX. "order_status");
		
		$data = array();
		foreach ($query->rows as $result) {
			$data[$result['order_status_id']] = $result['name'];
		}
		
		return $data;
	}
	
	public function getStatusMsg() {
		
		$query = $this->db->query("select order_status_id,wxtitle,wxmsg from " .DB_PREFIX. "order_status");
		
		$data = array();
		foreach ($query->rows as $result) {
			$omsg = new stdClass();
			$omsg->wxtitle = $result['wxtitle'];
			$omsg->wxmsg = $result['wxmsg'];
			$data[$result['order_status_id']] = $omsg;
		}
		
		return $data;
	}
	
	public function getDistricts() {
		
		$query = $this->db->query("select * from " .DB_PREFIX. "district");
		
		$data = array();
		foreach ($query->rows as $result) {
			$o = new stdClass();
			foreach($result as $key => $val) {
				$o->$key = $val;
			}
			$data[] = $o;
		}
		
		return $data;
	}
	
}