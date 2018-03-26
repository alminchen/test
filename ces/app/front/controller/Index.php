<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/20
 * Time: 17:18
 */

namespace app\front\controller;


use app\admin\model\Cata;
use app\admin\model\Good;
use think\Exception;

class Index extends  FrontBaseController
{
    private  $cata;
    private  $good;
    public  function  _initialize()
    {
       $this->cata=new Cata();
       $this->good=new Good();
      // parent::_initialize();
    }

   public  function  getCataList(){
        $userId=$this->getUserId();
        if($userId==null){
            $userId=1;
        }
        $data=array();
        $data['user_id']=$userId;
        try{
            $data['cataList']=$this->cata->getCataAll();

        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
       return $this->resultSet($data);
   }
    public  function  getGoodsList(){
        $cata_id=$this->request->param('cata_id',0);
        $keyword=$this->request->param('keyword');
        $data=array();
        try{

         $data['goodList']=$this->good->getListByCataId($cata_id,$keyword);
        }catch (Exception $e){
            $e->getMessage();
            return $this->failed('网络异常,稍后重试');
        }
        return $this->resultSet($data);
    }


}