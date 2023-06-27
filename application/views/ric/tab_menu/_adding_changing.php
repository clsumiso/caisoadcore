<div role="tabpanel" class="tab-pane fade in" id="adding_changing">
    <div class="panel panel-default panel-post">
        <div class="panel-body">
            <div class="post">
                <div class="post-heading">
                    <p>Enrollment</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div id="status-loading"></div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-3 col-lg-3"">
                            <b>Semester:</b>
                            <select class="form-control" id="addingSemester">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="studid_enrollment" id="studid_enrollment" placeholder="ID NUMBER e.g. 00-0000">
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-sm bg-grey waves-effect" onclick="studentEnrollment()">SEARCH</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            NAME: <h4 id="name">---</h4>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <b>COLLEGE</b>
                            <select class="form-control" id="college" onchange="getCourse(this.value)">
                                <?php echo $college; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <b>COURSE</b>
                            <select class="form-control" id="course_list" onchange="getSection(this.value)">
                                <option value="-1" selected>--- SELECT SECTION ---</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <b>SECTION</b>
                            <select class="form-control" id="section_list">
                                <option value="-1" selected>--- SELECT SECTION ---</option>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">  
                        <div class="col-sm-4">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="SEARCH SUBJECT HERE">
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-md btn-primary waves-effect" onclick="showSubject()">SEARCH</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-7" style="height: 500px; overflow-y: scroll; overflow-x: scroll;">
                            <h3>LIST OF SUBJECTS</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover nowrap js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>CAT_NO</th>
                                            <th>SCHEDULE</th>
                                            <th>UNITS</th>
                                            <th>SECTION</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>CAT_NO</th>
                                            <th>SCHEDULE</th>
                                            <th>UNITS</th>
                                            <th>SECTION</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="subjects">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <h3>SUBJECT ENROLLED</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover nowrap js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>CAT_NO</th>
                                            <th>SCHEDULE</th>
                                            <th>UNITS</th>
                                            <th>STATUS</th>
                                            <th>REASON</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>CAT_NO</th>
                                            <th>SCHEDULE</th>
                                            <th>UNITS</th>
                                            <th>STATUS</th>
                                            <th>REASON</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="subjectsEnrolled">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>