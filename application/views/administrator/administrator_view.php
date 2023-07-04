<body class="theme-green">
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
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">OFFICE OF ADMISSIONS (Comprehensive Academic Information System)</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section class="" style="margin: 100px 0 0 0">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-2">
                    <?php $this->load->view('administrator/_profile_card'); ?>
                    <?php $this->load->view('administrator/_about'); ?>
                </div>
                <div class="col-xs-12 col-sm-10">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist" style="font-size: 18px;">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                                    <li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Class Schedule</a></li>
                                    <li role="presentation"><a href="#classMonitoring" aria-controls="classMonitoring" role="tab" data-toggle="tab">Class Monitoring</a></li>
                                    <!-- <li role="presentation" class="bg-warning"><a href="#dropping" aria-controls="dropping" role="tab" data-toggle="tab">Enrollment</a></li>-->
                                    <li role="presentation" class="bg-warning"><a href="#applicants" aria-controls="applicants" role="tab" data-toggle="tab">Applicant</a></li>
                                    <li role="presentation" class="bg-warning"><a href="#applicant_setup" aria-controls="applicant_setup" role="tab" data-toggle="tab">Applicant Setup</a></li>
                                    <li role="presentation" class="bg-danger"><a href="#accounting" aria-controls="accounting" role="tab" data-toggle="tab">ACCOUNTING</a></li>
                                    <li role="presentation" class="bg-danger"><a href="#grades" aria-controls="grades" role="tab" data-toggle="tab">GRADES</a></li>
                                    <!--<li role="presentation" class="bg-danger"><a href="#encoder" aria-controls="encoder" role="tab" data-toggle="tab">ENCODER</a></li>-->
                                    <li role="presentation" class="bg-danger"><a href="#user_account" aria-controls="encoder" role="tab" data-toggle="tab">USER ACCOUNTS</a></li>
                                </ul>

                                <div class="tab-content">

                                    <?php $this->load->view('administrator/tab_menu/_home'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_applicants'); ?>

                                    <?php //$this->load->view('administrator/tab_menu/_enrollment'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_applicants_setup'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_schedule'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_grade'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_section_monitoring'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_accounting'); ?>

                                    <?php $this->load->view('administrator/tab_menu/_user_accounts'); ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>