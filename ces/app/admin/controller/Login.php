<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/16
 * Time: 10:23
 */

namespace app\admin\controller;


use app\admin\model\User;
use app\BaseController;
use think\Exception;

class Login extends  BaseController
{
    private  $user;
    private   $sessionKey='adminKey';
    public  function  _initialize()
    {
        $this->user =new User();
    }
    //用户登录接口
    public  function  login(){
        $username=$this->request->param("username"); //账号
        $password=md5($this->request->param("password")); //密码
        try{
            $userInfo=$this->user->checkLogin($username);
            if( $userInfo==null){
              return $this->failed('不存在该账号!!!');
            }
             if ($password!=$userInfo['password']){
                 return $this->failed('密码错误!!!');
             }
             if($userInfo['roleId']!=0){
                 return $this->failed('无权限操作!!!');
             }
            if($userInfo['status']!=1){
                return $this->failed('该账号已停用!!!');
            }
            $this->setSession($this->sessionKey,$userInfo);
            return $this->_Ok();
        }catch (Exception $e){
             $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //登录页面
        public  function  index(){
        return view('/login');
    }

}