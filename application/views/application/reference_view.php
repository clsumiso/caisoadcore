<body class="theme-green" onload="getApplicantInfo('<?php echo $appID; ?>')">
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>RECOMMENDATION FOR ADMISSION TO GRADUATE STUDIES</h2>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form action="" method="POST" id="referenceForm">
                                <div id="reference_form_container">
                                    <h2>Relationship with the Applicant</h2>
                                    <section>
                                        <h4>Recommendation for</h4>
                                        <h1 id="appName"></h1>
                                        <h4 id="appEmail"></h4>
                                        <p id="program"></p>
                                        <hr>
                                        <p>
                                            How long have you known the applicant? In what capacity?
                                        </p>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="question_1[]" id="question_1" class="form-control" value="As his/her professor">
                                                    <label for="question_1">As his/her professor</label>
                                                </td>
                                                <td></td>
                                                <td><input type="text" class="form-control" name="question_1[]" placeholder="Years"><input type="hidden" class="form-control" name="applicantID" value="<?php echo $appID; ?>" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="question_1[]" id="question_2" class="form-control" value="As his/her thesis adviser">
                                                    <label for="question_2">As his/her thesis adviser</label>
                                                </td>
                                                <td></td>
                                                <td><input type="text" class="form-control" name="question_1[]" placeholder="Years"></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="question_1[]" id="question_3" class="form-control" value="As his/her employer/supervisor">
                                                    <label for="question_3">As his/her employer/supervisor</label>
                                                </td>
                                                <td></td>
                                                <td><input type="text" class="form-control" name="question_1[]" placeholder="Years"></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="question_1[]" id="question_4" class="form-control" value="other">
                                                    <label for="question_4">Other, please specify </label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="otherSpecify" placeholder="if other, please specify">
                                                </td>
                                                <td><input type="text" class="form-control" name="question_1[]" placeholder="Years"></td>
                                            </tr>
                                        </table>
                                    </section>

                                    <h2>Aptitude for graduate work</h2>
                                    <section>
                                        <p>
                                            Aptitude for graduate work: (Please provide details of your evaluation)
                                        </p>
                                        <textarea name="question_2" class="form-control" placeholder="" rows="10"></textarea>
                                    </section>

                                    <h2>Scholastic capability</h2>
                                    <section>
                                        <p>
                                            Scholastic capability: (Please provide details of your evaluation)
                                        </p>
                                        <textarea name="question_3" class="form-control" placeholder="" rows="10"></textarea>
                                    </section>

                                    <h2>Potential for professional success</h2>
                                    <section>
                                        <p>
                                            Potential for professional success: (Please provide details of your evaluation)
                                        </p>
                                        <textarea name="question_4" class="form-control" placeholder="" rows="10"></textarea>
                                    </section>

                                    <h2>Others</h2>
                                    <section>
                                        <p>
                                            Others
                                        </p>
                                        <textarea name="question_5" class="form-control" placeholder="" rows="10"></textarea>
                                    </section>

                                    <h2>About Me</h2>
                                    <section>
                                        <p>
                                            About Me
                                        </p>
                                        <b>Name</b>
                                        <input type="text" name="reference_name" class="form-control" value="<?php echo $referenceInfo[3]; ?>">
                                        <input type="hidden" name="reference_email" class="form-control" value="<?php echo $referenceEmail; ?>" readonly>
                                        <b>Nature of relationship with the applicant</b>
                                        <input type="text" name="reference_relationship" class="form-control"value=" <?php echo $referenceInfo[2]; ?>">
                                        <b>My Affiliation (Please do not abbreviate)</b>
                                        <input type="text" name="reference_affiliation" class="form-control" value="<?php echo $referenceInfo[1]; ?>">
                                        <b>My Position/Job Title</b>
                                        <input type="text" name="reference_position" class="form-control" value="<?php echo $referenceInfo[0]; ?>">
                                        <b>My Mobile Phone Number</b>
                                        <input type="text" name="reference_number" class="form-control" value="<?php echo $referenceInfo[4]; ?>">
                                        <input type="hidden" name="reference_email" class="form-control" value="<?php echo $referenceInfo[5]; ?>">
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>