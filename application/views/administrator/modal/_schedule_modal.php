<div class="modal fade" id="classScheduleModal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="classScheduleModalLabel">Class Schedule</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Schedule ID</b>
                    </div>
                    <div class="col-sm-6 col-md-10 col-lg-10">
                        <p id="schedId"></p>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Catalogue No</b>
                    </div>
                    <div class="col-sm-6 col-md-10 col-lg-10">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="catNo" class="form-control" placeholder="Enter Catalogue Number Here...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Subject Title</b>
                    </div>
                    <div class="col-sm-6 col-md-10 col-lg-10">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="subjectTitle" class="form-control" placeholder="Enter Subject Title Here...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Units</b>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <select class="form-control show-tick">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Number of Schedule</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <select class="form-control show-tick" id="scheduleCount">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>  
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>Schedule</b>
                    </div>
                </div>
                <div class="row clearfix bg-teal" id="scheduleContainer">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <b>Time</b>
                        <select class="form-control show-tick" id="day1">
                            <option value="-1"></option>
                            <option value="7:00">7:00</option>
                            <option value="7:30">7:30</option>
                            <option value="8:00">8:00</option>
                            <option value="8:30">8:30</option>
                            <option value="9:00">9:00</option>
                            <option value="9:30">9:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="1:00">1:00</option>
                            <option value="1:30">1:30</option>
                            <option value="2:00">2:00</option>
                            <option value="2:30">2:30</option>
                            <option value="3:00">3:00</option>
                            <option value="3:30">3:30</option>
                            <option value="4:00">4:00</option>
                            <option value="4:30">4:30</option>
                            <option value="5:00">5:00</option>
                            <option value="5:30">5:30</option>
                            <option value="6:00">6:00</option>
                            <option value="6:30">6:30</option>
                            <option value="7:00">7:00</option>
                        </select>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6 col-md-1 col-lg-1">
                        <b>Section</b>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveSchedule()">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>