<style>

@import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

 


body{
  margin: 0;
  color: #212431;
  background-color: #92b91c;
  background-repeat: no-repeat;
  background-size: cover;
  font: 600 16px/18px 'Open Sans',sans-serif;
  
  background-color: #12A4B4;
  background-size: 16px 16px;

}
*,:after,:before{box-sizing:border-box}
.clearfix:after,.clearfix:before{content:'';display:table}
.clearfix:after{clear:both;display:block}
a{color:inherit;text-decoration:none}

.login-wrap{
	width:100%;
	margin:auto;
	max-width:525px;
	min-height:670px;
	position:relative;
	
	box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
}
.login-html{
	width:100%;
	height:100%;
	position:absolute;
	
	background: rgb(255 255 255 / 90%);
}

@media(min-width:600px){
  .login-html{
    padding:90px 70px 50px 70px;
  }
}
@media(max-width:600px){
  .login-html{
    padding:32px;
  }
}



.login-html .sign-in-htm,
.login-html .sign-up-htm{
	top:0;
	left:0;
	right:0;
	bottom:0;
	position:absolute;
	transform:rotateY(180deg);
	backface-visibility:hidden;
	transition:all .4s linear;
}
.login-html .sign-in,
.login-html .sign-up,
.login-form .group .check{
	display:none;
}
.login-html .tab,
.login-form .group .label,
.login-form .group .button{
	text-transform:uppercase;
}
.login-html .tab{
	font-size:22px;
	margin-right:15px;
	padding-bottom:5px;
	margin:0 15px 10px 0;
	display:inline-block;
	border-bottom:2px solid transparent;
}
.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab{
	color:#000000;
	border-color:#4e4e4e;
}
.login-form{
	min-height:345px;
	position:relative;
	perspective:1000px;
	transform-style:preserve-3d;
}
.login-form .group{
	margin-bottom:15px;
}
.login-form .group .label,
.login-form .group .input,
.login-form .group .button{
	width:100%;
	color:#000000;
	display:block;
}
.login-form .group .input,
.login-form .group .button{
	border:none;
	padding:15px 20px;
	border-radius:25px;
	background:rgba(0, 0, 0, 0.1);
}
.login-form .group input[data-type="password"]{
	
	-webkit-text-security:circle;
}
.login-form .group .label{
	color:#070807;
	font-size:12px;
}
.login-form .group .button{
	background:#92b91c;
}
.login-form .group label .icon{
	width:15px;
	height:15px;
	border-radius:2px;
	position:relative;
	display:inline-block;
	background:rgba(0, 255, 0, 0.5);
}
.login-form .group label .icon:before,
.login-form .group label .icon:after{
	content:'';
	width:10px;
	height:2px;
	background:#fff;
	position:absolute;
	transition:all .2s ease-in-out 0s;
}
.login-form .group label .icon:before{
	left:3px;
	width:5px;
	bottom:6px;
	transform:scale(0) rotate(0);
}
.login-form .group label .icon:after{
	top:6px;
	right:0;
	transform:scale(0) rotate(0);
}
.login-form .group .check:checked + label{
	color:#fff;
}
.login-form .group .check:checked + label .icon{
	background:#31a964;
}
.login-form .group .check:checked + label .icon:before{
	transform:scale(1) rotate(45deg);
}
.login-form .group .check:checked + label .icon:after{
	transform:scale(1) rotate(-45deg);
}
.login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{
	transform:rotate(0);
}
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm{
	transform:rotate(0);
}

.hr{
	height:2px;
	margin:60px 0 50px 0;
	background:rgba(104, 19, 19, 0.2);
}
.foot-lnk{
	text-align:center;
}

.ciites{
    font-size: 62pt;
    font-family: fantasy;
    color: #009b1a;
}
.ciites-desglosado{
    font-size: 18pt;
    color: #727272;
    margin-top: 32px;
}

.button-submit{
  border: none;
  padding: 15px 20px;
  border-radius: 25px;
  background: #7DAE46;
  width: 100%;
  color: #fff;
  display: block;
  font-size: 12pt;
  font-weight: bold;
  font-family: sans-serif;
}
</style>

<style>
  /***
Login page
***/

/* logo page */
.login {
  background-color: #f4f4f4 !important;
}

.login .logo {
  margin: 0 auto;   
  margin-top:60px;
  padding: 25px;
  text-align: center;
}  

.login .content {
  background-color:#fff; 
  width: 360px;
  margin: 0 auto; 
  margin-bottom: 0px;
  padding: 30px;  
  padding-top: 5px;  
  padding-bottom: 15px;
  box-shadow: 0 1px 7px rgba(0,0,0,0.5);
}

.login .content h3 {
  color: #000;
}
.login .content h4  {
  color: #555;
}

.login .content p {
  color: #222;
}

.login .content .login-form,
.login .content .forget-form {
    padding: 0px;
    margin: 0px;
}

.login .content .forget-form {
  display: none;
}

.login .content .register-form {
  display: none;
}

.login .content .form-title {
  font-weight: 300;
  margin-bottom: 25px;
  text-align: center;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.login .content .form-actions {
  background-color: #fff;
  clear: both;
  border: 0px;
  padding: 0px 30px 0px 30px;
  margin-left: -30px;
  margin-right: -30px;
}

.login .content .form-actions .checkbox {
  margin-left: 0;
  padding-left: 0;
}

.login .content .forget-form .form-actions {
  border: 0;
  margin-bottom: 0;
  padding-bottom: 20px;
}  

.login .content .register-form .form-actions {
  border: 0;
  margin-bottom: 0;
  padding-bottom: 0px;
}

.login .content .form-actions .checkbox {
  margin-top: 8px;
  display: inline-block;
}

.login .content .form-actions .btn {
  margin-top: 1px;
}

.login .content .forget-password {
  margin-top: 25px;
}

.login .content .create-account {
  border-top: 1px dotted #eee;
  padding-top: 10px;
  margin-top: 15px;
}

.login .content .create-account a {
  display: inline-block;
  margin-top: 5px;
}


/* footer copyright */
.login .copyright {
  text-align: center;
  margin: 0 auto; 
  padding: 10px;
  color: #555;
  font-size: 13px;
}



</style>

<style>
body { 
  color: #000; 
  font-family: 'Open Sans', sans-serif;
  padding: 0px !important;
  margin: 0px !important;
  font-size:13px; 
  direction: ltr;
}
.alert
{
  width: 300px;
  position: fixed;
  margin: auto;
  bottom: 10px;
  right: 10px;
  z-index: 999999 !important;
}

.alerta{
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 4px;
}

.text-center{
  text-align: center;
}


/***
Tools
***/
.display-none,
.display-hide {
  display: none;
}

.no-space {
  margin: 0px !important;
  padding: 0px !important;
}



.border {
  border: 1px solid red;
}

.inline {
  display: inline;
}


/********************
 GENERAL UI ELEMENTS 
*********************/

/***
Icon stuff
***/
i.icon, a.icon {
  color: #999;
  margin-right: 5px;
  font-weight: normal;
  font-size: 13px;
}

i.icon-black {
  color: #000 !important;
}

a.icon:hover {
  text-decoration: none;
  -webkit-transition: all 0.1s ease-in-out;
  -moz-transition: all 0.1s ease-in-out;
  -o-transition: all 0.1s ease-in-out;
  -ms-transition: all 0.1s ease-in-out;
  transition: all 0.1s ease-in-out;
  opacity: .4;
  filter:alpha(opacity=40);
}

a.icon.huge i{
  font-size: 16px !important;
}

i.big {
  font-size: 20px;
}

i.warning {
  color: #d12610;
}

i.critical {
  color: #37b7f3;
}

i.normal {
  color: #52e136;
}

/* input with left aligned icons */
.input-icon {
  position: relative;
}


.input-icon input {
   padding-left: 33px !important;
}

.input-icon i {
  color: #ccc;
  display: block;
  position: absolute;
  margin: 11px 2px 4px 10px;
  width: 16px;
  height: 16px;
  font-size: 16px;
  text-align: center;
}

.input-icon.right input {
   padding-left: 12px !important;
   padding-right: 33px !important;
}

.input-icon.right i {
   right: 8px;
   float: right;
}

.has-success .input-icon > i {
  color: #468847;
}

.has-warning .input-icon > i {
  color: #c09853;
}

.has-error .input-icon > i {
  color: #b94a48;
}



</style>