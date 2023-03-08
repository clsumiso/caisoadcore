    <script src="https://www.google.com/recaptcha/api.js?render=6Ld99ZoeAAAAAESX8jnwpdvlFv0Gz93vcwQlGXrB"></script>
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
    <script src="<?php echo base_url('assets/js/pages/examples/sign-in.js'); ?>"></script>
    <script src="<?php echo base_url('assets/login/login.js?sid='.rand()); ?>"></script>
    
    <script type="text/javascript">
        function my_password() 
        {
            var x = document.getElementById("pass");
            if (x.type === "password") 
            {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function forgot_password() 
        {
            // const { value: email } = Swal.fire({
            //     title: 'FORGOT PASSWORD',
            //     input: 'email',
            //     inputLabel: 'You\'re clsu2 email address',
            //     inputPlaceholder: 'Enter your clsu2 email address',
            //     showConfirmButton: true,
            //     confirmButtonText: 'SEND VERIFICATION'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         window.location = window.location.origin + "/star/forgot_password/password_verification/" + result.value;
            //     }
            // })

            swal({
                title: "Forgot Password",
                text: "You\'re clsu2 email address:",
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