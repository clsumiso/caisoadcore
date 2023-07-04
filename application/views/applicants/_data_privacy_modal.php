<div class="modal fade" id="data_privacy" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="data_privacyModalLabel">DATA PRIVACY</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: left;">
                    The Office of Admissions (OAd) is committed to ensure that your data privacy rights are upheld and protected.  Please read our full Data Privacy Notice from our website: <a href="https://oad.clsu2.edu.ph/data-privacy/" target="_blank">https://oad.clsu2.edu.ph/data-privacy/</a> before proceeding with your registration.
                </p>
                <br>
                
                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <input name="chkDataPrivacy" type="checkbox" id="chkDataPrivacy1" value="yes" class="with-gap radio-col-primary">
                        <label for="chkDataPrivacy1">
                            I confirm that I have read the data privacy notice of the OAd and I understand it.  I give OAd my permission to collect and process my personal information, including sharing them for legitimate purposes, as described in the said notice.
                        </label>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <b>Vaccination Status</b>
                        <select name="vaccine" class="form-control">
                            <option value="FULLY VACCINATED WITH TWO BOOSTER SHOTS" selected>FULLY VACCINATED WITH TWO BOOSTER SHOTS</option>
                            <option value="FULLY VACCINATED WITH BOOSTER SHOT">FULLY VACCINATED WITH BOOSTER SHOT</option>
                            <option value="FULLY VACCINATED TWO DOSES">FULLY VACCINATED TWO DOSES</option>
                            <option value="FULLY VACCINATED SINGLE DOSE WITH TWO BOOSTER SHOTS">FULLY VACCINATED SINGLE DOSE WITH TWO BOOSTER SHOTS</option>
                            <option value="FULLY VACCINATED SINGLE DOSE WITH BOOSTER SHOT">FULLY VACCINATED SINGLE DOSE WITH BOOSTER SHOT</option>
                            <option value="FULLY VACCINATED SINGLE DOSE">FULLY VACCINATED SINGLE DOSE</option>
                            <option value="PARTIALLY VACCINATED">PARTIALLY VACCINATED</option>
                            <option value="NOT VACCINATED">NOT VACCINATED</option>
                        </select>
                    </div>
                </div>

                <br><br>
                <p>For data privacy concerns, please contact us at <br> oad-privacy@clsu2.edu.ph.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-teal waves-effect" onclick="submitDataPrivacy('<?php echo $appID; ?>', '<?php echo $securityCode; ?>')">Confirm & Continue</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>