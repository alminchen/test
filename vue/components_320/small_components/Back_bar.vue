<template>
    <!-- 我只是个头 -->
  <div class="back_box">
    <div class="back_arrow" @click="back_one">
      <img class="arrow" src="../../images/back.png" alt="">
    </div>
    <h3>{{ title }}</h3>
  </div>

</template>

<script>
export default {
  name: 'back_bar',
  props: ['title'],
  data () {
    return {

    };
  },
  mounted () {

  },
  computed: {

  },
  methods: {
    back_one () {
      this.$router.go(-1);
    }
  }
};
</script>

<style lang="less" scoped>
.back_box{
  width:10rem;
  height:1rem;
  line-height:1rem;
  position:fixed;
  background:#1ebf98;
  top:0;
  left:0;
  right:0;
  z-index: 999;
  h3{
    color:#fff;
    width:100%;
    display:block;
    font-size:.52rem;
    text-align:center;
    font-weight: 700;
  }
  div.back_arrow{
    width:1rem;
    height:1rem;
    position:absolute;
    left:0;
    top:0;
    img{
      width:.5rem;
      height:.5rem;
      position:absolute;
      left:50%;
      top:50%;
      margin-left: -.3rem;
      margin-top: -.3rem;
      transform: rotate(180deg);
    }
  }
}
</style>
