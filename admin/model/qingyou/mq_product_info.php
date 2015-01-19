<?php
class ModelQingyouMqProductInfo extends Model
{
    public function getProductInfo()
    {
    	$data = array();
    	$sql = "select p.isbn as plu_serial_no, p.ean, p.price, pd.name from oc_product as p left join oc_product_description as pd on p.product_id = pd.product_id where hasedit = 1";

		$query = $this->db->query($sql);
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