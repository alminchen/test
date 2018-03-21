<template>
    <!-- 列表单个商家 -->

  <nav class="fixed_nav">
    <router-link to="/business">
      <span class="one_fixed_nav">
      	<img src="../../images/show_list_false.png"/>
        <span>全部菜品</span>
      </span>
    </router-link>

    <router-link to="/myzone">
      <span class="one_fixed_nav">
      	<img src="../../images/mine_msg_false.png"/>
        <span>我的订单</span>
      </span>
    </router-link>
  </nav>
</template>

<script>
export default {
  name: 'fixed_nav',
  data () {
    return {
		show:false
    };
  },
  mounted () {
    setInterval(() => {
      // console.log(this.returnPageNow);
    }, 2000);
  },
  computed: {
    returnPageNow () {
      this.show = !this.shoe;
    }
  },
  methods: {

  }
};
</script>

<style lang="less" scoped>
  .fixed_nav{
     width:10rem;
     height:1.2rem;
     background:#fff;
     position:fixed;
     left:0;
     right:0;
     bottom:0;
     font-size: .28rem;
     z-index: 999;
     svg{
      width:.45rem;
      height: .45rem;
      display:block;
      margin: .2rem auto .1rem;
     }
     .one_fixed_nav{
      width:49%;
      display:inline-block;
      height:1.2rem;
      text-align:center;
      line-height: 1.2rem;
      font-size: 28px;
      border-right: 1px solid #f5f5f5;
      img{
      	display: inline-block;
      	vertical-align: middle;
      }
     }
  }
</style>
