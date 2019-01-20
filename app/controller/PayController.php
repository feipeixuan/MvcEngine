<?php

// 支持相关的业务
class PayController extends Controller {

    /**
     * 购买会员
     *
     * @return boolean
     * @Route(ac="purchasemember",method="all")
     */
    public function purchaseMember(){
        return $this->view();
    }

    /**
     * 沟通礼物
     *
     * @return boolean
     * @Route(ac="purchasegift",method="get")
     */
    public function purchaseGift(){
        echo  "shishi purchase Gift to xuanxuan"."\n";
    }
}

