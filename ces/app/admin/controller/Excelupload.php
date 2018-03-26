<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/20
 * Time: 20:21
 */

namespace app\admin\controller;


use app\admin\model\Cata;
use app\admin\model\Good;
use app\admin\model\Order;
use app\admin\model\User;
use app\front\model\OrderGoods;
use hzhz\Excelimg;

class Excelupload extends  BackBaseController
{
    private  $user;
    private  $cata;
    private  $good;
    private $orderGoods;
    private $order;
    public  function _initialize(){
      $this->user=new User();
      $this->cata=new Cata();
      $this->good=new Good();
      $this->orderGoods=new OrderGoods();
        $this->order=new Order();
    }
    //用户列表
    public  function  userExcel(){
        $u_name=$this->request->param('u_name');//客户名称
        $keyword=$this->request->param('keyword');//关键字
        $list=$this->user->getUserList($u_name,$keyword);
        $filename='账号管理'.date('YmdHis');
        $header=array('账号','客户名称','送货地址','负责人','联系电话','状态','角色');
        $index = array('emplyId','u_name','adress','emply_name','mobile','status','roleId');
        $this->createtable($list,$filename,$header,$index );
    }
    //分类导出
    public  function  cataExcel(){
        $keyword=$this->request->param('keyword');//关键字
        $list=$this->cata->getCataLists($keyword);
        $filename='分类列表'.date('YmdHis');
        $header=array('分类名称','排序');
        $index = array('name','rank');
        $this->createtable($list,$filename,$header,$index );
    }
    //订单导出
    public function orderExcel()
    {
        $startTime = $this->request->param('startTime');
        $endTime = $this->request->param('endTime');
        $u_name = $this->request->param('u_name');
        $keyword = $this->request->param('keyword');
        $list= $this->order->getOrderAll($startTime, $endTime, $u_name, $keyword);
        $filename='订单列表'.date('YmdHis');
        $header=array('下单时间','订单号','客户名称','负责人','联系电话','送货日期','金额（元）');
        $index = array('cre_time','order_no','u_name','emply_name','mobile','send_time','totaPrice');
        $this->createtable($list,$filename,$header,$index );

    }



    //导出模板
    protected function createtable($list,$filename,$header=array(),$index = array()){
        header("Content-type:application/vnd.ms-excel;charset=utf-8");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                if($val=='status'){
                    $str=$row[$val]==1?'启用':'停用';
                    $strexport.=$str."\t";
                }elseif ($val=='roleId'){
                    $str1=$row[$val]==1?'普通用户':'后台管理员';
                    $strexport.=$str1."\t";
                } else{
                    $strexport.=$row[$val]."\t";
                }

            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
    }
    //订单导出模板
    protected function createtableByOrder($list,$filename,$header=array(),$index = array()){
        header("Content-type:application/vnd.ms-excel;charset=utf-8");
        header("Content-Disposition:filename=".$filename.".xls");
        $teble_header = implode("\t",$header);
        $strexport = $teble_header."\r";
        foreach ($list as $row){
            foreach($index as $val){
                if($val=='order_status'){
                    $str='';
                    if($row[$val]==0){
                        $str='用户下单';
                    }elseif ($row[$val]==1){
                        $str='已接单';
                    }elseif ($row[$val]==2){
                        $str='已配送';
                    }else{
                        $str='已取消';
                    }
                    $strexport.=$str."\t";
                }elseif ($val=='cre_time'||$val=='send_time'){
                    $str='';
                    if($row[$val]>0){
                        $str=date('Y-m-d',$row[$val]);
                    }
                    $strexport.=$str."\t";
                } else{
                    $strexport.=$row[$val]."\t";
                }

            }
            $strexport.="\r";

        }
        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport);
        exit($strexport);
        //$headArr,$alist,$filename,$imgindexs
    }
    // 商品列表
    public function goodExcel()
    {
        $status=$this->request->param('status',-1);//是否上下架
        $cata_id=$this->request->param('cata_id',0);//分类id
        $keyword=$this->request->param('keyword');//关键词
        $filename='商品列表'.date('YmdHis');
        $tableheader = array('图片', '商品编号', '名称', '规格','单价（元)','限购数量','分类','状态');
        $index = array('good_url','good_no','good_name','good_spec','good_price','limit_num','name','status');
        $list = $this->good->getListByCataIds($cata_id,$keyword,$status);
        $excel=new Excelimg();
        return $excel->excelByimg($list,$filename,$tableheader,$index);

    }
    // 订单明细表导出
    public function orderGoodExcel()
    {
        $id = $this->request->param('id');
        $lists= $this->order->getOrderById($id);
        $filename='订单明细表'.date('YmdHis');
        $tableheader = array('图片', '产品编号', '名称', '规格','单价（元)','数量','金额');
        $index = array('good_url','good_no','good_name','good_spec','good_price','good_num','price');
        $list = $this->orderGoods->getOrderGoodx($id);
        $excel=new Excelimg();
        return $excel->excelByOder($list,$lists,$filename,$tableheader,$index);

    }



}