var slide;  
var tabs;  
var slide_index;  
var interval;  
function init_tabs(){  
    slide = document.getElementsByClassName("slide");  
    slide_index = slide.length-1;  
    var tabc = document.getElementById("slide-tabs");  
    var html = "";  
    for(var i=0;i<slide.length;i++){  
        html+='<span class="slide-tab" onclick="slide_x('+i+')" > </span>';  
    }  
    tabc.innerHTML=html;  
    tabs=tabc.childNodes;  
    tabs[slide_index].className = addCls(tabs[slide_index].className,"slide-tab-acitve");  
    cInterval();  
}  
function pInterval(){  
    clearInterval(interval);  
    interval = -1;  
}  
function cInterval(){  
    if(interval!=-1)clearInterval(interval);  
    interval = setInterval("auto_next()",5000);  
}  
function auto_next(){  
    slide_out(slide_index);  
    slide_index=(slide_index-1+slide.length)%slide.length;  
    slide_in(slide_index);  
}  
function slide_out(i){  
    slide[i].className=remCls(slide[i].className,'right-in');  
    slide[i].className=remCls(slide[i].className,'left-in');  
    slide[i].className=addCls(slide[i].className,'right-out');  
    tabs[i].className = remCls(tabs[i].className,"slide-tab-acitve");  
}  
function slide_in(i){  
    slide[i].className=remCls(slide[i].className,'left-out');  
    slide[i].className=remCls(slide[i].className,'right-out');  
    slide[i].className=addCls(slide[i].className,'left-in');  
    tabs[i].className = addCls(tabs[i].className,"slide-tab-acitve");  
}  
function slide_x(x){  
    pInterval();  
    x=x%slide.length;  
    slide_out(slide_index);  
    slide_in(x);  
    slide_index=x;  
    cInterval();  
}  
function remCls(o,n){  
    if(o==null||typeof(o)!='string')return o;  
    var x = o.indexOf(n);  
    if(x>-1){  
        if(x>0) o=o.replace(n,'');  
        else o=o.replace(" "+n,'');  
    }  
    return o;  
}  
function addCls(o,n){  
    if(o==null||typeof(o)!='string')return o;  
    if(o.length>0) o+=' '+n;  
    else o+=n;  
    return o;  
}  
function slide_next(){  
    var x=(slide_index-1+slide.length)%slide.length;  
    slide_x(x);  
}  
function slide_last(){  
    pInterval();  
    slide[slide_index].className=remCls(slide[slide_index].className,'left-in');  
    slide[slide_index].className=remCls(slide[slide_index].className,'right-in');  
    slide[slide_index].className=addCls(slide[slide_index].className,'left-out');  
    tabs[slide_index].className = remCls(tabs[slide_index].className,"slide-tab-acitve");  
      
    slide_index=(slide_index+1)%slide.length;  
      
    slide[slide_index].className=remCls(slide[slide_index].className,'left-out');  
    slide[slide_index].className=remCls(slide[slide_index].className,'right-out');  
    slide[slide_index].className=addCls(slide[slide_index].className,'right-in');  
    tabs[slide_index].className = addCls(tabs[slide_index].className,"slide-tab-acitve");  
    cInterval();  
}  