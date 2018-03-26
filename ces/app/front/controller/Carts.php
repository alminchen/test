<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 19:59
 */

namespace app\front\controller;





use app\front\model\Cart;
use think\Exception;

class Carts extends FrontBaseController
{
    private  $carts;
    public  function  _initialize()
    {
        $this->carts=new Cart();
       // parent::_initialize();
    }
    //更新加人购物车
    public  function  updateCart(){
        $good_id=$this->request->param('good_id');//商品id
        $good_num=$this->request->param('good_num',0);//商品数量
        try{
        $cart=$this->carts->where('good_id',$good_id)->where('isDel',1)->find();
        $session=$this->getSession();
        if($cart==null){
            $this->carts->good_id=$good_id;
            $this->carts->good_num=$good_num;
            $this->carts->update_time=time();
            $this->carts->user_id=$session['id'];
            $this->carts->save();
        }else{
            $list=['$good_num'=>$good_num,'update_time'=>time()];
            $this->carts->where('good_id',$good_id)->where('user_id',$session['id'])->update($list);
        }
            $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            $this->failed('网络异常稍后重试!!!');
        }
    }

}