<div class="modal fade" id="noaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="noaModalLabel">NOTICE OF ADMISSION</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <b>Application CODE <span class="col-red">*readonly</span></b>
                        <input type="text" name="applicantID" class="form-control" readonly>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <b>Schedule of Registration</b>
                        <input type="date" name="regSched" class="form-control">
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <b>First Day of Classes</b>
                        <input type="date" name="classSchedule" class="form-control">
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <b>Remarks for Non-CLSU Graduate (optional)</b>
                        <textarea class="form-control" name="remarks" cols="30" rows="10" placeholder="(Write something)"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="printNOA()">GENERATE NOA</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>