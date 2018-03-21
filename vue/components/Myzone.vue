<template>
  <div class="myzone_index">
    <div class="myzone_content">
      <!-- 头 -->
      <div class="myzone_info clear">
        <p style="">{{userlist.emply_name}}</p>
        <p class="fon_14">联系人：{{userlist.u_name}}</p>
        <p class="tel_ma_max font_12">联系电话：{{userlist.mobile}}</p>
        <p class="font_12">送货地址：{{userlist.adress}}</p>
        <span class="login_out">退出登录</span>
      </div>
    </div>
    <!-- 3分 -->
    <div v-for="(n,index) in piclist" :key = "index">
    	<div class="three_lan">
	        <div class="tree_lan_tit">
	          <div class="tit_left">
	            	订单号：<span>212121123123</span>
	          </div>
	          <div class="tit_right">
	            <span>已提交</span>
	          </div>
	        </div>
	    </div>
	    <div class="scroll_x">
	      <div class="scroll_box">
						<swiper :options="swiperOption" ref="mySwiper">
						 <!-- slides -->
						 <swiper-slide v-for = "(n , index) in 10" :key = 'index'>I'm Slide {{n}}</swiper-slide>
						</swiper>
	      </div>
	    </div> 
	    <div class="cancel_dingdan">
	        	<div class="can_fl_l"><span>共<i>2</i>件商品</span><span>总价<i class="bol_font">￥12.00</i></span><span class="cancel_btn">取消订单</span></div>
	    </div>
    </div>
    
    <!-- 栏 -->
    <Fixednav></Fixednav>
  </div>
</template>

<script>
import Fixednav from './small_components/Fixed_nav';
import { swiper, swiperSlide } from 'vue-awesome-swiper';
export default {
  name: 'myzone',
  data () {
    return {
      uname: '',
      swiperOption: {
       notNextTick: true,
       autoplay: 3000,
       slidesPerView: 3,
       spaceBetween: 30,
     },
     userlist:{},
     piclist:{}
    };
  },
  mounted () {
		this.$http.get("http://192.168.8.100/rongjie/public/index.php/front/Ordering/showOrderById").then((res) => {
//			console.log(0)
			this.piclist = res.body.data.goodList;
			this.userlist = res.body.data.user;
		})
  },
  computed: {
    
  },
  methods: {

  },
  components: {
    Fixednav,
    swiper,
 		swiperSlide
  }
};
</script>

<style lang="less" scoped>
.myzone_content{
  width:10rem;
  /*height:3rem;*/
  /*margin-top:0.98rem;*/
  box-sizing:border-box;
  background:#1EBF98;
  img{
    width:1.4rem;
    height:1.4rem;
    border-radius:50%;float: left;
  }
  .myzone_uid{
    float: left;
    margin-left:.5rem;
    color:#fff;
    h3{
      font-size:.7rem;
    }
    p{
      font-size:.4rem;
    }
  }
}
.three_lan{
  display: table;
  width: 100%;
  border-bottom: 1px solid #ddd;
  background-color: #fff;
  margin-top: 8px;
  .three_lan_{
    display: table-cell;
    width: 33.3333%;
    vertical-align: middle;
    text-align: center;
    p.big_colorful{
      line-height:.4rem;
    }
    .index-2FmrF_0 {
        padding: .4rem 0 0;
        font-size: .6rem;
        line-height: .6rem;
        font-weight: 700;
    }
    .index-2V-Hh_0 {
        font-size: .32rem;
        line-height: .32rem;
    }
    .index-3S6cZ_0 {
        font-size: .32rem;
        line-height: .37rem;
        font-weight: 500;
        color: #666;
    }

  }
}
div.some_bar{
  width: 10rem;
  height: 1.1rem;
  padding: 0 .4rem;
  box-sizing: border-box;
  background:#fff;
  font-size:.4rem;
  line-height:1.1rem;
  border-top:1px solid #dedede;
  &.first-c{
    margin-top: .3rem;
    boeder:none;
  }
  svg{
    width: .4rem;
    height: .4rem;
  }
  span{
    margin-left:.2rem;
  }
}
.myzone_info{
  padding: 0.3rem .4rem 0.3rem;
  color: #fff;
  font-size: 36px;
  position: relative;
  p{
    height: .5rem;
    line-height: .5rem
  }
  .tel_ma_max{
    margin-top: .26rem
  }
  .font_12{
  	font-size: 24px;
  }
  .fon_14{
  	font-size: 28px;
  	margin-top: 10px;
  }
  span.login_out{
    display: block;
    width: 1.76rem;
    height: .6rem;
    text-align: center;
    line-height: .6rem;
    background: #fff;
    color: #666;
    font-size: 24px;
    border-radius: .3rem;
    position:absolute;
    right: 12px;
    top: 00.3rem
  }
}
.tree_lan_tit{
	padding: 0 0.4rem;
	height: 0.6rem;
	line-height: 0.6rem;
	font-size: 24px;
	color: #666;
	div{
		display: inline-block;
	}
	.tit_left{
		float: left;
	}
	.tit_right{
		float: right;
		color: #fe5579;
	}
}
.cancel_dingdan{
	padding: 0 0.4rem;
	height: 1rem;
	line-height: 1rem;
	font-size: 24px;
	color: #666;
	.can_fl_l{
		float: right;
		span{
			display: inline-block;
			line-height: 1rem;
			margin-right: 24px;
			i{
				font-style: normal;
			}
			.bol_font{
				font-weight: bold;
				margin-left: 10px;
				font-size: 26px;
			}
		}
		.cancel_btn{
			width: 1.76rem;
	    height: .6rem;
	    text-align: center;
	    line-height: .6rem;
	    background: #fff;
	    color: #666;
	    font-size: 24px;
	    border-radius: .3rem;
	    box-shadow: 0px 0px 0px #fafafa;
		}
	}
}
</style>
