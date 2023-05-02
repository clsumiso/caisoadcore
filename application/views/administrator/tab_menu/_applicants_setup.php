<div role="tabpanel" class="tab-pane fade in" id="applicant_setup">
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
                    <p>Applicants</p>
                </div>
                <div class="post-content" style="padding: 10px;">
                    <form action="" method="POST" id="releaseSetupForm">
                        <h2>Release Setup</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <button type="button" class="btn bg-teal btn-lg waves-effect" onclick="addReleaseDate()">ADD Release Date</button>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>...</th>
                                            <th>Letter Type</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
                                            <th>Percentage <br> Rank From</th>
                                            <th>Percentage <br> Rank To</th>
<<<<<<< HEAD
                                            <th>Release Date From</th>
                                            <th>Release Date To</th>
=======
                                            <th>Release Date</th>
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
                                        </tr>
                                    </thead>
                                    <tbody id="releaseList">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="" method="POST" id="letterTypeForm">
                        <h2>Letter Type Setup</h2>
                        <div class="row clearfix">
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>Name</b>
<<<<<<< HEAD
                                <input type="text" name="letterTypeName" class="form-control">
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>Code</b>
                                <input type="text" name="letterTypeCode" class="form-control" placeholder="(e.g Principal Qualifier = pq)">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <b>&nbsp;</b>
                                <button type="button" class="btn btn-primary btn-block waves-effect" onclick="saveLetterType()">SAVE</button>
=======
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>Code</b>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <b>&nbsp;</b>
                                <button type="button" class="btn btn-primary btn-block waves-effect">SAVE</button>
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
                            </div>
                        </div>
                    </form>
                    <hr>
                    <!-- Letter Configurations -->
                    <form action="" method="POST" id="letterForm">
                        <h2>Letter Setup</h2>
                        <div class="row clearfix">
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>Letter Type</b>
                                <select name="letterType" class="form-control">
                                    
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3">
                                <b>Letter Template</b>
                                <select name="letterList" class="form-control" onchange="getLetterTemplateContent(this.value)">
                                    <option value="-1">-- SELECT TEMPLATE --</option>
                                </select>
                            </div>
                        </div>
                        <!-- <textarea id="tinymce" name="content">
                            <h1 id="applicantID">#APPLICANT ID</h1><br>
                            <p style="font-size: 24px; font-weight: regular;" id="releaseDate">#RELEASE DATE</p><br><br>
                            <p style="font-size: 24px; font-weight: bold;" id="name">#NAME</p><br><br>
                            <p style="font-size: 24px; font-weight: bold;" id="course">#COURSE</p>
                            <p style="font-size: 24px; font-weight: bold;" id="dateFrom">#DATE FROM</p>
                            <p style="font-size: 24px; font-weight: bold;" id="dateFrom">#DATE FROM</p>
                            <p style="font-size: 24px; font-weight: bold;" id="dateTo">#DATE TO</p>
                            <ol style="font-size: 24px; font-weight: regular;" id="program_for_other_qualifier" type="1">
                                <li>#LIST</li>
                            </ol>
                        </textarea> -->
                        <div class="row clearfix">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <h3>Resources</h3>
                                <ol>
                                    <li>
                                        CLASSES (default font-size: 24)
                                        <ul>
                                            <li>
                                                APPLICANT ID
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(1)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                RELEASE DATE
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(2)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                NAME
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(3)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                COURSE
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(4)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                DATE FROM
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(5)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                DATE TO
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(6)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                PROGRAM/COURSE (LIST)
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(7)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Image Avatars
                                        <ul>
                                            <li>
                                                User Avatar
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(8)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                            <li>
                                                Dummy Signature
                                                <button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves" onclick="copyToClipboard(9)">
                                                    <i class="material-icons" style="font-size: 12px;">content_copy</i>
                                                </button>
                                            </li>
                                        </ul>
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-12 col-md-8 col-lg-8">
                                <textarea id="ckeditor">
<<<<<<< HEAD
                                    <div class="row d-flex justify-content-center" style="margin-left: 10%; margin-right: 10%;">
=======
                                    <div class="row d-flex justify-content-center">
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    
                                                </div>
                                            </div>
                                            <p>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <p style="font-size: 24px;">Dear</p>
                                                </div>
                                            </div>
                                            <p>
                                        </div>
                                    </div>
                                </textarea>
                                <!-- <textarea id="tinymce" name="content">
                                    <div class="d-flex justify-content-center">
                                    </div>
                                </textarea> -->
                            </div>
                        </div>
                        <br>
                        <button type="button" class="btn btn-primary btn-lg btn-block waves-effect" onclick="saveLetter()">SAVE</button>
                        <button type="button" class="btn bg-teal btn-lg btn-block waves-effect" onclick="previewLetter()">PREVIEW</button>
                    </form>
                    <h1>Preview</h1>
                    <hr>
                    <div class="justify-content-center" id="previewContent">
                        
                    </div>
                    <!-- End of Letter Configurations -->
                    <!-- Table -->
                    <!-- <table id='applicantTable' class='table table-bordered table-striped table-hover js-basic-example nowrap dataTable'>
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>...</th>
                            <th>Id Number</th>
                            <th>Semester</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Course/Program</th>
                            <th>Section</th>
                        </tr>
                      </thead>

                    </table> -->
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
</div>

<?php $this->load->view('administrator/modal/_grade_modal'); ?>