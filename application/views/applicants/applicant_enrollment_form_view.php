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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif ?>
                            
                        <?php echo form_open('applicant/enrollmentForm'); ?>
                            <div class="body">
                                <h2>INDIVIDUAL RECORD FORM</h2>
                                <hr>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <b>Applicant ID <span class="col-red">*not editable</span></b>
                                        <input type="text" name="applicantID" value="<?php if (isset($appID)) { echo $appID; } else { echo set_value('applicantID'); } ?>" class="form-control" placeholder="APPLICANT ID" readonly>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Lastname</b>
                                        <input type="text" name="lastname" value="<?php if (isset($lastname)) { echo $lastname; } else { echo set_value('lastname'); } ?>" class="form-control" placeholder="LASTNAME">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Firstname</b>
                                        <input type="text" name="firstname" value="<?php if (isset($firstname)) { echo $firstname; } else { echo set_value('firstname'); } ?>" class="form-control" placeholder="FIRSTNAME">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Middlename</b>
                                        <input type="text" name="middlename" value="<?php if (isset($middlename)) { echo $middlename; } else { echo set_value('middlename'); } ?>" class="form-control" placeholder="MIDDLENAME">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-1 col-lg-1">
                                        <b>Age</b>
                                        <input type="text" name="age" value="<?php echo set_value('age'); ?>" class="form-control" placeholder="AGE">
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Sex</b><br>
                                        <input name="sex" type="radio" id="sex1" value="M" <?php echo  set_radio('sex', 'M'); ?> class="with-gap radio-col-primary">
                                        <label for="sex1">Male</label>
                                        <input name="sex" type="radio" id="sex2" value="F" <?php echo  set_radio('sex', 'F'); ?> class="with-gap radio-col-primary">
                                        <label for="sex2">Female</label>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Religion</b><br>
                                        <select class="form-control" name="religion">
                                            <option value="">- Religion -</option>
                                            <option value="1" <?php echo set_select('religion','1', ( !empty($data) && $data == "1" ? TRUE : FALSE )); ?>>Aglipay</option>
                                            <option value="2" <?php echo set_select('religion','2', ( !empty($data) && $data == "2" ? TRUE : FALSE )); ?>>APOSTOLIC FAITH</option>
                                            <option value="3" <?php echo set_select('religion','3', ( !empty($data) && $data == "3" ? TRUE : FALSE )); ?>>Baptist</option>
                                            <option value="4" <?php echo set_select('religion','4', ( !empty($data) && $data == "4" ? TRUE : FALSE )); ?>>Born Again Christian</option>
                                            <option value="5" <?php echo set_select('religion','5', ( !empty($data) && $data == "5" ? TRUE : FALSE )); ?>>Buddhist</option>
                                            <option value="6" <?php echo set_select('religion','6', ( !empty($data) && $data == "6" ? TRUE : FALSE )); ?>>Christian</option>
                                            <option value="7" <?php echo set_select('religion','7', ( !empty($data) && $data == "7" ? TRUE : FALSE )); ?>>Evangelical Christian</option>
                                            <option value="8" <?php echo set_select('religion','8', ( !empty($data) && $data == "8" ? TRUE : FALSE )); ?>>Iglesia ng Dios kay Kristo;HSK</option>
                                            <option value="9" <?php echo set_select('religion','9', ( !empty($data) && $data == "9" ? TRUE : FALSE )); ?>>Iglesia ni Cristo</option>
                                            <option value="10" <?php echo set_select('religion','10', ( !empty($data) && $data == "10" ? TRUE : FALSE )); ?>>Islam</option>
                                            <option value="11" <?php echo set_select('religion','11', ( !empty($data) && $data == "11" ? TRUE : FALSE )); ?>>Jehovah\'s Witnessess</option>
                                            <option value="12" <?php echo set_select('religion','12', ( !empty($data) && $data == "12" ? TRUE : FALSE )); ?>>Jesus is Lord</option>
                                            <option value="13" <?php echo set_select('religion','13', ( !empty($data) && $data == "13" ? TRUE : FALSE )); ?>>LDS</option>
                                            <option value="14" <?php echo set_select('religion','14', ( !empty($data) && $data == "14" ? TRUE : FALSE )); ?>>Methodist</option>
                                            <option value="15" <?php echo set_select('religion','15', ( !empty($data) && $data == "15" ? TRUE : FALSE )); ?>>Others</option>
                                            <option value="16" <?php echo set_select('religion','16', ( !empty($data) && $data == "16" ? TRUE : FALSE )); ?>>Pentecost</option>
                                            <option value="17" <?php echo set_select('religion','17', ( !empty($data) && $data == "17" ? TRUE : FALSE )); ?>>Protestant</option>
                                            <option value="18" <?php echo set_select('religion','18', ( !empty($data) && $data == "18" ? TRUE : FALSE )); ?>>Roman Catholic</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Citizenship</b><br>
                                        <select class="form-control" name="citizenship">
                                            <option value="">- Nationality -</option>
                                            <option value="AME" <?php echo set_select('citizenship','AME', ( !empty($data) && $data == "AME" ? TRUE : FALSE )); ?>>American</option>
                                            <option value="BRT" <?php echo set_select('citizenship','BRT', ( !empty($data) && $data == "BRT" ? TRUE : FALSE )); ?>>British</option>
                                            <option value="CHN" <?php echo set_select('citizenship','CHN', ( !empty($data) && $data == "CHN" ? TRUE : FALSE )); ?>>Chinese</option>
                                            <option value="CND" <?php echo set_select('citizenship','CND', ( !empty($data) && $data == "CND" ? TRUE : FALSE )); ?>>Canadian</option>
                                            <option value="DEU" <?php echo set_select('citizenship','DEU', ( !empty($data) && $data == "DEU" ? TRUE : FALSE )); ?>>Germanian</option>
                                            <option value="DJI" <?php echo set_select('citizenship','DJI', ( !empty($data) && $data == "DJI" ? TRUE : FALSE )); ?>>Djiboutianne</option>
                                            <option value="ERI" <?php echo set_select('citizenship','ERI', ( !empty($data) && $data == "ERI" ? TRUE : FALSE )); ?>>Eritrean</option>
                                            <option value="ETH" <?php echo set_select('citizenship','ETH', ( !empty($data) && $data == "ETH" ? TRUE : FALSE )); ?>>Ethiopian</option>
                                            <option value="FIL" <?php echo set_select('citizenship','FIL', ( !empty($data) && $data == "FIL" ? TRUE : FALSE )); ?>>Filipino</option>
                                            <option value="FRE" <?php echo set_select('citizenship','FRE', ( !empty($data) && $data == "FRE" ? TRUE : FALSE )); ?>>French</option>
                                            <option value="IDN" <?php echo set_select('citizenship','IDN', ( !empty($data) && $data == "IDN" ? TRUE : FALSE )); ?>>Indonesian</option>
                                            <option value="IND" <?php echo set_select('citizenship','IND', ( !empty($data) && $data == "IND" ? TRUE : FALSE )); ?>>Indian</option>
                                            <option value="JAP" <?php echo set_select('citizenship','JAP', ( !empty($data) && $data == "JAP" ? TRUE : FALSE )); ?>>Japanese</option>
                                            <option value="KEN" <?php echo set_select('citizenship','KEN', ( !empty($data) && $data == "KEN" ? TRUE : FALSE )); ?>>Kenyan</option>
                                            <option value="KOR" <?php echo set_select('citizenship','KOR', ( !empty($data) && $data == "KOR" ? TRUE : FALSE )); ?>>Korean</option>
                                            <option value="LBY" <?php echo set_select('citizenship','LBY', ( !empty($data) && $data == "LBY" ? TRUE : FALSE )); ?>>Libyan</option>
                                            <option value="MRT" <?php echo set_select('citizenship','MRT', ( !empty($data) && $data == "MRT" ? TRUE : FALSE )); ?>>Mauritanian</option>
                                            <option value="MYS" <?php echo set_select('citizenship','MYS', ( !empty($data) && $data == "MYS" ? TRUE : FALSE )); ?>>Malaysian</option>
                                            <option value="NGA" <?php echo set_select('citizenship','NGA', ( !empty($data) && $data == "NGA" ? TRUE : FALSE )); ?>>Nigerian</option>
                                            <option value="NOR" <?php echo set_select('citizenship','NOR', ( !empty($data) && $data == "NOR" ? TRUE : FALSE )); ?>>Norwegian</option>
                                            <option value="PAK" <?php echo set_select('citizenship','PAK', ( !empty($data) && $data == "PAK" ? TRUE : FALSE )); ?>>Pakistanian</option>
                                            <option value="PNG" <?php echo set_select('citizenship','PNG', ( !empty($data) && $data == "PNG" ? TRUE : FALSE )); ?>>Papua New Guinean</option>
                                            <option value="SAU" <?php echo set_select('citizenship','SAU', ( !empty($data) && $data == "SAU" ? TRUE : FALSE )); ?>>Saudi</option>
                                            <option value="SOM" <?php echo set_select('citizenship','SOM', ( !empty($data) && $data == "SOM" ? TRUE : FALSE )); ?>>Somalian</option>
                                            <option value="SUD" <?php echo set_select('citizenship','SUD', ( !empty($data) && $data == "SUD" ? TRUE : FALSE )); ?>>Sudanese</option>
                                            <option value="THA" <?php echo set_select('citizenship','THA', ( !empty($data) && $data == "THA" ? TRUE : FALSE )); ?>>Thailand</option>
                                            <option value="TWN" <?php echo set_select('citizenship','TWN', ( !empty($data) && $data == "TWN" ? TRUE : FALSE )); ?>>Taiwanese</option>
                                            <option value="VNM" <?php echo set_select('citizenship','VNM', ( !empty($data) && $data == "VNM" ? TRUE : FALSE )); ?>>Vietnamese</option>
                                            <option value="YEM" <?php echo set_select('citizenship','YEM', ( !empty($data) && $data == "YEM" ? TRUE : FALSE )); ?>>Yemenese</option>
                                            <option value="Others" <?php echo set_select('citizenship','Others', ( !empty($data) && $data == "Others" ? TRUE : FALSE )); ?>>Others</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Multiple Citizenship</b><br>
                                        <select class="form-control" name="multi_citizenship">
                                            <option value="">- Nationality -</option>
                                            <option value="AME" <?php echo set_select('multi_citizenship','AME', ( !empty($data) && $data == "AME" ? TRUE : FALSE )); ?>>American</option>
                                            <option value="BRT" <?php echo set_select('multi_citizenship','BRT', ( !empty($data) && $data == "BRT" ? TRUE : FALSE )); ?>>British</option>
                                            <option value="CHN" <?php echo set_select('multi_citizenship','CHN', ( !empty($data) && $data == "CHN" ? TRUE : FALSE )); ?>>Chinese</option>
                                            <option value="CND" <?php echo set_select('multi_citizenship','CND', ( !empty($data) && $data == "CND" ? TRUE : FALSE )); ?>>Canadian</option>
                                            <option value="DEU" <?php echo set_select('multi_citizenship','DEU', ( !empty($data) && $data == "DEU" ? TRUE : FALSE )); ?>>Germanian</option>
                                            <option value="DJI" <?php echo set_select('multi_citizenship','DJI', ( !empty($data) && $data == "DJI" ? TRUE : FALSE )); ?>>Djiboutianne</option>
                                            <option value="ERI" <?php echo set_select('multi_citizenship','ERI', ( !empty($data) && $data == "ERI" ? TRUE : FALSE )); ?>>Eritrean</option>
                                            <option value="ETH" <?php echo set_select('multi_citizenship','ETH', ( !empty($data) && $data == "ETH" ? TRUE : FALSE )); ?>>Ethiopian</option>
                                            <option value="FIL" <?php echo set_select('multi_citizenship','FIL', ( !empty($data) && $data == "FIL" ? TRUE : FALSE )); ?>>Filipino</option>
                                            <option value="FRE" <?php echo set_select('multi_citizenship','FRE', ( !empty($data) && $data == "FRE" ? TRUE : FALSE )); ?>>French</option>
                                            <option value="IDN" <?php echo set_select('multi_citizenship','IDN', ( !empty($data) && $data == "IDN" ? TRUE : FALSE )); ?>>Indonesian</option>
                                            <option value="IND" <?php echo set_select('multi_citizenship','IND', ( !empty($data) && $data == "IND" ? TRUE : FALSE )); ?>>Indian</option>
                                            <option value="JAP" <?php echo set_select('multi_citizenship','JAP', ( !empty($data) && $data == "JAP" ? TRUE : FALSE )); ?>>Japanese</option>
                                            <option value="KEN" <?php echo set_select('multi_citizenship','KEN', ( !empty($data) && $data == "KEN" ? TRUE : FALSE )); ?>>Kenyan</option>
                                            <option value="KOR" <?php echo set_select('multi_citizenship','KOR', ( !empty($data) && $data == "KOR" ? TRUE : FALSE )); ?>>Korean</option>
                                            <option value="LBY" <?php echo set_select('multi_citizenship','LBY', ( !empty($data) && $data == "LBY" ? TRUE : FALSE )); ?>>Libyan</option>
                                            <option value="MRT" <?php echo set_select('multi_citizenship','MRT', ( !empty($data) && $data == "MRT" ? TRUE : FALSE )); ?>>Mauritanian</option>
                                            <option value="MYS" <?php echo set_select('multi_citizenship','MYS', ( !empty($data) && $data == "MYS" ? TRUE : FALSE )); ?>>Malaysian</option>
                                            <option value="NGA" <?php echo set_select('multi_citizenship','NGA', ( !empty($data) && $data == "NGA" ? TRUE : FALSE )); ?>>Nigerian</option>
                                            <option value="NOR" <?php echo set_select('multi_citizenship','NOR', ( !empty($data) && $data == "NOR" ? TRUE : FALSE )); ?>>Norwegian</option>
                                            <option value="PAK" <?php echo set_select('multi_citizenship','PAK', ( !empty($data) && $data == "PAK" ? TRUE : FALSE )); ?>>Pakistanian</option>
                                            <option value="PNG" <?php echo set_select('multi_citizenship','PNG', ( !empty($data) && $data == "PNG" ? TRUE : FALSE )); ?>>Papua New Guinean</option>
                                            <option value="SAU" <?php echo set_select('multi_citizenship','SAU', ( !empty($data) && $data == "SAU" ? TRUE : FALSE )); ?>>Saudi</option>
                                            <option value="SOM" <?php echo set_select('multi_citizenship','SOM', ( !empty($data) && $data == "SOM" ? TRUE : FALSE )); ?>>Somalian</option>
                                            <option value="SUD" <?php echo set_select('multi_citizenship','SUD', ( !empty($data) && $data == "SUD" ? TRUE : FALSE )); ?>>Sudanese</option>
                                            <option value="THA" <?php echo set_select('multi_citizenship','THA', ( !empty($data) && $data == "THA" ? TRUE : FALSE )); ?>>Thailand</option>
                                            <option value="TWN" <?php echo set_select('multi_citizenship','TWN', ( !empty($data) && $data == "TWN" ? TRUE : FALSE )); ?>>Taiwanese</option>
                                            <option value="VNM" <?php echo set_select('multi_citizenship','VNM', ( !empty($data) && $data == "VNM" ? TRUE : FALSE )); ?>>Vietnamese</option>
                                            <option value="YEM" <?php echo set_select('multi_citizenship','YEM', ( !empty($data) && $data == "YEM" ? TRUE : FALSE )); ?>>Yemenese</option>
                                            <option value="Others" <?php echo set_select('multi_citizenship','Others', ( !empty($data) && $data == "Others" ? TRUE : FALSE )); ?>>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                        <h4>Address</h4>
                                        <b>(House No., Street Name, Building)</b>
                                        <input type="text" name="street1" value="<?php echo set_value('street1'); ?>"  class="form-control" placeholder="(House No., Street Name, Building)"></input>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Region</b>
                                        <select class="form-control region1" name="region1" onfocus="_region1()" onchange="_province1()">
                                            <!-- generate via ajax -->
                                            <option value="">-- SELECT REGION --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Province</b>
                                        <select class="form-control province1" name="province1" onchange="_municipality1()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT PROVINCE --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Municipality</b>
                                        <select class="form-control municipality1" name="municipality1" onchange="_barangay1()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT MUNICIPALITY --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Barangay</b>
                                        <select class="form-control barangay1" name="barangay1">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT BARANGAY --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <b>Postal/Zip Code</b>
                                        <input type="text" name="zipcode" value="<?php echo set_value('zipcode'); ?>"  class="form-control" placeholder="(Postal/Zip Code)"></input>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <b>Country</b>
                                        <input type="text" name="country" value="<?php echo set_value('country'); ?>"  class="form-control" placeholder="(e.g Philippines)"></input>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Date of Birth</b>
                                        <input type="date" name="date_of_birth" value="<?php echo set_value('date_of_birth'); ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Place of Birth</b>
                                        <input type="text" name="place_of_birth" value="<?php echo set_value('place_of_birth'); ?>" class="form-control">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Course & Year <span class="col-red">*not editable</span></b>
                                        <input type="text" name="course_year" value="<?php if (isset($program)) { echo $program; } else { echo set_value('course_year'); } ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Gender</b><br>
                                        <input name="gender" type="radio" id="gender8" value="straight" <?php echo  set_radio('gender', 'straight'); ?> class="with-gap radio-col-primary">
                                        <label for="gender8">Straight</label>
                                        <input name="gender" type="radio" id="gender1" value="lesbian" <?php echo  set_radio('gender', 'lesbian'); ?> class="with-gap radio-col-primary">
                                        <label for="gender1">Lesbian</label>
                                        <input name="gender" type="radio" id="gender2" value="gay" <?php echo  set_radio('gender', 'gay'); ?> class="with-gap radio-col-primary">
                                        <label for="gender2">Gay</label>
                                        <input name="gender" type="radio" id="gender3" value="bisexual" <?php echo  set_radio('gender', 'bisexual'); ?> class="with-gap radio-col-primary">
                                        <label for="gender3">Bisexual</label>
                                        <input name="gender" type="radio" id="gender4" value="transgender" <?php echo  set_radio('gender', 'transgender'); ?> class="with-gap radio-col-primary">
                                        <label for="gender4">Transgender</label>
                                        <input name="gender" type="radio" id="gender5" value="queer" <?php echo  set_radio('gender', 'queer'); ?> class="with-gap radio-col-primary">
                                        <label for="gender5">Queer</label>
                                        <input name="gender" type="radio" id="gender9" value="queer" <?php echo  set_radio('gender', 'Prefer not to say'); ?> class="with-gap radio-col-primary">
                                        <label for="gender9">Prefer not to say</label>
                                        <input name="gender" type="radio" id="gender7" value="other" <?php echo  set_radio('gender', 'other'); ?> class="with-gap radio-col-primary">
                                        <label for="gender7">Others: Pls. specify</label>
                                        <input name="gender6" type="text" id="gender6" class="form-control" style="width: 400px; display: none;" placeholder="Others please specify">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Civil Status</b><br>
                                        <input name="civilStatus" type="radio" id="civilStatus1" value="single" <?php echo  set_radio('civilStatus', 'single'); ?> class="with-gap radio-col-primary">
                                        <label for="civilStatus1">Single</label>
                                        <input name="civilStatus" type="radio" id="civilStatus2" value="married" <?php echo  set_radio('civilStatus', 'married'); ?> class="with-gap radio-col-primary">
                                        <label for="civilStatus2">Married</label>
                                        <input name="civilStatus" type="radio" id="civilStatus3" value="single-parent" <?php echo  set_radio('civilStatus', 'single-parent'); ?> class="with-gap radio-col-primary">
                                        <label for="civilStatus3">Single-Parent</label>
                                        <input name="civilStatus" type="radio" id="civilStatus5" value="other" <?php echo  set_radio('civilStatus', 'other'); ?> class="with-gap radio-col-primary">
                                        <label for="civilStatus5">Others: Pls. specify</label>
                                        <input name="civilStatus4" type="text" id="civilStatus4" class="form-control" style="width: 400px; display: none;" placeholder="Others please specify">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Telephone No</b>
                                        <input type="text" name="tel_no" class="form-control" value="<?php echo set_value('tel_no'); ?>" placeholder="Telephone Number">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Mobile No</b>
                                        <input type="text" name="mobile_no" class="form-control" value="<?php echo set_value('mobile_no'); ?>" placeholder="Mobile Number">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Email Address</b>
                                        <input type="email" name="email_address" class="form-control" value="<?php echo set_value('email_address'); ?>" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                        <h4>Address (while studying in CLSU)</h4>
                                        <b>(House No., Street Name, Building)</b>
                                        <input type="text" name="street2" class="form-control" value="<?php echo set_value('street2'); ?>" placeholder="(House No., Street Name, Building)"></input>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Region</b>
                                        <select class="form-control region2" name="region2" onfocus="_region2()" onchange="_province2()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT REGION --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Province</b>
                                        <select class="form-control province2" name="province2" onchange="_municipality2()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT PROVINCE --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Municipality</b>
                                        <select class="form-control municipality2" name="municipality2" onchange="_barangay2()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT MUNICIPALITY --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Barangay</b>
                                        <select class="form-control barangay2" name="barangay2">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT BARANGAY --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                        <h4>Senior High School where Graduated</h4>
                                        <b>&nbsp;</b>
                                        <input type="text" name="street3" class="form-control" value="<?php echo set_value('street3'); ?>" placeholder="School Name"></input>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>School Address</h4>
                                        <b>Region</b>
                                        <select class="form-control region3" name="region3" onfocus="_region3()" onchange="_province3()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT REGION --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Province</b>
                                        <select class="form-control province3" name="province3" onchange="_municipality3()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT PROVINCE --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Municipality</b>
                                        <select class="form-control municipality3" name="municipality3" onchange="_barangay3()">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT MUNICIPALITY --</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <h4>&nbsp</h4>
                                        <b>Barangay</b>
                                        <select class="form-control barangay3" name="barangay3">
                                            <!-- generate via ajax -->
                                            <option value="" selected>-- SELECT BARANGAY --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-6 col-6">
                                        <b>Strand</b><br>
                                        <select class="form-control" name="strand">
                                            <option value="">Choose</option>
                                            <option value="Sports Track"  <?php echo set_select('strand','Sports Track', ( !empty($data) && $data == "Sports Track" ? TRUE : FALSE )); ?>>Sports Track</option>
                                            <option value="Arts and Design Track"  <?php echo set_select('strand','Arts and Design Track', ( !empty($data) && $data == "Arts and Design Track" ? TRUE : FALSE )); ?>>Arts and Design Track</option>
                                            <option value="Technical-Vocational Livelihood Track (Home Economics Stand)"  <?php echo set_select('strand','Technical-Vocational Livelihood Track (Home Economics Stand)', ( !empty($data) && $data == "Technical-Vocational Livelihood Track (Home Economics Stand)" ? TRUE : FALSE )); ?>>Technical-Vocational Livelihood Track (Home Economics Stand)</option>
                                            <option value="Technical-Vocational Livelihood Track (Information and Communication Technology Strand)"  <?php echo set_select('strand','Technical-Vocational Livelihood Track (Information and Communication Technology Strand)', ( !empty($data) && $data == "Technical-Vocational Livelihood Track (Information and Communication Technology Strand)" ? TRUE : FALSE )); ?>>Technical-Vocational Livelihood Track (Information and Communication Technology Strand)</option>
                                            <option value="Technical-Vocational Livelihood Track (Agri-Fisheries Strand)"  <?php echo set_select('strand','Technical-Vocational Livelihood Track (Agri-Fisheries Strand)', ( !empty($data) && $data == "Technical-Vocational Livelihood Track (Agri-Fisheries Strand)" ? TRUE : FALSE )); ?>>Technical-Vocational Livelihood Track (Agri-Fisheries Strand)</option>
                                            <option value="Technical-Vocational Livelihood Track (Industrial Arts Strand)"  <?php echo set_select('strand','Technical-Vocational Livelihood Track (Industrial Arts Strand)', ( !empty($data) && $data == "Technical-Vocational Livelihood Track (Industrial Arts Strand)" ? TRUE : FALSE )); ?>>Technical-Vocational Livelihood Track (Industrial Arts Strand)</option>
                                            <option value="Academic Track (Accountancy, Business and Management (ABM) Strand)"  <?php echo set_select('strand','Academic Track (Accountancy, Business and Management (ABM) Strand)', ( !empty($data) && $data == "Academic Track (Accountancy, Business and Management (ABM) Strand)" ? TRUE : FALSE )); ?>>Academic Track (Accountancy, Business and Management (ABM) Strand)</option>
                                            <option value="Academic Track (Humanities and Social Sciences Strand (HUMSS))"  <?php echo set_select('strand','Academic Track (Humanities and Social Sciences Strand (HUMSS))', ( !empty($data) && $data == "Academic Track (Humanities and Social Sciences Strand (HUMSS))" ? TRUE : FALSE )); ?>>Academic Track (Humanities and Social Sciences Strand (HUMSS))</option>
                                            <option value="Academic Track (Science, Technology, Engineering and Mathematics (STEM) Strand)"  <?php echo set_select('strand','Academic Track (Science, Technology, Engineering and Mathematics (STEM) Strand)', ( !empty($data) && $data == "Academic Track (Science, Technology, Engineering and Mathematics (STEM) Strand)" ? TRUE : FALSE )); ?>>Academic Track (Science, Technology, Engineering and Mathematics (STEM) Strand)</option>
                                            <option value="Academic Track (General Academic Strand)"  <?php echo set_select('strand','Academic Track (General Academic Strand)', ( !empty($data) && $data == "Academic Track (General Academic Strand)" ? TRUE : FALSE )); ?>>Academic Track (General Academic Strand)</option>
                                            <option value="n/a"  <?php echo set_select('strand','n/a', ( !empty($data) && $data == "n/a" ? TRUE : FALSE )); ?>>Not Applicable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Type of School</b><br>
                                        <input name="schoolType" type="radio" id="schoolType1" value="private sectarian" <?php echo  set_radio('schoolType', 'private sectarian'); ?> class="with-gap radio-col-primary">
                                        <label for="schoolType1">Private Sectarian</label>
                                        <input name="schoolType" type="radio" id="schoolType2" value="private non-sectarian" <?php echo  set_radio('schoolType', 'private non-sectarian'); ?> class="with-gap radio-col-primary">
                                        <label for="schoolType2">Private Non-Sectarian</label>
                                        <input name="schoolType" type="radio" id="schoolType3" value="public" <?php echo  set_radio('schoolType', 'public'); ?> class="with-gap radio-col-primary">
                                        <label for="schoolType3">Public</label>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3" style="display: none;">
                                        <b>High School Grade Average</b><br>
                                        <input name="highSchoolGradeAverage" type="number" step=0.01 value="<?php echo set_value('highSchoolGradeAverage'); ?>" id="highSchoolGradeAverage" class="form-control" placeholder="AVERAGE">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Year of Graduation</b><br>
                                        <select name="highSchoolYearGraduated" class="form-control">

                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Senior High School Award</b><br>
                                        <input type="text" name="senior_high_school_awards" class="form-control" value="<?php echo set_value('senior_high_school_awards'); ?>" placeholder="(Awards)"></input>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Name of Father</b>
                                        <input type="text" name="father_name" value="<?php echo set_value('father_name'); ?>" class="form-control" placeholder="NAME">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Age</b>
                                        <select name="father_age" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="25 years old to 30 years old" <?php echo set_select('father_age','25 years old to 30 years old', ( !empty($data) && $data == "25 years old to 30 years old" ? TRUE : FALSE )); ?>>25 years old to 30 years old</option>
                                            <option value="31 years old to 35 years old" <?php echo set_select('father_age','31 years old to 35 years old', ( !empty($data) && $data == "31 years old to 35 years old" ? TRUE : FALSE )); ?>>31 years old to 35 years old</option>
                                            <option value="36 years old to 40 years old" <?php echo set_select('father_age','36 years old to 40 years old', ( !empty($data) && $data == "36 years old to 40 years old" ? TRUE : FALSE )); ?>>36 years old to 40 years old</option>
                                            <option value="41 years old to 45 years old" <?php echo set_select('father_age','41 years old to 45 years old', ( !empty($data) && $data == "41 years old to 45 years old" ? TRUE : FALSE )); ?>>41 years old to 45 years old</option>
                                            <option value="46 years old to 50 years old" <?php echo set_select('father_age','46 years old to 50 years old', ( !empty($data) && $data == "46 years old to 50 years old" ? TRUE : FALSE )); ?>>46 years old to 50 years old</option>
                                            <option value="51 years old to 55 years old" <?php echo set_select('father_age','51 years old to 55 years old', ( !empty($data) && $data == "51 years old to 55 years old" ? TRUE : FALSE )); ?>>51 years old to 55 years old</option>
                                            <option value="56 years old to 60 years old" <?php echo set_select('father_age','56 years old to 60 years old', ( !empty($data) && $data == "56 years old to 60 years old" ? TRUE : FALSE )); ?>>56 years old to 60 years old</option>
                                            <option value="61 years old and above" <?php echo set_select('father_age','61 years old and above', ( !empty($data) && $data == "61 years old and above" ? TRUE : FALSE )); ?>>61 years old and above</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Occupation</b>
                                        <select name="father_occupation" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Non-Employed" <?php echo set_select('father_occupation','Non-Employed', ( !empty($data) && $data == "Non-Employed" ? TRUE : FALSE )); ?>>Non-Employed</option>
                                            <option value="Self-Employed" <?php echo set_select('father_occupation','Self-Employed', ( !empty($data) && $data == "Self-Employed" ? TRUE : FALSE )); ?>>Self-Employed</option>
                                            <option value="Private Employee" <?php echo set_select('father_occupation','Private Employee', ( !empty($data) && $data == "Private Employee" ? TRUE : FALSE )); ?>>Private Employee</option>
                                            <option value="Government Employee" <?php echo set_select('father_occupation','Government Employee', ( !empty($data) && $data == "Government Employee" ? TRUE : FALSE )); ?>>Government Employee</option>
                                            <option value="OFW" <?php echo set_select('father_occupation','OFW', ( !empty($data) && $data == "OFW" ? TRUE : FALSE )); ?>>OFW</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Educational Attainment</b>
                                        <select name="father_education" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Elementary Level" <?php echo set_select('father_education','Elementary Level', ( !empty($data) && $data == "Elementary Level" ? TRUE : FALSE )); ?>>Elementary Level</option>
                                            <option value="Elementary Graduate" <?php echo set_select('father_education','Elementary Graduate', ( !empty($data) && $data == "Elementary Graduate" ? TRUE : FALSE )); ?>>Elementary Graduate</option>
                                            <option value="High School Level" <?php echo set_select('father_education','High School Level', ( !empty($data) && $data == "High School Level" ? TRUE : FALSE )); ?>>High School Level</option>
                                            <option value="High School Graduate" <?php echo set_select('father_education','High School Graduate', ( !empty($data) && $data == "High School Graduate" ? TRUE : FALSE )); ?>>High School Graduate</option>
                                            <option value="Vocational" <?php echo set_select('father_education','Vocational', ( !empty($data) && $data == "Vocational" ? TRUE : FALSE )); ?>>Vocational</option>
                                            <option value="College Level" <?php echo set_select('father_education','College Level', ( !empty($data) && $data == "College Level" ? TRUE : FALSE )); ?>>College Level</option>
                                            <option value="College Graduate" <?php echo set_select('father_education','College Graduate', ( !empty($data) && $data == "College Graduate" ? TRUE : FALSE )); ?>>College Graduate</option>
                                            <option value="Masters Level" <?php echo set_select('father_education','Masters Level', ( !empty($data) && $data == "Masters Level" ? TRUE : FALSE )); ?>>Master's Level</option>
                                            <option value="Masters Degree Graduate" <?php echo set_select('father_education','Masters Degree Graduate', ( !empty($data) && $data == "Masters Degree Graduate" ? TRUE : FALSE )); ?>>Master's Degree Graduate</option>
                                            <option value="Doctorate Level" <?php echo set_select('father_education','Doctorate Level', ( !empty($data) && $data == "Doctorate Level" ? TRUE : FALSE )); ?>>Doctorate Level</option>
                                            <option value="Doctorate Degree Graduate" <?php echo set_select('father_education','Doctorate Degree Graduate', ( !empty($data) && $data == "Doctorate Degree Graduate" ? TRUE : FALSE )); ?>>Doctorate Degree Graduate</option>
                                            <option value="n/a" <?php echo set_select('father_education','n/a', ( !empty($data) && $data == "n/a" ? TRUE : FALSE )); ?>>Not Applicable</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Father Contact</b>
                                        <input type="text" name="father_contact" value="<?php echo set_value('father_contact'); ?>" class="form-control" placeholder="CONTACT">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Father Address</b>
                                        <input type="text" name="father_address" value="<?php echo set_value('father_address'); ?>" class="form-control" placeholder="ADDRESS">
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-5">
                                        <input type="checkbox" name="signatories[]" id="signatories1" class="filled-in chk-col-green" value="father" <?php echo set_checkbox('signatories[]', 'father'); ?>>
                                        <label for="signatories1">Please check if your father will sign the enrollment form</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Name of Mother</b>
                                        <input type="text" name="mother_name" value="<?php echo set_value('mother_name'); ?>" class="form-control" placeholder="NAME">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Age</b>
                                        <select name="mother_age" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="25 years old to 30 years old" <?php echo set_select('mother_age','25 years old to 30 years old', ( !empty($data) && $data == "25 years old to 30 years old" ? TRUE : FALSE )); ?>>25 years old to 30 years old</option>
                                            <option value="31 years old to 35 years old" <?php echo set_select('mother_age','31 years old to 35 years old', ( !empty($data) && $data == "31 years old to 35 years old" ? TRUE : FALSE )); ?>>31 years old to 35 years old</option>
                                            <option value="36 years old to 40 years old" <?php echo set_select('mother_age','36 years old to 40 years old', ( !empty($data) && $data == "36 years old to 40 years old" ? TRUE : FALSE )); ?>>36 years old to 40 years old</option>
                                            <option value="41 years old to 45 years old" <?php echo set_select('mother_age','41 years old to 45 years old', ( !empty($data) && $data == "41 years old to 45 years old" ? TRUE : FALSE )); ?>>41 years old to 45 years old</option>
                                            <option value="46 years old to 50 years old" <?php echo set_select('mother_age','46 years old to 50 years old', ( !empty($data) && $data == "46 years old to 50 years old" ? TRUE : FALSE )); ?>>46 years old to 50 years old</option>
                                            <option value="51 years old to 55 years old" <?php echo set_select('mother_age','51 years old to 55 years old', ( !empty($data) && $data == "51 years old to 55 years old" ? TRUE : FALSE )); ?>>51 years old to 55 years old</option>
                                            <option value="56 years old to 60 years old" <?php echo set_select('mother_age','56 years old to 60 years old', ( !empty($data) && $data == "56 years old to 60 years old" ? TRUE : FALSE )); ?>>56 years old to 60 years old</option>
                                            <option value="61 years old and above" <?php echo set_select('mother_age','61 years old and above', ( !empty($data) && $data == "61 years old and above" ? TRUE : FALSE )); ?>>61 years old and above</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Occupation</b>
                                        <select name="mother_occupation" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Non-Employed" <?php echo set_select('mother_occupation','Non-Employed', ( !empty($data) && $data == "Non-Employed" ? TRUE : FALSE )); ?>>Non-Employed</option>
                                            <option value="Self-Employed" <?php echo set_select('mother_occupation','Self-Employed', ( !empty($data) && $data == "Self-Employed" ? TRUE : FALSE )); ?>>Self-Employed</option>
                                            <option value="Private Employee" <?php echo set_select('mother_occupation','Private Employee', ( !empty($data) && $data == "Private Employee" ? TRUE : FALSE )); ?>>Private Employee</option>
                                            <option value="Government Employee" <?php echo set_select('mother_occupation','Government Employee', ( !empty($data) && $data == "Government Employee" ? TRUE : FALSE )); ?>>Government Employee</option>
                                            <option value="OFW" <?php echo set_select('mother_occupation','OFW', ( !empty($data) && $data == "OFW" ? TRUE : FALSE )); ?>>OFW</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Educational Attainment</b>
                                        <select name="mother_education" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Elementary Level" <?php echo set_select('mother_education','Elementary Level', ( !empty($data) && $data == "Elementary Level" ? TRUE : FALSE )); ?>>Elementary Level</option>
                                            <option value="Elementary Graduate" <?php echo set_select('mother_education','Elementary Graduate', ( !empty($data) && $data == "Elementary Graduate" ? TRUE : FALSE )); ?>>Elementary Graduate</option>
                                            <option value="High School Level" <?php echo set_select('mother_education','High School Level', ( !empty($data) && $data == "High School Level" ? TRUE : FALSE )); ?>>High School Level</option>
                                            <option value="High School Graduate" <?php echo set_select('mother_education','High School Graduate', ( !empty($data) && $data == "High School Graduate" ? TRUE : FALSE )); ?>>High School Graduate</option>
                                            <option value="Vocational" <?php echo set_select('mother_education','Vocational', ( !empty($data) && $data == "Vocational" ? TRUE : FALSE )); ?>>Vocational</option>
                                            <option value="College Level" <?php echo set_select('mother_education','College Level', ( !empty($data) && $data == "College Level" ? TRUE : FALSE )); ?>>College Level</option>
                                            <option value="College Graduate" <?php echo set_select('mother_education','College Graduate', ( !empty($data) && $data == "College Graduate" ? TRUE : FALSE )); ?>>College Graduate</option>
                                            <option value="Masters Level" <?php echo set_select('mother_education','Masters Level', ( !empty($data) && $data == "Masters Level" ? TRUE : FALSE )); ?>>Master's Level</option>
                                            <option value="Masters Degree Graduate" <?php echo set_select('mother_education','Masters Degree Graduate', ( !empty($data) && $data == "Masters Degree Graduate" ? TRUE : FALSE )); ?>>Master's Degree Graduate</option>
                                            <option value="Doctorate Level" <?php echo set_select('mother_education','Doctorate Level', ( !empty($data) && $data == "Doctorate Level" ? TRUE : FALSE )); ?>>Doctorate Level</option>
                                            <option value="Doctorate Degree Graduate" <?php echo set_select('mother_education','Doctorate Degree Graduate', ( !empty($data) && $data == "Doctorate Degree Graduate" ? TRUE : FALSE )); ?>>Doctorate Degree Graduate</option>
                                            <option value="n/a" <?php echo set_select('mother_education','n/a', ( !empty($data) && $data == "n/a" ? TRUE : FALSE )); ?>>Not Applicable</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Mother Contact</b>
                                        <input type="text" name="mother_contact" value="<?php echo set_value('mother_contact'); ?>" class="form-control" placeholder="CONTACT">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Mother Address</b>
                                        <input type="text" name="mother_address" value="<?php echo set_value('mother_address'); ?>" class="form-control" placeholder="ADDRESS">
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-5">
                                        <input type="checkbox" name="signatories[]" id="signatories2" class="filled-in chk-col-green" value="mother" <?php echo set_checkbox('signatories[]', 'mother'); ?>>
                                        <label for="signatories2">Please check if your mother will sign the enrollment form</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Name of Guardian</b>
                                        <input type="text" name="guardian_name" value="<?php echo set_value('guardian_name'); ?>" class="form-control" placeholder="NAME">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Relationship to your guardian</b>
                                        <input type="text" name="guardian_relationship" value="<?php echo set_value('guardian_relationship'); ?>" class="form-control" placeholder="Relationship">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Age</b>
                                        <select name="guardian_age" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="25 years old to 30 years old" <?php echo set_select('guardian_age','25 years old to 30 years old', ( !empty($data) && $data == "25 years old to 30 years old" ? TRUE : FALSE )); ?>>25 years old to 30 years old</option>
                                            <option value="31 years old to 35 years old" <?php echo set_select('guardian_age','31 years old to 35 years old', ( !empty($data) && $data == "31 years old to 35 years old" ? TRUE : FALSE )); ?>>31 years old to 35 years old</option>
                                            <option value="36 years old to 40 years old" <?php echo set_select('guardian_age','36 years old to 40 years old', ( !empty($data) && $data == "36 years old to 40 years old" ? TRUE : FALSE )); ?>>36 years old to 40 years old</option>
                                            <option value="41 years old to 45 years old" <?php echo set_select('guardian_age','41 years old to 45 years old', ( !empty($data) && $data == "41 years old to 45 years old" ? TRUE : FALSE )); ?>>41 years old to 45 years old</option>
                                            <option value="46 years old to 50 years old" <?php echo set_select('guardian_age','46 years old to 50 years old', ( !empty($data) && $data == "46 years old to 50 years old" ? TRUE : FALSE )); ?>>46 years old to 50 years old</option>
                                            <option value="51 years old to 55 years old" <?php echo set_select('guardian_age','51 years old to 55 years old', ( !empty($data) && $data == "51 years old to 55 years old" ? TRUE : FALSE )); ?>>51 years old to 55 years old</option>
                                            <option value="56 years old to 60 years old" <?php echo set_select('guardian_age','56 years old to 60 years old', ( !empty($data) && $data == "56 years old to 60 years old" ? TRUE : FALSE )); ?>>56 years old to 60 years old</option>
                                            <option value="61 years old and above" <?php echo set_select('guardian_age','61 years old and above', ( !empty($data) && $data == "61 years old and above" ? TRUE : FALSE )); ?>>61 years old and above</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Occupation</b>
                                        <select name="guardian_occupation" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Non-Employed" <?php echo set_select('guardian_occupation','Non-Employed', ( !empty($data) && $data == "Non-Employed" ? TRUE : FALSE )); ?>>Non-Employed</option>
                                            <option value="Self-Employed" <?php echo set_select('guardian_occupation','Self-Employed', ( !empty($data) && $data == "Self-Employed" ? TRUE : FALSE )); ?>>Self-Employed</option>
                                            <option value="Private Employee" <?php echo set_select('guardian_occupation','Private Employee', ( !empty($data) && $data == "Private Employee" ? TRUE : FALSE )); ?>>Private Employee</option>
                                            <option value="Government Employee" <?php echo set_select('guardian_occupation','Government Employee', ( !empty($data) && $data == "Government Employee" ? TRUE : FALSE )); ?>>Government Employee</option>
                                            <option value="OFW" <?php echo set_select('guardian_occupation','OFW', ( !empty($data) && $data == "OFW" ? TRUE : FALSE )); ?>>OFW</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Educational Attainment</b>
                                        <select name="guardian_education" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Elementary Level" <?php echo set_select('guardian_education','Elementary Level', ( !empty($data) && $data == "Elementary Level" ? TRUE : FALSE )); ?>>Elementary Level</option>
                                            <option value="Elementary Graduate" <?php echo set_select('guardian_education','Elementary Graduate', ( !empty($data) && $data == "Elementary Graduate" ? TRUE : FALSE )); ?>>Elementary Graduate</option>
                                            <option value="High School Level" <?php echo set_select('guardian_education','High School Level', ( !empty($data) && $data == "High School Level" ? TRUE : FALSE )); ?>>High School Level</option>
                                            <option value="High School Graduate" <?php echo set_select('guardian_education','High School Graduate', ( !empty($data) && $data == "High School Graduate" ? TRUE : FALSE )); ?>>High School Graduate</option>
                                            <option value="Vocational" <?php echo set_select('guardian_education','Vocational', ( !empty($data) && $data == "Vocational" ? TRUE : FALSE )); ?>>Vocational</option>
                                            <option value="College Level" <?php echo set_select('guardian_education','College Level', ( !empty($data) && $data == "College Level" ? TRUE : FALSE )); ?>>College Level</option>
                                            <option value="College Graduate" <?php echo set_select('guardian_education','College Graduate', ( !empty($data) && $data == "College Graduate" ? TRUE : FALSE )); ?>>College Graduate</option>
                                            <option value="Masters Level" <?php echo set_select('guardian_education','Masters Level', ( !empty($data) && $data == "Masters Level" ? TRUE : FALSE )); ?>>Master's Level</option>
                                            <option value="Masters Degree Graduate" <?php echo set_select('guardian_education','Masters Degree Graduate', ( !empty($data) && $data == "Masters Degree Graduate" ? TRUE : FALSE )); ?>>Master's Degree Graduate</option>
                                            <option value="Doctorate Level" <?php echo set_select('guardian_education','Doctorate Level', ( !empty($data) && $data == "Doctorate Level" ? TRUE : FALSE )); ?>>Doctorate Level</option>
                                            <option value="Doctorate Degree Graduate" <?php echo set_select('guardian_education','Doctorate Degree Graduate', ( !empty($data) && $data == "Doctorate Degree Graduate" ? TRUE : FALSE )); ?>>Doctorate Degree Graduate</option>
                                            <option value="n/a" <?php echo set_select('guardian_education','n/a', ( !empty($data) && $data == "n/a" ? TRUE : FALSE )); ?>>Not Applicable</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Guardian Contact</b>
                                        <input type="text" name="guardian_contact" value="<?php echo set_value('guardian_contact'); ?>" class="form-control" placeholder="CONTACT">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Email Address of your Guardian</b>
                                        <input type="text" name="guardian_email" value="<?php echo set_value('guardian_email'); ?>" class="form-control" placeholder="Email Address">
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Guardian Address</b>
                                        <input type="text" name="guardian_address" value="<?php echo set_value('guardian_address'); ?>" class="form-control" placeholder="ADDRESS">
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-5">
                                        <input type="checkbox" name="signatories[]" id="signatories3" class="filled-in chk-col-green" value="guardian" <?php echo set_checkbox('signatories[]', 'guardian'); ?>>
                                        <label for="signatories3">Please check if your guardian will sign the enrollment form</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Marriage Status of Parents</b>
                                        <select name="parent_marriage_status" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Living Together" <?php echo set_select('parent_marriage_status','Living Together', ( !empty($data) && $data == "Living Together" ? TRUE : FALSE )); ?>>Living Together</option>
                                            <option value="Separated because of work" <?php echo set_select('parent_marriage_status','Separated because of work', ( !empty($data) && $data == "Separated because of work" ? TRUE : FALSE )); ?>>Separated because of work</option>
                                            <option value="Separated due to conflict" <?php echo set_select('parent_marriage_status','Separated due to conflict', ( !empty($data) && $data == "Separated due to conflict" ? TRUE : FALSE )); ?>>Separated due to conflict</option>
                                            <option value="Widowed/widower" <?php echo set_select('parent_marriage_status','Widowed/widower', ( !empty($data) && $data == "Widowed/widower" ? TRUE : FALSE )); ?>>Widowed/widower</option>
                                            <option value="Single Parent" <?php echo set_select('parent_marriage_status','Single Parent', ( !empty($data) && $data == "Single Parent" ? TRUE : FALSE )); ?>>Single Parent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Are you living with your parents?</b><br>
                                        <input name="living_with_parent" type="radio" id="living_with_parent1" value="yes" <?php echo  set_radio('living_with_parent', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="living_with_parent1">Yes</label>
                                        <input name="living_with_parent" type="radio" id="living_with_parent2" value="no" <?php echo  set_radio('living_with_parent', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="living_with_parent2">No</label>
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <b>If No, Why?</b><br>
                                        <input type="text" name="living_with_parent_remarks" value="<?php echo set_value('living_with_parent_remarks'); ?>" class="form-control" placeholder="BIRTH ORDER">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-3">
                                        <b>Birth Order in the Family</b>
                                        <select name="birth_order" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="Eldest" <?php echo set_select('birth_order','Eldest', ( !empty($data) && $data == "Eldest" ? TRUE : FALSE )); ?>>Eldest</option>
                                            <option value="Middle Child" <?php echo set_select('birth_order','Middle Child', ( !empty($data) && $data == "Middle Child" ? TRUE : FALSE )); ?>>Middle Child</option>
                                            <option value="Youngest" <?php echo set_select('birth_order','Youngest', ( !empty($data) && $data == "Youngest" ? TRUE : FALSE )); ?>>Youngest</option>
                                            <option value="Only Child" <?php echo set_select('birth_order','Only Child', ( !empty($data) && $data == "Only Child" ? TRUE : FALSE )); ?>>Only Child</option>
                                            <option value="Adopted Child" <?php echo set_select('birth_order','Adopted Child', ( !empty($data) && $data == "Adopted Child" ? TRUE : FALSE )); ?>>Adopted Child</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-2">
                                        <b>No. of Brothers</b>
                                        <input type="number" name="number_of_brother" value="<?php echo set_value('number_of_brother'); ?>" class="form-control" placeholder="BROTHERS">
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-2">
                                        <b>No. of Sisters</b>
                                        <input type="number" name="number_of_sister" value="<?php echo set_value('number_of_sister'); ?>" class="form-control" placeholder="SISTERS">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Who are your companions at home?</b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home1" class="filled-in chk-col-green" value="Siblings" <?php echo set_checkbox('companions_at_home[]', 'Siblings'); ?>>
                                        <label for="companions_at_home1">Siblings</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home2" class="filled-in chk-col-green" value="Stepfather" <?php echo set_checkbox('companions_at_home[]', 'Stepfather'); ?>>
                                        <label for="companions_at_home2">Stepfather</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home3" class="filled-in chk-col-green" value="Stepmother" <?php echo set_checkbox('companions_at_home[]', 'Stepmother'); ?>>
                                        <label for="companions_at_home3">Stepmother</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home4" class="filled-in chk-col-green" value="Step Sisters/ Step Brothers" <?php echo set_checkbox('companions_at_home[]', 'Step Sisters/ Step Brothers'); ?>>
                                        <label for="companions_at_home4">Step Sisters/ Step Brothers</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home5" class="filled-in chk-col-green" value="Grandparents" <?php echo set_checkbox('companions_at_home[]', 'Grandparents'); ?>>
                                        <label for="companions_at_home5">Grandparents</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home6" class="filled-in chk-col-green" value="Relatives" <?php echo set_checkbox('companions_at_home[]', 'Relatives'); ?>>
                                        <label for="companions_at_home6">Relatives</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="companions_at_home[]" id="companions_at_home7" class="filled-in chk-col-green" value="Other" <?php echo set_checkbox('companions_at_home[]', 'Other'); ?>>
                                        <label for="companions_at_home7">Other</label>
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-2">
                                        <b>If your companion is others please specify</b>
                                        <input type="text" name="companions_at_home_other" value="<?php echo set_value('companions_at_home_other'); ?>" class="form-control" placeholder="If others please specify">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Monthly Family Income (Please check)</b><br>
                                        <input name="familyIncome" type="radio" id="familyIncome1" value="below Php 10,000" <?php echo  set_radio('familyIncome', 'below Php 10,000'); ?> class="with-gap radio-col-primary">
                                        <label for="familyIncome1">below Php 10, 000</label>
                                        <input name="familyIncome" type="radio" id="familyIncome2" value="Php 10,001- Php 15,000" <?php echo  set_radio('familyIncome', 'Php 10,001- Php 15,000'); ?> class="with-gap radio-col-primary">
                                        <label for="familyIncome2">Php 10, 001- Php 15, 000</label>
                                        <input name="familyIncome" type="radio" id="familyIncome3" value="Php 15,001- Php 30,000" <?php echo  set_radio('familyIncome', 'Php 15,001- Php 30,000'); ?> class="with-gap radio-col-primary">
                                        <label for="familyIncome3">Php 15, 001- Php 30, 000</label>
                                        <input name="familyIncome" type="radio" id="familyIncome4" value="Php 30,001- Php 45,000" <?php echo  set_radio('familyIncome', 'Php 30,001- Php 45,000'); ?> class="with-gap radio-col-primary">
                                        <label for="familyIncome4">Php 30, 001- Php 45, 000</label>
                                        <input name="familyIncome" type="radio" id="familyIncome5" value="Php 45,001 and above" <?php echo  set_radio('familyIncome', 'Php 45,001 and above'); ?> class="with-gap radio-col-primary">
                                        <label for="familyIncome5">Php 45, 001 and above</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Are you currently a part-time working student?</b><br>
                                        <input name="working_student" type="radio" id="working_student1" value="yes" <?php echo  set_radio('working_student', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="working_student1">Yes</label>
                                        <input name="working_student" type="radio" id="working_student2" value="no" <?php echo  set_radio('working_student', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="working_student2">No</label>
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <b>If "YES", kindly indicate the Name of Company and Address (If "NO, write N/A")</b><br>
                                        <input type="text" name="working_student_remarks" value="<?php echo set_value('working_student_remarks'); ?>" class="form-control" placeholder="Name of Company and Address">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Educational Background</b>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>School and Address</th>
                                                    <th>Inclusive Years</th>
                                                    <th>Award</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p>Elementary</p>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="elementary_schoolName" value="<?php echo set_value('elementary_schoolName'); ?>" placeholder=" School Name (do not abbreviate) & Complpete School Address">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="elementary_year" value="<?php echo set_value('elementary_year'); ?>" placeholder="(e.g 2000-2001)">
                                                    </td> 
                                                    <td>
                                                        <input type="text" name="elem_awards" class="form-control" value="<?php echo set_value('elem_awards'); ?>" placeholder="(Awards)"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>High Schhol</p>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="highSchool_schoolName" value="<?php echo set_value('highSchool_schoolName'); ?>" placeholder=" School Name (do not abbreviate) & Complpete School Address">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="highSchool_year" value="<?php echo set_value('highSchool_year'); ?>" placeholder="(e.g 2000-2001)">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="high_school_awards" class="form-control" value="<?php echo set_value('high_school_awards'); ?>" placeholder="(Awards)"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>Vocational</p>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="vocational_schoolName" value="<?php echo set_value('vocational_schoolName'); ?>" placeholder=" School Name (do not abbreviate) & Complpete School Address">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="vocational_year" value="<?php echo set_value('vocational_year'); ?>" placeholder="(e.g 2000-2001)">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="vocational_awads" class="form-control" value="<?php echo set_value('vocational_awads'); ?>" placeholder="(Awards)"></input>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p>College</p>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="college_schoolName"  value="<?php echo set_value('college_schoolName'); ?>" placeholder=" School Name (do not abbreviate) & Complpete School Address">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="college_year"  value="<?php echo set_value('college_year'); ?>" placeholder="(e.g 2000-2001)">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="college_awards" class="form-control" value="<?php echo set_value('college_awards'); ?>" placeholder="(Awards)"></input>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Co and Extra curricular Activities in High School</b>
                                        <textarea class="form-control" name="extra_curricular" placeholder="(optional)"></textarea>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Do you have study habit?</b>
                                        <select name="study_habit" class="form-control">
                                            <option value="yes" <?php echo set_select('study_habit','yes', ( !empty($data) && $data == "yes" ? TRUE : FALSE )); ?>>Yes</option>
                                            <option value="no" <?php echo set_select('study_habit','no', ( !empty($data) && $data == "no" ? TRUE : FALSE )); ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>How many hours in a day? </b>
                                        <select name="study_habit_hours" class="form-control">
                                            <option value="30 min - 1 hour" <?php echo set_select('study_habit_hours','30 min - 1 hour', ( !empty($data) && $data == "30 min - 1 hour" ? TRUE : FALSE )); ?>>30 min - 1 hour</option>
                                            <option value="more than an hour - 2 hours" <?php echo set_select('study_habit_hours','more than an hour - 2 hours', ( !empty($data) && $data == "more than an hour - 2 hours" ? TRUE : FALSE )); ?>>more than an hour - 2 hours</option>
                                            <option value="more than 2 hours" <?php echo set_select('study_habit_hours','more than 2 hours', ( !empty($data) && $data == "more than 2 hours" ? TRUE : FALSE )); ?>>more than 2 hours</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>How do you update yourself with the current events?</b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="current_event[]" id="current_event1" class="filled-in chk-col-green" value="Televsion" <?php echo set_checkbox('current_event[]', 'Televsion'); ?>>
                                        <label for="current_event1">Televsion</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="current_event[]" id="current_event2" class="filled-in chk-col-green" value="Radio" <?php echo set_checkbox('current_event[]', 'Radio'); ?>>
                                        <label for="current_event2">Radio</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="current_event[]" id="current_event3" class="filled-in chk-col-green" value="Newspaper" <?php echo set_checkbox('current_event[]', 'Newspaper'); ?>>
                                        <label for="current_event3">Newspaper</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="current_event[]" id="current_event4" class="filled-in chk-col-green" value="Magazines" <?php echo set_checkbox('current_event[]', 'Magazines'); ?>>
                                        <label for="current_event4">Magazines</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="current_event[]" id="current_event5" class="filled-in chk-col-green" value="Other" <?php echo set_checkbox('current_event[]', 'Other'); ?>>
                                        <label for="current_event5">Other</label>
                                    </div>
                                    <div class="col-sm-12 col-md-2 col-2">
                                        <b>If others please specify</b>
                                        <input type="text" name="current_event_other" value="<?php echo set_value('current_event_other'); ?>" class="form-control" placeholder="If others please specify">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Why did you enroll in CLSU</b>
                                        <input type="text" name="reason_to_enroll" class="form-control" value="<?php echo set_value('reason_to_enroll'); ?>" placeholder="Reason">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Name of Person to be notified in case of emergency</b>
                                        <input type="text" name="emergency_person" class="form-control" value="<?php echo set_value('emergency_person'); ?>" placeholder="NAME">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Relationship</b>
                                        <select name="emergency_relationship" class="form-control">
                                            <option value="">- Relationship -</option>
                                            <option value="father" <?php echo set_select('emergency_relationship','father', ( !empty($data) && $data == "father" ? TRUE : FALSE )); ?>>Father</option>
                                            <option value="mother" <?php echo set_select('emergency_relationship','mother', ( !empty($data) && $data == "mother" ? TRUE : FALSE )); ?>>Mother</option>
                                            <option value="aunt" <?php echo set_select('emergency_relationship','aunt', ( !empty($data) && $data == "aunt" ? TRUE : FALSE )); ?>>Aunt</option>
                                            <option value="sister" <?php echo set_select('emergency_relationship','sister', ( !empty($data) && $data == "sister" ? TRUE : FALSE )); ?>>Sister</option>
                                            <option value="brother" <?php echo set_select('emergency_relationship','brother', ( !empty($data) && $data == "brother" ? TRUE : FALSE )); ?>>Brother</option>
                                            <option value="uncle" <?php echo set_select('emergency_relationship','uncle', ( !empty($data) && $data == "uncle" ? TRUE : FALSE )); ?>>Uncle</option>
                                            <option value="spouse" <?php echo set_select('emergency_relationship','spouse', ( !empty($data) && $data == "spouse" ? TRUE : FALSE )); ?>>Spouse</option>
                                            <option value="husband" <?php echo set_select('emergency_relationship','husband', ( !empty($data) && $data == "husband" ? TRUE : FALSE )); ?>>Husband</option>
                                            <option value="guardian" <?php echo set_select('emergency_relationship','guardian', ( !empty($data) && $data == "guardian" ? TRUE : FALSE )); ?>>Guardian</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Tel. / Cell No</b>
                                        <input type="text" name="emergency_contact" value="<?php echo set_value('emergency_contact'); ?>" class="form-control" placeholder="Emergency Contact">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Address</b>
                                        <textarea class="form-control" name="emergency_address" placeholder="Emergency Person Address"><?php echo set_value('emergency_address'); ?></textarea>
                                    </div>
                                </div>
                                <div class="row clearfix" style="display: none;">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>CLSU College Admission Test (Over-all rating)</b>
                                        <input type="number" step=0.01 name="admission_test" value="<?php echo set_value('admission_test'); ?>" class="form-control" placeholder="(Over-all rating)">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Name of Scholarship (if there's any)</b>
                                        <input type="text" name="scholarship_name" class="form-control" placeholder="(Name of Scholarship)">
                                    </div>
                                </div>
                                <div class="row clearfix" style="display: none;">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>What course do you intend to enroll in CLSU?</b>
                                        <select name="intendedProgram" class="form-control">
                                            <?php echo $applicantProgram; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>What activities do you want to participate in? (Please check)</b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity1" class="filled-in chk-col-green" value="Sports and Activities" <?php echo set_checkbox('participateActivity[]', 'Sports and Activities'); ?>>
                                        <label for="participateActivity1">Sports and Activities</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity2" class="filled-in chk-col-green" value="Dancing" <?php echo set_checkbox('participateActivity[]', 'Dancing'); ?>>
                                        <label for="participateActivity2">Dancing</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity3" class="filled-in chk-col-green" value="Oration/Declamation/Debate" <?php echo set_checkbox('participateActivity[]', 'Oration/Declamation/Debate'); ?>>
                                        <label for="participateActivity3">Oration/Declamation/Debate</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity4" class="filled-in chk-col-green" value="Campus Journalism" <?php echo set_checkbox('participateActivity[]', 'Campus Journalism'); ?>>
                                        <label for="participateActivity4">Campus Journalism</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity5" class="filled-in chk-col-green" value="Singing" <?php echo set_checkbox('participateActivity[]', 'Singing'); ?>>
                                        <label for="participateActivity5">Singing</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity6" class="filled-in chk-col-green" value="Campus Musical Band" <?php echo set_checkbox('participateActivity[]', 'Campus Musical Band'); ?>>
                                        <label for="participateActivity6">Campus Musical Band</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity7" class="filled-in chk-col-green" value="Campus Politics" <?php echo set_checkbox('participateActivity[]', 'Campus Politics'); ?>>
                                        <label for="participateActivity7">Campus Politics</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity8" class="filled-in chk-col-green" value="Acting" <?php echo set_checkbox('participateActivity[]', 'Acting'); ?>>
                                        <label for="participateActivity8">Acting</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity9" class="filled-in chk-col-green" value="Campus Youth Ministry" <?php echo set_checkbox('participateActivity[]', 'Campus Youth Ministry'); ?>>
                                        <label for="participateActivity9">Campus Youth Ministry</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity10" class="filled-in chk-col-green" value="Drawing/Painting" <?php echo set_checkbox('participateActivity[]', 'Drawing/Painting'); ?>>
                                        <label for="participateActivity10">Drawing/Painting</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity11" class="filled-in chk-col-green" value="Photography" <?php echo set_checkbox('participateActivity[]', 'Photography'); ?>>
                                        <label for="participateActivity11">Photography</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="participateActivity[]" id="participateActivity13" class="filled-in chk-col-green" value="Other" <?php echo set_checkbox('participateActivity[]', 'Other'); ?>>
                                        <label for="participateActivity13">Others, please specify</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" name="participateActivityOther" value="<?php echo set_value('participateActivityOther'); ?>" id="participateActivity12" class="form-control" placeholder="(Others, please specify)" style="display: none;">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Personal advocacy about...</b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy1" class="filled-in chk-col-green" value="Physical handicap" <?php echo set_checkbox('personal_advocacy[]', 'Physical handicap'); ?>>
                                        <label for="personal_advocacy1">Physical handicap</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy2" class="filled-in chk-col-green" value="Learning disability" <?php echo set_checkbox('personal_advocacy[]', 'Learning disability'); ?>>
                                        <label for="personal_advocacy2">Learning disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy3" class="filled-in chk-col-green" value="Solo parent" <?php echo set_checkbox('personal_advocacy[]', 'Solo parent'); ?>>
                                        <label for="personal_advocacy3">Solo parent</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy4" class="filled-in chk-col-green" value="Indigenous people" <?php echo set_checkbox('personal_advocacy[]', 'Indigenous people'); ?>>
                                        <label for="personal_advocacy4">Indigenous people</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy5" class="filled-in chk-col-green" value="DSWD scholars" <?php echo set_checkbox('personal_advocacy[]', 'DSWD scholars'); ?>>
                                        <label for="personal_advocacy5">DSWD scholars</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy6" class="filled-in chk-col-green" value="OFW dependent" <?php echo set_checkbox('personal_advocacy[]', 'OFW dependent'); ?>>
                                        <label for="personal_advocacy6">OFW dependent</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy7" class="filled-in chk-col-green" value="Foreign student" <?php echo set_checkbox('personal_advocacy[]', 'Foreign student'); ?>>
                                        <label for="personal_advocacy7">Foreign student</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy8" class="filled-in chk-col-green" value="LGBTQ" <?php echo set_checkbox('personal_advocacy[]', 'LGBTQ'); ?>>
                                        <label for="personal_advocacy8">LGBTQ</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy9" class="filled-in chk-col-green" value="Cultural performer" <?php echo set_checkbox('personal_advocacy[]', 'Cultural performer'); ?>>
                                        <label for="personal_advocacy9">Cultural performer</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy10" class="filled-in chk-col-green" value="Athlete" <?php echo set_checkbox('personal_advocacy[]', 'Athlete'); ?>>
                                        <label for="personal_advocacy10">Athlete</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="personal_advocacy[]" id="personal_advocacy13" class="filled-in chk-col-green" value="Other" <?php echo set_checkbox('personal_advocacy[]', 'Other'); ?>>
                                        <label for="personal_advocacy13">Others, please specify</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="personal_advocacy12">If others, please specify</label>
                                        <input type="text" name="personal_advocacyOther" value="<?php echo set_value('personal_advocacyOther'); ?>" id="personal_advocacy12" class="form-control" placeholder="(Others, please specify)">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <b>Are you a member of an indigenous groups?</b><br>
                                        <input name="indigenous" type="radio" id="indigenous1" value="yes" <?php echo  set_radio('indigenous', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="indigenous1">Yes</label>
                                        <input name="indigenous" type="radio" id="indigenous2" value="no" <?php echo  set_radio('indigenous', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="indigenous2">No</label>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-3" id="indigenousType" style="display: none;">
                                        <b>If yes, please specify:</b><br>
                                        <input name="indigenousType" type="text" class="form-control" value="<?php echo set_value('indigenousType'); ?>">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Is your household a member of 4P's</b><br>
                                        <input name="four_p" type="radio" id="four_p1" value="yes" <?php echo  set_radio('four_p', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="four_p1">Yes</label>
                                        <input name="four_p" type="radio" id="four_p2" value="no" <?php echo  set_radio('four_p', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="four_p2">No</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Is your household is included in Listahanan</b><br>
                                        <input name="listahanan" type="radio" id="listahanan1" value="yes" <?php echo  set_radio('listahanan', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="listahanan1">Yes</label>
                                        <input name="listahanan" type="radio" id="listahanan2" value="no" <?php echo  set_radio('listahanan', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="listahanan2">No</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <b>First Generation College Student</b><br>
                                        <input name="firstGeneration" type="radio" id="firstGeneration1" value="yes" <?php echo  set_radio('firstGeneration', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="firstGeneration1">Yes, I am the first among our family member to enter college</label>
                                        <br>
                                        <input name="firstGeneration" type="radio" id="firstGeneration2" value="no" <?php echo  set_radio('firstGeneration', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="firstGeneration2">No, there are members of the family who already graduated in college</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>Health Status:</b><br>
                                        <b>Are you a person with disability?</b><br>
                                        <input name="disability" type="radio" id="disability1" value="yes" <?php echo  set_radio('disability', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="disability1">Yes</label>
                                        <input name="disability" type="radio" id="disability2" value="no" <?php echo  set_radio('disability', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="disability2">No</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>If Yes, Please Specify:</b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Total Visual Disability'); ?> id="disabilityType1" class="filled-in chk-col-green" value="Total Visual Disability">
                                        <label for="disabilityType1">Total Visual Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Partial Visual Disability'); ?> id="disabilityType2" class="filled-in chk-col-green" value="Partial Visual Disability">
                                        <label for="disabilityType2">Partial Visual Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Communication Disability (Hearing Impairment)'); ?> id="disabilityType3" class="filled-in chk-col-green" value="Communication Disability (Hearing Impairment)">
                                        <label for="disabilityType3">Communication Disability (Hearing Impairment)</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Communication Disability (Speech)'); ?> id="disabilityType4" class="filled-in chk-col-green" value="Communication Disability (Speech)">
                                        <label for="disabilityType4">Communication Disability (Speech)</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Orthopedic Disability'); ?> id="disabilityType5" class="filled-in chk-col-green" value="Orthopedic Disability">
                                        <label for="disabilityType5">Orthopedic Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Intellectual Disability'); ?> id="disabilityType6" class="filled-in chk-col-green" value="Intellectual Disability">
                                        <label for="disabilityType6">Intellectual Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Learning Disability'); ?> id="disabilityType7" class="filled-in chk-col-green" value="Learning Disability">
                                        <label for="disabilityType7">Learning Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Mental Disability'); ?> id="disabilityType8" class="filled-in chk-col-green" value="Mental Disability">
                                        <label for="disabilityType8">Mental Disability</label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <input type="checkbox" name="disabilityType[]"  <?php echo set_checkbox('disabilityType[]', 'Psychosocial Disability'); ?> id="disabilityType9" class="filled-in chk-col-green" value="Psychosocial Disability">
                                        <label for="disabilityType9">Psychosocial Disability</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Health Status: Vision</b>
                                        <select name="vision_health" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="color blind" <?php echo set_select('vision_health','color blind', ( !empty($data) && $data == "color blind" ? TRUE : FALSE )); ?>>Color Blind</option>
                                            <option value="far-sighted" <?php echo set_select('vision_health','far-sighted', ( !empty($data) && $data == "far-sighted" ? TRUE : FALSE )); ?>>Far-sighted</option>
                                            <option value="near-sighted" <?php echo set_select('vision_health','near-sighted', ( !empty($data) && $data == "near-sighted" ? TRUE : FALSE )); ?>>Near-sighted</option>
                                            <option value="astigmatism" <?php echo set_select('vision_health','astigmatism', ( !empty($data) && $data == "astigmatism" ? TRUE : FALSE )); ?>>Astigmatism</option>
                                            <option value="wearing eyeglasses" <?php echo set_select('vision_health','wearing eyeglasses', ( !empty($data) && $data == "Wearing eyeglasses" ? TRUE : FALSE )); ?>>wearing eyeglasses</option>
                                            <option value="none" <?php echo set_select('vision_health','none', ( !empty($data) && $data == "none" ? TRUE : FALSE )); ?>>None</option>   
                                        </select>
                                    </div>    
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                        <b>Allergy</b><br>
                                        <input name="allergy" type="radio" id="allergy1" value="yes" <?php echo  set_radio('allergy', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="allergy1">Yes</label>
                                        <input name="allergy" type="radio" id="allergy2" value="no" <?php echo  set_radio('allergy', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="allergy2">No</label>
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <b>If yes, please specify</b><br>
                                        <input type="text" name="allergy_remarks" value="<?php echo set_value('allergy_remarks'); ?>" class="form-control" placeholder="please specify">
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Do you take medicine for maintenance of health condition </b>
                                        <input name="medicine_take" type="radio" id="medicine_take1" value="yes" <?php echo  set_radio('medicine_take', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="medicine_take1">Yes</label>
                                        <input name="medicine_take" type="radio" id="medicine_take2" value="no" <?php echo  set_radio('medicine_take', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="medicine_take2">No</label>
                                    </div>
                                </div> 
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Do you have an existing mental health condition? </b>
                                        <input name="mental_health" type="radio" id="mental_health1" value="yes" <?php echo  set_radio('mental_health', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="mental_health1">Yes</label>
                                        <input name="mental_health" type="radio" id="mental_health2" value="no" <?php echo  set_radio('mental_health', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="mental_health2">No</label>
                                    </div>
                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                        <b>If yes, please specify</b><br>
                                        <input type="text" name="mental_health_remarks" value="<?php echo set_value('mental_health_remarks'); ?>" class="form-control" placeholder="please specify">
                                    </div>
                                </div>  
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>Do you want to see your guidance counselor for assistance?</b><br>
                                        <input name="guidance_councilor" type="radio" id="guidance_councilor1" value="yes" <?php echo  set_radio('guidance_councilor', 'yes'); ?> class="with-gap radio-col-primary">
                                        <label for="guidance_councilor1">Yes</label>
                                        <input name="guidance_councilor" type="radio" id="guidance_councilor2" value="no" <?php echo  set_radio('guidance_councilor', 'no'); ?> class="with-gap radio-col-primary">
                                        <label for="guidance_councilor2">No</label>
                                        <input name="guidance_councilor" type="radio" id="guidance_councilor3" value="maybe" <?php echo  set_radio('guidance_councilor', 'maybe'); ?> class="with-gap radio-col-primary">
                                        <label for="guidance_councilor3">Maybe</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <b>When do you plan to visit your guidance counselor?</b><br>
                                        <input name="visit_guidance_councilor" type="radio" id="visit_guidance_councilor1" value="The guidance counselor will send me an invitation during our free time" <?php echo  set_radio('visit_guidance_councilor', 'The guidance counselor will send me an invitation during our free time'); ?> class="with-gap radio-col-primary">
                                        <label for="visit_guidance_councilor1">The guidance counselor will send me an invitation during our free time</label>
                                        <input name="visit_guidance_councilor" type="radio" id="visit_guidance_councilor2" value="The guidance counselor will send me an invitation during our free time" <?php echo  set_radio('visit_guidance_councilor', 'The guidance counselor will send me an invitation during our free time'); ?> class="with-gap radio-col-primary">
                                        <label for="visit_guidance_councilor2">The guidance counselor will send me an invitation during our free time</label>
                                        <input name="visit_guidance_councilor" type="radio" id="visit_guidance_councilor3" value="I will come voluntary to consult our guidance counselor" <?php echo  set_radio('visit_guidance_councilor', 'I will come voluntary to consult our guidance counselor'); ?> class="with-gap radio-col-primary">
                                        <label for="visit_guidance_councilor3">I will come voluntary to consult our guidance counselor</label>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <b>How do you want to be assisted by a guidance counselor?</b>
                                        <textarea class="form-control" name="guidance_councilor_assistance" placeholder="(write something...)"><?php echo set_value('guidance_councilor_assistance'); ?></textarea>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Name of Family Doctor</b>
                                        <input type="text" name="family_doctor" value="<?php echo set_value('family_doctor'); ?>" class="form-control" placeholder="FAMILY DOCTOR (optional)">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-4">
                                        <b>Contact Number</b>
                                        <input type="text" name="family_doctor_contact" value="<?php echo set_value('family_doctor_contact'); ?>" class="form-control" placeholder="CONTACT NUMBER (optional)">
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-12 col-12">
                                        <input type="submit" class="btn btn-primary btn-lg btn-block waves-effect" value="SUBMIT">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>