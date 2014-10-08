<?php
class ModelQingyouMqExchangeData extends Model
{
    public function uploadData($type)
    {
        if ( $type == 1 || // upload goods info
             $type == 2 )  // upload change price list
        {
            $contents = file_get_contents("php://input");
            $this->log->write($contents);

            //$sql = iconv("gbk","UTF-8//IGNORE", $sql); //Both methods can be used.
            $query = $this->db->query("set names gbk");
            $sql = "INSERT INTO pos_exchange_data SET datatype = ".$type.", dataval = '".$contents."'";
            $query = $this->db->query($sql);

//            file_put_contents('UpdatePrice.txt', $contents);
//            $myfile = fopen("UpdatePrice.txt", "r") or die("Unable to open file!");
//            while( !feof($myfile) )
//            {
//                $line = fgets($myfile);
//                $this->log->write($line);
//                if ( empty($line) )
//                    continue;
//
//                $arr = explode('|', $line);
//                $this->log->write($arr);
//                if ( count($arr) == 5 ) // The first line of change price list
//                {
//                    $listID = $arr[0];
//                }
//                else
//                {
//                    $sql = "INSERT INTO pos_exchange_data SET ".
//                        "id = ".$listID.", ".
//                        "datatype = 2".", ".
//                        "dataval = ".$line;
//                    $this->log->write($sql);
//                    $query = $this->db->query($sql);
//                }
//            }
//            fclose($myfile);
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