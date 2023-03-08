<div role="tabpanel" class="tab-pane fade in" id="evaluation">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">view_list</i>
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
                    <h4 class="media-heading">
                        <a href="#" >Evaluation</a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="post">
                <div class="post-heading" id="status-loading">
                    
                </div>
                <div class="post-content" style="margin-left: 10px; margin-right: 10px;">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <b>Semester</b>
                            <select class="form-control" id="semester" onchange="evaluation()" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <b>Courses</b>
                            <select class="form-control" id="course_filter" onchange="evaluation()" style="height: 60px;">
                                <?php echo $courses; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-3">
                            <button class="button-19" role="button" onclick="evaluation()">Refresh</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="student_evaluation">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>ID NUMBER</th>
                                            <th>LASTNAME</th>
                                            <th>FIRSTNAME</th>
                                            <th>MIDDLENAME</th>
                                            <th>Course/Program</th>
                                            <th>Section</th>
                                            <th>Date Admitted</th>
                                            <th>Residency</th>
                                            <th>Entance Credentials</th>
                                            <th>INC, Conditional Grades</th>
                                            <th>Lapsed Removal of INC/Conditional Grades</th>
                                            <th>No Grades</th>
                                            <th>Force Drop</th>
                                            <th>Behind Subjects</th>
                                            <th>Regular units allowed to enroll</th>
                                            <th>Other Concerns</th>
                                            <th>Instruction's From Records-in-charge</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>ID NUMBER</th>
                                            <th>LASTNAME</th>
                                            <th>FIRSTNAME</th>
                                            <th>MIDDLENAME</th>
                                            <th>Course/Program</th>
                                            <th>Section</th>
                                            <th>Date Admitted</th>
                                            <th>Residency</th>
                                            <th>Entance Credentials</th>
                                            <th>INC, Conditional Grades</th>
                                            <th>Lapsed Removal of INC/Conditional Grades</th>
                                            <th>No Grades</th>
                                            <th>Force Drop</th>
                                            <th>Behind Subjects</th>
                                            <th>Regular units allowed to enroll</th>
                                            <th>Other Concerns</th>
                                            <th>Instruction's From Records-in-charge</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <!-- <ul>
                <li>
                    <a href="#">
                        <i class="material-icons">thumb_up</i>
                        <span>12 Likes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="material-icons">comment</i>
                        <span>5 Comments</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="material-icons">share</i>
                        <span>Share</span>
                    </a>
                </li>
            </ul>

            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" placeholder="Type a comment" />
                </div>
            </div> -->
        </div>
    </div>
</div>

<!-- Large Size -->
<div class="modal fade" id="evaluation_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">EVALUATION FORM</h4>
            </div>
            <form action="" method="POST" id="eval_form">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-6">
                            <b>ID Number <small class="col-red">*readonly</small></b>
                            <input class="form-control" type="text" name="studid" id="studid" placeholder="ID NUMBER" readonly>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-4 col-lg-4">
                            <b>Lastname <small class="col-red">*readonly</small></b>
                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="(e.g. Dela Cruz)">
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <b>Firstname <small class="col-red">*readonly</small></b>
                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="(e.g. Juan, Jr.)">
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <b>Middlename <small class="col-red">*readonly</small></b>
                            <input class="form-control" type="text" name="middlename" id="middlename" placeholder="(e.g. Doe)">
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-6">
                            <b>Course (program) <small class="col-red">*readonly</small></b>
                            <input class="form-control" type="text" name="course" id="course" placeholder="Course">
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <b>Major</b>
                            <select class="form-control" id="major" name="major">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-6">
                            <b>Section</b>
                            <select class="form-control" id="section" name="section">
                                
                            </select>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <b>Date admitted</b>
                            <div class="input-group date" id="bs_datepicker_component_container">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="date_admitted" name="date_admitted" placeholder="Please choose a date..." readonly>
                                </div>
                                <span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-2">
                            <b>Residency</b>
                            <input class="form-control" type="text" name="residency" id="residency" placeholder="Residency">
                        </div>
                        <div class="col-sm-6 col-lg-10">
                            <b>Entrance Credentials</b>
                            <select class="form-control show-tick" name="entrance_credential" id="entrance_credential" multiple>
                                <option>ENROLLMENT FORM (application for admission)</option>
                                <option>FORM 137A</option>
                                <option>FORM 138</option>
                                <option>PSA (birth certificate)</option>
                                <option>RECOMMENDATION LETTER (must be 3 for PhD, 2 for MS)</option>
                                <option>TOR (Transfer Credential)</option>
                                <option>COMPLETE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>INC, Conditional Grades</b>
                            <textarea class="form-control" name="inc_cond_grades" id="inc_cond_grades" placeholder="(e.g FILI 1100,ENGL 1100)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>Lapsed Removal of INC/Conditional Grades</b>
                            <textarea class="form-control" name="lapse" id="lapse" placeholder="(e.g FILI 1100,ENGL 1100)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>No Grades</b>
                            <textarea class="form-control" name="nod_grades" id="nod_grades" placeholder="(e.g FILI 1100,ENGL 1100)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>Behind Subjects</b>
                            <textarea class="form-control" name="behind_subjects" id="behind_subjects" placeholder="(e.g FILI 1100,ENGL 1100)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>Other Concern</b>
                            <textarea class="form-control" name="other_concern" id="other_concern" placeholder="Enter something....(optional)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>Instructions from Records-in-charge</b>
                            <textarea class="form-control" name="instruction" id="instruction" placeholder="Enter something....(optional)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-12">
                            <b>Force Drop Remarks</b>
                            <textarea class="form-control" name="forceDrop" id="forceDrop" placeholder="Enter something....(optional)"></textarea>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-6">
                            <b>Max units allowed to enroll for (<span style="color: red;" id="evaluation_sem"></span>)</b>
                            <input class="form-control" type="text" name="max_units_allowed" id="max_units_allowed" placeholder="Max units allowed to enroll">
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-sm-6 col-lg-6">
                            <b>Force Drop Subject(s)</b>
                            <select class="form-control" id="student_registration_semester" onchange="show_subject_enrolled_per_sem()" style="height: 60px;">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-lg-12">
                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>...</th>
                                    <th>SCHEDID</th>
                                    <th>CAT_NO</th>
                                    <th>UNITS</th>
                                    <th>DAY</th>
                                    <th>TIME</th>
                                    <th>ROOM</th>
                                    <th>SECTION</th>
                                    <th>STATUS</th>
                                </tr>
                                <tbody id="student_registration">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" onclick="submit_evaluation()">SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>