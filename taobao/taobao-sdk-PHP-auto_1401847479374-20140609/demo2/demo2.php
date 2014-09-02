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

function prompt()
{
    print_r("\n////////////////////////////////////////////////////////////////////////////////////////////////");
    print_r("\n * Parameter a : Call tb_getTrades() to get 3 months orders.");
    print_r("\n * Parameter b : Call tb_getIncrementTrades() to get increment orders.");
    print_r("\n * Parameter c : Call tb_updateItemPrice() to update price.");
    print_r("\n * Parameter d : Call tb_getItemsOnsale() to update other_product_id column in oc_product table.");
    print_r("\n * Parameter d : Call tb_getItemsOnsale() to update other_product_id column in oc_product table.");
    print_r("\n////////////////////////////////////////////////////////////////////////////////////////////////\n");
}

if ( isset($_SERVER['argc']) && $_SERVER['argc'] > 1 )
{
    prompt();

    $file = "./data";

    $data = new HandleTBData("21798867",
        "f319e4c8f72f0776ba206e904074a816",
        "61020124ab8b649426071391bea8607ab459dd612f5d0da2025928648");

    foreach ($_SERVER['argv'] as $value)
    {
        switch ($value)
        {
            case 'a':
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

                    $data->tb_TradesSoldGetRequest(json_encode(array('fields' => $fields, 'endCreated' => $arr["endDate"])));
                    $data->db_TradesSoldGet();

                    file_put_contents($file, serialize($arr));//写入缓存
                }
                break;

            case 'b':
                if ( file_exists($file) )
                {
                    //从文件中读取上次操作时间
                    $handle = fopen($file, "r");
                    $arr = unserialize(fread($handle, filesize($file)));

                    // Get increment orders
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

                    $data->tb_TradesSoldIncrementGetRequest(json_encode(array('fields' => $fields,
                                                                              'startModified' => $arr["startDate"],
                                                                              'endModified' => $arr["endDate"])));
                    $data->db_TradesSoldGet();

                    file_put_contents($file, serialize($arr));//写入缓存
                }
                break;

            case 'c':
                $data->tb_ItemPriceUpdateRequest(json_encode(array('numIid' => 38533168596, //黄瓜
                                                                   'price => 1.8')));
                break;

            case 'd';
                $data->tb_ItemsOnsaleGetRequest(json_encode(array('fields' => "num_iid,title")));
                $data->db_ItemsOnsaleGetRequest();
                break;

            default:
                break;
        }

        $data->pt();
    }
}

/*
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
                                                'endModified' => $arr["endDate"])));
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
*/
?>
