<template>
  <div class="business_box">
  	<div class="re_search">
      <input type="search" class="v-md" placeholder="请输入商品名称"	>
      <img src="../images/searcr.png"/>
      <span class="btn_sure">确定</span>
    </div>
    <section class="business_content">
        <div class="menu-wrapper" ref=menu-wrapper>
          <ul class="business_left" ref="businessLeft" >
               <li v-for="(item, index) in 10" :key="index" :class='{active_ia:index == 0}'>
                 {{ item }}
                 <span class="left_red" v-if="0">{{ item}}</span>
               </li>
           </ul>
        </div>
        <div class="business_wrapper" ref=food-wrappe>
          <ul class="business_right" ref="ullist">
              <li v-for=" (n, index) in 1 " :key="index">
                <section class="single_commodity" v-for=" (x, index) in 1 " :key="index">
                  <div class="single_l">
                    <img src="../images/slider-pic/slider-pic1.jpeg" alt="">
                  </div>
                  <div class="single_r">
                    <h4>猪肉羊肉/<em>斤</em></h4>
                    <p>￥12.00</p>
                    <div class="add_remove">
                      <div class="add_remove_btn">
                        <img src="../images/shop_minu.png"/>
                        <!-- ???? shoppingCarList[x.one_food_id][count] 会报错count未定义 改用 '.'就好了 ????-->
                        <span class="commodity_count">{{x}}</span>
                        <!-- nav_click_f(x.category_id, $event)内联$event传递DOM事件与其他参数 -->
                        <img src="../images/shop_add.png"/>
                      </div>
                    </div>
                  </div>
                </section>
              </li>
          </ul>
        </div>

    </section>
    <section class="push_dingdan">
    	<div class="fix_dingdan">
    		<span class="total_num">共<i>2</i>件商品</span>
	    	<span class="total_price">总价<em>￥12.00</em></span>
	    	<span class="push_houtai">提交订单</span>
    	</div>
    </section>
    <Fixednav></Fixednav>
  </div>
</template>
<script>
	import Fixednav from './small_components/Fixed_nav';
  import BScroll from 'better-scroll';
	export default {
  name: 'business',
	  data () {
	    return {
	      showMe: false
	    };
	  },
	  computed: {
	  },
	  mounted () {
      this._initScroll();
      this._calculateHeight();
	  },
	  methods: {
      click(obj,num){
        this.$http()
      }
	  },
	  components: {
	  	Fixednav
	  }
};
</script>

<style lang="less">
	.re_search{
	  background:#1ebf98;
	  line-height:0;
	  padding: .2rem;
	  position: relative;
	  input[type="search"]{
	    display:inline-block;
	    height:.9rem;
	    width:8rem;
	    outline: none;
	    border: none;
	    border-radius:.45rem;
	    background:#f2f2f2;
	    box-sizing: border-box;
	    padding: 0 0.9rem;
	    font-size:.4rem;
	    vertical-align: top;
	  }
	  img{
	  	width: 0.58rem;
	  	height: 0.58rem;
	  	position: absolute;
	  	left: 0.42rem;
	  	top: 50%;
	  	margin-top: -0.25rem;
	  }
	  span{
	  	display: inline-block;
	  	width: 1rem;
	  	height: 0.9rem;
	  	font-size: 0.42rem;
	  	vertical-align: top;
	  	line-height: 0.9rem;
	  	text-align: center;
	  	color: #fff;
	  }
	}
.business_content{
    /*padding-bottom:3rem;*/
    box-sizing:border-box;
    position:relative;
    height: 100%;
    overflow: hidden;
    ul{
      -webkit-overflow-scrolling: touch;
      overflow-y:auto;
      height:100%;
      &.business_left{
        width:2.5rem;
        float:left;
        li{
          padding:.45rem .3rem;
          font-size:.4rem;
          position:relative;
          border-bottom: 1px solid #ccc;
          position:relative;
          .left_red{
            background:#ff461d;
            color:#fff;
            position:absolute;
            right:0.08rem;
            top:0.08rem;
            font-size:.3rem;
            min-width: .4rem;
            text-align:center;
            border-radius:.2rem;
            padding:.02rem .05rem;
          }
        }
        li.active_ia{
          background:#fff;
          &:after{
            content:'';
            position:absolute;
            left:0;
            top:0;
            width:.1rem;
            height:100%;
            background:#1ebf98;
          }
        }

      }
      &.business_right{
        margin-left:2.5rem;
        background:#fff;
        li{
          .type_title{
            padding:.2rem;
            box-sizing:border-box;
            width:100%;
            background:#f1f1f1;
            line-height:.6rem;
            strong{
              font-size: .45rem;
              color:#666;
            }
            span{
              font-size:.3rem;
              color:#999;
            }
          }
          .single_commodity{
            background:#fff;
            padding:.3rem;
            border-bottom: 1px solid #ccc;
            .single_l{
              width:1.5rem;
              height:1.5rem;
              img{
                width:100%;
              }
              float: left;
            }
            .single_r{
              margin-left:1.7rem;
              h4{
                font-size:.5rem;
                color: #333;
                em{
                	font-style: normal;
                	color: #666;
                	font-size: 14px;
                }
              }
              p{
                font-size:16px;
                color:#fe5579;
                margin-top: 16px;
              }
              .xiaolq{
                font-size:.4rem;
                color:#666;
              }
              .add_remove{
                margin-top:.2rem;
                height:1rem;
                line-height:.5rem;
                font-size:.4rem;
                span{
                  font-size:.45rem;
                  font-weight: 0;
                  color:#f60;
                  vertical-align:middle;
                }
                .add_remove_btn{
                  float:right;
                  .commodity_count{
                    color:#666;
                    margin:0 .15rem;
                  }
                  img{
                  	width: 0.7rem;
                  	height: 0.7rem;
                  	vertical-align: middle;
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  .push_dingdan{
  	padding-bottom: 2rem;
  	width: 100%;
  	height:2.4rem;
  	/*overflow: hidden;*/
  	vertical-align: middle;
  	line-height: 2.4rem;
  	/*position: fixed;
  	background: #fff;
  	left: 0;
  	bottom: 150px;*/
  	span{
  		display: inline-block;
  		font-size:28px;
  		color: #666;
  		vertical-align: middle;
  		i,em{
  			font-style: normal;
  		}
  		em{
  			color: #fe5579;
  		}
  	}
  	.total_num{
  		padding: 0 24px;
  	}
  	.push_houtai{
  		float: right;
  		width: 4.14rem;
  		height: 1.2rem;
  		background: #1ebf98;
  		color: #fff;
  		text-align: center;
  		line-height: 1.2rem;
  		border-radius: 0.3rem;
  		margin-right: 24px;
  		margin-top: 55px;
  	}
  }
</style>
