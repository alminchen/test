<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 15:57
 */

namespace app\admin\controller;


use app\admin\model\Cata;
use app\admin\model\Good;

class Goods extends  BackBaseController
{
    private  $good;
    private  $cata;
    public  function  _initialize(){
        $this->good=new Good();
        $this->cata=new Cata();
        //return parent::_initialize();
    }
   //图片上传
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
       $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//validate(['size'=>15678,'ext'=>'jpg,png,gif'])->
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
           // echo $info->getFilename();
            return $this->resultSet('/uploads/'.$info->getSaveName());
        }else{
            // 上传失败获取错误信息
            return $this->failed($file->getError());
        }
    }
    //图片上传
    public function showUpImg(){
        return view('/img');
    }
  //显示添加商品页面
 public  function  showAddGood(){
     $this->assign('cataList',$this->cata->getCataAll());
     return view('/product-add');
 }
    public  function  index(){
        $this->assign('cataList',$this->cata->getCataAll());
        return view('/index1111');
    }
 //添加商品
    public  function  addGood(){
        $cata_id=$this->request->param('cata_id',0);//分类id
        $good_no=$this->request->param('good_no',0);//商品编号
        $good_name=$this->request->param('good_name');//商品名称
        $good_spec=$this->request->param('good_spec');//商品规格
        $good_price=$this->request->param('good_price');//商品价格
        $good_url=$this->request->param('good_url');
        $limit_num=$this->request->param('limit_num');//限购数量
        $status=$this->request->param('status');//状态
        if(empty($good_no)||empty($good_name)||$good_price<=0){
            return $this->failed('参数不能为空');
        }
        try{
            $list=$this->good->where('good_no',$good_no)->where('isDel',1)->find();
            if($list!=null){
                return $this->failed('商品编号重复');
            }
            $this->good->cata_id=$cata_id;
            $this->good->good_no=$good_no;
            $this->good->good_name=$good_name;
            $this->good->good_spec=$good_spec;
            $this->good->good_price=$good_price;
            $this->good->good_url=$good_url;
            $this->good->limit_num=$limit_num;
            $this->good->status=$status;
            $this->good->save();
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }


    }
    //显示编辑商品页面
    public  function  showUpdateGood(){
        $id=$this->request->param('id');//id
        $this->assign('good',$this->good->where('id',$id)->find());
        $this->assign('cataList',$this->cata->getCataAll());
        return view('/product-add');
    }

   //编辑商品
    public  function  updateGood(){
        $id=$this->request->param('id');//id
        $cata_id=$this->request->param('cata_id',0);//分类id
        $good_no=$this->request->param('good_no',0);//商品编号
        $good_name=$this->request->param('good_name');//商品名称
        $good_spec=$this->request->param('good_spec');//商品规格
        $good_price=$this->request->param('good_price');//商品价格
        $good_url=$this->request->param('good_url');
        $limit_num=$this->request->param('limit_num');//限购数量
        $status=$this->request->param('status');//状态
        if(empty($good_no)||empty($good_name)||$good_price<=0){
            return $this->failed('参数不能为空');
        }
        try{
            $list=$this->good->where('good_no',$good_no)->where('isDel',1)->find();
            if($list!=null){
                return $this->failed('商品编号重复');
            }
            $this->good->updateGood($id,$cata_id,$good_no,$good_name,$good_url,$good_spec,$good_price,$limit_num,$status);
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //商品上下架
    public  function  setGoodByStatus(){
        $id=$this->request->param('id');//id
        $status=$this->request->param('status');//状态
        try{
            $this->good->where('id',$id)->update(['status'=>$status]);
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    //删除商品
    public  function  deleteGood(){
        $id=$this->request->param('id');//id
        try{
            $this->good->where('id',$id)->update(['isDel'=>0]);
            return $this->_Ok();
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
    }
    public function   goodsList(){
        $status=$this->request->param('status',-1);//是否上下架
        $cata_id=$this->request->param('cata_id',0);//分类id
        $keyword=$this->request->param('keyword');//关键词
        $this->assign($this->good->getListByCataId($cata_id,$keyword,$status));
        $this->assign('cataList',$this->cata->getCataAll());
        $this->assign('keyword',$keyword);
        $this->assign('cata_id',$cata_id);
        $this->assign('status',$status);
        return view('/member-litwo');

    }


}