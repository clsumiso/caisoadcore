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
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <h3>LIST OF GRADUATE LEVEL APPLICANTS</h3>
                            <div class="table-responsive">
                                <table id='applicantList' class='table table-bordered table-stripped table-hover js-basic-example dataTable'>
                                    <thead>
                                        <tr>
                                            <th colspan="9"></th>
                                            <th colspan="3" style="text-align: center;">APPLICATION STATUS</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>Requirements</th>
                                            <th>Lastname</th>
                                            <th>Firstname</th>
                                            <th>Middlename</th>
                                            <th>Degree Program</th>
                                            <th>Level Applied</th>
                                            <th>Date Applied</th>
                                            <th style="text-align: center;">Reference <br> (Reference 1|Reference 2|Reference 3)</th>
                                            <th>Department Head</th>
                                            <th>Dean</th>
                                        </tr>
                                    </thead>
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