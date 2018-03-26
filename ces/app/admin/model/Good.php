<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 16:09
 */

namespace app\admin\model;


use think\Model;

class Good extends  Model
{
    public  function  updateGood($id,$cata_id,$good_no,$good_name,$good_url,$good_spec,$good_price,$limit_num,$status){
        $list=['cata_id'=>$cata_id,'good_no'=>$good_no,'good_name'=>$good_name,'good_url'=>$good_url,'good_spec'=>$good_spec,'good_price'=>$good_price,
            'limit_num'=>$limit_num,'status'=>$status];
        return $this->where('id',$id)->update($list);
    }
    public  function  getListByCataId($cata_id,$keyword,$status){
        $where=[];
        $status!=-1&&$where['a.status']=$status;
        $cata_id>0&&$where['a.cata_id']=$cata_id;
        $where['a.isDel']=1;
        $keyword&&$where['good_name']=['like','%'.$keyword.'%'];
        return  $this->field('a.id,a.good_url,a.good_no,a.good_name,a.good_spec,a.good_price,a.limit_num,c.name,a.status')->alias('a')->join('cy_cata c','a.cata_id=c.id','left')
            ->where($where)->order('a.id')->paginate()->toArray();
    }
    public  function  getListByCataIds($cata_id,$keyword,$status){
        $where=[];
        $status!=-1&&$where['a.status']=$status;
        $cata_id>0&&$where['a.cata_id']=$cata_id;
        $where['a.isDel']=1;
        $keyword&&$where['a.good_name']=['like','%'.$keyword.'%'];
        return $this->field('a.good_url,a.good_no,a.good_name,a.good_spec,a.good_price,a.limit_num,c.name,IF(a.status=0,"下架","上架") status')->alias('a')->join('cy_cata c','a.cata_id=c.id','left')
             ->where($where)->order('a.id')->select();
    }




}