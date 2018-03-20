<template lang="html">
  <div>
    <div>
      <Backbar title="订单详情"></Backbar>
      <div class="order_box">
        <div class="order_name">
          <div class="order_name_tel">
            <span class="flo-l">联系人:张三</span>
            <span class="flo-r">13167823136</span>
          </div>
          <div class="order_name_addredd">
            地址：<span>广东省东莞市松山湖科技十路联合金融</span>
          </div>
        </div>
        <div class="solt_bag"></div>
        <div class="rongjie_ct">
          <div class="rongjie_tit">
            <span>蓉姐餐厅</span>
          </div>
          <div v-for=" (item, index) in  5" class="order_one">
            <div class="order_img">
              <img src="../images/shop-logo.png" alt="">
            </div>
            <div class="order_info">
              <header class="order_info_t">
                <div class="order_title flex_align">
                  <p class="b_name">猪肉牛肉/斤</p>
                  <p class="b_status">￥{{ item }}</p>
                </div>
              </header>
              <footer class="order_info_b flex_align">
                <p class="order_brief_info">x{{ item }}</p>
              </footer>
              <div style="display:none;">{{ item }}</div>
            </div>
          </div>
        </div>
        <div class="sent_date">
          <span class="sent_fl">送货日期</span>
          <span class="sent_fr">2018-2-9</span>
        </div>
        <div class="check_lang">
          <span>留言</span><span class="ma_50">买家没有留言</span>
        </div>
        <div class="total_price_num">
          <div class="toyal_fr">
            <span class="ma_20">共<i>6</i>件商品</span><span>总价<i class="is_red">￥72.00</i></span>
          </div>
        </div>
        <div class="sub_dingdan">
          <span class="push_dingdan_ht">提交订单</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Backbar from './small_components/Back_bar';
export default {
  components: {
    Backbar
  }
}
</script>

<style lang="less" scoped>
.order_box{
  background: #fff;
  margin-top: 1rem;
}
.order_one{
  background:#fff;
  margin-bottom: .2rem;
  .order_img{
    width:1rem;
    height:1rem;
    float:left;
    // padding: .2rem .4rem;
    img{
      width:100%;
    }
  }
  .order_info{
    margin-left:1.6rem;
    padding:.2rem .2rem 0 0;
    box-sizing:border-box;
    .order_info_t{
      border-bottom: 1px solid #eee;
      .order_title{
        height:.6rem;
        line-height:.6rem;
        .b_name{
          font-size:.4rem;
        }
        .b_status{
          font-size:.35rem;
          color:#333;
        }
      }
      .order_time{
        font-size:.3rem;
        color:#999;
        line-height:.6rem;
      }
    }
    .order_info_b{
      padding: 0.2rem 0;
      .order_brief_info{
        font-size: 0.346667rem;
        color: #666;
      }
      .order_price{
        text-align: right;
        font-size: 0.346667rem;
        color: #333;
        font-weight: bold;
      }
    }
  }
}
.order_name{
  padding: 0 .4rem;
  height: 2.1rem;
  overflow: hidden;
  font-size: 22px;
  background: #fff;
  .order_name_tel{
    width: 100%;
    height: .73rem;
    line-height: .73rem;
    margin-top: .3rem;
    font-weight: bold;
    font-size: 26px;
    .flo-l{
      float: left;
    }
    .flo-r{
      float: right;
    }
  }
  .order_name_addredd{
    width: 100%;
    height:0.73rem;
    line-height: .73rem
  }
}
.solt_bag{
  width: 100%;
  height: 20px;
  background: url(../images/background.png) repeat-x left center;
}
.sent_time{
  padding: 0 .4rem;
  height: 2.5rem;
  font-size: 30px;
  .clar_both{
    clear: both;
  }
  p{
    height: .43rem;
    line-height: .43rem;
    span{
      display: inline-block;
      height: .83rem;
      line-height: .83rem;
      float: left;
    }
    i{
      margin-left: 20px;
      display: inline-block;
      height: .83rem;
      line-height: .83rem;
      float: left;
      font-family: normal;
    }
    .blod_font{
      font-weight: bold
    }
  }
}
.rongjie_ct{
  height: auto;
  padding: 0 .4rem;
  margin-top: 16px;
  span{
    display: block;
    height: .77rem;
    line-height: .77rem;
    font-size: 30px;
  }
}
.sent_date{
  margin: 0 .4rem;
  height: 1.6rem;
  line-height: 1.6rem;
  font-size: 28px;
  border-bottom: 1px solid #f5f5f5;
  span{
    display: inline-block;
    height: 100%;
    line-height: 1.6rem
  }
  .sent_fl{
    float: left;
  }
  .sent_fr{
    float: right;
    font-weight: bold
  }
}
.check_lang{
  margin: 0 .4rem;
  height: 1.6rem;
  line-height: 1.6rem;
  font-size: 30px;
  border-bottom: 1px solid #f5f5f5;
  span{
    display: inline-block;
    height: 100%;
    line-height: 1.6rem;
  }
  .ma_50{
    margin-left: .5rem
  }
}
.total_price_num {
  width: 100%;
  height: 1.6rem;
  line-height: 1.6rem;
  font-size: 28px;
  .toyal_fr{
    float: right;
    margin-right: .4rem;
    .ma_20{
      margin-right: 20px;
    }
    span{
      display:inline-block;
      height:100%;
      line-height:1.6rem;
      i{
        font-style: normal;
      }
      .is_red{
        color: red
      }
    }
  }
}
.sub_dingdan{
  width: 100%;
  height: 1rem;
  line-height:1rem;
  font-size: 32px;
  color: #fff;
  span{
    float: right;
    display: block;
    width: 3rem;
    height: 1rem;
    line-height: 1rem;
    text-align: center;
    background-color: #1ebf98;
    margin-right: .4rem;
    border-radius: .3rem
  }
}
</style>
