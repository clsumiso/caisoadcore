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
                <button type="button" class="btn btn-link waves-effect" onclick="savePayment('insert')">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="updatePaymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updatePaymentModalLabel">Assessment Form</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>O.R NUMBER</b>
                    </div>
                    <div class="col-sm-6 col-md-10 col-lg-10">
                        <input class="form-control" type="hidden" name="studID" readonly>
                        <input class="form-control" type="hidden" name="paymentID" readonly>
                        <input class="form-control" type="hidden" name="semesterPay" readonly>
                        <input class="form-control" type="hidden" name="transID" readonly>
                        <input class="form-control" type="text" name="orNumberUpdate" placeholder="O.R NUMBER HERE">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 col-lg-2">
                        <b>AMOUNT</b>
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <input class="form-control" type="number" min="0" name="amountUpdate" placeholder="AMOUNT HERE">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="savePayment('update')">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>