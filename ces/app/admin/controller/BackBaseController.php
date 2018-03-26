<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/15
 * Time: 14:52
 * 后台用户拦截器
 */

namespace app\admin\controller;




use app\BaseController;
use think\Controller;
use think\Session;

class BackBaseController extends BaseController
{
    private   $sessionKey='adminKey';
    public function  _initialize()
    {
       $session=$this->getSession();
      if($session==null){
            $this->redirect('/admin/login');
        }



    }

    public  function  getSession(){
        $session=null;
        if (Session::has($this->sessionKey)){
            $session=Session::get($this->sessionKey);
        }
        return $session;
    }
    public  function  getUserId(){
        $userId=null;
        if (Session::has($this->sessionKey)){
            $session=json_decode(base64_decode(Session::get($this->sessionKey)));
            $userId=$session->emplyId;
        }
        return $userId;
    }
    public  function  delSession(){
        if (Session::has($this->sessionKey)){
             Session::delete($this->sessionKey);
        }

    }

}