<div role="tabpanel" class="tab-pane fade in" id="grades">
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
                    <p>Grade</p>
                </div>
                <div class="post-content table-responsive" style="padding: 10px;">
                    <div class="row">
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
                            <select class="form-control" id="gradeCourse">
                                <option value="-1" selected></option>
                            </select>
                        </div>
                    </div>
                    <!-- Table -->
                    <table id='gradeTable' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                      <thead>
                        <!-- <tr>
                            <th colspan="4"></th>
                            <th colspan="3" class="text-center">NAME</th=-
                            <th colspan="4"></th>
                        </tr> -->
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

                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>

<?php $this->load->view('administrator/modal/_grade_modal'); ?>