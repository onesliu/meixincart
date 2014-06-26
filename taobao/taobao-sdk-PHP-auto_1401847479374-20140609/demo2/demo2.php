<?php

header("Content-type: text/html; charset=utf-8");

include "../TopSdk.php";
include "HandleTBData.php";

// Configuration
if (file_exists('../../../config.php'))
{
    require_once('../../../config.php');
}

require_once(DIR_SYSTEM . 'startup.php');

// Set default GMT
date_default_timezone_set('PRC');

$data = new HandleTBData("21798867",
                         "f319e4c8f72f0776ba206e904074a816",
                         "6101726daf41926692dc098b83e4925e0d1a94c11aaec652025928648");

$file = "./data";

if ( !file_exists($file) )
{
    // order initialization
    // Get orders in 3 months
    $fields = "has_buyer_message,seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,
                     payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,
                     buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,
                     num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,
                     receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,
                     orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,
                     orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,
                     orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,
                     orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type";
    $arr["startDate"] = "";
    $arr["endDate"] = date("Y-m-d H:i:s");

    $data->getTrades(json_encode(array('fields' => $fields, 'endCreated' => $arr["endDate"])));
}
else
{
    //从文件中读取上次操作时间
    $handle = fopen($file, "r");
    $arr = unserialize(fread($handle, filesize($file)));

    // Get increment orders
    $req = new TradesSoldIncrementGetRequest;
    $fields = "has_buyer_message,seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,
                     payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,
                     buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,
                     num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,
                     receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,
                     orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,
                     orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,
                     orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,
                     orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type";
    $arr["startDate"] = $arr["endDate"];
    $arr["endDate"] = date("Y-m-d H:i:s");

    $data->getIncrementTrades(json_encode(array('fields' => $fields,
                                                'startModified' =>  $arr["startDate"],
                                                'endModified' => $arr["startDate"])));
}

if ( isset($resp->code) )
{
    printf("\nERROR! [line:%d] code:%d, msg:%s\n", __LINE__, $resp->code, $resp->msg);
    return;
}
else
{
    $data->handleOrders();

    file_put_contents($file, serialize($arr));//写入缓存

//    fclose($handle);
}

$data->tb_print();

?>
