<div role="tabpanel" class="tab-pane fade in active" id="home">
    <div class="panel panel-default panel-post">
        <div class="panel-heading">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <i class="material-icons">account_balance_wallet</i>
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
                    <p>Students</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <div class="row bg-grey" style="padding: 20px;">
                        <div class="col-6">
                            <h3>SELECT SEMESTER</h3>
                            <select class="form-control" id="semester" onchange="studentEnrollment()">
                                <?php echo $semester; ?>
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-responsive js-basic-example dataTable" id="studentEnrollment">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>...</th>
                                <th>ID NUMBER</th>
                                <th>LASTNAME</th>
                                <th>FIRSTNAME</th>
                                <th>MIDDLENAME</th>
                                <th>Course/Program</th>
                                <th>Section</th>
                                <th>O.R NUMBER</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>...</th>
                                <th>ID NUMBER</th>
                                <th>LASTNAME</th>
                                <th>FIRSTNAME</th>
                                <th>MIDDLENAME</th>
                                <th>Course/Program</th>
                                <th>Section</th>
                                <th>O.R NUMBER</th>
                                <th>AMOUNT</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>

<!-- Large Size -->
<div class="modal fade" id="assessmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Assessment Form</h4>
            </div>
            <div class="modal-body">
                <table class=" table table-hover">
                    <thead>
                        <tr>
                            <th colspan="3">FEES</th>
                        </tr>
                    </thead>
                    <tbody id="fees">
                        
                    </tbody>
                </table>
                <!-- <b>TUITION FEE</b>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">1. TUITION FEE</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>Tuition Fee Here</p>
                    </div>
                </div>
                <b>MISCELLANEOUS AND OTHER SCHOOL FEES</b>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">1. ADMISSION FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>ADMISSION FEES HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">2. ATHLETIC FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>ATHLETIC FEES HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">3. COMPUTER FEE</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>COMPUTER FEE HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">4. DEVELOPMENT FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>DEVELOPMENT FEES HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">5. ENTRANCE FEE</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>ENTRANCE FEE HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">6. GUIDANCE FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>GUIDANCE FEES</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">7. LABORATORY FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>LABORATORY FEES HERE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">8. LIBRARY FEE</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>LIBRARY FEE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">9. MEDICAL AND DENTAL FEES</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>MEDICAL AND DENTAL FEES</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">10. REGISTRATION FEE</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>REGISTRATION FEE</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">11. SCHOOL ID</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p>SCHOOL ID</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b style="padding-left: 10px;">TOTAL</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <p class="col-teal" style="font-weight: bolder;">TOTAL HERE</p>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>NAME</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <input class="form-control" type="text" name="fullname" placeholder="FULLNAME HERE" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>ID NUMBER</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <input class="form-control" type="text" name="idNumber" placeholder="ID NUMBER HERE" readonly>
                        <input class="form-control" type="hidden" name="semesterID" placeholder="SEMESTER HERE" readonly>
                        <input class="form-control" type="hidden" name="dataRow" placeholder="ROW HERE" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>O.R NUMBER</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <input class="form-control" type="text" name="ORnumber" placeholder="O.R NUMBER HERE">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>AMOUNT</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <input class="form-control" type="number" min="0" name="amount" placeholder="AMOUNT HERE">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="savePayment()">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>