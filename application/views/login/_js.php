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
        function forgot_password() 
        {
            swal({
                title: "Forgot Password",
                text: "CLSU2 email address:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Enter your clsu2 email address",
                confirmButtonText: 'SEND VERIFICATION CODE'
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") 
                {
                    swal.showInputError("You need to write something!"); return false
                }else
                {
                    window.location = window.location.origin + "/office-of-admissions/forgot_password/password_verification/" + inputValue;
                }
                // swal("Nice!", "You wrote: " + inputValue, "success");
            });
        }
    </script>
</body>
</html>