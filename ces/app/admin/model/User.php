<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/16
 * Time: 10:30
 */
namespace  app\admin\model;
use think\Db;
use think\Model;

class User extends  Model
{
     private    $isDel=1;//用户状态
    //查询用户
    public function  checkLogin($username){

        $user=$this->where('emplyId',$username)->where('isDel',$this->isDel)->find();
        return $user;
    }
    //查询用户信息
    public function  getUserInfo($username){
        $user=$this->field('u.*,d.id as b_id,d.province,d.city,d.county,d.adress')->alias('u')->join('(select * from cy_adress where isDel=1 ) d','u.id=d.user_id','left')->
        where('u.emplyId',$username)->where('u.isDel',$this->isDel)->find();
        return $user;
    }
  //修改密码
    public function  updatePwd($username,$password){
        return $this->where('emplyId',$username)->update(['password'=>$password]);

    }
    //编辑账号
    public function  updateUser($username,$password,$u_name,$adress,$emply_name,$mobile,$status){
      $list=['password'=>$password,'u_name'=>$u_name,'adress'=>$adress,'emply_name'=>$emply_name,'mobile'=>$mobile
      ,'status'=>$status];
        return $this->where('emplyId',$username)->update($list);

    }
    //用户列表
    public function  getUserList($u_name,$keyword){
        $where=[];
        $where['u.isDel']=$this->isDel;
        $u_name && $where['u.u_name']=$u_name;
        $keyword && $where['u.mobile|u.emply_name']=['like','%'.$keyword.'%'];
        $list=$this->field('u.*,d.adress_all')->alias('u')->join('(select * from cy_adress where isDel=1 ) d','u.id=d.user_id','left')->where($where)->order('id')->paginate();
        return $list->toArray();
    }
    //用户名称列表
    public function  unameList(){
        $list=$this->field('u_name')->where('isDel',$this->isDel)->group('u_name')->order('id')->paginate();
        return $list;
    }


}