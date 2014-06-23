<?php

header("Content-type: text/html; charset=utf-8");

include "../TopSdk.php";

// Configuration
if (file_exists('../../../config.php'))
{
    require_once('../../../config.php');
}

require_once(DIR_SYSTEM . 'startup.php');

// Set default GMT
date_default_timezone_set('PRC');

//$test = parseReceiveTime("11明天13");

// TopClient instance ��
$c = new TopClient;
$c->appkey = "21798867";
$c->secretKey = "f319e4c8f72f0776ba206e904074a816";
$sessionKey = "6101200615def83a8cbcf4cf2ecb598a7d320f73349348a2025928648";

$file = "./data";

if ( !file_exists($file) )
{
    $arr = array("init" => true,
                 "lastDate" => "",
                 "currDate" => "");

    // order initialization
    // Get orders in 3 months
    $req = new TradesSoldGetRequest;
    $req->setFields("has_buyer_message,seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,
                     payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,
                     buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,
                     num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,
                     receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,
                     orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,
                     orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,
                     orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,
                     orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type");
    $req->setFields(" sid,tid ");
    $curDate = date("Y-m-d H:i:s");
    $req->setEndCreated($curDate);
    $resp = $c->execute($req, $sessionKey);

    $arr["lastDate"] = "";
    $arr["currDate"] = $curDate;
}
else
{
    $handle = fopen($file, "r");
    $arr = unserialize(fread($handle, filesize($file)));

    // Get increment orders
    $req = new TradesSoldIncrementGetRequest;
    $req->setFields("has_buyer_message,seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,
                     payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,
                     buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,
                     num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,
                     receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,
                     orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,
                     orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,
                     orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,
                     orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type");
    $arr["lastDate"] = $arr["currDate"];
    $req->setStartModified($arr["lastDate"]);
    $arr["currDate"] = date("Y-m-d H:i:s");
    $req->setEndModified($arr["currDate"]);
    $resp = $c->execute($req, $sessionKey);
}

if ( isset($resp->code) )
{
    printf("\nERROR! [line:%d] code:%d, msg:%s\n", __LINE__, $resp->code, $resp->msg);
    return;
}
else
{
    handleOrder($c, $resp);

    file_put_contents($file, serialize($arr));//写入缓存

//    fclose($handle);
}

echo "result:";
print_r($resp);


/*
    解析注释。
    param  t    注释字段是否存在

    字符串格式：[str1 str2]
    Note：以空格分割字符串。其中
            str1 = 今天/明天,
            str2 = 24小时制的小时
*/
function handleBuyerMessage($msg)
{
    $tmp1 = trim($msg);
    $tm = false;

    if ( $tmp1 != "" )
    {
        if ( ($pos = strpos($tmp1, "今")) !== false )
        {//拿到‘今’字后面的字符串
            $str = substr($tmp1, $pos+strlen("今"));
            $tm = true;
        }
        elseif ( ($pos = strpos($tmp1, "明")) !== false )
        {//拿到‘明’字后面的字符串
            $str = substr($tmp1, $pos+strlen("明"));
            $tm = false;
        }
        else
        {
            return "";
        }

        preg_match('/\d+/', $str, $arr); //取得小时
        if ( $arr[0] == null )
        {//不存在数字字符
            return "";
        }
        elseif ( $arr[0] > 23 )
        {
            $hour = substr($arr[0], 0, 2);
            if ( $hour > 23 )
            {
                return "";
            }
        }
        else
        {
            $hour = $arr[0];
        }

        if ( $tm )
            $shippingtime = date("Y-m-d ".$hour.":00:00");
        else
            $shippingtime = date("Y-m-d ".$hour.":00:00", strtotime("+1 day"));
    }

    return $shippingtime;
}

function handleOrder($c, $result)
{
    if ( isset($result->code) )
    {
        printf("\nERROR! [line:%d] code:%d, msg:%s\n", __LINE__, $result->code, $result->msg);
        return;
    }
    else if ( $result->total_results == 0 )
    {
        print_r("\n[line:%d] No new order!\n", __LINE__);
        return;
    }

    // Database
    $db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    foreach($result->trades->trade as $paraValue)
    {
        switch ($paraValue->status)
        {
            case "TRADE_NO_CREATE_PAYALL":      //(没有创建支付宝交易)
            case "WAIT_BUYER_PAY":              //(等待买家付款)
            case "ALL_WAIT_PAY":                //(包含：WAIT_BUYER_PAY、TRADE_NO_CREATE_PAY)
                break;

            case "WAIT_SELLER_SEND_GOODS":      //(等待卖家发货,即:买家已付款)
            case "TRADE_BUYER_SIGNED":          //(买家已签收,货到付款专用)
            case "TRADE_FINISHED":              //(交易成功)
            {
                // 查询是否有相同订单号
                $query = $db->query("SELECT * FROM oc_order_product WHERE order_id = $paraValue->sid");
                if ( $query->num_rows > 0 )
                {
                    print_r("\nError!Same order!\n");
                    break;
                }

                // 查询淘宝账号（昵称）是否存在于数据库中
                $query = $db->query("SELECT * FROM oc_customer WHERE firstname = '".$paraValue->buyer_nick."' AND customer_type = 2");
                if ( $query->num_rows == 0 )
                {//插入新淘宝账号
                    $query = $db->query("INSERT INTO oc_customer SET firstname = '".$paraValue->buyer_nick."', customer_type = 2");
                    $customerid = $db->getLastId();

                    //插入新地址到新淘宝账号
                    $query = $db->query("INSERT INTO oc_address SET customer_id = ".$customerid.
                                                                    ", address_1 = '".$paraValue->receiver_address.
                                                                    "', city = '".$paraValue->receiver_city.
                                                                    "', telephone = '".$paraValue->receiver_telephone."'");
                    $addressid = $db->getLastId();
                }
                else
                {// 淘宝账号已存在
                    $customerid = $query->row['customer_id'];

                    //该淘宝账户下是否有相同的(收货人姓名&收货地址&收货人电话)在数据库中
                    $query = $db->query("SELECT * FROM oc_address WHERE customer_id = ".$customerid.
                                                                        " AND firstname = '".$paraValue->receiver_name.
                                                                        "' AND address_1 = '".$paraValue->receiver_address.
                                                                        "' AND telephone = '".$paraValue->receiver_mobile."'");
                    if ( $query->num_rows == 0 )
                    {
                        //插入新地址到已存在的淘宝账号
                        $query = $db->query("INSERT INTO oc_address SET customer_id = ".$customerid.
                                                                        ", firstname = '".$paraValue->receiver_name.
                                                                        "', address_1 = '".$paraValue->receiver_address.
                                                                        "', telephone = '".$paraValue->receiver_mobile.
                                                                        "', city = '".$paraValue->receiver_city."'");
                        $addressid = $db->getLastId();

                    }
                    else
                    {//该淘宝账号使用已有的地址
                        $addressid = $query->row['address_id'];
                    }
                }

                //更新oc_customer表中该淘宝用户的默认address_id
                $query = $db->query("UPDATE oc_customer SET address_id = ".$addressid." WHERE customer_id = ".$customerid);

                //拿到买家留言信息
                if ( $paraValue->has_buyer_message === false )
                {
                    $buyer_message = '';
                }
                else
                {
                    $req = new TradeFullinfoGetRequest;
                    $req->setFields("buyer_message");
                    $req->setTid($paraValue->sid);
                    global $sessionKey;
                    $resp = $c->execute($req, $sessionKey);
                    if ( isset($resp->code) )
                    {
                        printf("code:%s msg:", $resp->code, $resp->msg);
                        break;
                    }
                }
                //处理收货时间
                $receivetime = handleBuyerMessage($resp->trade->buyer_message);
                //插入新订单
                $query = $db->query("INSERT INTO oc_order SET customer_id = ".$customerid.
                                                            ", firstname = '".$paraValue->buyer_nick.
                                                            "', shipping_firstname = '".$paraValue->receiver_name.
                                                            "', shipping_address_1 = '".$paraValue->receiver_address.
                                                            "', shipping_city = '".$paraValue->receiver_city.
                                                            "', comment = '".$resp->trade->buyer_message.
                                                            "', total = ".$paraValue->payment.
                                                            ", shipping_time = '".$receivetime.
                                                            "', other_order_id = ".$paraValue->sid.
                                                            ", shipping_telephone = '".$paraValue->receiver_mobile."'");
                $orderid = $db->getLastId();

                // 插入产品信息
                foreach($paraValue->orders->order as $arr)
                {
                    $query = $db->query("INSERT INTO oc_order_product SET order_id = ".$orderid.
                                                                        ", product_id = ".$arr->num_iid.
                                                                        ", name = '".$arr->title.
                                                                        "', quantity = ".$arr->num.
                                                                        ", price = ".$arr->price.
                                                                        ", total = ".$arr->payment);
                }

                break;
            }
            case "SELLER_CONSIGNED_PART":       //(卖家部分发货）
            case "WAIT_BUYER_CONFIRM_GOODS":    //(等待买家确认收货,即:卖家已发货)
                break;

            case "TRADE_CLOSED":                //(交易关闭)
            case "TRADE_CLOSED_BY_TAOBAO":      //(交易被淘宝关闭)
            case "ALL_CLOSED":                  //(包含：TRADE_CLOSED、TRADE_CLOSED_BY_TAOBAO)
                break;

            default:
                break;
        }
    }
}

?>
