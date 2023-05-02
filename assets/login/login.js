function user_login() {
    let email = '';
    let psw = '';

    if ($('[name="username"]').val() == '') 
    {
      $('#systemAlert').removeClass('d-none');
      $('#systemAlert').text("Username or email is required");
    } else if ($('[name="pass"]').val() == '') 
    {
        // Swal.fire({
        //     icon: 'warning',
        //     title: 'FAILED',
        //     text: 'PASSWORD IS REQUIRED!!!',
        //     padding: '2px'
        // })
      // swal("Failed", "", "warning");
      $('#systemAlert').removeClass('d-none');
      $('#systemAlert').text("Password is required");
    }else 
    {
        email = $('[name="username"]').val();
        psw = $('[name="pass"]').val();
        // remember = $('input[name=thename]:checked') ? 1 : 0;
        $('#loginPreload').removeClass('d-none');
        $('#systemAlert').addClass('d-none');
        try{
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('6Ld99ZoeAAAAAESX8jnwpdvlFv0Gz93vcwQlGXrB', {action: 'login'}).then(function(token) 
                {
                    $('.grecaptcha-badge').append(".content-wrapper");
                    // add token to form
                    $.ajax({
                      url:  window.location.origin + '/office-of-admissions/login/login_verification',
                      type: "POST",
                      data: { action: 'login', token: token, email: email, pass: psw/*, remember: remember*/ },
                      dataType: "JSON",
                      beforeSend: function() {
                        $('#loginPreload').removeClass('d-none');
                        $('#systemAlert').addClass('d-none');
                      },
                      success: function (response) {
                        if (response.sys_msg === "SUCCESS")
                        {
                          window.open(window.location.origin + "/office-of-admissions/" + response.redirect, "_SELF");
                          // console.log(response.redirect);
                        }else
                        {
                          // Swal.fire({
                          //   icon: 'error',
                          //   title: response.sys_msg,
                          //   text: response.msg
                          // })
                          
                          $('#systemAlert').removeClass('d-none');
                          $('#systemAlert').text(response.msg);
                        }
                      },
                      complete: function () 
                      {
                        $('#loginPreload').addClass('d-none');
                      }
                    });
                });
            });
        }catch(err){
            swal("Something went wrong", "Check your internet connection, please reload your browser", "warning");
        }
        // $.ajax({
        //   url:  window.location.origin + '/office-of-admissions/login/login_verification',
        //   type: "POST",
        //   data: { action: 'login', /*token: token,*/ email: email, pass: psw/*, remember: remember*/ },
        //   dataType: "JSON",
        //   beforeSend: function() {
        //     // Swal.fire({
        //     //     title: 'OFFICE OF ADMISSIONS',
        //     //     html: 'Loading...please wait',
        //     //     timerProgressBar: true,
        //     //     allowOutsideClick: false,
        //     //     allowEscapeKey: false,
        //     //     didOpen: () => {
        //     //         Swal.showLoading()
        //     //     }
        //     // });
        //     $('#login-loading').html('<span class="loader1"></span>');
        //   },
        //   success: function (response) {
        //     if (response.sys_msg === "SUCCESS")
        //     {
        //       window.open(window.location.origin + "/office-of-admissions/" + response.redirect, "_SELF");
        //       // console.log(response.redirect);
        //     }else
        //     {
        //       // Swal.fire({
        //       //   icon: 'error',
        //       //   title: response.sys_msg,
        //       //   text: response.msg
        //       // })
        //       $('#login-loading').html('Sign in to start your session');
        //       swal(response.sys_msg, response.msg, "error");
        //     }
        //   }
        // });
        
    }
}