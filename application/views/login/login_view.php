<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<img src="<?php echo base_url('assets/images/cais2.png'); ?>" style="width: 100%; padding-bottom: 50px;" alt="CAIS">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="IMG">
				</div>
				<form class="login100-form validate-form" id="sign_in" method="POST" action="">
					<span class="login100-form-title">
						OFFICE OF ADMISSIONS
					</span>
					<div class="row flex justify-content-center d-none" id="loginPreload">
						<span class="loader"></span>
					</div>

					<div class="alert alert-danger d-none" role="alert" id="systemAlert"></div>
					<br>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" onclick="user_login()">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#" onclick="forgot_password()">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<!-- <a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a> -->
					</div>
				</form>
			</div>
		</div>
	</div>