<template>
  <div class="myzone_index">
    <Backbar title="我的"></Backbar>
    <div class="myzone_content">
      <!-- 头 -->
      <div class="myzone_info clear">
        <p style="padding-top:30px">某某食堂</p>
        <p>联系人：张三</p>
        <p class="tel_ma_max">联系电话：17267823144</p>
        <p>送货地址：广东省东莞市松山湖科技十路联合金融</p>
        <span class="login_out">退出登录</span>
      </div>
    </div>
    <!-- 3分 -->
    <div class="three_lan">
        <div class="tree_lan_tit">
          <div class="tit_left">
            订单号：<span>212121123123</span>
          </div>
          <div class="tit_right">
            <span>已提交</span>
          </div>
        </div>
        <div class="scroll_x">
          <div class="scroll_box">

          </div>
        </div>
    </div>
    <!-- 栏 -->
    <div class="some_bar">
      <svg class="v-md">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#shop"></use>
      </svg>
      <span class="v-md">积分商城</span>
    </div>
    <div class="some_bar">
      <svg class="v-md">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#eleme"></use>
      </svg>
      <span class="v-md">饿了么会员卡</span>
    </div>

    <div class="some_bar first-c">
      <svg class="v-md">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#discover.5811137"></use>
      </svg>
      <span class="v-md">服务中心</span>
    </div>
    <div class="some_bar">
      <svg class="v-md">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#index.18edf5a"></use>
      </svg>
      <span class="v-md">下载饿了么APP</span>
    </div>
    <Fixednav></Fixednav>
  </div>
</template>

<script>
import Backbar from './small_components/Back_bar';
import Fixednav from './small_components/Fixed_nav';
export default {
  name: 'myzone',
  data () {
    return {
      uname: ''
    };
  },
  mounted () {

  },
  computed: {
    isLogin () {
      return this.$store.getters.getLogin;
    }
  },
  methods: {

  },
  components: {
    Fixednav,
    Backbar
  }
};
</script>

<style lang="less" scoped>
.myzone_content{
  width:10rem;
  height:3rem;
  margin-top:1rem;
  // padding: .8rem .4rem;
  box-sizing:border-box;
  background:#0097ff;
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
  height: 2.24rem;
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
  padding: 0 .4rem;
  color: #fff;
  font-size: 18px;
  position: relative;
  p{
    height: .5rem;
    line-height: .5rem
  }
  .tel_ma_max{
    margin-top: 26px
  }
  span.login_out{
    display: block;
    width: 1.76rem;
    height: .6rem;
    text-align: center;
    line-height: .6rem;
    background: #fff;
    color: #666;
    font-size: 20px;
    border-radius: .3rem;
    position:absolute;
    right: 12px;
    top: 30px
  }
}
</style>
