<body class="login-page" style="background-color: #008937;">
	<div class="login-box">
	    <div class="logo">
	        <a href="javascript:void(0);" style="color: #fff;"><b>CAIS</b></a>
	        <small style="color: #fff;">Central Luzon State University</small>
	    </div>
	    <div class="card">
	        <div class="body">
	            <form id="sign_in" method="POST" action="">
	                <div class="msg">
	                	<!-- Sign in to start your session -->
	                	<div style="margin: 0 auto;" id="login-loading">
	                		Sign in to start your session 
	                	</div>
	                </div>
	                
	                <div class="input-group">
	                    <span class="input-group-addon">
	                        <i class="material-icons">person</i>
	                    </span>
	                    <div class="form-line">
	                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
	                    </div>
	                </div>
	                <div class="input-group">
	                    <span class="input-group-addon">
	                        <i class="material-icons">lock</i>
	                    </span>
	                    <div class="form-line">
	                        <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-xs-8 p-t-5">
	                        <input type="checkbox" name="show_hide" id="show_hide" class="filled-in chk-col-green" onclick="my_password()">
	                        <label for="show_hide">Show Password</label>
	                    </div>
	                    <div class="col-xs-4">
	                        <button class="btn btn-lg btn-block bg-green waves-effect" id="btnLogin" type="button" onclick="user_login()">
	                        	LOGIN
                            </button>
	                    </div>
	                </div>
	                <div class="row m-t-15 m-b--20">
	                    <div class="col-xs-6">
	                        <!-- <a href="sign-up.html">Register Now!</a> -->
	                        <a href="javascript:void(0);" onclick="forgot_password()">Forgot Password?</a>
	                    </div>
	                    <div class="col-xs-6 align-right">
	                        <!-- <a href="forgot-password.html">Forgot Password?</a> -->
	                        <small>version 3.0.0</small>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>