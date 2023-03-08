<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>OAD | Forgot Password</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url('assets/images/logo.png'); ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url('assets/plugins/node-waves/waves.css'); ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url('assets/plugins/animate-css/animate.css'); ?>" rel="stylesheet" />
    
    <!-- Sweetalert Css -->
    <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
</head>
<!-- <body>
  <div class="content mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12 contents">
          <div class="row justify-content-center">
            <div class="card" style="width: 30rem;">
              <img class="card-img-top" src="<?php echo base_url('assets/images/OAD.png'); ?>" alt="Card image cap" style="height: 100%;">
              <div class="card-body">
                <p class="card-text"></p>

                <form action="" method="POST" id="vcode_form">
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <input type="text" name="vcode" class="form-control form-control-lg" placeholder="VERIFICATION CODE">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-2">
                      <button type="button" name="btnLogin" id="btnLogin" onclick="check_vcode()" class="btn btn-lg text-white btn-block" style="background-color: #2979FF;">RESET PASSWORD</button>
                    </div>
                    <div class="col-md-12 mb-2">
                      <a href="/admissions" class="btn btn-lg btn-success btn-block">LOGIN</a>
                    </div>
                  </div>
                  <span class="d-block text-center my-4 text-muted">Copyright &copy; 2021. All rights reserve.</span>

                  <div class="social-login">
                    <a href="#" class="facebook">
                      <span class="icon-facebook mr-3"></span>
                    </a>
                    <a href="#" class="twitter">
                      <span class="icon-twitter mr-3"></span>
                    </a>
                    <a href="#" class="google">
                      <span class="icon-google mr-3"></span>
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
<body class="fp-page">
  <div class="fp-box">
      <div class="logo">
          <a href="javascript:void(0);">Admin<b>BSB</b></a>
          <small>Admin BootStrap Based - Material Design</small>
      </div>
      <div class="card">
          <div class="body">
              <form action="" method="POST" id="vcode_form">
                  <p class="card-text"></p>
                  <div class="msg">
                      Enter your email address that you used to register. We'll send you an email with your username and a
                      link to reset your password.
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="material-icons">email</i>
                      </span>
                      <div class="form-line">
                          <input type="text" name="vcode" class="form-control" placeholder="Email" required autofocus>
                      </div>
                  </div>

                  <button type="button" name="btnLogin" id="btnLogin" onclick="check_vcode()" class="btn btn-block btn-lg bg-pink waves-effect" type="submit">RESET MY PASSWORD</button>

                  <div class="row m-t-20 m-b--5 align-center">
                      <a href="/office-of-admissions">LOGIN</a>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!-- Jquery Core Js -->
  <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

  <!-- Bootstrap Core Js -->
  <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.js'); ?>"></script>

  <!-- Waves Effect Plugin Js -->
  <script src="<?php echo base_url('assets/plugins/node-waves/waves.js'); ?>"></script>

  <!-- Validation Plugin Js -->
  <script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.js'); ?>"></script>

  <!-- SweetAlert Plugin Js -->
  <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>

  <!-- Custom Js -->
  <script src="<?php echo base_url('assets/js/admin.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/pages/examples/forgot-password.js'); ?>"></script>
  <script>
    function send_verification() 
    {
      $.ajax({
        url: window.location.origin + '/office-of-admissions/forgot_password/send_verification',
        type: 'POST',
        data:{ uid: 0 },
        dataType: 'TEXT',
        success: function(data){
          if (data == 'failed') 
          {
            // Swal.fire({
            //   icon: 'warning',
            //   title: 'INVALID EMAIL',
            //   html: '<b style="color: red;">Sorry your email address is not registred in our system. Please send us email in enrollment.concerns@clsu2.edu.ph</b>',
            //   allowOutsideClick: false,
            //   confirmButtonText: 'BACK TO LOGIN',
            //   showClass: {
            //     popup: 'animate__animated animate__bounceIn'
            //   },
            //   hideClass: {
            //     popup: 'animate__animated animate__bounceOut'
            //   }
            // }).then((result) => {
            //   /* Read more about isConfirmed, isDenied below */
            //   if (result.isConfirmed) {
            //     window.location = window.location.origin + "/admissions/";
            //   }
            // })
            swal({
                title: "INVALID EMAIL",
                text: "Sorry your email address is not registred in our system. Please send us email in enrollment.concerns@clsu2.edu.ph",
                type: "info",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function (isConfirm) 
            {
                if (isConfirm) 
                {
                  // swal("Deleted!", "Your imaginary file has been deleted.", "success");
                } 
            });
          }else {
            $('.card-text').html('Didn\'t receive the verification code? <button class="btn btn-sm btn-primary" onclick="send_verification()">resend</button>')
            // swal.fire(
            //   'EMAIL SENT',
            //   'You\'re verification code is sent into your email',
            //   'success'
            // )
            swal("EMAIL SENT!", "You\'re verification code is sent into your email!", "success");
          }
        }
      });
    }send_verification();

    function check_vcode() {
      if ($('[name=vcode]').val() == '') {
        Swal.fire({
          icon: 'warning',
          title: 'VERIFICATION CODE IS REQUIRED',
          html: '<b style="color: red;">Please enter verificarion code.</b>',
          allowOutsideClick: false,
          confirmButtonText: 'OKAY',
          showClass: {
            popup: 'animate__animated animate__bounceIn'
          },
          hideClass: {
            popup: 'animate__animated animate__bounceOut'
          }
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            
          }
        })
        swal("Verification code is required!", "Please enter verificarion code.", "warning");
      }else{
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
                    window.location = "https://oad.clsu2.edu.ph/user-login/";
                  } 
              });
            }else if(data.sys_msg == '2')
            {
              swal("Wrong verification code!", "Please try again", "error");
            }else
            {
              swal("Password reset failed!", "Please try again", "warning");
            }
          }
        });
      }
    }
  </script>
</body>
</html>
