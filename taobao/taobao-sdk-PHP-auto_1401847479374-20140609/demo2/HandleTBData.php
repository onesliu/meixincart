<?php

class HandleTBData
{
	private $c;
    private $sessionKey;
    private $resp;
    private $db;

    public function __construct($appkey, $secretkey, $sessionkey)
    {
        $this->c = new TopClient;
        $this->c->appkey = $appkey;
        $this->c->secretKey = $secretkey;
        $this->sessionKey = $sessionkey;
        $this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }

    /*
     * 查询卖家已卖出的交易数据（根据创建时间）
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，fields 为必须字段。其他字段可选。
     *          调用 tb_TradesSoldGetRequest() 后，需立即调用函数 db_TradesSoldGetRequest() 进行数据库操作。
     */
    public function tb_TradesSoldGetRequest($json_str)
    {
        $arr = json_decode($json_str);

        $req = new TradesSoldGetRequest;

        if (isset($arr->buyerNick))     $req->setBuyerNick($arr->buyerNick);
        if (isset($arr->endCreated))    $req->setEndCreated($arr->endCreated);
        if (isset($arr->extType))       $req->setExtType($arr->extType);
        if (isset($arr->fields))        $req->setFields($arr->fields);
        if (isset($arr->pageNo))        $req->setPageNo($arr->pageNo);
        if (isset($arr->pageSize))      $req->setPageSize($arr->pageSize);
        if (isset($arr->rateStatus))    $req->setRateStatus($arr->rateStatus);
        if (isset($arr->startCreated))  $req->setStartCreated($arr->startCreated);
        if (isset($arr->status))        $req->setStatus($arr->status);
        if (isset($arr->tag))           $req->setTag($arr->tag);
        if (isset($arr->type))          $req->setType($arr->type);
        if (isset($arr->useHasNext))    $req->setUseHasNext($arr->useHasNext);

        return $this->resp = $this->c->execute($req, $this->sessionKey);
    }


    /*
     * 查询卖家已卖出的增量交易数据（根据修改时间）
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，fields，startModified 和 endModified 为必须字段。其他字段可选。
     *          调用 tb_TradesSoldIncrementGetRequest()后，需立即调用函数 db_TradesSoldIncrementGetRequest() 进行数据库操作。
     */
    public function tb_TradesSoldIncrementGetRequest($json_str)
    {
        $arr = json_decode($json_str);

        $req = new TradesSoldIncrementGetRequest;

        if (isset($arr->$endModified))      $req->setEndModified($arr->$endModified);
        if (isset($arr->extType))           $req->setExtType($arr->extType);
        if (isset($arr->fields))            $req->setFields($arr->fields);
        if (isset($arr->pageNo))            $req->setPageNo($arr->pageNo);
        if (isset($arr->pageSize))          $req->setPageSize($arr->pageSize);
        if (isset($arr->$startModified))    $req->setStartModified($arr->$startModified);
        if (isset($arr->status))            $req->setStatus($arr->status);
        if (isset($arr->tag))               $req->setTag($arr->tag);
        if (isset($arr->type))              $req->setType($arr->type);
        if (isset($arr->useHasNext))        $req->setUseHasNext($arr->useHasNext);

        return $this->resp = $this->c->execute($req, $this->sessionKey);
    }


    /*
     * 获取单笔交易的详细信息
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，fields 和 tid 为必须字段。其他字段可选。
     */
    public function tb_TradeFullinfoGetRequest($json_str)
    {
        $arr = json_decode($json_str);

        $req = new TradeFullinfoGetRequest;

        if (isset($arr->fields))    $req->setFields($arr->fields);
        if (isset($arr->tid))       $req->setTid($arr->tid);

        return $this->resp = $this->c->execute($req, $this->sessionKey);
    }


    /*
     * 更新商品价格
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，numIid 为必须字段。其他字段可选。
     */
    public function tb_ItemPriceUpdateRequest($json_str)
    {
        $arr = json_decode($json_str);

        $req = new ItemPriceUpdateRequest;

        if (isset($arr->numIid))                    $req->setNumIid($arr->numIid);
        if (isset($arr->afterSaleId))               $req->setAfterSaleId($arr->afterSaleId);
        if (isset($arr->approveStatus))             $req->setApproveStatus($arr->approveStatus);
        if (isset($arr->auctionPoint))              $req->setAuctionPoint($arr->auctionPoint);
        if (isset($arr->autoFill))                  $req->setAutoFill($arr->autoFill);
        if (isset($arr->cid))                       $req->setCid($arr->cid);
        if (isset($arr->codPostageId))              $req->setCodPostageId($arr->codPostageId);
        if (isset($arr->desc))                      $req->setDesc($arr->desc);
        if (isset($arr->emsFee))                    $req->setEmsFee($arr->emsFee);
        if (isset($arr->expressFee))                $req->setExpressFee($arr->expressFee);
        if (isset($arr->freightPayer))              $req->setFreightPayer($arr->freightPayer);
        if (isset($arr->hasDiscount))               $req->setHasDiscount($arr->hasDiscount);
        if (isset($arr->hasInvoice))                $req->setHasInvoice($arr->hasInvoice);
        if (isset($arr->hasShowcase))               $req->setHasShowcase($arr->hasShowcase);
        if (isset($arr->hasWarranty))               $req->setHasWarranty($arr->hasWarranty);
        if (isset($arr->image))                     $req->setImage($arr->image);
        if (isset($arr->increment))                 $req->setIncrement($arr->increment);
        if (isset($arr->inputPids))                 $req->setInputPids($arr->inputPids);
        if (isset($arr->inputStr))                  $req->setInputStr($arr->inputStr);
        if (isset($arr->is3D))                      $req->setIs3D($arr->is3D);
        if (isset($arr->isEx))                      $req->setIsEx($arr->isEx);
        if (isset($arr->isLightningConsignment))    $req->setIsLightningConsignment($arr->isLightningConsignment);
        if (isset($arr->isReplaceSku))              $req->setIsReplaceSku($arr->isReplaceSku);
        if (isset($arr->isTaobao))                  $req->setIsTaobao($arr->isTaobao);
        if (isset($arr->isXinpin))                  $req->setIsXinpin($arr->isXinpin);
        if (isset($arr->lang))                      $req->setLang($arr->lang);
        if (isset($arr->listTime))                  $req->setListTime($arr->listTime);
        if (isset($arr->locationCity))              $req->setLocationCity($arr->locationCity);
        if (isset($arr->locationState))             $req->setLocationState($arr->locationState);
        if (isset($arr->num))                       $req->setNum($arr->num);
        if (isset($arr->outerId))                   $req->setOuterId($arr->outerId);
        if (isset($arr->picPath))                   $req->setPicPath($arr->picPath);
        if (isset($arr->postFee))                   $req->setPostFee($arr->postFee);
        if (isset($arr->postageId))                 $req->setPostageId($arr->postageId);
        if (isset($arr->price))                     $req->setPrice($arr->price);
        if (isset($arr->productId))                 $req->setProductId($arr->productId);
        if (isset($arr->propertyAlias))             $req->setPropertyAlias($arr->propertyAlias);
        if (isset($arr->props))                     $req->setProps($arr->props);
        if (isset($arr->sellPromise))               $req->setSellPromise($arr->sellPromise);
        if (isset($arr->sellerCids))                $req->setSellerCids($arr->sellerCids);
        if (isset($arr->skuPrices))                 $req->setSkuPrices($arr->skuPrices);
        if (isset($arr->skuProperties))             $req->setSkuProperties($arr->skuProperties);
        if (isset($arr->skuQuantities))             $req->setSkuQuantities($arr->skuQuantities);
        if (isset($arr->stuffStatus))               $req->setStuffStatus($arr->stuffStatus);
        if (isset($arr->subStock))                  $req->setSubStock($arr->subStock);
        if (isset($arr->title))                     $req->setTitle($arr->title);
        if (isset($arr->validThru))                 $req->setValidThru($arr->validThru);
        if (isset($arr->weight))                    $req->setWeight($arr->weight);

        return $this->resp = $this->c->execute($req, $this->sessionKey);
    }


    /*
     * 获取当前会话用户出售中的商品列表
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，fields 为必须字段。其他字段可选。
     *          调用 tb_ItemsOnsaleGetRequest()后，需立即调用函数 db_ItemsOnsaleGetRequest() 进行数据库操作。
     */
    public function tb_ItemsOnsaleGetRequest($json_str)
    {
        $arr = json_decode($json_str);

        $req = new ItemsOnsaleGetRequest;

        if (isset($arr->cid))           $req->setCid($arr->cid);
        if (isset($arr->endModified))   $req->setEndModified($arr->endModified);
        if (isset($arr->fields))        $req->setFields($arr->fields);
        if (isset($arr->hasDiscount))   $req->setHasDiscount($arr->hasDiscount);
        if (isset($arr->hasShowcase))   $req->setHasShowcase($arr->hasShowcase);
        if (isset($arr->isCspu))        $req->setIsCspu($arr->isCspu);
        if (isset($arr->isEx))          $req->setIsEx($arr->isEx);
        if (isset($arr->isTaobao))      $req->setIsTaobao($arr->isTaobao);
        if (isset($arr->orderBy))       $req->setOrderBy($arr->orderBy);
        if (isset($arr->pageNo))        $req->setPageNo($arr->pageNo);
        if (isset($arr->pageSize))      $req->setPageSize($arr->pageSize);
        if (isset($arr->q))             $req->setQ($arr->q);
        if (isset($arr->sellerCids))    $req->setSellerCids($arr->sellerCids);
        if (isset($arr->startModified)) $req->setCid($arr->startModified);

        $this->resp = $this->c->execute($req, $this->sessionKey);

        return $this->resp;
    }

    /*
     *  解析注释字符串，得到希望的收货时间
     *
     *  param  msg  注释字段。
     *              字段格式：[str1 str2]
     *                      str1 = 今天/明天,
     *                      str2 = 24小时制的小时
     */
    private function handleBuyerMessage($msg)
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

    /*
     * 订单处理流程。
     *
     * Param    $json_str    json编码字符串
     * Note:    json解码后的字段中，fields，startModified 和 endModified 为必须字段。其他字段可选。
     */
    public function db_TradesSoldGet()
    {
        if ( isset($this->resp->code) )
        {
            printf("\nERROR! [line:%d] code:%d, msg:%s\n", __LINE__, $this->resp->code, $this->resp->msg);
            return $this->resp;
        }
        else if ( $this->resp->total_results == 0 )
        {
            print_r("\n[line:%d] No new order!\n", __LINE__);
            return $this->resp;
        }

        foreach($this->resp->trades->trade as $paraValue)
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
                    $query = $this->db->query("SELECT * FROM oc_order_product WHERE order_id = $paraValue->sid");
                    if ( $query->num_rows > 0 )
                    {
                        print_r("\nError!Same order!\n");
                        break;
                    }

                    // 查询淘宝账号（昵称）是否存在于数据库中
                    $query = $this->db->query("SELECT * FROM oc_customer WHERE firstname = '".$paraValue->buyer_nick."' AND customer_type = 2");
                    if ( $query->num_rows == 0 )
                    {//插入新淘宝账号
                        $query = $this->db->query("INSERT INTO oc_customer SET firstname = '".$paraValue->buyer_nick."', customer_type = 2");
                        $customerid = $this->db->getLastId();

                        //插入新地址到新淘宝账号
                        $query = $this->db->query("INSERT INTO oc_address SET customer_id = ".$customerid.
                                                                            ", address_1 = '".$paraValue->receiver_address.
                                                                            "', city = '".$paraValue->receiver_city.
                                                                            "', telephone = '".$paraValue->receiver_telephone."'");
                        //得到新建的地址id
                        $addressid = $this->db->getLastId();
                    }
                    else
                    {// 淘宝账号已存在
                        $customerid = $query->row['customer_id'];

                        //该淘宝账户下是否有相同的(收货人姓名&收货地址&收货人电话)在数据库中
                        $query = $this->db->query("SELECT * FROM oc_address WHERE customer_id = ".$customerid.
                                                                                " AND firstname = '".$paraValue->receiver_name.
                                                                                "' AND address_1 = '".$paraValue->receiver_address.
                                                                                "' AND telephone = '".$paraValue->receiver_mobile."'");
                        if ( $query->num_rows == 0 )
                        {
                            //插入新地址到已存在的淘宝账号
                            $query = $this->db->query("INSERT INTO oc_address SET customer_id = ".$customerid.
                                                                                ", firstname = '".$paraValue->receiver_name.
                                                                                "', address_1 = '".$paraValue->receiver_address.
                                                                                "', telephone = '".$paraValue->receiver_mobile.
                                                                                "', city = '".$paraValue->receiver_city."'");
                            $addressid = $this->db->getLastId();

                        }
                        else
                        {//该淘宝账号使用已有的地址id
                            $addressid = $query->row['address_id'];
                        }
                    }

                    //更新oc_customer表中该淘宝用户的默认address_id
                    $query = $this->db->query("UPDATE oc_customer SET address_id = ".$addressid." WHERE customer_id = ".$customerid);

                    //拿到买家留言信息
                    if ( $paraValue->has_buyer_message === false )
                    {
                        $buyer_message = '';
                    }
                    else
                    {
                        $this->tb_TradeFullinfoGetRequest(json_encode(array('fields' => "buyer_message",
                                                                            'tid' => $paraValue->sid)));

                        if ( isset($this->resp->code) )
                        {
                            printf("code:%s msg:", $this->resp->code, $this->resp->msg);
                            break;
                        }
                    }

                    //得到收货时间
                    $receivetime = $this->handleBuyerMessage($this->resp->trade->buyer_message);
                    //插入新订单
                    $query = $this->db->query("INSERT INTO oc_order SET customer_id = ".$customerid.
                                                                    ", firstname = '".$paraValue->buyer_nick.
                                                                    "', shipping_firstname = '".$paraValue->receiver_name.
                                                                    "', shipping_address_1 = '".$paraValue->receiver_address.
                                                                    "', shipping_city = '".$paraValue->receiver_city.
                                                                    "', comment = '".$this->resp->trade->buyer_message.
                                                                    "', total = ".$paraValue->payment.
                                                                    ", shipping_time = '".$receivetime.
                                                                    "', other_order_id = ".$paraValue->sid.
                                                                    ", shipping_telephone = '".$paraValue->receiver_mobile."'");
                    $orderid = $this->db->getLastId();

                    // 插入商品信息
                    foreach($paraValue->orders->order as $arr)
                    {
                        $query = $this->db->query("SELECT * FROM oc_product_description WHERE name = '".$arr->title."'");
                        if ( $query->num_rows == 0 )
                        {
                            $query = $this->db->query("INSERT INTO oc_order_product SET order_id = ".$orderid.
                                                                                    ", name = '".$arr->title.
                                                                                    "', quantity = ".$arr->num.
                                                                                    ", price = ".$arr->price.
                                                                                    ", total = ".$arr->payment.
                                                                                    ",other_product_id = ".$arr->num_iid);
                        }
                        else
                        {
                            $productid = $query->row['product_id'];

                            $query = $this->db->query("INSERT INTO oc_order_product SET order_id = ".$orderid.
                                                                                    ", product_id = ".$productid.
                                                                                    ", name = '".$arr->title.
                                                                                    "', quantity = ".$arr->num.
                                                                                    ", price = ".$arr->price.
                                                                                    ", total = ".$arr->payment.
                                                                                    ", other_product_id = ".$arr->num_iid);

                        }
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

        return $this->resp;
    }


    /*
     * 更新 oc_product 表 other_product_id 字段
     */
    public function db_ItemsOnsaleGetRequest()
    {
        if ( isset($this->resp->code) )
        {
            printf("\nERROR! [line:%d] code:%d, msg:%s\n", __LINE__, $this->resp->code, $this->resp->msg);
            return $this->resp;
        }
        else if ( $this->resp->total_results == 0 )
        {
            print_r("\n[line:%d] No new order!\n", __LINE__);
            return $this->resp;
        }

        foreach($this->resp->items->item as $paraValue)
        {
            $query = $this->db->query("SELECT * FROM oc_product_description WHERE name = '".$paraValue->title."'");
            if ( $query->num_rows != 0 )
            {
                $query = $this->db->query("UPDATE oc_product SET other_product_id = ".$paraValue->num_iid." WHERE product_id = ".$query->row['product_id']);
            }
        }
    }

    public function pt()
    {
        echo "result:";
        print_r($this->resp);
    }
}
?>