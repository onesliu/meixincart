<?php
class ModelQingyouMqExchangeData extends Model
{
    public function updateData($type)
    {
        if      ( $type == 1 )
        {
        }
        else if ( $type == 2 )  // Change price
        {
            $contents = file_get_contents("php://input");
            $this->log->write($contents);

            //$sql = iconv("gbk","UTF-8//IGNORE", $sql); //Both methods can be used.
            $query = $this->db->query("set names gbk");
            $sql = "INSERT INTO pos_exchange_data SET datatype = 2, dataval = '".$contents."'";
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
}