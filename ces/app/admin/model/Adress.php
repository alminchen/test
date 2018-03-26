<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/23
 * Time: 10:01
 */

namespace app\admin\model;


use think\Model;

class Adress extends  Model
{
  public  function  updateAdress($id,$province,$city,$county,$adress,$adress_all){
    $this->where('id',$id)->update(['province'=>$province,'city'=>$city,'county'=>$county,'adress'=>$adress,'adress_all'=>$adress_all]);
  }
}