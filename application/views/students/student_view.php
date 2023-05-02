<body class="theme-green bg-custom-gradient1">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <span class="loader"></span>
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
                <a class="navbar-brand" href="javascript:void(0);">OFFICE OF ADMISSIONS</a>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section class="" style="margin: 100px 0 0 0">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-2">
                    <?php $this->load->view('faculty/_profile_card'); ?>
                    <?php $this->load->view('faculty/_about'); ?>
                </div>
                <div class="col-xs-12 col-sm-10">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist" style="font-size: 18px;">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                                    <li role="presentation"><a href="#grades" aria-controls="grades" role="tab" data-toggle="tab">Grades</a></li>
                                    <li role="presentation"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Schedule</a></li>
                                    <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                                </ul>

                                <div class="tab-content">
                                    <?php $this->load->view('students/tab_menu/_home.php'); ?>

                                    <?php $this->load->view('students/tab_menu/_grades.php'); ?>

                                    <?php $this->load->view('students/tab_menu/_schedule.php'); ?>

                                    <?php $this->load->view('students/tab_menu/_profile_settings.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>