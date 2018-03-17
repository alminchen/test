ajax方法

//代码区域,同步的方式
var data = cnitr.ajax({
    "url":"/add/name",
    "json":{"name":"张三","mobile":"13800000000"}
})
if(data){
    //正确回调
}else{
    //网络错误。
}
//代码区域,异步的方式
cnitr.ajax({
    "url":"/add/name",
    "json":{"name":"张三","mobile":"13800000000"}
},function(data){
    if(data){
        //正确回调
    }else{
        //网络错误。
    }
})

verify表单验证
参数有：null	不能为空
		phone	验证手机号，1开头的11位数字
		tel		验证电话号码
		email	验证邮箱地址
		number
实例
//html
<form class="form">
    <input verify="null">
</form>
//js结合按钮来使用
var data = cnitr.verify();
data.isok;//true/false验证通过为true;//返回值
data.eq;//验证不通过时，返回eq为第几个验证失败$("input[verify='null']").eq(eq); //返回值
data.msg;//验证不通过时提示错误语。//返回值

verify_fun独立验证 
name	null/phone/tel/email/number	
val		text
//实例js
var data = cnitr.verify_fun({
    "name":"phone"
    "val":"13800000000"
})
data.isok;//true/false验证通过为true;
data.msg;//验证不通过时提示错误语。

回到顶部--nav_top滑动到页面顶部
num	number	移动时长（值越小移动越快）
cnitr.nav_top(300)//300就是NUM值

form_json获取表单数据
//代码区域
<form class="form">
    <input type="text" name="name" value="李四">
    <input type="text" name="mobile" value="13800000000">
    <input type="checkbox" name="checkbox" id="" value="1" checked="checked">
    <input type="checkbox" name="checkbox" id="" value="2">
    <input type="checkbox" name="checkbox" id="" value="3" checked="checked">
    <input type="checkbox" name="radio" id="" value="1">
    <input type="checkbox" name="radio" id="" value="2">
    <input type="checkbox" name="radio" id="" value="3" checked="checked">
    <select name="sex">
        <option value="0" selected="selected">男</option>
        <option value="1">女</option>
    </select>
    <textarea name="content" rows="" cols="">我赛</textarea>
</form>
//代码区域
var data = cnitr.form_json();
data:{"name":"李四","mobile":"13800000000","checkbox":["1","3"],"radio":"3","sex":"0","content":"我赛"}
//data[name]=val;
//name为控件在name值;
//val得到的是控件的value;


tab切换
<div class="act">
    <a>显示1</a>
    <a>显示2</a>
    <a>显示3</a>
    <a>显示4</a>
</div>
<div class="tab">
    <li>我是1</li>
    <li>我是2</li>
    <li>我是3</li>
    <li>我是4</li>
</div>

$(".act a").live("click",function(){
    cnitr.tab({
        "class":"active",
        "this":$(this),//必填$(this)，不可修改
        "div":".tab li"//被切换的列表
    })
})
$(".act a").eq(0).click();//默认调用


scroll_b页面滚动到底部时加载更多
参数
isok	boolean	传入true，启动下拉加载
page	number	每页的条数，不传默认是10条。
div		Object	回调然后渲染的div，会在该div底部追加新的列表
fun		text	调用渲染的方法名（必须在cnitr_html函数下的方法）
url		text	异步的链接地址。
json	json	异步的json参数
代码实例
<div class="list"></div>

//渲染列表html
var cnitr_html.addhtml=function(e){
    var html = "";
    html += '<div>'+e[i].name+'</div>';
    return html;
}
//自动回调的写法
cnitr.scroll_b({
    "isok":true, //打开滚动加载，会清除之前的滚动加载的方法。
    "async":true,//true异步请求,false同步请求
    "page":2, //每页显示条数
    "div":".list", //渲染的class，或者id
    "fun":"addhtml", //渲染列表的方法
    "url":"/add/html", //异步调用的方法
    "json":{"name":"llla","id":"53"} //异步参数
});
//自定义回调的写法
cnitr.scroll_b({
    "isok":true, //打开滚动加载，会清除之前的滚动加载的方法。
    "async":true,//true异步请求,false同步请求
    "page":2, //每页显示条数
    "div":".list", //渲染的class，或者id
    "fun":"addhtml", //渲染列表的方法
    "url":"/add/html", //异步调用的方法
    "json":{"name":"llla","id":"53"} //异步参数
},function(e){
//e:异步到的参数
});

page分页渲染

当前的页码会自动添加class="act"作为标识
当前页不能点击，第一页时上一页不能点击，最后一页时下一页不能点击
参数名	参数类型	描述
0	Object	渲染页码的列表的div （如：$(".page")）
1	number	总页码数
2	number	当前页码数
3	number	连续页码数

cnitr.page($(".page"),10,5,3);
cnitr.page_url = function(e){
    //"e"是选中的页码数
    console.log(e);
    //如果是静态渲染，可以回调一下以下的方法回显页码
    //cnitr.page($(".page"),10,e,5);
}

img_src图片懒加载
<img src="加载前默认图片" vua_src="原图地址">
//添加图片懒加载模块
cnitr.img_src();


vua_time时间渲染
yyyy-MM-dd HH:mm:ss	String	年-月-日 时:分:秒
yyyy-MM-dd HH:mm	String	年-月-日 时:分
yyyy-MM-dd	String	年-月-日
HH:mm:ss	String	时:分:秒
不设置参数	null	年-月-日 时:分:秒(默认)
all	String	自动模拟时间差显示

<div cnitr_time="1523523202" cnitr_time_pz="yyyy-MM-dd HH:mm:ss"></div>
<input type="text" cnitr_time="1523823202" cnitr_time_pz="yyyy-MM-dd">
<span cnitr_time="1523523202"></span>
cnitr.vua_time();