个人打包方法，请谨慎使用
var cnitr = {
	//异步方法
	ajax : function(e,fun){
		var type="post";
		var dataType="json";
		var async = false;
		if(fun){
			var async = true;
		}
		var timeout=1000*60;
		if(e.type){
			type=e.type;
		}
		if(e.dataType){
			dataType=e.dataType;
		}
		if(e.async){
			async=e.async;
		}
		if(e.time){
			timeout=e.time;
		}
		var json_mun=false;
		$.ajax({
			type : type,
			url : e.url,
			data : e.json,
			async:async,
			timeout:timeout,
			dataType : dataType,
			success : function(resp){
				json_mun=resp;
				if(fun){
					fun(json_mun);
					return false;
				}
			},error:function(){
				if(fun){
					fun(json_mun)
					return false;
				}
			}
		});
		return json_mun
	},
	//表单验证
	verify : function(){
		var l = $(".form [verify]").size();
		var e=-1;
		var msg="";
		if(l!=0){
			for(var i=0;i<l;i++){
				var verify_name = $(".form [verify]").eq(i).attr("verify");
				if(verify_name==""){
					verify_name="null";
				}
				var val = $(".form [verify]").eq(i).val();
				var json_mun = {};
				json_mun.name = verify_name;
				json_mun.val = val;
				var chen = cnitr.verify_fun(json_mun);
				if(!chen.isok){
					e=i;
					msg=chen.msg;
					break;
				}
			}
		}
		var  j={};
		if(e==-1){
			j.isok = true;
		}else{
			j.eq = e;
			j.isok = false;
		}
		j.msg = msg;
		return j;
	},
	verify_fun : function(e){
		var retu_mun = true;
		var msg="";
		//验证非空
		if(e.name=="null"){
			if(e.val==""){
				retu_mun = false;
				msg="请填写必填项";
			}
		//验证手机
		}else if(e.name=="phone"){
			if(!(/^1\d{10}$/.test(e.val))){
				retu_mun = false;
				msg="请输入正确的手机号码";
			}
		//验证电话
		}else if(e.name=="tel"){
			if(!(/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/).test(e.val)){
				retu_mun = false;
				msg="请输入正确的电话号码";
			}
		//验证邮箱
		}else if(e.name=="email"){
			var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if(!myreg.test(e.val)){
				retu_mun = false;
				msg="请输入正确的邮箱地址";
			}
		//验证正整数
		}else if(e.name=="number"){
			var ren = '^\+?[1-9][0-9]*$/';
			if(!ren.test(e.val)){
				retu_mun = false;
				msg="请输入正整数";
		    }
		}
		var j={};
		j.isok = retu_mun;
		j.msg = msg;
		return j;
	},
	//回到顶部
	nav_top : function(e){
		var a = 500;
		if(e>0){a=e;a++;a--;}
		$('html, body').animate({
            scrollTop: 0
        },a);
	},
	//获取表单数据
	form_json : function(){
		var json_mun={};
		var l = $(".form input").size();
		for(var i=0;i<l;i++){
			var type = $(".form input").eq(i).attr("type");
			var name = $(".form input").eq(i).attr("name");
			if(name!=""){
				if(type=="radio" || type=="checkbox"){
					if(type=="radio"){
						if($(".form input[type='radio'][name='"+name+"'][checked]").size()>0){
							if($(".form input").eq(i).is(":checked")){
								json_mun[name]=$(".form input").eq(i).val();
							}
						}else{
							json_mun[name]="";
						}
					}else{
						if($(".form input[type='checkbox'][name='"+name+"'][checked]").size()>0){
							if(!json_mun[name]){
								json_mun[name]=[];
							}
							if($(".form input").eq(i).is(":checked")){
								var len=json_mun[name].length;
								json_mun[name][len]=$(".form input").eq(i).val();
							}
						}else{
							json_mun[name]=[];
						}
					}
				}else if(type=="image" || type=="reset" || type=="button"){
					
				}else{
					var val = $(".form input").eq(i).val();
					json_mun[name]=val;
				}
			}
			
		}
		l = $(".form select").size();
		for(var i=0;i<l;i++){
			var name = $(".form select").eq(i).attr("name");
			if(name!=""){
				var val = $(".form select").eq(i).val();
				json_mun[name]=val;
			}
		}
		l = $(".form textarea").size();
		for(var i=0;i<l;i++){
			var name = $(".form textarea").eq(i).attr("name");
			if(name!=""){
				var val = $(".form textarea").eq(i).val();
				json_mun[name]=val;
			}
		}
		return json_mun;
	},
	//切换框架
	tab : function(e){
		var c=e["class"];
		var $this = e.this;
		var div = e.div;
		var i = $this.index();
		if(c){
			$this.siblings().removeClass(c);
			$this.removeClass(c);
			$this.addClass(c);
		}
		$(div).hide();
		$(div).eq(i).show();
	},
	//页面滑动底部加载
	scroll_b : function(e,fun){
		$(window).unbind('scroll');
		var if_add=e.isok;
		var page_mun = 10;
		if(e.page){
			if(e.page>0){
				page_mun=e.page
			}
		}
		$(window).scroll(function(){
			totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
			if(($(document).height()) <= totalheight) {
				if(if_add){
					var l = $(e.div+">div").size();
					if(l==0){
						l = $(e.div+">a").size();
					}
					if(l==0){
						l = $(e.div+" tr").size();
					}
					if(l%page_mun>0){
						return;
					}else{
						//页码
						var page = l/page_mun+1;
						e.json.page = page;
						e.json.offset = page;
						if_add=false;
						var json_mun;
						$(".loading").show();
						if(e.async){
							cnitr.ajax({
								"url":e.url,
								"json":e.json
							},function(data){
								if(data){
									if(fun){
										fun(data);
									}else{
										if(data!=""){
											cnitr_html.add({"data":data,"temp":e.fun,"div":$(e.div)})
											if_add=true;
										}
									}
								}else{
									$(window).unbind('scroll');
								}
								$(".loading").hide();
							})
						}else{
							json_mun = cnitr.ajax({
								"url":e.url,
								"json":e.json
							})
							if(json_mun){
								if(fun){
									fun(data);
								}else{
									if(json_mun!=""){
										cnitr_html.add({"data":data,"temp":e.fun,"div":$(e.div)})
										if_add=true;
									}
								}
							}else{
								$(window).unbind('scroll');
							}
							$(".loading").hide();
						}
					}
				}
			}	
		});
	},
	//div渲染的div; a总页码数; b当前页码数; c连续的页码数
	page : function(div,a,b,c){
		if(a<2){
			return;
		}
		var html = "";
		if(b!=1){
			html+='<a vua_id="'+(b-1)+'">上一页</a>';
		}else{
			html+='<a vua_id="-1">上一页</a>';
		}
		if(!(c<a)){
			for(var i=1;i<a+1;i++){
				if(i==b){
					html+='<a vua_id="'+i+'" class="act">'+i+'</a>';
				}else{
					html+='<a vua_id="'+i+'">'+i+'</a>';
				}
			}
		}else{
			var ok_l = 0;
			var qian_l=0;
			var hou_l=0;
			if(c%2==0){
				var cha = (b+c/2-a-1);
			}else{
				var cha = (b+parseInt(c/2)-a);
			}
			if(cha<0){
				cha=0;
			}
			for(var i=1;i<a+1;i++){
				if(ok_l<c){
					if(i<b){
						if(i>(b-parseInt(c/2)-1-cha)){
							html+='<a vua_id="'+i+'">'+i+'</a>';
							ok_l++;
						}else{
							if(qian_l==0){
								html += "...";
								qian_l++
							}
						}
					}else if(i==b){
						html+='<a vua_id="'+i+'" class="act">'+i+'</a>';
						ok_l++;
					}else{
						html+='<a vua_id="'+i+'">'+i+'</a>';
						ok_l++;
					}
				}else{
					if(hou_l==0){
						html += "...";
						hou_l++
					}
				}
			}
		}
		if(b!=a){
			html+='<a vua_id="'+(b+1)+'">下一页</a>';
		}else{
			html+='<a vua_id="-1">下一页</a>';
		}
		div.html(html);
		div.find("a").unbind();
		div.find("a").click(function(){
			var id = $(this).attr("vua_id");
			id--;id++;
			if($(this).hasClass("act") || id==-1){
				return;
			}
			cnitr.page_url(id);
		})
	},
	files:function(e){
		for(var z=0;z<e.length;z++){
			var data = cnitr_config[e[z]];
			var l = data.length;
			for(var i=0;i<l;i++){
				if(data[i].type=="js"){
					$.getScript(data[i].url+"?v="+data[i].versions);
				}else if(data[i].type=="css"){
					var html='<link rel="stylesheet" type="text/css" href="'+data[i].url+"?v="+data[i].versions+'"/>';
					$("head").append(html);
				}else if(data[i].type=="html"){
					var html=data[i].html;
					$("head").append(html);
				}
			}
		}
	},
	img_src:function(){
		cnitr.img_src_fun();
		cnitr.img_src_scroll = window;
		cnitr.img_src_scroll.onscroll = function(){
			cnitr.img_src_fun();
	    };
	},
	img_src_fun:function(){
		var l = $("img[vua_src]").size();
		if(l==0){
			return;
		}
	   	var b = $(window).height();
	   	var c = $("body").scrollTop();
		for(var i=0;i<l;i++){
			var $this = $("img[vua_src]").eq(i);
			var a = $this.offset().top;
		   	if(a<(b+c)){
		   		$this.attr("src",$this.attr("vua_src"));
		   		$this.attr("vua_src_remove","yes");
		   	}
		}
		$this.removeAttr("vua_src_remove")
	},
	vua_time:function(){
		cnitr.vua_time_fun();
	},
	vua_time_fun:function(){
		var l = $("[cnitr_time]").size();
		if(l==0){
			return;
		}
		for(var i=0;i<l;i++){
			var $this = $("[cnitr_time]").eq(i);
			var num = $this.attr("cnitr_time");
		   	if(num==0 || num==null || !num || num==""){
		   		
		   	}else{
		   		var num_pz=$this.attr("cnitr_time_pz");
			   	if($this.prop("tagName")=="INPUT"){
			   		$this.val(cnitr.time_ran(num,num_pz));
			   	}else{
			   		$this.text(cnitr.time_ran(num,num_pz));
			   	}
		   	}
   		}
	   	$this.removeAttr("cnitr_time");
	   	$this.removeAttr("cnitr_time_pz");
	},
	time_ran:function(a,b){
		a++;a--;a=a*1000
		var $this = new Date(a);
		if(b=="yyyy-MM-dd HH:mm:ss"){
			return $this.getFullYear()+"-"+cnitr.repair($this.getMonth()+1)+"-"+cnitr.repair($this.getDate())+" "+cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes())+":"+cnitr.repair($this.getSeconds());
		}else if(b=="yyyy-MM-dd HH:mm"){
			return $this.getFullYear()+"-"+cnitr.repair($this.getMonth()+1)+"-"+cnitr.repair($this.getDate())+" "+cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes());
		}else if(b=="yyyy-MM-dd"){
			return $this.getFullYear()+"-"+cnitr.repair($this.getMonth()+1)+"-"+cnitr.repair($this.getDate());
		}else if(b=="HH:mm:ss"){
			return cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes())+":"+cnitr.repair($this.getSeconds());
		}else if(b=="all"){
			return cnitr.time_ran_all(a);
		}else{
			return $this.getFullYear()+"-"+cnitr.repair($this.getMonth()+1)+"-"+cnitr.repair($this.getDate())+" "+cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes())+":"+cnitr.repair($this.getSeconds());
		}
	},
	time_ran_all:function(e){
		var $me = new Date();
		var $this = new Date(e);
		if((($me.getTime()/1000)-(e/1000))<0){
			return $this.getFullYear()+"年"+cnitr.repair($this.getMonth()+1)+"月"+cnitr.repair($this.getDate())+"日 "+cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes());
		}
		if((($me.getTime()/1000)-(e/1000))<60){
			return parseInt($me.getTime()/1000-(e/1000))+"秒前";
		}else if((($me.getTime()/1000)-(e/1000))<3600){
			return parseInt(($me.getTime()/1000-(e/1000))/60)+"分钟前";
		}else if((($me.getTime()/1000)-(e/1000))<3600*24){
			return parseInt(($me.getTime()/1000-(e/1000))/3600)+"小时前";
		}else if((($me.getTime()/1000)-(e/1000))<3600*24*30){
			return parseInt(($me.getTime()/1000-(e/1000))/(3600*24))+"天前";
		}else if((($me.getTime()/1000)-(e/1000))<3600*24*30*12){
			return parseInt(($me.getTime()/1000-(e/1000))/(3600*24*30))+"月前";
		}else{
			return $this.getFullYear()+"年"+cnitr.repair($this.getMonth()+1)+"月"+cnitr.repair($this.getDate())+"日 "+cnitr.repair($this.getHours())+":"+cnitr.repair($this.getMinutes());
		}
	},
	repair : function(e){
		if(e<10){
			return "0"+e;
		}else{
			return e;
		}
	}
}
var cnitr_html={
	html:function(e,temp,c){
		cnitr_html.funs=c;
		var data = cnitr_html.fun(e);
		var html = "";
		if(data.len==0){
			return "";
		}
		for(var i=0;i<data.len;i++){
			html+=cnitr_html[temp](data.list[i],i);
		}
		cnitr_html.funs(html);
	},
	fun:function(e){
		var json_numn = {};
		if(e.list){
			json_numn.list=e.list;
		}else if(e.data){
			json_numn.list=e.data;
		}else{
			json_numn.list=e;
		}
		json_numn.len = json_numn.list.length;
		return json_numn;
	},
	add:function(e){
		cnitr_html.html(e.data,e.temp,function(a){
			e.div.append(a);
		})
	}
}
