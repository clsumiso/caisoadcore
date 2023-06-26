<div class="modal fade" id="userAccountModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userAccountModalLabel">Reset Password</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <b>Username <span class="col-red">*readonly</span></b>
                        <input type="hidden" name="txtUserID" class="form-control" readonly>
                        <input type="text" name="txtUsername" class="form-control" placeholder="Username" readonly>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <b>Password</b>
                        <input type="text" name="txtPassword" placeholder="Password" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveUser()">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>