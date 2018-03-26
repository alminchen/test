<?php
namespace app\index\controller;

use app\admin\model\User;
use app\index\model\Api;
use think\Controller;
use think\Db;

class Index extends  Controller
{
    public function index()
    {

         echo  date('Y-m-d');
         die;
    }


}
