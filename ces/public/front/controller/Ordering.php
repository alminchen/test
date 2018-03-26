<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 20:11
 */

namespace app\front\controller;



use app\admin\model\Good;
use app\admin\model\Order;
use app\admin\model\User;
use app\front\model\OrderGoods;
use think\Session;

class Ordering extends  FrontBaseController
{
    private  $order;
    private  $good;
    private  $orderGoods;
    private  $user;
    public function  _initialize()
    {
        $this->order=new Order();
        $this->good=new Good();
        $this->orderGoods=new OrderGoods();
        $this->user=new User();
         parent::_initialize();
    }
    //提交订单
    public  function  addOrder(){
        $data=$this->request->param('data');
        $send_time=$this->request->param('send_time',0);
        if($data){
            return $this->failed('商品不能为空');
        }
        $user_id=$this->getUserId();
        if($user_id==null){
            $user_id=1;
        }
        $this->order->user_id=$user_id;
        $this->order->order_no=date('YmdHis');
        $this->order->cre_time=time();
        $this->order->update_time=time();
        $this->order->send_time=$send_time;
        try{
            $num=$this->order->save();
            if($num>0){
                $order_id=$this->order->id;
                $arr = json_decode($data,true);
                $lists=array();
                for ($i=0;$i<count($arr);$i++){
                    $array=array();
                    $goods=$arr[$i];
                    $good=$this->good->where('id',$goods['id'])->find();
                    if($good!=null){
                        $array['order_id']=$order_id;
                        $array['cata_id']=$good['cata_id'];
                        $array['good_id']=$goods['id'];
                        $array['good_num']=$goods['good_num'];
                        $array['good_price']=$good['good_price'];
                        $lists[]=$array;
                    }
                }
                $this->orderGoods->saveAll($lists);
                return $this->_Ok();
            }else{
                return $this->failed('提交订单操作失败');
            }

        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }


        return $this->_Ok();

    }
   //显示确定订单页面
    public  function  showAddOrder(){
        $ids=$this->request->param('ids');
        $userId=$this->getUserId();
        if($userId==null){
            $userId=1;
        }
        $id=explode(',',$ids);
        try{
        $lists=array();
        for($i=0;$i<count($id);$i++){
            $good=$this->good->where('id',$id[$i])->find();
            if($good!=null){
                $lists[]=$good;
            }

        }
        $data=array();
        $data['goodList']=$lists;
        $data['user']=$this->user->where('id',$userId)->find();
        return $this->resultSet($data);
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //单个订单详情页面
    public  function  showOrderBygood(){
        $order_id=$this->request->param('order_id');
        $userId=$this->getUserId();
        if($userId==null){
            $user_id=1;
        }
        $list=$this->order->where('id',$order_id)->find();
        $this->assign('order',$list);
        $this->assign('goodList',$this->orderGoods->where('order_id',$order_id)->where('isDel',1)->select());
        $this->assign('user',$this->user->where('id',$userId)->find);
        return view('/');

    }
    //所有订单详情页面
    public  function  showOrderById(){
        $userId=$this->getUserId();
        if($userId==null){
            $userId=1;
        }
        try{
        $list=$this->order->where('user_id',$userId)->where('isDel',1)->select();
        $lists=array();
        if($list){
            foreach ($list as $k=>$v){
                $good=array();
                $good['order_no']=$v['order_no'];
                $goods=$this->orderGoods->getGoodToId($v['id']);
                $good['goodList']=$goods;
                $lists[]=$good;
            }
        }
        $data=array();
        $data['goodList']=$lists;
        $data['user']=$this->user->where('id',$userId)->find();
        return $this->resultSet($data);
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    public  function  index(){
        if(Session::has('name')){
            Session::delete('name');
        }
        Session::set('name','1111');
        echo Session::get('name');
        die;

   /* $data = '[{ "id": "1", "good_num": "1"},{ "id": "2", "good_num": "11"}]';
        //转换成数组
        $arr = json_decode($data,true);*/
        $list=$this->order->where('user_id',1)->select();
        $lists=array();

      /* $arrs=array();
        for ($i=0;$i<2;$i++){
            $arr=array();
            $num=$i+1;
            $c=$i+1;
            $arr['num']=$num;
            $arr['c']=$c;
            $arrs[]=$arr;
        }
        print_r($arrs);*/
         //输出
    }


}