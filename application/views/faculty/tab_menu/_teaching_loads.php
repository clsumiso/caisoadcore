<div role="tabpanel" class="tab-pane fade in" id="teaching-loads">
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
                        <a href="#" >Teaching Loads</a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="post">
                <!-- <div class="post-heading" id="teaching-loads-status-loading">
                    
                </div> -->
                <div class="post-content" style="margin-left: 10px; margin-right: 10px;">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-4">
                            <b>Semester</b>
                            <select class="form-control" id="teaching-loads-semester" onchange="get_teaching_loads()" style="height: 60px;">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="teaching_loads">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>SEMESTER</th>
                                            <th>CAT_NO</th>
                                            <th>UNITS</th>
                                            <th>DAY</th>
                                            <th>TIME</th>
                                            <th>ROOM</th>
                                            <th>SECTION</th>
                                            <th>DEPARTMENT</th>
                                            <th>ASSIGNED FACULTY</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>...</th>
                                            <th>SCHEDID</th>
                                            <th>SEMESTER</th>
                                            <th>CAT_NO</th>
                                            <th>UNITS</th>
                                            <th>DAY</th>
                                            <th>TIME</th>
                                            <th>ROOM</th>
                                            <th>SECTION</th>
                                            <th>DEPARTMENT</th>
                                            <th>ASSIGNED FACULTY</th>
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