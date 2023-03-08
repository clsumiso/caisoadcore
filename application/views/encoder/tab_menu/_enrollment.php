<div role="tabpanel" class="tab-pane fade in" id="enrollment">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">event_note</i>
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
                    <h4 class="media-heading">
                        <a href="#" >Enrollment</a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">priority_high</i>
                        </div>
                        <div class="content">
                            <div class="text">PENDING</div>
                            <div class="number">15</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-amber hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">face</i>
                        </div>
                        <div class="content">
                            <div class="text">CONCURRENT</div>
                            <div class="number">92%</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-deep-orange hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">face</i>
                        </div>
                        <div class="content">
                            <div class="text">OVERLOADING</div>
                            <div class="number">92%</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">face</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL ENROLLED</div>
                            <div class="number">92%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post">
                <div class="post-heading">
                    <div class="row clearfix bg-blue-grey">
                        <div class="col-xs-12 col-sm-4">
                            <b>Semester</b>
                            <select class="form-control" id="enrollment-semester" onchange="get_enrollment()" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <b>Courses</b>
                            <select class="form-control" id="enrollment-course-filter" onchange="get_enrollment()" style="height: 60px;">
                                <?php echo $courses; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <b>Year Level</b>
                            <select class="form-control" id="year_level" onchange="get_enrollment()" style="height: 60px;">
                                <option value="-1">--- Select Year Level ---</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                                <option value="5">Fifth Year</option>
                                <option value="6">Sixth Year</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <b>Year Level</b>
                            <select class="form-control" id="enroll_status" onchange="get_enrollment()" style="height: 60px;">
                                <option value="-1">--- Select Status ---</option>
                                <option value="1">Pending</option>
                                <option value="2">Overloading</option>
                                <option value="3">Concurrent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="post-content" style="margin-left: 10px; margin-right: 10px;">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover nowrap js-basic-example dataTable" id="student_enrollment">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>ID NUMBER</th>
                                            <th>LASTNAME</th>
                                            <th>FIRSTNAME</th>
                                            <th>MIDDLENAME</th>
                                            <th>COURSE</th>
                                            <th>SECTION</th>
                                            <th>STUDENT TYPE</th>
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
                                            <th>COURSE</th>
                                            <th>SECTION</th>
                                            <th>STUDENT TYPE</th>
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
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales orci ante, sed ornare eros vestibulum ut. Ut accumsan
                vitae eros sit amet tristique. Nullam scelerisque nunc enim, non dignissim nibh faucibus ullamcorper.
                Fusce pulvinar libero vel ligula iaculis ullamcorper. Integer dapibus, mi ac tempor varius, purus
                nibh mattis erat, vitae porta nunc nisi non tellus. Vivamus mollis ante non massa egestas fringilla.
                Vestibulum egestas consectetur nunc at ultricies. Morbi quis consectetur nunc.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>