<template>
  <div class="business_box">
  	<div class="re_nav_fixed">
  		<div class="re_search">
	      <input type="search" class="v-md" placeholder="请输入商品名称"	>
	      <img src="../images/searcr.png"/>
	      <span class="btn_sure">确定</span>
	    </div>
  	</div>
    <section class="business_content">
        <div class="menu-wrapper" ref=menu-wrapper>
          <ul class="business_left" ref="businessLeft" >
               <li v-for="(item, index) in catalist" :key="index" :class='{active_ia:index == 0}' :data-id = "item.id"  @click='getDetail(item.id)'>
                 {{ item.name }}
                 <span class="left_red" v-if="0">{{ item}}</span>
               </li>
           </ul>
        </div>
        <div class="business_wrapper" ref=food-wrappe>
          <ul class="business_right" ref="ullist">
              <li>
                <section class="single_commodity" v-for=" (x, index) in catalist " :key="index">
                  <div class="single_l">
                    <img src="../images/slider-pic/slider-pic1.jpeg" alt="">
                  </div>
                  <div class="single_r">
                    <h4>{{x.className}}/<em>斤</em></h4>
                    <p>￥12.00</p>
                    <div class="add_remove">
                      <div class="add_remove_btn">
                        <img src="../images/shop_minu.png" @click="reduce_food(x.classID)" v-if="shoppingCarList[x.classID]"/>
                        <!-- ???? shoppingCarList[x.one_food_id][count] 会报错count未定义 改用 '.'就好了 ????-->
                        <span class="commodity_count" v-if="shoppingCarList[x.classID]">{{shoppingCarList[x.classID].count}}</span>
                        <!-- nav_click_f(x.category_id, $event)内联$event传递DOM事件与其他参数 -->
                        <img src="../images/shop_add.png" @click="add_food(x, x, $event)"/>
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
    		<span class="total_num">共<i>{{allCount}}</i>件商品</span>
	    	<span class="total_price">总价<em>￥{{totalPrice}}</em></span>
	    	<span class="push_houtai" @click="pushorder();">提交订单</span>
    	</div>
    </section>
    <Fixednav></Fixednav>
  </div>
</template>
<script>
	import Fixednav from './small_components/Fixed_nav';
	export default {
  name: 'business',
	  computed: {
//	  	console.log(this.shoppingCarList)	
	  },
	  beforeCreate () {
			this.$http.get("http://192.168.8.100/rongjie/public/index.php/front/index/getCataList").then((res) => {
				this.catalist = res.body.data.cataList;
				console.log(this.catalist)
			})
	  },
	  methods: {
      add_food (n, x, e) {
      	// n 为大类 x为大类种商品
	      // 大类标记 c1 ,大类名字 热销榜 ,商品名 吮指原味鸡 ,单个商品id 100001 ,单价 11
	      // console.log(n.type_accumulation, n.name, x.name, x.one_food_id, x.unit_price);
	      this.add_shopping_car(x.classID, x.className, 1, x.classID, 11);
	    },
	    // 向购物车添加
	    add_shopping_car (type, typename, foodname, foodid, foodprice) {
	      if (!this.shoppingCarList[foodid]) {
//	        this.shoppingCarList[foodid] = {
//	          
//	        };
				this.$set(this.shoppingCarList,foodid,{
					'type_accumulation': type,
		          'type_name': typename,
		          'name': foodname,
		          'one_food_id': foodid,
		          'unit_price': foodprice,
          'count': 1
				})

	      } else {
	        this.shoppingCarList[foodid].count++;
	      }
//	      this.count = this.shoppingCarList[foodid].count;
	      // 购物车改变 相关计算
	      this.spChangeComputeAll();
	    },
	    // 减去单个食物--
	    reduce_food (foodid) {
	      // console.log(this.shoppingCarList[foodid].count);
	      if (this.shoppingCarList && this.shoppingCarList[foodid].count > 0) {
	        this.shoppingCarList[foodid].count--;
	        this.shoppingCarList[foodid].count <= 0 && delete this.shoppingCarList[foodid];
	      }
	      console.log(this.shoppingCarList)
	      // 购物车改变 相关计算
	      this.spChangeComputeAll();
	    },
	    // 购物车改变 相关计算
	    spChangeComputeAll () {
		      var allPrice = 0;
		      let alcount = 0;
		      for (var z in this.shoppingCarList) {
		        // +=数量乘单价
		        alcount += this.shoppingCarList[z].count;
		        allPrice += this.shoppingCarList[z].count * this.shoppingCarList[z].unit_price;
		      }
		      this.allCount = alcount;
		      this.totalPrice = allPrice;
		      console.log(this.allCount)
			},
			pushorder(){
				this.$http.get("http://192.168.8.100/rongjie/public/index.php/front/Ordering/addOrder",{
					data:{"id":1,"good_num":2}
				}).then((res) => {
					if(res.body.type == 1 ){
						var push = { 'id':1,'good_num':2 };
						var str = JSON.stringify(push);
						localStorage.setItem("one",str);
						this.$router.push("/sureorder")
					}
				})
			},
			getDetail(id){
				this.$http.get('http://192.168.8.100/rongjie/public/index.php/front/index/getGoodsList?cata_id'+id).then((res) =>{
//					console.log(res.body.data.goodList.data);
					this.catalist = res.body.data.goodList.data
				})
			}
	  },
	  data () {
	    return {
		     showMe: true,
	      // 计算商品区域高度
	      computedContentHeight: window.innerHeight - (window.innerWidth / 10 * 4.2),
	      // 控制显示食物还是显示评价
	      changeShowType: 'food',
	      // 购物车列表
	      shoppingCarList: {},
	      // 大类数量
	      reNub: {},
	      // 购物车总数
	      allNub: 0,
	      // 商品总价格
	      totalPrice: 0,
	      // 最终价格（加运费）
	      allTotalPrice: 0,
	      // 是否弹出支付窗口
	      alertBoxShow: false,
	      // 是否弹出购物车
	      shoppingCarShow: false,
	      
	      catalist:{},
	      allCount:0
	    };
	  },
	  components: {
	  	Fixednav
	  }
};
</script>

<style lang="less">
	.re_nav_fixed{
		width: 100%;
		overflow: hidden;
		z-index: 1111;
		position: fixed;
		left: 0;
		top: 0;
	}
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
    margin-top: 1.27rem;
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
                font-size:20px;
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
  		border-radius: 0.6rem;
  		margin-right: 24px;
  		margin-top: 55px;
  	}
  }
</style>
