<?php
class ModelQingyouMqExchangeData extends Model
{
    public function uploadData($type)
    {
        if ( $type == 1 )   // upload goods info
        {
            $contents = file_get_contents("php://input");

            //$sql = iconv("gbk","UTF-8//IGNORE", $sql); //Both methods can be used.
            $query = $this->db->query("set names gbk");
            $sql = "INSERT INTO pos_exchange_data SET datatype = ".$type.", dataval = '".$contents."'";
            $query = $this->db->query($sql);

            /* update new goods info to database */
            $arr_line = explode("\r\n", $contents);
            foreach ($arr_line as $value)
            {
            	$value = trim($value);
                if ( empty($value) )
                    continue;

                $this->log->write($value);
                $arr_goodsproperty = explode("|", $value);

                $sql = "SELECT * FROM oc_product WHERE ean = '".$arr_goodsproperty[2]."'";
                $query = $this->db->query($sql);
                if ( $query->num_rows != 0 )
                {
                    ;// Update .....
                }
                else
                {
                    // Insert new goods
                    $sql = "INSERT INTO oc_product SET ean = '".trim($arr_goodsproperty[2]).
                                        "', price = ".trim($arr_goodsproperty[7]).
                                        ", product_type = ".trim($arr_goodsproperty[10]);
                    $query = $this->db->query($sql);

                    $product_id = $this->db->getLastId();

                    $sql = "SELECT * FROM oc_product_description WHERE product_id = ".$product_id;
                    $query = $this->db->query($sql);
                    if ( $query->num_rows != 0 )
                    {
                        ;// Update ...
                    }
                    else
                    {
                        $sql = "INSERT INTO oc_product_description SET product_id = ".$product_id.
                                            ", name = '".trim($arr_goodsproperty[3]).
                                            "', description = '".trim($arr_goodsproperty[9])."'";
                        $query = $this->db->query($sql);

                        $sql = "SELECT * FROM oc_product_to_category WHERE product_id = ".$product_id;
                        $query = $this->db->query($sql);
                        if ( $query->num_rows != 0 )
                        {
                            ;// Update ...
                        }
                        else
                        {
                            $sql = "INSERT INTO oc_product_to_category SET product_id = ".$product_id.
                                                ", category_id = ".trim($arr_goodsproperty[0]);
                            $query = $this->db->query($sql);

                            $category_id = trim($arr_goodsproperty[0]);

                            $sql = "SELECT * FROM oc_category WHERE category_id = ".$category_id;
                            $query = $this->db->query($sql);
                            if ( $query->num_rows != 0 )
                            {
                                ;// Update ...
                            }
                            else
                            {
                                $sql = "INSERT INTO oc_category SET category_id = ".$category_id;
                                $query = $this->db->query($sql);

                                $sql = "INSERT INTO oc_category_description SET name = '".trim($arr_goodsproperty[1])."'";
                                $query = $this->db->query($sql);
                            }
                        }
                    }
                }
            }
        }
        else if ( $type == 2 )  // upload change price list
        {
            $contents = file_get_contents("php://input");

            //$sql = iconv("gbk","UTF-8//IGNORE", $sql); //Both methods can be used.
            $query = $this->db->query("set names gbk");
            $sql = "INSERT INTO pos_exchange_data SET datatype = ".$type.", dataval = '".$contents."'";
            $query = $this->db->query($sql);
        }
        else if ( $type == 3 )
        {
        }
        else if ( $type == 4 )
        {
        }
        else if ( $type == 5 )
        {
        }
    }

    public function downloadData($shopNo, $type)
    {
        if ( $type == 1 || // download goods info
             $type == 2 )  // download change price list
        {
            $sql = "set names gbk";
            $query = $this->db->query($sql);
            $sql = "SELECT * FROM pos_exchange_data WHERE datatype = ".$type;
            $query = $this->db->query($sql);

            $contents = "";
            foreach ($query->rows as $row)
            {
                $dataID = $row['id'];
                $sql = "SELECT * FROM pos_exchange_store WHERE storeid = ".$shopNo." AND dataid = ".$dataID;
                $query1 = $this->db->query($sql);
                if ($query1->num_rows != 0)
                    continue;
                else
                {
                    $contents .= $row['dataval']."\r\n";
                    $sql = "INSERT INTO pos_exchange_store SET storeid = ".$shopNo.", dataid = ".$dataID;
                    $query1 = $this->db->query($sql);
                }
            }
            return  $contents;
        }
        else if ( $type == 3 )
        {
        }
        else if ( $type == 4 )
        {
        }
        else if ( $type == 5 )
        {
        }
    }
}