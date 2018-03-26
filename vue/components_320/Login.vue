<template>
  <div class="login_box">
  	<div class="login_logo">
  		<img src="../images/login_logo.png"/>
  	</div>
    <div class="input_login">
    	<div class="login_name login_pic">
    		<div class="pic_box"><img src="../images/login_pic_2.png"/></div>
    		<div class="input_username"><input type="search" placeholder="输入账号/手机号" v-model="uname" maxlength="18" autocapitalize="off"></div></div>
      <div class="login_psd login_pic">
      	<div class="pic_box"><img src="../images/login_pic_1.png"/></div>
      	<div class="input_psd"><input type="password" placeholder="输入密码" v-model="pwd" maxlength="18" @keydown.enter="cheack_n_p"></div></div>
      <button @click="cheack_n_p">登录</button>
    </div>
  </div>
</template>

<script>
import Backbar from './small_components/Back_bar';
import { mapGetters } from 'vuex';

export default {
  name: 'login',
  data () {
    return {
      uname: '',
      pwd: ''
    };
  },
  mounted () {
    if (this.getLogin) {
//    this.$router.replace('/myzone');
    }
  },
  computed: {
    ...mapGetters([
      'getLogin',
      'getuname',
      'getpwd'
    ])
  },
  methods: {
    cheack_n_p () {
      if (this.uname === '' || this.pwd === '') {
        alert('用户名或密码不能为空');
        return;
      }
      if (this.uname !== this.getuname || this.pwd !== this.getpwd) {
        alert('用户名或密码错误');
      } else {

     this.$store.dispatch('setLogin', true);
//      this.$router.replace('/business/s10001');
			this.$router.push('/business')
      }
    }
  },
  components: {
    'Backbar': Backbar
  }
};
</script>

<style lang="less" scoped>
/*.input_login{
  margin-top: 1.35rem;
  input{
    height: 1rem;
    width: 10rem;
    padding:.6rem;
    box-sizing:border-box;
    border:none;
    outline:none;
    font-size:.45rem;
    display:block;
  }
  button{
    margin: .6rem auto;
    display:block;
    width: 9rem;
    height: 1rem;
    font-size:.5rem;
    background:#4cd964;
    border:none;
    outline:none;
    color:#fff;
    border-radius:.1rem;
  }
}*/

.login_box{
	padding: 3.32rem 0.6rem 0;
	display: table-cell;
	text-align: center;
	vertical-align: middle;
	.input_login{
		margin-top: 0.8rem;
		.login_pic{
			padding: 20px 0;
			.pic_box{
				width: 1.75rem;
				height: 1.2rem;
				position: relative;
				display: inline-block;
					&::after{
					content: "";
					position: absolute;
					right: 0;
					top: 0;
					border-right: 1px solid #e4e4e4;
					height: 1.2rem;
				}
			}
			.input_username{
				margin-left:20px ;
				display: inline-block;
				width: 70%;
				height: 1.2rem;
				vertical-align: top;
				input[type="search"]{
					outline: none;
					width: 100%;
					height: 1.18rem;
					vertical-align: top;
					border:1px solid #f5f5f5;
					font-size: 42px;
					&::-webkit-input-placeholder{
						color: #999;
						font-size:0.42rem ;
						height: 1.2rem;
						line-height: 1.2rem;
					}
				}
			}
		}
		.input_psd{
			position: relative;
				margin-left:20px ;
				display: inline-block;
				width:70%;
				height: 1.2rem;
				vertical-align: top;
				input[type="password"]{
					outline: none;
					width: 100%;
					height: 1.18rem;
					vertical-align: top;
					border:1px solid #f5f5f5;
					font-size: 42px;
					&::-webkit-input-placeholder{
						color: #999;
						font-size:0.42rem ;
						height: 1.2rem;
						line-height: 1.2rem;
					}
				}
		}
	}
	button{
		margin-top: 1.2rem;
    display:block;
    width: 9rem;
    height: 1.4rem;
    font-size:44px;
    background: -webkit-linear-gradient(left, #1ebf9f , #1ebf84); /* Safari 5.1 - 6.0 */
    background: -o-linear-gradient(right, #1ebf9f , #1ebf84); /* Opera 11.1 - 12.0 */
    background: -moz-linear-gradient(right, #1ebf9f , #1ebf84); /* Firefox 3.6 - 15 */
    background: linear-gradient(to right, #1ebf9f , #1ebf84); /* 标准的语法（必须放在最后） */
    border:none;
    outline:none;
    color:#fff;
    border-radius:.1rem;
    border-radius: 1.2rem;
	}
}

</style>
