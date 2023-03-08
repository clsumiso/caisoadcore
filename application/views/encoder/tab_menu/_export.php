<div role="tabpanel" class="tab-pane fade in" id="export-menu">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">cloud_download</i>
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
                    <h4 class="media-heading">
                        <a href="#" >EXPORT</a>
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
                    <b>Evaluation Template</b>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <select class="form-control" id="export_semester" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <select class="form-control" id="export_course" style="height: 60px;">
                                <?php echo $courses; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <button class="button-19" role="button" onclick="exportEvaluation()">EXPORT</button>
                        </div>
                    </div>
                    <hr>
                    <b>Class List</b>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <select class="form-control" id="semester" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <select class="form-control" id="semester" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <button class="button-19" role="button">EXPORT</button>
                        </div>
                    </div>
                    <hr>
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