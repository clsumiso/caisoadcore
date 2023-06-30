<div role="tabpanel" class="tab-pane fade in" id="user_account">
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
                    <p>Grade</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <b>Filter by USER TYPE:</b>
                            <select class="form-control" id="userType">
                                <option value="">-- SELECT USERTYPE --</option>
                                <option value="student">Student</option>
                                <option value="faculty">Faculty</option>
                                <option value="department head">Department Head</option>
                                <option value="dean">Dean</option>
                                <option value="registration adviser">Registration Adviser</option>
                            </select>
                        </div>
                    </div>
                    <div class=" table-responsive">
                        <!-- Table -->
                        <table id='userTable' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                        <thead>
                            <!-- <tr>
                                <th colspan="4"></th>
                                <th colspan="3" class="text-center">NAME</th=-
                                <th colspan="4"></th>
                            </tr> -->
                            <tr>
                                <th>#</th>
                                <th>...</th>
                                <th>ID NUMBER / EMAIL</th>
                                <th>Lastname</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>

<?php $this->load->view('administrator/modal/_user_account_modal'); ?>