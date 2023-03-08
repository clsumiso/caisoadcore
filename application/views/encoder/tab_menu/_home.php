<div role="tabpanel" class="tab-pane fade in active" id="home">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">assessment</i>
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
                    <p>Enrollment</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div id="status-loading"></div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="studid" id="studid" placeholder="ID NUMBER e.g. 00-0000">
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
                            <select class="form-control" id="course" onchange="getSection(this.value)">
                                <option value="-1" selected>--- SELECT SECTION ---</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <b>SECTION</b>
                            <select class="form-control" id="section">
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
                        <div class="col-sm-7">
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
                                            <th>APPROVED</th>
                                            <th>DECLINED</th>
                                            <th>PENDING</th>
                                            <th>TOTAL ENROLLED</th>
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
                                            <th>APPROVED</th>
                                            <th>DECLINED</th>
                                            <th>PENDING</th>
                                            <th>TOTAL ENROLLED</th>
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

    <!-- <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img src="../../images/user-lg.jpg" />
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="#">Marc K. Hammond</a>
                    </h4>
                    Shared publicly - 01 Oct 2018
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="post">
                <div class="post-heading">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div class="post-content">
                    <iframe width="100%" height="360" src="https://www.youtube.com/embed/10r9ozshGVE" frameborder="0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <ul>
                <li>
                    <a href="#">
                        <i class="material-icons">thumb_up</i>
                        <span>125 Likes</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="material-icons">comment</i>
                        <span>8 Comments</span>
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
            </div>
        </div>
    </div> -->
</div>