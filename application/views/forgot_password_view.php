<!DOCTYPE html>
<html lang="en">
<head>
	<title>CAIS</title>	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->	
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
  <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
  <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/vendor/animate/animate.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/vendor/css-hamburgers/hamburgers.min.css'); ?>">
  <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/vendor/select2/select2.min.css'); ?>">
  <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/css/util.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/css/main.css?sid='.rand()); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_assets/css/preloader1.css?sid='.rand()); ?>">
  <!--===============================================================================================-->
    
  <!-- Sweetalert Css -->
  <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />

</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<img src="<?php echo base_url('assets/images/cais2.png'); ?>" style="width: 100%; padding-bottom: 50px;" alt="CAIS">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="IMG">
				</div>
				<form class="login100-form validate-form" action="" method="POST" id="vcode_form">
					<span class="login100-form-title">
						Forgot Password
					</span>
					<div class="row flex justify-content-center d-none" id="loginPreload">
						<span class="loader"></span>
					</div>

					<div class="alert alert-danger d-none" role="alert" id="systemAlert"></div>
          <br>  
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="vcode" placeholder="VERIFICATION CODE">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fas fa-code" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn bg-primary" onclick="check_vcode()">
							Reset Password
						</button>
						<a href="/office-of-admissions" class="login100-form-btn bg-success mt-2">
							Login
            </a>
					</div>
				</form>
			</div>
		</div>
	</div>

  <script src="https://www.google.com/recaptcha/api.js?render=6Ld99ZoeAAAAAESX8jnwpdvlFv0Gz93vcwQlGXrB"></script>
  <!--===============================================================================================-->	
  <script src="<?php echo base_url('assets/login_assets/vendor/jquery/jquery-3.2.1.min.js'); ?>"></script>
  <!--===============================================================================================-->
	<script src="<?php echo base_url('assets/login_assets/vendor/bootstrap/js/popper.js'); ?>"></script>
	<script src="<?php echo base_url('assets/login_assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
  <!--===============================================================================================-->
	<script src="<?php echo base_url('assets/login_assets/vendor/select2/select2.min.js'); ?>"></script>
  <!--===============================================================================================-->
	<script src="<?php echo base_url('assets/login_assets/vendor/tilt/tilt.jquery.min.js'); ?>"></script>
    
  <!-- SweetAlert Plugin Js -->
  <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
  <!--===============================================================================================-->
    
  <!-- SweetAlert Plugin Js -->
  <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/login_assets/js/main.js'); ?>"></script>
  <script src="<?php echo base_url('assets/login/login.js?sid='.rand()); ?>"></script>
  <script type="text/javascript">
    function send_verification() 
    {
      $('#loginPreload').removeClass('d-none');
      $('#systemAlert').addClass('d-none');
      $.ajax({
        url: window.location.origin + '/office-of-admissions/forgot_password/send_verification',
        type: 'POST',
        data:{ uid: 0 },
        dataType: 'TEXT',
        beforeSend: function() {
          $('#loginPreload').removeClass('d-none');
          $('#systemAlert').addClass('d-none');
        },
        success: function(data){
          
          $('#systemAlert').removeClass('d-none');
          if (data == 'failed') 
          {
            $('#systemAlert').text('Sorry <?php echo $email; ?> is not registred in our system.');
          }else 
          {
            $('#systemAlert').html('Didn\'t receive the verification code? <button class="btn btn-sm btn-primary" onclick="send_verification()">resend</button>');
          }
        },
        complete: function () 
        {
          $('#loginPreload').addClass('d-none');
        }
      });
    }send_verification();

    function check_vcode() 
    {
      if ($('[name=vcode]').val() == '') 
      {
        $('#systemAlert').text("Verification code is required!");
      }else
      {
        $.ajax({
          url: window.location.origin + '/office-of-admissions/forgot_password/reset_password',
          type: 'POST',
          data:{ vcode: $('[name=vcode]').val() },
          dataType: 'JSON',
          success: function(data){
            if (data.sys_msg == '1') 
            {
              swal({
                title: 'PASSWORD RESET SUCCESSFULLY',
                html: '<b style="color: green;">You\'re default password is: </b>' + '<h3>' + data.default_pass + '</h3>',
                type: "success",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "OK",
                closeOnConfirm: false
              }, function (isConfirm) 
              {
                  if (isConfirm) 
                  {
                    window.location = window.location.origin + "/office-of-admissions";
                  } 
              });
            }else if(data.sys_msg == '2')
            {
              $('#systemAlert').text("Wrong verification code!");
            }else
            {
              $('#systemAlert').text("Password reset failed!");
            }
          }
        });
      }
    }
  </script>
</body>
</html>