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
                    <p>Description Here</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b>Semester</b>
                            <select class="form-control" onchange="gradesAnlyticsPieChart(this.value)">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <b>CLSU MAP</b>
                            <select class="form-control" onchange="javascript:alert('Not yet available')">
                                <option value="-1">no data available</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="gradesAnlyticsPieChart" class="dashboardChart"></div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div id="map" class="dashboardChart" style="z-index: 0;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <p>Note: No Grade (NG), In Progress (IP), Drop (D) and Incomplete (INC) will not be shown in the Bar Chart above. You can check the status in <b>Grades Tab</b>.</p>
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