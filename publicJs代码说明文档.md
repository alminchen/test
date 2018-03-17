ajax方法<br/>

//代码区域,同步的方式<br/>
var data = cnitr.ajax({<br/>
    "url":"/add/name",<br/>
    "json":{"name":"张三","mobile":"13800000000"}<br/>
})<br/>
if(data){<br/>
    //正确回调<br/>
}else{<br/>
    //网络错误。<br/>
}
//代码区域,异步的方式<br/>
cnitr.ajax({<br/>
    "url":"/add/name",<br/>
    "json":{"name":"张三","mobile":"13800000000"}<br/>
},function(data){<br/>
    if(data){<br/>
        //正确回调<br/>
    }else{<br/>
        //网络错误。<br/>
    }<br/>
})<br/>

verify表单验证<br/>
参数有：null	不能为空<br/>
		phone	验证手机号，1开头的11位数字<br/>
		tel		验证电话号码<br/>
		email	验证邮箱地址<br/>
		number<br/>
实例<br/>
//html<br/>
<form class="form"><br/>
    <input verify="null"><br/>
</form><br/>
//js结合按钮来使用<br/>
var data = cnitr.verify();<br/>
data.isok;//true/false验证通过为true;//返回值<br/>
data.eq;//验证不通过时，返回eq为第几个验证失败$("input[verify='null']").eq(eq); //返回值<br/>
data.msg;//验证不通过时提示错误语。//返回值<br/>

verify_fun独立验证 <br/>
name	null/phone/tel/email/number	<br/>
val		text<br/>
//实例js<br/>
var data = cnitr.verify_fun({<br/>
    "name":"phone"<br/>
    "val":"13800000000"<br/>
})<br/>
data.isok;//true/false验证通过为true;<br/>
data.msg;//验证不通过时提示错误语。<br/>

回到顶部--nav_top滑动到页面顶部<br/>
num	number	移动时长（值越小移动越快）<br/>
cnitr.nav_top(300)//300就是NUM值<br/>

form_json获取表单数据<br/>
//代码区域<br/>
<form class="form"><br/>
    <input type="text" name="name" value="李四"><br/>
    <input type="text" name="mobile" value="13800000000"><br/>
    <input type="checkbox" name="checkbox" id="" value="1" checked="checked"><br/>
    <input type="checkbox" name="checkbox" id="" value="2"><br/>
    <input type="checkbox" name="checkbox" id="" value="3" checked="checked"><br/>
    <input type="checkbox" name="radio" id="" value="1"><br/>
    <input type="checkbox" name="radio" id="" value="2"><br/>
    <input type="checkbox" name="radio" id="" value="3" checked="checked"><br/>
    <select name="sex"><br/>
        <option value="0" selected="selected">男</option><br/>
        <option value="1">女</option><br/>
    </select><br/>
    <textarea name="content" rows="" cols="">我赛</textarea><br/>
</form><br/>
//代码区域
var data = cnitr.form_json();<br/>
data:{"name":"李四","mobile":"13800000000","checkbox":["1","3"],"radio":"3","sex":"0","content":"我赛"}<br/>
//data[name]=val;<br/>
//name为控件在name值;<br/>
//val得到的是控件的value;<br/>


tab切换
<div class="act"><br/>
    <a>显示1</a><br/>
    <a>显示2</a><br/>
    <a>显示3</a><br/>
    <a>显示4</a><br/>
</div><br/>
<div class="tab"><br/>
    <li>我是1</li><br/>
    <li>我是2</li><br/>
    <li>我是3</li><br/>
    <li>我是4</li><br/>
</div><br/>

$(".act a").live("click",function(){<br/>
    cnitr.tab({<br/>
        "class":"active",<br/>
        "this":$(this),//必填$(this)，不可修改<br/>
        "div":".tab li"//被切换的列表<br/>
    })<br/>
})<br/>
$(".act a").eq(0).click();//默认调用<br/>


scroll_b页面滚动到底部时加载更多<br/>
参数<br/>
isok	boolean	传入true，启动下拉加载<br/>
page	number	每页的条数，不传默认是10条。<br/>
div		Object	回调然后渲染的div，会在该div底部追加新的列表<br/>
fun		text	调用渲染的方法名（必须在cnitr_html函数下的方法）<br/>
url		text	异步的链接地址。<br/>
json	json	异步的json参数<br/>
代码实例
<div class="list"></div><br/>

//渲染列表html<br/>
var cnitr_html.addhtml=function(e){<br/>
    var html = "";<br/>
    html += '<div>'+e[i].name+'</div>';<br/>
    return html;<br/>
}
//自动回调的写法
cnitr.scroll_b({<br/>
    "isok":true, //打开滚动加载，会清除之前的滚动加载的方法。<br/>
    "async":true,//true异步请求,false同步请求<br/>
    "page":2, //每页显示条数<br/>
    "div":".list", //渲染的class，或者id<br/>
    "fun":"addhtml", //渲染列表的方法<br/>
    "url":"/add/html", //异步调用的方法<br/>
    "json":{"name":"llla","id":"53"} //异步参数<br/>
});
//自定义回调的写法<br/>
cnitr.scroll_b({<br/>
    "isok":true, //打开滚动加载，会清除之前的滚动加载的方法。<br/>
    "async":true,//true异步请求,false同步请求<br/>
    "page":2, //每页显示条数<br/>
    "div":".list", //渲染的class，或者id<br/>
    "fun":"addhtml", //渲染列表的方法<br/>
    "url":"/add/html", //异步调用的方法<br/>
    "json":{"name":"llla","id":"53"} //异步参数<br/>
},function(e){<br/>
//e:异步到的参数<br/>
});

page分页渲染<br/>

当前的页码会自动添加class="act"作为标识<br/>
当前页不能点击，第一页时上一页不能点击，最后一页时下一页不能点击<br/>
参数名	参数类型	描述<br/>
0	Object	渲染页码的列表的div （如：$(".page")<br/>）
1	number	总页码数<br/>
2	number	当前页码数<br/>
3	number	连续页码数<br/>

cnitr.page($(".page"),10,5,3);
cnitr.page_url = function(e){<br/>
    //"e"是选中的页码数<br/>
    console.log(e);<br/>
    //如果是静态渲染，可以回调一下以下的方法回显页码<br/>
    //cnitr.page($(".page"),10,e,5);<br/>
}<br/>

img_src图片懒加载<br/>
<img src="加载前默认图片" vua_src="原图地址"><br/>
//添加图片懒加载模块<br/>
cnitr.img_src();<br/>


vua_time时间渲染<br/>
yyyy-MM-dd HH:mm:ss	String	年-月-日 时:分:秒<br/>
yyyy-MM-dd HH:mm	String	年-月-日 时:分<br/>
yyyy-MM-dd	String	年-月-日<br/>
HH:mm:ss	String	时:分:秒<br/>
不设置参数	null	年-月-日 时:分:秒(默认)<br/>
all	String	自动模拟时间差显示<br/>

<div cnitr_time="1523523202" cnitr_time_pz="yyyy-MM-dd HH:mm:ss"></div><br/>
<input type="text" cnitr_time="1523823202" cnitr_time_pz="yyyy-MM-dd"><br/>
<span cnitr_time="1523523202"></span><br/>
cnitr.vua_time();<br/>