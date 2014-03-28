<?php
class ModelWeixinMessage extends Model {  
    
    public function addMessage($data) {
    	if ($this->parseMessage($data) == true) {
    		$this->db->query("insert into ");
    	}
    }
    
    private function parseMessage($xmlstr) {
    	$xmlDoc = new DOMDocument();
		if ($xmlDoc->loadXML($xmlstr) == false)
			return false;
		
		$x = $xmlDoc->documentElement;
	    foreach ($x->childNodes as $item)
		{
			if ($item->nodeName != "#text") {
				$this->{$item->nodeName} = $item->nodeValue;
			}
		}

		return true;
    } 
}
?>