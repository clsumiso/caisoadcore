<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>404 | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url('assets/plugins/node-waves/waves.css'); ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

    <style>
        table
        {
            width: 100%;
        }

        table th
        {
            text-align: left;
        }

        table, tr, th, td
        {
            border: 2px solid #2c3e50;
            border-collapse: collapse;
            padding: 10px;
        }

        /* Absolute Center Spinner */
        .fullscreen-loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .fullscreen-loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
                background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .fullscreen-loading:not(:required) {
            /* hide "fullscreen-loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .fullscreen-loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
            }
            @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
            }
            @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
            }
            @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="theme-amber">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <span class="loader"></span>
        <!-- <span class="loader"></span> -->
        <!-- <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div> -->
    </div>
    <div class="fullscreen-loading" style="display: none;">Please wait&#8230;</div>
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">OFFICE OF ADMISSIONS (Comprehensive Academic Information System)</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section class="" style="display: flex; flex-direction: row; margin: 100px 0 0 0;">
        <div class="container-fluid" style="border: 4px dashed #636e72; padding: 20px; width: 50%;">
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h1 class="text-center">TRACK REFERENCE FORM</h1>
                    
                    <?php if ($trackTitle != ""): ?>
                        <p><?php echo $trackTitle; ?></p>
                    <?php endif ?>
                </div>
            </div>
            <?php if ($emailSendStatus != ""): ?>
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <table>
                            <thead>
                                <th>REFERENCE EMAIL</th>
                                <th>STATUS</th>
                                <th>...</th>
                            </thead>
                            <tbody>
                                <?php echo $emailSendStatus; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif ?>

            <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h1 class="text-center">REQUIRED ATTACHMENT</h1>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <table>
                        <thead>
                            <th>ATTACHMENT TYPE</th>
                            <th>STATUS</th>
                            <th>...</th>
                        </thead>
                        <tbody>
                            <?php echo $requiredAttachment; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <?php if ($enrollmentFormBtn != 0): ?>
                <?php //echo $enrollmentFormBtn; ?>
            <?php endif ?>
            
            <!-- <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                    <i class="material-icons" style="font-size: 150px; color: #27ae60;">check_circle</i>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                    <h1>CONGRATULATIONS</h1>
                    <h4>Your application is now Accepted & Approved, check you email inbox or email spam.</h4>
                </div>
            </div> -->
        </div>
    </section>
    
    <!-- Jquery Core Js -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.js'); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url('assets/plugins/node-waves/waves.js'); ?>"></script>

    <script>
        let applicantID = [];

        function resendReference(appID, name, referenceEmail, referenceName)
        {
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: window.location.origin + "/office-of-admissions/admission_application/resendReference",
                data: 
                { 
                    appID: appID,
                    name: name,
                    referenceEmail: referenceEmail,
                    referenceName: referenceName
                },
                dataType: "JSON",
                beforeSend: function ()
                {
                    // $('#saveApplicantPreload').html('<span class="loader1"></span>');
                    $('.fullscreen-loading').css("display", "block");
                },
                success: function (data) 
                {
                    window.open(window.location.origin + "/office-of-admissions/admission-verification/"+appID, "_SELF");         
                },
                complete: function () 
                {
                    // $('#saveApplicantPreload').html('');
                    $('.fullscreen-loading').css("display", "none");
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        }
    </script>
</body>

</html>