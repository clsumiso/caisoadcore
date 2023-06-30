<div class="card profile-card">
    <div class="profile-header" style="background-color: #f1c40f;">&nbsp;</div>
    <div class="profile-body">
        <div class="image-area">
            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Profile Image" width="128" height="128" />
        </div>
        <div class="content-area">
            <h3><?php echo $name; ?></h3>
            <p><?php echo $email; ?></p>
            <p><?php echo $user_type; ?></p>
        </div>
    </div>
    <div class="profile-footer">
        <ul>
            <li>
                <span>SEMESTER</span>
                <span>1.234</span>
            </li>
            <li>
                <span>TEACHING LOADS</span>
                <span>1.201</span>
            </li>
            <li>
                <span style="vertical-align: middle;"><i class="material-icons">date_range</i></span>
                <span><?php echo $get_time; ?></span>
            </li>
        </ul>
        <?php if(isset($_SESSION['admin_login_token'])): ?>
            <button class="btn  bg-green btn-lg waves-effect btn-block" onclick="switchUser('<?php echo $_SESSION['admin_login_token']; ?>','<?php echo $_SESSION['admin_user']; ?>','<?php echo $_SESSION['admin_pass']; ?>');">SWITCH BACK TO ADMIN</button>
        <?php endif; ?>
        <button class="btn btn-primary btn-lg waves-effect btn-block">CHANGE PASSWORD</button>
        <a href="/office-of-admissions/login/logout" class="btn btn-danger btn-lg waves-effect btn-block">LOGOUT</a>
        
    </div>
</div>
<script type="text/javascript">
    function switchUser(token,email,pass){
       // console.log(ema);
     $.ajax({
          url:  window.location.origin + '/office-of-admissions/login/login_verification',
          type: "POST",
          data: { action: 'login', token: token, email: email, pass: pass/*, remember: remember*/ },
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
          },
          error:function(err){
            console.log(err);
          }
        });
}
</script>