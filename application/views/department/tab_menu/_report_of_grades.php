<div role="tabpanel" class="tab-pane" id="rog">
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
               <div class="row clearfix">
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 p-2">
                        <b>SEMESTER:</b>
                        <select class="form-control select2 select2-success" data-dropdown-css-class="select2-success" style="width: 100%;" onchange="show_subject()" id="school_year">
                            <?php echo $semester; ?>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 p-2">
                      <b>SORT BY STATUS:</b>
                      <select class="custom-select rounded-0" id="rog_filter" onchange="show_subject()">
                          <option value="-" selected>--- SELECT STATUS ---</option>
                          <option value="faculty">FACULTY</option>
                          <option value="department head">DEPARTMENT HEAD</option>
                          <option value="dean">DEAN</option>
                          <option value="approved">OFFICE OF ADMISSIONS</option>
                          <option value="no grade submitted">NO GRADE SUBMITTED</option>
                         <!--  <option value="#">SHOW ALL</option> -->
                      </select>
                    </div>
                    <!-- <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 p-2">
                        <b>SORT BY:</b>
                        <select class="custom-select rounded-0" id="filter" onchange="show_subject()">
                            <option value="0" selected>SHOW ALL</option>
                            <option value="1">SHOW OWNED</option>
                        </select>
                    </div> -->
                </div><br>
                <div class="row table-responsive" style="padding: 15px;">
                    <table class="table table-bordered" id="subject_list">
                        <thead>
                            <tr>
                            <td colspan="11">
                                <h5 class="font-weight-bold text-left" style="font-size: 1em;">FOR MOBILE USERS CLICK <span style="background-color: #0275d8; color: #fff; padding: 1px 5px 1px 5px; border-radius: 100%;">+</span> BUTTON OR DRAG LEFT AND RIGHT TO VIEW ALL RECORDS</h5>
                            </td>
                            </tr>
                            <tr>
                                <th>Index #</th>
                                <th>...</th>
                                <th>SUBJECT CODE</th>
                                <th>CATALOGUE NUMBER</th>
                                <th>UNITS</th>
                                <th>DAY</th>
                                <th>TIME</th>
                                <th>ROOM</th>
                                <th>SECTION</th>
                                <th>FACULTY</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Index #</th>
                                <th>...</th>
                                <th>SUBJECT CODE</th>
                                <th>CATALOGUE NUMBER</th>
                                <th>UNITS</th>
                                <th>DAY</th>
                                <th>TIME</th>
                                <th>ROOM</th>
                                <th>SECTION</th>
                                <th>FACULTY</th>
                                <th>STATUS</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('department/modal/_applicationFormModal'); ?>