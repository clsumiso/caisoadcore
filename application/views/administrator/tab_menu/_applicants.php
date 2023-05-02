<div role="tabpanel" class="tab-pane fade in" id="applicants">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">list</i>
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
                    <h4 class="media-heading">
                        <a href="#"><?php  echo $name; ?></a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="post">
                <div class="post-heading">
                    <p>Applicants</p>
                </div>
                <div class="post-content table-responsive" style="padding: 10px;">
                    <!-- <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3"">
                            <b>Semester:</b>
                            <select class="form-control" id="semesterGrades">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>College</b>
                            <select class="form-control" onchange="getCourse(this.value)" id="gradeCollegeFilter">
                                <?php echo $college; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b>Course</b>
                            <select class="form-control" onchange="" id="gradeCourse">
                                <option value="-1" selected></option>
                            </select>
                        </div>
                    </div> -->
                    <!-- Letter Configurations -->
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                    <form action="" method="POST" id="importApplicantForm">
                        <div class="row clearfix">
                            <div class="errMsg"></div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <b>Import Applicants</b>
                                <input type="file" name="userfile" class="form-control">
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>:</b>
                                <button type="button" class="btn bg-teal btn-block" onclick="importApplicants()">IMPORT</button>
                            </div>
                        </div>
                    </form>
                    <table id='applicantList' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>...</th>
<<<<<<< HEAD
=======
=======
                    <div class="row clearfix">
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <input type="file" class="form-control">
                        </div>
                    </div>
                    <table id='applicantList' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                        <thead>
                            <tr>
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                                <th>Applicant ID</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Course/Program</th>
<<<<<<< HEAD
                                <th>Qualifier Type</th>
=======
<<<<<<< HEAD
                                <th>Qualifier Type</th>
=======
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                                <th>Confirm Date</th>
                                <th>Confirm Status</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- End of Letter Configurations -->
                    <!-- Table -->
                    <!-- <table id='applicantTable' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>...</th>
                            <th>Id Number</th>
                            <th>Semester</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Course/Program</th>
                            <th>Section</th>
                        </tr>
                      </thead>

                    </table> -->
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>
<<<<<<< HEAD
<?php $this->load->view('administrator/modal/_releaseDate_modal'); ?>
<?php $this->load->view('administrator/modal/_applicant_info_modal'); ?>
=======
<<<<<<< HEAD
<?php $this->load->view('administrator/modal/_releaseDate_modal'); ?>
<?php $this->load->view('administrator/modal/_applicant_info_modal'); ?>
=======
<?php $this->load->view('administrator/modal/_releaseDate_modal'); ?>
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
