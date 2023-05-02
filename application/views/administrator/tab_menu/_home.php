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
                    <!-- <h2>Dashboard</h2> -->
                </div>
                <div class="post-content" style="padding: 10px;">
                    <h3>Total Enrollment per COLLEGE</h3>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b>Semester</b>
                            <select class="form-control" name="enrollmentType" onchange="filterEnrollmentType()">
                                <option value="resident" selected>Resident</option>
                                <option value="incoming_freshmen">Incoming Freshmen</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b>Semester</b>
                            <select class="form-control" name="enrollPerCollegeSem" onchange="enrollPerCollege(this.value)">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b></b>
                            <!-- <select class="form-control" onchange="enrollPerCollege(this.value)">
                                <?php echo $semester; ?>
                            </select> -->
<<<<<<< HEAD
=======
<<<<<<< Updated upstream
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div id="enrollPerCollege" class="dashboardChart"></div>
>>>>>>> Stashed changes
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="display: none;">
                            <div id="map" class="dashboardChart" style="z-index: 0;"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="display: none;">
                            <div id="map" class="dashboardChart" style="z-index: 0;"></div>
                        </div>
                    </div>
<<<<<<< HEAD
                    <h3>Total Enrollment per COURSE</h3>
                    <div class="row">
=======
<<<<<<< Updated upstream
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="enrollPerCollege" class="dashboardChart"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="map" class="dashboardChart" style="z-index: 0;"></div>
                        </div>
                    </div>
=======
>>>>>>> Stashed changes
                    <h3>Total Enrollment per COURSE</h3>
                    <div class="row">
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>Semester</b>
                            <select class="form-control" name="enrollmentTypePerCourse" onchange="filterEnrollmentTypePerCourse()">
                                <option value="resident" selected>Resident</option>
                                <option value="incoming_freshmen">Incoming Freshmen</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>Semester</b>
                            <select class="form-control" onchange="enrollPerCourse()" id="enrollPerSemFilter">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>College</b>
                            <select class="form-control" onchange="enrollPerCourse()" id="enrollPerSemCollegeFilter">
                                <?php echo $college; ?>
                            </select>
                        </div>
                        <!-- <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>Course</b>
                            <select class="form-control" onchange="enrollPerCourse()" id="course">
                            </select>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="enrollPerCourse" class="dashboardChart"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="enrollPerCoursePie" class="dashboardChart"></div>
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