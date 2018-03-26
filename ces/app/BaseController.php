<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/16
 * Time: 13:37
 */

namespace  app;
use think\Controller;
use think\Session;

/**
 * Class BaseController
 * @package app
 * 基础类
 */
class BaseController extends  Controller

{
    public  function  resultSet($data){
        $result=array();
        $result['type']=1;
        $result['data']=$data;
        return  json($result);
}
   public  function  _Ok(){
        $data=array();
        $data['type']=1;
        $data['msg']='操作成功!!!';
        return json($data);
  }
  public  function  failed($msg){
        $data=array();
        $data['type']=0;
        $data['msg']=$msg;
        return json($data);
    }
    //设置session
  public function setSession($sessionKey,$mySession=array()){
      if(Session::has($sessionKey)){
          Session::delete($sessionKey);
      }
      if($mySession!=null){
          unset($mySession['password']);
      }
      Session::set($sessionKey,base64_encode($mySession));
  }


}