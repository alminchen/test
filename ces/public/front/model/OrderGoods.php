<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/20
 * Time: 10:19
 */

namespace app\front\model;


use think\Model;

class OrderGoods extends  Model
{
    public  function  getOrderGoods($orderId){
        return $this->field('g.good_url,g.good_no,g.good_name,g.good_spec,c.good_price,c.good_num,(c.good_price*c.good_num) price')->alias('c')
            ->join('cy_good g','c.good_id=g.id')->where('c.order_id',$orderId)->where('c.isDel',1)->order('c.id')->paginate();
    }
    public  function  getCountPrice($orderId){
        return $this->where('order_id',$orderId)->where('isDel',1)->sum('good_price');
    }
    public  function  exitGoodByOrder($orderId,$good_id){
        return $this->where('order_id',$orderId)->where('isDel',1)->where('good_id',$good_id)->count()>0?true:flase;
    }

    public  function  countOrderGood($startTime,$endTime,$cata_id,$keyword){
        $data=[];
        $json=[
            ['cy_order o','s.order_id=o.id','left'],
            ['cy_good g','s.good_id=g.id','left'],
            ['cy_cata c','s.cata_id=c.id','left'],
        ];
        $where=[];
        $startTime>0&&$where['o.update_time']=['>=',$startTime];
        $endTime>0&&$where['o.update_time	']=['<',$endTime];
        $cata_id>0&&$where['s.cata_id']=$cata_id;
        $where['o.isDel']=1;
        $where['o.order_status']=2;
        $keyword&&$where['good_name']=['like','%'.$keyword.'%'];
        $list= $this->field('c.name,g.good_no,g.good_name,g.good_spec,g.good_url,SUM(s.good_num) num,SUM( s.good_num*s.good_price) price ')->alias('s')->
        join($json)->where($where)->group('s.good_id')->paginate();
        $data['list']=$list;
        $sum=$this->field('SUM( s.good_num*s.good_price) sum ')->alias('s')->
        join($json)->where($where)->find();
        $data['sum']=$sum['sum'];
        return $data;

    }
    public  function getOrderSum(){

    }
    //前端获取订单详情
    public  function  getGoodToId($id){

        return  $this->alias('c')->field('c.id,c.good_num,c.good_price,c.good_id,g.good_url')->join('cy_good g','c.good_id=g.id','left')
            ->where('c.isDel',1)->where('c.order_id',$id)->select();
    }
    //导出
    public  function  getOrderGoodx($orderId){
        return $this->field('g.good_url,g.good_no,g.good_name,g.good_spec,c.good_price,c.good_num,(c.good_price*c.good_num) price')->alias('c')
            ->join('cy_good g','c.good_id=g.id')->where('c.order_id',$orderId)->where('c.isDel',1)->order('c.id')->select();
    }

}