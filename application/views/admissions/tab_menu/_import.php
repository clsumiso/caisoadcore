<div role="tabpanel" class="tab-pane fade in" id="import-menu">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">cloud_upload</i>
                    </a>
                </div>
                <div class="media-body" style="vertical-align: middle;">
                    <h4 class="media-heading">
                        <a href="#" >IMPORT</a>
                    </h4>
                    <!-- Shared publicly - 26 Oct 2018 -->
                </div>
            </div>
        </div>
        <form action="" method="POST">
            <div class="panel-body">
                <div class="post">
                    <div class="post-heading" id="import-loading">
                        <p>Upload Status: </p>
                        <b>(20/40)</b>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    <div class="post-content" style="margin-left: 10px; margin-right: 10px;">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-sm-12">
                                <b>IMPORT FILE:</b>
                                <input type="file" name="file_import" id="file_import" placeholder="Upload file" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-6">
                        <button type="button" class="button-19" role="button" onclick="importEvaluation()">IMPORT</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>