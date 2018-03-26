<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 20:00
 */

namespace app\front\controller;


use app\BaseController;
use think\Session;

class FrontBaseController extends  BaseController
{

    private   $sessionKey='ForntKey';
    public  function _initialize(){
        $session=$this->getSession();
        if($session==null){

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
            $userId=$session->id;
        }
        return $userId;
    }

}