<div role="tabpanel" class="tab-pane fade in" id="schedule">
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
                    <p>Schedule</p>
                </div>
                <div class="post-content table-responsive" style="padding: 10px;">
                    <div class="row">
                        <div class="col-sm-3">
                            <b>Filter Semester:</b>
                            <select class="form-control" id="semester">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Table -->
                    <table id='scheduleTable' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>

                      <thead>
                        <tr>
                          <th>#</th>
                          <th>....</th>
                          <th>SCHEDID</th>
                          <th>SEMESTER</th>
                          <th>CAT_NO</th>
                          <th>SUBJECT TITLE</th>
                          <th>UNITS</th>
                          <th>DAY</th>
                          <th>TIME</th>
                          <th>ROOM</th>
                          <th>SECTION</th>
                          <th>ATL</th>
                        </tr>
                      </thead>

                    </table>
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

<?php $this->load->view('administrator/modal/_schedule_modal'); ?>