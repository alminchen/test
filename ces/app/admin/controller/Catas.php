<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 14:41
 */

namespace app\admin\controller;


use app\admin\model\Cata;
use think\Exception;

class Catas extends  BackBaseController
{
    private  $cata;
    public  function  _initialize()
    {
        $this->cata=new Cata();
        return parent::_initialize();

    }
    public  function  showAddCata(){

        return view('/add-melist');
    }
    //添加类别
    public  function  addCata(){
        $name=$this->request->param('name');
        $rank=$this->request->param('rank',0);
        if(empty($name)){
            return $this->failed('参数不能为空');
        }
        try{
            $list=$this->cata->where('name',$name)->where('isDel',1)->find();
            if($list!=null){
                    return $this->failed('类别名称重复');
            }
            $this->cata->name=$name;
            $this->cata->rank=$rank;
            $time=time();
            $this->cata->cre_date=$time;
            $this->cata->update_date=$time;
            $this->cata->save();
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //跳转编辑页面
    public  function  showUpdateCata(){
        $id=$this->request->param('id');
        $this->assign('cata',$this->cata->getCataById($id));
        return view('/change-melist');
    }
        //编辑类别
    public  function  updateCata(){
        $id=$this->request->param('id');
        $name=$this->request->param('name');
        $rank=$this->request->param('rank',0);
        if(empty($name)){
            return $this->failed('参数不能为空');
        }
        try{
           /* $list=$this->cata->where('name',$name)->where('isDel',1)->find();
            if($list!=null){
                return $this->failed('类别名称重复');
            }*/
            $this->cata->updateCata($id,$name,$rank,time());
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //分类状态更改
    public  function  upCataStatus()
    {
        $id = $this->request->param('id');
        $status = $this->request->param('status');
        try {
            $this->cata->setCataByStatus($id, $status);
            return $this->_Ok();
        } catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //删除分类
    public  function  deleteCata()
    {
        $id = $this->request->param('id');
        try {
            $this->cata->where('id',$id)->update(['isDel' => 0]);
            return $this->_Ok();
        } catch (Exception $e) {
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //分类列表
    public  function  cataList(){
        $keyword= $this->request->param('keyword');
        $this->assign('keyword',$keyword);
        $this->assign($this->cata->getCataList($keyword));
        return view('/member-list');
    }

}