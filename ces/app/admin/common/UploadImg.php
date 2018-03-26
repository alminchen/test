<?php
/**
 * Created by PhpStorm.
 * User: HeZhen
 * Date: 2018/3/19
 * Time: 16:32
 */

class UploadImg
{
    public function  getImgUrl($name){
        $upload_path = __DIR__ . '/../public/static/goods/';//上传文件的存放路径
        $time=time();
        $year=date('Y',$time).'/';
        return $upload_path.$year.$time+'.'.$name;
}

}