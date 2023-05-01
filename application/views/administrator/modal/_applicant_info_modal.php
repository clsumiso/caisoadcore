<div class="modal fade" id="applicant_info_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="releaseDateModalLabel">Release Setup</h4>
                
                <div id="saveApplicantPreload">
                    <!-- Generate via request -->
                </div>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="applicantInfoForm">
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Applicant ID</b>
                            <input type="text" class="form-control" name="applicantID" readonly>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Firstname</b>
                            <input type="text" class="form-control" name="firstname">
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Middlename</b>
                            <input type="text" class="form-control" name="middlename">
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Lastname</b>
                            <input type="text" class="form-control" name="lastname">
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Program/Course</b>
                            <select name="applicantProgram" class="form-control" id="applicantProgram">
                                <?php echo $applicantProgram; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <b>Applicant Category</b>
                            <select name="applicantCategory" class="form-control" id="applicantCategory">
                                <?php echo $applicantCategory; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveApplicantInfo('update')">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>