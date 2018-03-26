<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 17:35
 */

namespace app\admin\controller;


use app\admin\model\Cata;
use app\admin\model\Good;
use app\admin\model\Order;
use app\admin\model\User;
use app\front\model\OrderGoods;
use think\Exception;

class Orders extends  BackBaseController
{
    private $good;
    private $order;
    private $orderGoods;
    private $user;

    public function _initialize()
    {
        $this->good = new Good();
        $this->order = new Order();
        $this->orderGoods = new OrderGoods();
        $this->user=new User();
        //return parent::_initialize();
    }

    //更新订单状态
    public function upOrByStatus()
    {
        $status = $this->request->param('status');
        $id = $this->request->param('id');
        try {
            $num = $this->order->where('id', $id)->update(['order_status' => $status,'update_time' => time()]);
            if ($num > 0) {
                return $this->_Ok();
            } else {
                return $this->failed('更新订单状态失败');
            }

        } catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试!!!');
        }
    }

    //删除订单
    public function delOrder()
    {
        $id = $this->request->param('id');
        try {
            $num = $this->order->where('id', $id)->update(['isDel' => 0]);
            if ($num > 0) {
                return $this->_Ok();
            } else {
                return $this->failed('删除订单失败');
            }

        } catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试!!!');
        }
    }

        //订单列表
    public function orderList()
    {
        $startTime = $this->request->param('startTime');
        $endTime = $this->request->param('endTime');
        $u_name = $this->request->param('u_name');
        $keyword = $this->request->param('keyword');
        $this->assign( $this->order->getOrderAll($startTime, $endTime, $u_name, $keyword));
        $this->assign('nameList',$this->user->unameList());
        $this->assign('startTime', $startTime);
            $this->assign('u_name', $u_name);
        $this->assign('keyword', $keyword);
        $this->assign('endTime', $endTime);
        return view('/product-list');

    }
    /**
     * 订单明细
     */

    //订单明细表
    public function oderGoodsList()
    {
        $id = $this->request->param('id');
        $this->assign('order', $this->order->getOrderById($id));
        $this->assign('goodList', $this->orderGoods->getOrderGoods($id));
        $this->assign('count', $this->orderGoods->count());
        $this->assign('totalPrice', $this->orderGoods->getCountPrice($id));
        return view('/');

    }
    //显示编辑页面
    public  function  showUpOrderGood(){
        $id=$this->request->param('id');
        $this->assign('id', $id);
        $this->assign('goodList', $this->good->field('id,good_name')->where('isDel',1)->group('good_name')->select());
        return view('/show-product');
    }


    //订单明细商品编辑/添加
    public  function  updateOrderGood(){
        $id=$this->request->param('id',0);
        $good_id=$this->request->param('good_id');
        $good_num=$this->request->param('good_num');
        try{
            $num=0;
            $good=$this->good->where('id',$good_id)->find();
            if($good!=null){
                 if($id>0){
                     $num=$this->orderGoods->where('id',$id)->update(['cata_id'=> $good['cata_id'],'good_price'=>$good['good_price'],'good_num'=>$good_num]);
                 }else{
                     $order_id=$this->request->param('order_id');
                     $this->orderGoods->cata_id=$good['cata_id'];
                     $this->orderGoods->good_price=$good['good_price'];
                     $this->orderGoods->order_id=$order_id;
                     $this->orderGoods->good_id=$good_id;
                     $this->orderGoods->good_num=$good_num;
                     $num=$this->orderGoods->save();
                 }

            }
            if($num>0){
                return $this->_Ok();
            }else{
                return $this->failed('操作失败');
            }

        }catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试!!!');
        }
    }
    //删除订单明细商品
    public  function delOrderGood(){
        $id=$this->request->param('id');
        $num=0;
        try{
            $num=$this->orderGoods->where('id',$id)->update(['isDel'=>0]);
            return $this->_Ok();
        }catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试!!!');
        }
        if($num>0){
            return $this->_Ok();
        }else{
            return $this->failed('编辑失败');
        }
    }
     //显示编辑页面
    public  function  showAddOrderGood(){
        $order_id=$this->request->param('order_id');
        $this->assign('order_id', $order_id);
        $this->assign('goodList', $this->good->field('id,good_name')->where('isDel',1)->group('good_name')->select());
        return view('/show-product');
    }


    public  function  index(){
       $str='1521623464';
       echo  date('Y-m-d',$str);
    }


}