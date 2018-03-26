<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/20
 * Time: 14:51
 */

namespace app\admin\controller;


use app\admin\model\Good;
use app\admin\model\Order;
use app\front\model\OrderGoods;

class Countorder extends  BackBaseController
{
    private $good;
    private $order;
    private $orderGoods;

    public function _initialize()
    {
        $this->good = new Good();
        $this->order = new Order();
        $this->orderGoods = new OrderGoods();
        //return parent::_initialize();
    }
    //订单汇总报表
    public  function  showOrderCount(){
        $startTime=$this->request->param('startTime',0);
        $endTime=$this->request->param('endTime',0);
        $cata_id=$this->request->param('cata_id',0);
        $keyword=$this->request->param('keyword');

        $this->assign('keyword',$keyword);
        $this->assign('startTime',$startTime);
        $this->assign('endTime',$endTime);
        $this->assign('cata_id',$cata_id);
        $this->assign('data',$this->orderGoods->countOrderGood($startTime,$endTime,$cata_id,$keyword));
        return view('/data-list');
    }


}