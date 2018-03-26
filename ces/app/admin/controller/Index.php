<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/16
 * Time: 18:15
 */

namespace app\admin\controller;




use app\admin\model\Adress;
use app\admin\model\User;

class Index extends  BackBaseController
{
   private  $user;
    private  $adress;

   public  function  _initialize()
   {
       $this->user=new User();
       $this->adress=new Adress();
        parent::_initialize();

       }

    //跳转首页
   public  function  index(){
       $username=$this->getUserId();
       if($username==null){
           return view('/login');
       }
       $this->assign('user',$this->user->getUserInfo($username));
       return view('/index');
   }
    //修改密码页面
    public  function  showUpdatePwd(){
        return view('/admin-reset');
    }
 //修改密码
    public function  updatePwd(){
        $newPwd1=$this->request->param('newPwd1');
        $newPwd2=$this->request->param('newPwd2');
        $oldPwd=md5($this->request->param('oldPwd'));

        if($newPwd1!=$newPwd2){
           return  $this->failed('两次新密码不一致');
        }
        $username=$this->getUserId();
        if($username==null){
            return view('/login');
        }
        $userInfo=$this->user->checkLogin($username);
        if($oldPwd!=$userInfo['password']){
            return  $this->failed('旧密码错误');
        }

        $this->user->updatePwd($username,md5($newPwd1));
        return $this->_Ok();

    }
    //添加账号页面
    public function  showAddUser(){
       return view('/admin-add');
    }

    //添加账号
  public function  addUser(){
      $username=$this->request->param('username');//账号
      $password=md5($this->request->param('password','123456'));//密码
      $u_name=$this->request->param('u_name');//账号名称
      $adress=$this->request->param('adress');//地址
      $emply_name=$this->request->param('emply_name');//负责人
      $mobile=$this->request->param('mobile');//联系电话
      $status=$this->request->param('status',0);//状态
      $province=$this->request->param('province',0);//状态
      $city=$this->request->param('city','0');//状态
      $county=$this->request->param('county','0');//状态
      $adress_all=$this->request->param('adress_all');//状态
      if(empty($username)||empty($password)||empty($u_name)||empty($adress)||empty($emply_name)||empty($mobile)){
          return  $this->failed('参数不能为空!!!');
      }
      $userInfo=$this->user->checkLogin($username);
      if($userInfo!=null){
          return  $this->failed('该账号已存在!!!');
      }
      $this->user->emplyId=$username;
      $this->user->password=$password;
      $this->user->u_name=$u_name;
      $this->user->emply_name=$emply_name;
      $this->user->mobile=$mobile;
      $this->user->status=$status;
      try{
        $num=$this->user->save();
        if($num>0){
            $this->adress->user_id=$this->user->id;
            $this->adress->province=$province;
            $this->adress->city=$city;
            $this->adress->county=$county;
            $this->adress->adress=$adress;
            $this->adress->adress_all=$adress_all;
            $num=$this->adress->save();
            if($num>0){
                return $this->_Ok();
            }else{
                return  $this->failed('添加地址失败');
            }
        }else{
            return  $this->failed('添加账号失败');
        }

      }catch(Exception $e){
          $e->getMessage();
          return $this->failed('网络异常，稍后重试!!!');
      }

}
    ///编辑账号页面
    public function  showUpdateUser(){
        $username=$this->request->param('username');//账号
        $this->user->getUserInfo($username);
       $this->assign('user',$this->user->getUserInfo($username));
        return view('/admin-edit');
    }
    //编辑账号
    public function  updateUser(){
        $a_id=$this->request->param('a_id',0);//地址id;
        $user_id=$this->request->param('user_id',0);//用户id;
        $username=$this->request->param('username');//账号
        $password=$this->request->param('password');//密码
        $password=empty($password)?$password:md5($password);
        $u_name=$this->request->param('u_name');//账号名称
        $adress=$this->request->param('adress');//地址
        $emply_name=$this->request->param('emply_name');//负责人
        $mobile=$this->request->param('mobile');//联系电话
        $status=$this->request->param('status',0);//状态
        $province=$this->request->param('province',0);//省
        $city=$this->request->param('city','0');//市
        $county=$this->request->param('county','0');//县
        $adress_all=$this->request->param('adress_all');//地址全称
        if(empty($username)||empty($u_name)||empty($adress)||empty($emply_name)||empty($mobile)||$user_id==0){
            return  $this->failed('参数不能为空!!!');
        }
        $userInfo=$this->user->checkLogin($username);
        if($userInfo==null){
            return  $this->failed('该账号不存在!!!');
        }
        if(empty($password)){
            $password=$userInfo->password;
        }
        try{
           $this->user->updateUser($username,$password,$u_name,$adress,$emply_name,$mobile,$status);
                if($a_id>0){
                    $this->adress->updateAdress($a_id,$province,$city,$county,$adress,$adress_all);
                }else {
                    $this->adress->user_id = $user_id;
                    $this->adress->province = $province;
                    $this->adress->city = $city;
                    $this->adress->county = $county;
                    $this->adress->adress = $adress;
                    $this->adress->adress_all = $adress_all;
                    $this->adress->save();
                }
                return $this->_Ok();
        }catch(Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //停用或开启用户
    public  function  setUserByStatus(){
        $username=$this->request->param('username');//账号
        $status=$this->request->param('status');//状态
        try{
        $userInfo=$this->user->checkLogin($username);
        if($userInfo==null){
            return  $this->failed('该账号不存在!!!');
        }
        $this->user->where('emplyId',$username)->update(['status'=>$status]);
        return $this->_Ok();
        }catch(Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //删除用户
    public  function  deleteUser(){
        $username=$this->request->param('username');//账号
        try{
            $this->user->where('emplyId',$username)->update(['isDel'=>0]);
            return $this->_Ok();
        }catch(Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //设置后台管理员
    public  function  setUserByRole(){
        $username=$this->request->param('username');//账号
        $roleId=$this->request->param('roleId');//角色
        try{
            $this->user->where('emplyId',$username)->update(['roleId'=>$roleId]);
            return $this->_Ok();
        }catch(Exception $e){
            $e->getMessage();
            return $this->failed('网络异常，稍后重试!!!');
        }

    }
    //用户列表
    public  function  getUserList(){
        $u_name=$this->request->param('u_name');//客户名称
        $keyword=$this->request->param('keyword');//关键字
        $list=$this->user->getUserList($u_name,$keyword);
        $this->assign('u_name',$u_name);
        $this->assign('keyword',$keyword);
        $this->assign($list);
        $this->assign('nameList',$this->user->unameList());
        return view('/admin-list');
    }
    //用户退出
  public function logout(){
       try{
         $this->delSession();
         return view('/login');
      }catch(Exception $e){
          $e->getMessage();
         return $this->failed('网络异常，稍后重试!!!');
}

  }





}