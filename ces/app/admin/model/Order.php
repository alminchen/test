<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 19:20
 */

namespace app\admin\model;


use think\Model;

class Order extends  Model
{
    public  function  getOrderAll($startTime,$endTime,$u_name,$keyword){

        $where=[];
        $startTime>0&&$where['o.cre_time']=['>=',$startTime];
        $endTime>0&&$where['o.cre_time']=['<',$endTime];
        $where['o.isDel']=1;
        $u_name&&$where['u.u_name']=$u_name;
        $keyword&&$where['u.mobile|u.emply_name']=['like','%'.$keyword.'%'];
        $join=[
            ['( SELECT order_id,SUM(good_num*good_price) totaPrice FROM cy_order_goods WHERE isDel=1 GROUP BY order_id ) g ','g.order_id=o.id','left'],
            ['cy_user u','o.user_id=u.id','left']
            ];
        return  $this->field('o.id,o.order_no,o.cre_time,o.send_time,o.order_status,g.totaPrice,u.u_name,u.emply_name,u.mobile')->alias('o')->join($join)->where($where)->paginate('5')->toArray();

    }
   public  function  getOrderById($id){
       return $this->alias('o')->join('cy_user u','o.user_id=u.id','left')->where('o.id',$id)->find();
  }



}