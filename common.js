var own_common = {
	//去除空格  type 1-所有空格  2-前后空格  3-前空格 4-后空格
	trim:function(str,type){
		switch (type){
	        case 1:return str.replace(/\s+/g,"");
	        case 2:return str.replace(/(^\s*)|(\s*$)/g, "");
	        case 3:return str.replace(/(^\s*)/g, "");
	        case 4:return str.replace(/(\s*$)/g, "");
	        default:return str;
	    }
	},
	/*type
	1:首字母大写   
	2：首页母小写
	3：大小写转换
	4：全部大写
	5：全部小写
	 * */
	changeCase:function(str,type){
			function ToggleCase(str) {
		        var itemText = ""
			        str.split("").forEach(
			            function (item) {
			                if (/^([a-z]+)/.test(item)) {
			                    itemText += item.toUpperCase();
			                }
			                else if (/^([A-Z]+)/.test(item)) {
			                    itemText += item.toLowerCase();
			                }
			                else{
			                    itemText += item;
			                }
			            });
			        return itemText;
		    }
		
		    switch (type) {
		        case 1:
		            return str.replace(/^(\w)(\w+)/, function (v, v1, v2) {
		                return v1.toUpperCase() + v2.toLowerCase();
		            });
		        case 2:
		            return str.replace(/^(\w)(\w+)/, function (v, v1, v2) {
		                return v1.toLowerCase() + v2.toUpperCase();
		            });
		        case 3:
		            return ToggleCase(str);
		        case 4:
		            return str.toUpperCase();
		        case 5:
		            return str.toLowerCase();
		        default:
		            return str;
		    }
	},
	//字符串替换(str字符串,AFindText要替换的字符,ARepText替换成什么)
	replaceAll:function(str,AFindText,ARepText){
		raRegExp = new RegExp(AFindText,"g");
　　　		return str.replace(raRegExp,ARepText);
	},
	//count取值范围0-36
	randomNumber:function(count) {
		return Math.random().toString(count).substring(2);
	},
	//查找字符串出现了多少次 str字符串 ,出现多少次的strSplit标记
	countStr:function(str,strSplit){
		 return str.split(strSplit).length-1
	},
	//利用ES6的set方法
	removeRepeatArray:function(str){
		return Array.from(new Set(arr))
	},
	//查找数组中出现多少次该字符:obj数组或者对象, ele查找的条件
	getEleCount:function(obj, ele){
		var num = 0;
		    for (var i = 0, len = obj.length; i < len; i++) {
		        if (ele == obj[i]) {
		            num++;
		        }
		    }
		    return num;
	},
	//返回剩余时间
	getEndTime:function(endTime){
		var startDate=new Date();  //开始时间，当前时间
	    var endDate=new Date(endTime); //结束时间，需传入时间参数
	    var t=endDate.getTime()-startDate.getTime();  //时间差的毫秒数
	    var d=0,h=0,m=0,s=0;
	    if(t>=0){
	      d=Math.floor(t/1000/3600/24);
	      h=Math.floor(t/1000/60/60%24);
	      m=Math.floor(t/1000/60%60);
	      s=Math.floor(t/1000%60);
	    } 
	    return "剩余时间"+d+"天 "+h+"小时 "+m+" 分钟"+s+" 秒";
	},
	//设置url参数
	//ecDo.setUrlPrmt({'a':1,'b':2})
	//result：a=1&b=2
	setUrlPrmt: function (obj) {
	    var _rs = [];
	    for (var p in obj) {
	        if (obj[p] != null && obj[p] != '') {
	            _rs.push(p + '=' + obj[p])
	        }
	    }
	    return _rs.join('&');
	},
	getUrlPrmt: function (url) {
	    url = url ? url : window.location.href;
	    var _pa = url.substring(url.indexOf('?') + 1),
	        _arrS = _pa.split('&'),
	        _rs = {};
	    for (var i = 0, _len = _arrS.length; i < _len; i++) {
	        var pos = _arrS[i].indexOf('=');
	        if (pos == -1) {
	            continue;
	        }
	        var name = _arrS[i].substring(0, pos),
	            value = window.decodeURIComponent(_arrS[i].substring(pos + 1));
	        _rs[name] = value;
	    }
	    return _rs;
	},
	//手机型号判断
	browserInfo: function (type) {
	    switch (type) {
	        case 'android':
	            return navigator.userAgent.toLowerCase().indexOf('android') !== -1
	        case 'iphone':
	            return navigator.userAgent.toLowerCase().indexOf('iphone') !== -1
	        case 'ipad':
	            return navigator.userAgent.toLowerCase().indexOf('ipad') !== -1
	        case 'weixin':
	            return navigator.userAgent.toLowerCase().indexOf('micromessenger') !== -1
	        default:
	            return navigator.userAgent.toLowerCase()
	    }
	},
	//滚动图片懒加载
	loadImg: function (className, num, errorUrl) {
	    var _className = className || 'ec-load-img', _num = num || 0, _this = this,_errorUrl=errorUrl||null;
	    var oImgLoad = document.getElementsByClassName(_className);
	    for (var i = 0, len = oImgLoad.length; i < len; i++) {
	        //如果图片已经滚动到指定的高度
	        if (document.documentElement.clientHeight + document.documentElement.scrollTop > oImgLoad[i].offsetTop - _num && !oImgLoad[i].isLoad) {
	            //记录图片是否已经加载
	            oImgLoad[i].isLoad = true;
	            //设置过渡，当图片下来的时候有一个图片透明度变化
	            oImgLoad[i].style.cssText = "transition: ''; opacity: 0;"
	            if (oImgLoad[i].dataset) {
	                this.aftLoadImg(oImgLoad[i], oImgLoad[i].dataset.src, _errorUrl, function (o) {
	                    //添加定时器，确保图片已经加载完了，再把图片指定的的class，清掉，避免重复编辑
	                    setTimeout(function () {
	                        if (o.isLoad) {
	                            _this.removeClass(o, _className);
	                            o.style.cssText = "";
	                        }
	                    }, 1000)
	                });
	            } else {
	                this.aftLoadImg(oImgLoad[i], oImgLoad[i].getAttribute("data-src"), _errorUrl, function (o) {
	                    //添加定时器，确保图片已经加载完了，再把图片指定的的class，清掉，避免重复编辑
	                    setTimeout(function () {
	                        if (o.isLoad) {
	                            _this.removeClass(o, _className);
	                            o.style.cssText = "";
	                        }
	                    }, 1000)
	                });
	            }
	            (function (i) {
	                setTimeout(function () {
	                    oImgLoad[i].style.cssText = "transition:all 1s; opacity: 1;";
	                }, 16)
	            })(i);
	        }
	    }
	},
	//星星评级优化
	itemClass:function(score,nums,cls_on,cls_off,cls_half){
		var LENGTH = nums || 5, //星星等级
			CLS_ON = cls_on || 'icon-grade-full', //全星
			CLS_OFF = cls_off || 'icon-grade-empty', //空星
			CLS_HALF = cls_half || 'icon-grade-half', // 半星
			result = [],
			score = Math.floor(score * 2) / 2, //取值评分数值优化
			hasDecimal = score %1 ! == 0, //判断是不是有半星
			integer = Math.floor(score); //取整数值
			for (var i = 0; i < integer; i++) {
				result.push(CLS_ON)
			}
			if( hasDecimal ){
				result.push(CLS_HALF)
			}
			if( result.length < LENGTH ){
				result.push(CLS_OFF)
			}
		return result;
	}

}
