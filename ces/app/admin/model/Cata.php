<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 14:47
 */

namespace app\admin\model;


use think\Model;

class Cata extends  Model
{
    //编辑类别
    public  function  updateCata($id,$name,$rank,$time){
        $list=['name'=>$name,'rank'=>$rank,'update_date'=>$time];
        return $this->where('id',$id)->update($list);
    }
    //查找类别
    public  function  getCataById($id){
        return $this->where('id',$id)->find();
    }
    public  function  setCataByStatus($id,$status){

        return  $this->where('id',$id)->update(['status' => $status]);
    }
    public  function  getCataList($keyword){
        $where=[];
        $where['isDel']=1;
        $keyword&&$where['name']=['like','%'.$keyword.'%'];
        return $this->where($where)->order('rank')->paginate('1')->toArray();
    }
    //导出
    public  function  getCataLists($keyword){
        $where=[];
        $where['isDel']=1;
        $keyword&&$where['name']=['like','%'.$keyword.'%'];
        return $this->field('name,rank')->where($where)->order('rank')->select();
    }
    //商品类别列表
    public  function  getCataAll(){
        return $this->where('isDel',1)->select();
    }

}