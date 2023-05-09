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
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <h3>APPLICATION FOR ADMISSION TO GRADUATE STUDIES</h3>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form action="" method="POST" id="applicationForm">
                                <div id="wizard_vertical">
                                    <h2>Basic Information</h2>
                                    <section>
                                        <p>
                                            <small></small>
                                            Instruction to Applicant: This form should be accomplished with all entries. Please fill-out all items, Applicant for MS/MPS must be a Bachelor’s degree graduate; applicant for PhD must be an MS/MA degree graduate. An application entitles one for consideration to the specified program only.
                                        </p>
                                        <hr>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Are you currently enrolled in a degree program in CLSU or in other higher education institution?</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input name="question_1" type="radio" id="question_1_yes" value="true" class="with-gap radio-col-green">
                                                <label for="question_1_yes">Yes</label>
                                                <input name="question_1" type="radio" id="question_1_no" value="false" class="with-gap radio-col-green">
                                                <label for="question_1_no">NO</label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Were you previously enrolled in a graduate program in CLSU (including DOT-Uni)?</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input name="question_2" type="radio" id="question_2_yes" value="true" class="with-gap radio-col-green">
                                                <label for="question_2_yes">Yes</label>
                                                <input name="question_2" type="radio" id="question_2_no" value="false" class="with-gap radio-col-green">
                                                <label for="question_2_no">NO</label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>
                                                    Have you previously applied for admission to a graduate program in CLSU?
                                                </p>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <input name="question_26" type="radio" id="question_26_yes" value="true" class="with-gap radio-col-green">
                                                <label for="question_26_yes">Yes</label>
                                                <input name="question_26" type="radio" id="question_26_no" value="false" class="with-gap radio-col-green">
                                                <label for="question_26_no">NO</label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="display: none;" id="question_27_container">
                                                <label for="question_27">If yes, when</label>   
                                                <input name="question_27" id="question_27" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Level Applied for: </p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input name="question_3" type="radio" id="question_3_yes" value="master" class="with-gap radio-col-green">
                                                <label for="question_3_yes">Master's</label>
                                                <input name="question_3" type="radio" id="question_3_no" value="phd" class="with-gap radio-col-green">
                                                <label for="question_3_no">PhD</label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Degree Program: </p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <!-- <input type="text" name="question_4" class="form-control" /> -->
                                                <select name="question_4" class="form-control">
                                                    <?php echo $courseList; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Title:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input name="question_5" type="radio" id="question_5_mr" value="mr" class="with-gap radio-col-green">
                                                <label for="question_5_mr">Mr.</label>
                                                <input name="question_5" type="radio" id="question_5_ms" value="ms" class="with-gap radio-col-green">
                                                <label for="question_5_ms">Ms.</label>
                                                <input name="question_5" type="radio" id="question_5_mrs" value="mrs" class="with-gap radio-col-green">
                                                <label for="question_5_mrs">Mrs.</label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Name:</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_6" class="form-control" placeholder="(Family Name)" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_7" class="form-control" placeholder="(First Name)" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_8" class="form-control" placeholder="(MIddle Name)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Mailing Address:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <textarea name="question_9" class="form-control" placeholder="(House No., Street Name, Building)"></textarea>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>:</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <select class="form-control" name="question_10" id="region" onfocus="_region()" onchange="_province()">
                                                    <!-- generate via ajax -->
                                                    <option value="#" selected>-- SELECT REGION --</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                                <select class="form-control" name="question_11" id="province" onchange="_municipality()">
                                                    <!-- generate via ajax -->
                                                    <option value="#" selected>-- SELECT PROVINCE --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>:</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <select class="form-control" name="question_12" id="municipality" onchange="_barangay()">
                                                    <!-- generate via ajax -->
                                                    <option value="#" selected>-- SELECT MUNICIPALITY --</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                                <select class="form-control" name="question_13" id="barangay">
                                                    <!-- generate via ajax -->
                                                    <option value="#" selected>-- SELECT BARANGAY --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>:</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_14" class="form-control" placeholder="(Postal/Zip Code)" />
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                                <input type="text" name="question_15" class="form-control" placeholder="(Country)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Email:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input type="email" name="question_16" class="form-control" placeholder="(Email Address Here)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Mobile Phone Number:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" name="question_17" class="form-control" placeholder="(Mobile Phone Number Here)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Citizenship:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" name="question_18" class="form-control" placeholder="(Citizenship Here)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Present occupation or position:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" name="question_19" class="form-control" placeholder="(Present occupation or position Here)" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-right">
                                                <p>Name & Address of Employment:</p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" name="question_20" class="form-control" placeholder="(Name & Address of Employment Here)" />
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Educational Background</h2>
                                    <section>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <p>
                                                    College/University Attended Beyond High School (No action will be taken without the original copy of the student's official transcript of records from each institution attended):
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p></p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Institution</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Dates Attended</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Degree Obtained</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">GPA</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>Bachelor's</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="date" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>Master's</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="date" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>Doctorate</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="date" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>Other</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="date" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_21[]" class="form-control" />
                                            </div>
                                        </div>
                                    </section>

                                    <h2>References</h2>
                                    <section>
                                        <p>
                                            Name and contact details of two (for master's degree applicants) of three (for PhD applicants) persons, preferably professors, supervisors, or professionals under whom you have worked or studied. The individuals will be conducted directly by the Office of Admissions. Please provide accurate contact information
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Name(s)</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Nature of relationship with the referee</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Affiliation (Please do not abbreviate)</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Position/Job Title</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Corporate Email Address</p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p class="align-center">Mobile Phone Number</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <input type="text" name="question_22[]" class="form-control" />
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Others</h2>
                                    <section>
                                        <div class="row clearfix" style="display: none;">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 align-right">
                                                <p>Field and Areas of Interest:</p>
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                                <input type="text" name="question_23" class="form-control" placeholder="(Field and Areas of Interes)" />
                                            </div>
                                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                                <input type="text" name="question_24" class="form-control" placeholder="(Major, if applicable)" />
                                            </div>
                                        </div>
                                        <p>
                                            Language Proficiency: (please rate yourself excellent, good, fair or poor)
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Language</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Reading Skills</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Writing Skills</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Speaking Skills</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p>a. English</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p>b. Filipino</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p>c. Others</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_25[]" class="form-control" />
                                            </div>
                                        </div>
                                        <p>
                                            Teaching and Other Experiences
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Position</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Agency</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Inclusive Dates</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_28[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_28[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_28[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_28[]" class="form-control" />
                                            </div>
                                        </div>
                                        <hr>
                                        <p>
                                            Published materials (not more than three), give the title, name of journal, year and pages of the three most recent published article.
                                        </p>
                                        <!-- <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <textarea name="question_29" class="form-control" placeholder="(Please elaborate...)"></textarea>
                                            </div>
                                        </div> -->
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Title</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Name of Journal</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Year</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <p class="align-center">Pages</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <input type="text" name="question_29[]" class="form-control" />
                                            </div>
                                        </div>
                                        <p>
                                            Academic honors, awards, certificate, or honorary scholarship you have received: 
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Kind</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Award Institution/Agency</p>
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <p class="align-center">Date</p>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_30[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_30[]" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="text" name="question_30[]" class="form-control" />
                                            </div>
                                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                                <input type="date" name="question_30[]" class="form-control" />
                                            </div>
                                        </div>
                                        <p>
                                            Brief account of future plans upon completion of your graduate studies at the Central Luzon State University.
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <textarea name="question_31" class="form-control" placeholder="(Please elaborate...)"></textarea>
                                            </div>
                                        </div>
                                        <p>
                                            Expected source and amount of financial support for your travel and study in this University.
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <textarea name="question_32" class="form-control" placeholder="(Please elaborate...)"></textarea>
                                            </div>
                                        </div>
                                        <p>
                                            When do you wish to begin studies in this University?
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>School Year:</p>
                                            </div>
                                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                <select name="question_33" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                                <p>
                                                    Semester:
                                                </p>
                                            </div>
                                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                <input name="question_34" type="radio" id="question_34_yes" value="1" class="with-gap radio-col-green">
                                                <label for="question_34_yes">1<sup>st</sup> Semester</label>
                                                <input name="question_34" type="radio" id="question_34_no" value="2" class="with-gap radio-col-green">
                                                <label for="question_34_no">2<sup>nd</sup> Semester</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row clearfix">
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                                <input type="checkbox" name="question_35" id="question_35" class="filled-in chk-col-green">
                                                <label for="question_35"></label>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <p>
                                                    I certify that the information submitted in this application form is accurate:
                                                </p>
                                            </div>
                                        </div>
                                    </section>

                                    <h2>Attachment</h2><section>
                                    <section>
                                        <p>
                                            Transcript of Records (TOR), <span class="col-red">please upload pdf file format</span>
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="file" class="form-control" name="gradAttachment[]" id="torFile">
                                            </div> 
                                        </div>
                                        <p>
                                            Certificate of Grade Point Average from your previous school (GWA), <span class="col-red">please upload pdf file format</span>
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="file" class="form-control" name="gradAttachment[]" id="gwaFile">
                                            </div>
                                        </div>
                                        <p>
                                            Passport Size Picture, <span class="col-red">please upload JPEG|JPG|PNG file format</span>
                                        </p>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="file" class="form-control" name="gradAttachment[]" id="pictureFile">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>