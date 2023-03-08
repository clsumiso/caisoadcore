<div role="tabpanel" class="tab-pane fade in" id="manage_grades">
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
                        <a href="#" >STUDENT GRADES</a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="post">
                <!-- <div class="post-heading" id="status-loading">
                    
                </div> -->
                <div class="post-content" style="margin-left: 10px; margin-right: 10px;">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <b>Semester</b>
                            <select class="form-control" id="semester" onchange="subject_filter()" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <b>Catalogue Number (section)(schedid)</b>
                            <select class="form-control" id="subject_filter" onchange="get_grades()" style="height: 60px;">
                                
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <b>....</b>
                            <button class="button-21" role="button">SUBMIT</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <button class="button-20" role="button" onclick="test()">REQUEST RECTIFICATION</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="student_grades">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>ID NUMBER</th>
                                            <th>NAME</th>
                                            <th>SEMESTER</th>
                                            <th>CAT_NO</th>
                                            <th>UNITS</th>
                                            <th>GRADES (1st Submitted)</th>
                                            <th>GRADES (2nd.. Submitted)</th>
                                            <th>REMARKS</th>
                                            <th>STATUS</th>
                                            <th>FACULTY DATE SUBMITTED</th>
                                            <th>DEPARTMENT DATE APPROVED</th>
                                            <th>DEAN DATE APPROVED</th>
                                            <th>FACULTY DATE UPLOADED</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>ID NUMBER</th>
                                            <th>NAME</th>
                                            <th>SEMESTER</th>
                                            <th>CAT_NO</th>
                                            <th>UNITS</th>
                                            <th>GRADES (1st Submitted)</th>
                                            <th>GRADES (2nd.. Submitted)</th>
                                            <th>REMARKS</th>
                                            <th>STATUS</th>
                                            <th>FACULTY DATE SUBMITTED</th>
                                            <th>DEPARTMENT DATE APPROVED</th>
                                            <th>DEAN DATE APPROVED</th>
                                            <th>FACULTY DATE UPLOADED</th>
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