<div class="modal fade" id="releaseDateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="releaseDateModalLabel">Release Setup</h4>
                <div id="savePreload">
                    <!-- Generate via request -->
                </div>
            </div>
            <div class="modal-body table-responsive">
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <b>Letter Type</b>
                        <input type="hidden" class="form-control form-control" name="releaseID" readonly>
                        <select name="releaseLetterType" class="form-control">
                                    
                        </select>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <b>Date From</b>
                        <input type="text" class="datetimepicker form-control" name="dateFrom" placeholder="Please choose date & time...">
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <b>Date To</b>
                        <input type="text" class="datetimepicker form-control" name="dateTo" placeholder="Please choose date & time...">
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <b>Percentage Rank From</b>
                        <input type="number" class="form-control" name="percentFrom">
                    </div>
                    <div class="col-xs-6 col-md-6 col-lg-6">
                        <b>Percentage Rank To</b>
                        <input type="number" class="form-control" name="percentTo">
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <b>Release Date From</b>
                        <input type="text" class="datetimepicker form-control" name="releaseDate" placeholder="Please choose date & time...">
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6">
                        <b>Release Date To</b>
                        <input type="text" class="datetimepicker form-control" name="releaseDateTo" placeholder="Please choose date & time...">
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 col-lg-12" id="programList">
                        <h4>Program to be release</h4>
                        <?php echo $programCheckBox; ?>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveRelease()">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>