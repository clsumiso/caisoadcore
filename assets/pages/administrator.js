
let scheduleData = $('#scheduleTable').DataTable({
    'dom': 'lBfrtip',
    'buttons': [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11]
            },
            filename: 'EVALUATION TEMPLATE',
            "action": newexportaction
        },
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11]
            },
            "action": newexportaction
        },
        {
            extend: 'print',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11]
            },
            "action": newexportaction,
            customize: function(win)
            {
    
                var last = null;
                var current = null;
                var bod = [];
    
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');
    
                style.type = 'text/css';
                style.media = 'print';
    
                if (style.styleSheet)
                {
                    style.styleSheet.cssText = css;
                }
                else
                {
                    style.appendChild(win.document.createTextNode(css));
                }
    
                head.appendChild(style);
            },
            pageSize: 'LEGAL'
        }
    ],
    'responsive': true,
    'autoWidth': false,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    columnDefs: [
        { orderable: false, targets: [0, 1] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
        'url': window.location.origin + "/office-of-admissions/administrator/scheduleList",
        'data': function(data)
        {
        data.semester = $('#semester option:selected').val();
        }
    },
    'columns': 
    [
    { data: "numRows" },
    { data: "action" },
    { data: "schedid" },
    { data: "semester_name" },
    { data: "cat_no" },
    { data: "subject_title" },
    { data: "units" },
    { data: "day" },
    { data: "time" }, 
    { data: "room" },
    { data: "section" },
    { data: "atl" }
    ]
});

$('#semester').change(function(){
    scheduleData.draw();
});
// ********************************************************************************************************************************
let classMonitoringData = $('#sectionMonitoringTable').DataTable({
    'dom': 'lBfrtip',
    'buttons': [
    {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11]
        },
        filename: 'CLASS MONITORING',
        "action": newexportaction
    },
    {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        messageTop: 'Student Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11]
        },
        "action": newexportaction
    },
    {
        extend: 'print',
        messageTop: 'Student Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11]
        },
        "action": newexportaction,
        customize: function(win)
        {

            var last = null;
            var current = null;
            var bod = [];

            var css = '@page { size: landscape; }',
                head = win.document.head || win.document.getElementsByTagName('head')[0],
                style = win.document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet)
            {
                style.styleSheet.cssText = css;
            }
            else
            {
                style.appendChild(win.document.createTextNode(css));
            }

            head.appendChild(style);
        },
        pageSize: 'LEGAL'
    }
    ],
    'responsive': true,
    'autoWidth': false,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    columnDefs: [
        { orderable: false, targets: [0, 1] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
    'url': window.location.origin + "/office-of-admissions/administrator/sectionMonitoringList",
    'data': function(data)
    {
        data.semester = $('#semesterClassMonitoring option:selected').val();
    }
    },
    'columns': 
    [
        { data: "numRows" },
        // { data: "action" },
        { data: "schedid" },
        { data: "semester_name" },
        { data: "cat_no" },
        { data: "subject_title" },
        { data: "units" },
        { data: "day" },
        { data: "time" }, 
        { data: "room" },
        { data: "section" },
        { data: "atl" },
        { data: "total_enrolled" }
    ]
});

$('#semesterClassMonitoring').change(function(){
    classMonitoringData.draw();
});

$('#scheduleCount').change(function(){
    //   console.log($('#scheduleCount option:selected').val());
});
// ********************************************************************************************************************************
let accountingData = $('#accountingTable').DataTable({
    'dom': 'lBfrtip',
    'saveState': true,
    'buttons': [
    {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [2,3,4,5,6,7,8,9,10]
        },
        filename: 'CLSU Accounting',
        "action": newexportaction
    },
    {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        messageTop: 'Accounting Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [2,3,4,5,6,7,8,9,10]
        },
        "action": newexportaction
    },
    {
        extend: 'print',
        messageTop: 'Accounting Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [2,3,4,5,6,7,8,9,10]
        },
        "action": newexportaction,
        customize: function(win)
        {

            var last = null;
            var current = null;
            var bod = [];

            var css = '@page { size: landscape; }',
                head = win.document.head || win.document.getElementsByTagName('head')[0],
                style = win.document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet)
            {
                style.styleSheet.cssText = css;
            }
            else
            {
                style.appendChild(win.document.createTextNode(css));
            }

            head.appendChild(style);
        },
        pageSize: 'LEGAL'
    }
    ],
    'responsive': true,
    'autoWidth': false,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    columnDefs: [
        { orderable: false, targets: [0, 1, 9, 10] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
    'url': window.location.origin + "/office-of-admissions/administrator/accountingList",
    'data': function(data)
    {
        data.semester = $('#semesterAccounting option:selected').val();
    }
    },
    'columns': 
    [
        { data: "numRows" },
        { data: "action" },
        { data: "user_id" },
        { data: "semester_name" },
        { data: "lname" },
        { data: "fname" },
        { data: "mname" },
        { data: "course_name" },
        { data: "section" }, 
        { data: "trasaction_id" },
        { data: "amount" }
    ]
});

$('#semesterAccounting').change(function(){
    accountingData.draw();
});
// ********************************************************************************************************************************
let gradeData = $('#gradeTable').DataTable({
    'dom': 'lBfrtip',
    'saveState': true,
    'buttons': [
    {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [2,3,4,5,6,7]
        },
        filename: 'CLSU | Office of Admissions',
        "action": newexportaction
    },
    {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        messageTop: 'Office of Admissions Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [2,3,4,5,6,7]
        },
        "action": newexportaction
    },
    {
        extend: 'print',
        messageTop: 'Office of Admissions Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [2,3,4,5,6,7,8]
        },
        "action": newexportaction,
        customize: function(win)
        {

            var last = null;
            var current = null;
            var bod = [];

            var css = '@page { size: landscape; }',
                head = win.document.head || win.document.getElementsByTagName('head')[0],
                style = win.document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet)
            {
                style.styleSheet.cssText = css;
            }
            else
            {
                style.appendChild(win.document.createTextNode(css));
            }

            head.appendChild(style);
        },
        pageSize: 'LEGAL'
    }
    ],
    'responsive': true,
    'autoWidth': false,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    columnDefs: [
        { orderable: false, targets: [0, 1] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
    'url': window.location.origin + "/office-of-admissions/administrator/gradeList",
    'data': function(data)
    {
        data.semester = $('#semesterGrades option:selected').val();
        data.course = $('#gradeCourse option:selected').val();
    }
    },
    'columns': 
    [
        { data: "numRows" },
        { data: "action" },
        { data: "user_id" },
        { data: "semester_name" },
        { data: "lname" },
        { data: "fname" },
        { data: "mname" },
        { data: "course_name" },
        { data: "section" }
    ]
});
<<<<<<< HEAD
=======
<<<<<<< Updated upstream

$('#semesterGrades').change(function(){
    gradeData.draw();
});
$('#gradeCollegeFilter').change(function(){
    getCourse($('#gradeCollegeFilter option:selected').val(), gradeData)
});
$('#gradeCourse').change(function(){
    gradeData.draw();
});
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
$('#gradeCourse').change(function(){
    gradeData.draw();
});
// ********************************************************************************************************************************
let applicantData = $('#applicantList').DataTable({
    'dom': 'lBfrtip',
    'saveState': true,
    'buttons': [
    {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [1,2,3,4,5,6,7]
        },
        filename: 'CLSU | Office of Admissions',
        "action": newexportaction
    },
    {
        extend: 'pdfHtml5',
        orientation: 'landscape',
        pageSize: 'LEGAL',
        messageTop: 'Office of Admissions Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [1,2,3,4,5,6,7]
        },
        "action": newexportaction
    },
    {
        extend: 'print',
        messageTop: 'Office of Admissions Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [1,2,3,4,5,6,7]
        },
        "action": newexportaction,
        customize: function(win)
        {

            var last = null;
            var current = null;
            var bod = [];

            var css = '@page { size: landscape; }',
                head = win.document.head || win.document.getElementsByTagName('head')[0],
                style = win.document.createElement('style');

            style.type = 'text/css';
            style.media = 'print';

            if (style.styleSheet)
            {
                style.styleSheet.cssText = css;
            }
            else
            {
                style.appendChild(win.document.createTextNode(css));
            }

            head.appendChild(style);
        },
        pageSize: 'LEGAL'
    }
    ],
    'responsive': true,
    'autoWidth': false,
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    columnDefs: [
        { orderable: false, targets: [0, 1] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
    'url': window.location.origin + "/office-of-admissions/administrator/applicantList",
    'data': function(data)
    {
        // data.semester = $('#semesterGrades option:selected').val();
        // data.course = $('#gradeCourse option:selected').val();
    }
    },
    'columns': 
    [
        { data: "numRows" },
        { data: "action" },
        { data: "applicant_id" },
        { data: "lname" },
        { data: "fname" },
        { data: "mname" },
        { data: "program_name" },
        { data: "qualifier_type" },
        { data: "confirmation_status" },
        { data: "confirmation_date" }
    ]
});
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721

let arrDay = ["M_", "T_", "W_", "TH_", "F_", "S_"]; 

function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
}


function updateSchedule(schedid, semester) 
{
   $('#classScheduleModal').modal(
   {
       backdrop: 'static', 
       keyboard: false
   }, 
   'show');

   $('.modal-title').text('Class Schedule (' + $('#semester option:selected').text() + ")");
}

function save(action)
{
    let modalInitialValue = $("[name='gradeData[]']").map(function(){
                                return $(this).val();
                            }).get();

    // console.log(values);
    // $('#loginPreload').removeClass('d-none');
    swal({
        title: 'Are you sure?',
        text: '',
        type: "info",
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "SAVE",
        cancelButtonText: "CANCEL",
        showCancelButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false
    }, function (isConfirm) 
    {
        if (isConfirm) 
        {
            $.ajax({
                url: window.location.origin + "/office-of-admissions/administrator/saveGrade",
                type:"POST",
                dataType: 'JSON',
                data: 
                { 
                    action: action,
                    gradeData:  modalInitialValue,
                    semester:   $("#semesterGrades option:selected").val(),
                    studentID:  $("#studentID").val()
                },
                beforeSend: function ()
                {
                    $('#savePreload').html('<span class="loader1"></span>');
                },
                success: function(data)
                {
                    swal("OFFICE OF ADMISSIONS", data.sys_msg.msg, data.sys_msg.icon);
                    // console.log(data.sys_msg);
                    // if (data.sys_msg == "success") 
                    // {
                    //     accountingData.draw();
                    //     $('#assessmentModal').modal('hide');
                    //     $('[name="orNumberUpdate"]').val();
                    //     $('[name="amountUpdate"]').val();
                    // }
                    gradeDetails($("#studentID").val(), $("#semesterGrades option:selected").val());
                    $('#savePreload').html('');
                },
                complete: function () 
                {
                    // $('#savePreload').html('');
                },
                error: function (jqXHR, textStatus, errorThrown) 
                {
                    
                }
            });
        }
    });
}

function saveLetter()
{
    // console.log(CKEDITOR.instances.ckeditor.getData());
    // tinyMCE.get('tinymce').getContent()
    swal({
        title: "Are you sure?",
<<<<<<< HEAD
        text: "",
=======
<<<<<<< Updated upstream
        text: "This letter will be saved as your template",
=======
        text: "",
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            $.ajax({
                type: "POST",
                url: window.location.origin + "/office-of-admissions/administrator/saveLetter",
                data: { content: CKEDITOR.instances.ckeditor.getData(), letterType: $('[name="letterType"] option:selected').val() },
                dataType: "JSON",
                success: function (data) 
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    });
<<<<<<< HEAD
                    getLetterTemplate();
=======
<<<<<<< Updated upstream
=======
                    getLetterTemplate();
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

function saveRelease()
{
<<<<<<< HEAD
=======
<<<<<<< Updated upstream
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
    let programs = "";
    let ctr = 0;
    $("[name='program[]']:checked").each(function(){
        programs += $(this).val();
        if (ctr < ($("[name='program[]']:checked").length - 1)) 
        {
            programs += '|';
        }
        ctr++;
    });
    console.log(programs);
    
    swal({                                                                                   
        title: "Are you sure?",
        text: "",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            $.ajax({
                type: "POST",
                url: window.location.origin + "/office-of-admissions/administrator/saveRelease",
                data: 
                { 
                    "releaseID"     :   $('[name="releaseID"]').val(),
                    "letterType"    :   $('[name="releaseLetterType"] option:selected').val(),
                    "dFrom"         :   $('[name="dateFrom"]').val(),
                    "dTo"           :   $('[name="dateTo"]').val(),
                    "pFrom"         :   $('[name="percentFrom"]').val(),
                    "pTo"           :   $('[name="percentTo"]').val(),
                    "rDate"         :   $('[name="releaseDate"]').val(),
                    "rDateTo"       :   $('[name="releaseDateTo"]').val(),
                    "programs"      :   programs
                },
                dataType: "JSON",
                success: function (data) 
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    }, function (isConfirm)
                    {
                        if (isConfirm)
                        {
                            $('#releaseDateModal').modal('hide');
                            getReleaseList();
                        }
                    });
                    
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

function saveLetterType()
{
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
    swal({
        title: "Are you sure?",
        text: "",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            $.ajax({
                type: "POST",
<<<<<<< HEAD
=======
<<<<<<< Updated upstream
                url: window.location.origin + "/office-of-admissions/administrator/saveRelease",
                data: { 
                    "letterType"    :   $('[name="releaseLetterType"] option:selected').val(),
                    "dFrom"         :   $('[name="dateFrom"]').val(),
                    "dTo"           :   $('[name="dateTo"]').val(),
                    "pFrom"         :   $('[name="percentFrom"]').val(),
                    "pTo"           :   $('[name="percentTo"]').val(),
                    "rDate"         :   $('[name="releaseDate"]').val()
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                url: window.location.origin + "/office-of-admissions/administrator/saveLetterType",
                data: 
                { 
                    name: $("[name='letterTypeName']").val(), 
                    code: $("[name='letterTypeCode']").val()
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                },
                dataType: "JSON",
                success: function (data) 
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    });
<<<<<<< HEAD
                    getLetterType();
=======
<<<<<<< Updated upstream
                    getReleaseList();
=======
                    getLetterType();
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

<<<<<<< HEAD
=======
<<<<<<< Updated upstream
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
function importApplicants()
{
    swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            // Get form
            var form = $('#importApplicantForm')[0];
    
            // Create an FormData object 
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: window.location.origin + "/office-of-admissions/administrator/importApplicants",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "JSON",
                success: function (data) 
                {
                    /**
                     * 
                     * <div class="alert bg-pink alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                Lorem ipsum dolor sit amet, id fugit tollit pro, illud nostrud aliquando ad est, quo esse dolorum id
                            </div>
                     * 
                     */
                    
                    if (data.sys_msg == "error")
                    {
                        $(".errMsg").html('<div class="alert bg-red alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+data.msg+'</div>');
                    }else
                    {
                        swal("OFFICE OF ADMISSIONS", data.msg, data.icon);
                        applicantData.draw();
                        $(".errMsg").html('');
                    }
                    $("#importApplicantForm")[0].reset();
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

function removeApplicant(appId)
{
    swal({
        title: "Are you sure?",
        text: "",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            $.ajax({
                type: "POST",
                url: window.location.origin + "/office-of-admissions/administrator/removeApplicant",
                data: { 
                    "appId"    :   appId
                },
                dataType: "JSON",
                success: function (data) 
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    });
                    applicantData.draw();
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

function updateApplicant(appId)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/applicantInfo",
        type: "POST",
        data: { appId: appId },
        dataType: "json",
        success: function(response)
        {
            // console.log(response.course);
            
            $('[name="applicantID"]').val(response.appID);
            $('[name="firstname"]').val(response.firstname);
            $('[name="middlename"]').val(response.middlename);
            $('[name="lastname"]').val(response.lastname);

            // $('#applicantProgram').prop('selected', response.programID);
            $('[name="applicantProgram"]').selectpicker('val', response.programID);
            // $('[name="applicantProgram"]').change();

            // $('#applicantCategory').prop('selected', response.qualifierType);
            $('[name="applicantCategory"]').selectpicker('val', response.qualifierType);
            // $('[name="applicantProgram"]').change();

            $('#applicant_info_modal').modal(
            {
                backdrop: 'static', 
                position: 'center',
                keyboard: false
            }, 
            'show');
        },
        complete: function () 
        {
  
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
           swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
        }
     });
}

function saveApplicantInfo(action)
{
    swal({
        title: 'Are you sure?',
        text: '',
        type: "info",
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "SAVE",
        cancelButtonText: "CANCEL",
        showCancelButton: true,
        closeOnConfirm: false
    }, function (isConfirm) 
    {
        if (isConfirm) 
        {
            $.ajax({
                url: window.location.origin + "/office-of-admissions/administrator/saveApplicant",
                type:"POST",
                dataType: 'JSON',
                data: 
                { 
                    action                  : action,
                    "appID"		            :	$('[name="applicantID"]').val(),
                    "firstname"				:	$('[name="firstname"]').val(),
                    "middlename"			:	$('[name="middlename"]').val(),
                    "lastname"				:	$('[name="lastname"]').val(),
                    "applicantProgram"		:	$('[name="applicantProgram"] option:selected').val(),
                    "applicantCategory"	    :	$('[name="applicantCategory"] option:selected').val()
                },
                beforeSend: function ()
                {
                    $('#saveApplicantPreload').html('<span class="loader1"></span>');
                },
                success: function(data)
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    });
                    $("#applicantInfoForm")[0].reset();
                    $('#applicant_info_modal').modal('toggle');;
                    applicantData.draw();
                },
                complete: function () 
                {
                    $('#saveApplicantPreload').html('');
                },
                error: function (jqXHR, textStatus, errorThrown) 
                {
                    
                }
            });
        }
    });
}

function addReleaseDate()
{
    $('#releaseDateModal').modal(
    {
        backdrop: 'static', 
        position: 'center',
        keyboard: false
    }, 
    'show');
}

function updateRelease(releaseID)
{
    $.ajax({
        type: "POST",
        url: window.location.origin + "/office-of-admissions/administrator/releaseDateInfo",
        data: 
        { 
            "releaseID"    :   releaseID
        },
        dataType: "JSON",
        success: function (data) 
        {
            console.log(data);
            $('[name="releaseID"]').val(data.release_id);
            $('[name="releaseLetterType"]').val(data.letterType);
            $('[name="releaseLetterType"]').selectpicker('refresh');
            $('[name="dateFrom"]').val(data.date_from);
            $('[name="dateTo"]').val(data.date_to);
            $('[name="percentFrom"]').val(data.percent_from);
            $('[name="percentTo"]').val(data.percent_to);
            $('[name="releaseDate"]').val(data.release_date);
            $('[name="releaseDateTo"]').val(data.release_date_to);
            $('#releaseDateModal').modal(
            {
                backdrop: 'static', 
                position: 'center',
                keyboard: false
            }, 
            'show');
        },
        error: function (e) 
        {
            swal("System Message", e.responseText, "error");
        }
    });
}

function removeRelease(releaseID)
{
    swal({
        title: "Are you sure?",
        text: "",
        type: "info",
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) 
        {
            $.ajax({
                type: "POST",
                url: window.location.origin + "/office-of-admissions/administrator/removeRelease",
                data: 
                { 
                    "releaseID"    :   releaseID
                },
                dataType: "JSON",
                success: function (data) 
                {
                    swal({
                        title: "Office of Admissions",
                        text: data.msg,
                        type: data.icon
                    }, function (isConfirm)
                    {
                        if (isConfirm)
                        {
                            getReleaseList();
                        }
                    });
                },
                error: function (e) 
                {
                    swal("System Message", e.responseText, "error");
                }
            });
        } 
    });
}

function assessPayment(studentID, semester) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/accounting/accountingComponents",
        type:"POST",
        dataType: 'JSON',
        data: { studentID: studentID, semester: semester },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#fees').html(data.htmlData);
            $('[name="fullname"]').val(data.fullname);
        },
        complete: function () 
        {
            $('#assessmentModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
            $('.modal-title').text("ASSESSMENT FORM " + "(" + studentID + ")");
            $('[name="idNumber"]').val(studentID);
            $('[name="semesterID"]').val(semester);
            $('[name="ORnumber"]').val(''),
            $('[name="amount"]').val('')
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal({
                title: 'Session Expired, please re-login',
                text: '',
                type: "info",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "LOGIN",
                cancelButtonText: "CANCEL",
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                closeOnConfirm: false
            }, function (isConfirm) 
            {
                if (isConfirm) 
                {
                    window.open(window.location.origin + "/office-of-admissions/", "_SELF");
                }
            });
        }
    });
}

function savePayment(action) 
{
    let txtORNumber = action == "insert" ? $('[name="ORnumber"]').val() : $('[name="orNumberUpdate"]').val();
    let txtAmount = action == "insert" ? $('[name="amount"]').val() : $('[name="amountUpdate"]').val();
    if (txtORNumber == '' && txtAmount != '') 
    {
        swal("Required Field!!!", "OR NUMBER IS REQUIRED!!!", "warning");
    }else if (txtORNumber != '' && txtAmount == '')
    {
        swal("Required Field!!!", "AMOUNT IS REQUIRED!!!", "warning");
    }else if (txtORNumber == '' && txtAmount == '')
    {
        swal("Required Field!!!", "OR NUMBER AND AMOUNT ARE REQUIRED!!!", "warning");
    }else
    {
        swal({
            title: 'Are you sure?',
            text: '',
            type: "info",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "SAVE",
            cancelButtonText: "CANCEL",
            showCancelButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            closeOnConfirm: false
        }, function (isConfirm) 
        {
            if (isConfirm) 
            {
                $.ajax({
                    url: window.location.origin + "/office-of-admissions/accounting/savePayment",
                    type:"POST",
                    dataType: 'JSON',
                    data: 
                    { 
                        paymentID: action == "update" ? $('[name="paymentID"]').val() : "", 
                        studentID: action == "insert" ? $('[name="idNumber"]').val() : $('[name="studID"]').val(), 
                        semester: action == "insert" ? $('[name="semesterID"]').val() : $('[name="semesterPay"]').val(),
                        transID: action == "update" ? $('[name="transID"]').val() : "",
                        orNumber: action == "insert" ? $('[name="ORnumber"]').val() : $('[name="orNumberUpdate"]').val(),
                        amount: action == "insert" ? $('[name="amount"]').val() : $('[name="amountUpdate"]').val(),
                        action: action
                    },
                    beforeSend: function ()
                    {
                        $('#status-loading').html('<span class="loader"></span>');
                    },
                    success: function(data)
                    {
                        swal("OFFICE OF ADMISSIONS", data.msg, data.icon);
                        if (data.sys_msg == "success") 
                        {
                            // $('#studentEnrollment').DataTable().cell(($('[name="dataRow"]').val()), 8).data($('[name="ORnumber"]').val());
                            // $('#studentEnrollment').DataTable().cell(($('[name="dataRow"]').val()), 9).data($('[name="amount"]').val());
                            // $('#studentEnrollment').DataTable().draw(false);

                            // $('[name="ORnumber"]').val("");
                            // $('[name="amount"]').val("");
                            accountingData.draw();
                            $('#assessmentModal').modal('hide');
                            $('[name="orNumberUpdate"]').val();
                            $('[name="amountUpdate"]').val();
                        }
                    },
                    complete: function () 
                    {
                        $('#status-loading').html('');
                    },
                    error: function (jqXHR, textStatus, errorThrown) 
                    {
                        swal({
                            title: 'Session Expired, please re-login',
                            text: '',
                            type: "info",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "LOGIN",
                            cancelButtonText: "CANCEL",
                            showCancelButton: true,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            closeOnConfirm: false
                        }, function (isConfirm) 
                        {
                            if (isConfirm) 
                            {
                                window.open(window.location.origin + "/office-of-admissions/", "_SELF");
                            }
                        });
                    }
                });
            }
        });
    }
}

function updateOR(paymentID, transID, studid, semester, amount) 
{
    $('#updatePaymentModal').modal(
    {
        backdrop: 'static', 
        position: 'center',
        keyboard: false
    }, 
    'show');
    $('[name="studID"]').val(studid);
    $('[name="paymentID"]').val(paymentID);
    $('[name="transID"]').val(transID);
    $('[name="orNumberUpdate"]').val(transID);
    $('[name="semesterPay"]').val(semester);
    $('[name="amountUpdate"]').val(amount);
}

function gradeDetails(studentID, semesterID)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/studentGradeList",
        type: "POST",
        data: { studentID: studentID, semesterID: semesterID },
        dataType: "JSON",
        success: function (response)
        {
            $("#gradeList").html(response.data);
            $("[name='studentID']").val(studentID);
            $('#gradeModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
        },
        complete: function () 
        {
            
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            console.log(errorThrown);
        }
    });
}

<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
function getReleaseList()
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/getReleaseList",
        type: "POST",
        data: { uid: 0 },
        dataType: "json",
        success: function(response)
        {
          // console.log(response.course);
          $("#releaseList").html(response.content);
        },
        complete: function () 
        {
  
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
           swal("Something went wrong!!!", "No data, please try again", "error");
        }
     });
}getReleaseList();

function getCourse(college = 0, drawData = null)
{
   $.ajax({
      url: window.location.origin + "/office-of-admissions/administrator/getCourse",
      type: "POST",
      data: { college: college },
      dataType: "json",
      success: function(response)
      {
        // console.log(response.course);
        $('#gradeCourse').html(response.course);
        $('#gradeCourse').selectpicker('refresh');
        
        if(drawData !== null)
        {
            drawData.draw();
        }

      },
      complete: function () 
      {

      },
      error: function (jqXHR, textStatus, errorThrown) 
      {
         swal("Something went wrong!!!", "No data, please try again", "error");
      }
   });
}

function getLetterType()
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/getLetterType",
        type: "POST",
        data: { uid: 0 },
        dataType: "json",
        success: function(response)
        {
          // console.log(response.course);
          $('[name="letterType"]').html(response.content);
          $('[name="letterType"]').selectpicker('refresh');
          $('[name="releaseLetterType"]').html(response.content);
          $('[name="releaseLetterType"]').selectpicker('refresh');
<<<<<<< HEAD
=======
<<<<<<< Updated upstream
        },
        complete: function () 
        {
  
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
          $('[name="applicantCategory"]').html(response.content);
          $('[name="applicantCategory"]').selectpicker('refresh');
        },
        complete: function () 
        {
            
<<<<<<< HEAD
=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
           swal("Something went wrong!!!", "No data, please try again", "error");
        }
     });
}getLetterType();

function getLetterTemplate()
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/getLetterTemplate",
        type: "POST",
        data: { uid: 0 },
        dataType: "json",
        success: function(response)
        {
          // console.log(response.course);
          $('[name="letterList"]').html(response.content);
          $('[name="letterList"]').selectpicker('refresh');
        },
        complete: function () 
        {
  
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
           swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
        }
     });
}getLetterTemplate();

function getLetterTemplateContent(id)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/getLetterTemplateContent",
        type: "POST",
        data: { letterID: id },
        dataType: "json",
        success: function(response)
        {
          // console.log(response.course);
        //   $('[name="letterList"]').html(response.content);
        //   $('[name="letterList"]').selectpicker('refresh');
            CKEDITOR.instances['ckeditor'].setData(response.content);
        },
        complete: function () 
        {
  
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
           swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
        }
     });
}

<<<<<<< HEAD
=======
<<<<<<< Updated upstream
function addReleaseDate()
{
    $('#releaseDateModal').modal(
    {
        backdrop: 'static', 
        position: 'center',
        keyboard: false
    }, 
    'show');
}

function assessPayment(studentID, semester) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/accounting/accountingComponents",
        type:"POST",
        dataType: 'JSON',
        data: { studentID: studentID, semester: semester },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#fees').html(data.htmlData);
            $('[name="fullname"]').val(data.fullname);
        },
        complete: function () 
        {
            $('#assessmentModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
            $('.modal-title').text("ASSESSMENT FORM " + "(" + studentID + ")");
            $('[name="idNumber"]').val(studentID);
            $('[name="semesterID"]').val(semester);
            $('[name="ORnumber"]').val(''),
            $('[name="amount"]').val('')
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal({
                title: 'Session Expired, please re-login',
                text: '',
                type: "info",
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: "LOGIN",
                cancelButtonText: "CANCEL",
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                closeOnConfirm: false
            }, function (isConfirm) 
            {
                if (isConfirm) 
                {
                    window.open(window.location.origin + "/office-of-admissions/", "_SELF");
                }
            });
        }
    });
}

function savePayment(action) 
{
    let txtORNumber = action == "insert" ? $('[name="ORnumber"]').val() : $('[name="orNumberUpdate"]').val();
    let txtAmount = action == "insert" ? $('[name="amount"]').val() : $('[name="amountUpdate"]').val();
    if (txtORNumber == '' && txtAmount != '') 
    {
        swal("Required Field!!!", "OR NUMBER IS REQUIRED!!!", "warning");
    }else if (txtORNumber != '' && txtAmount == '')
    {
        swal("Required Field!!!", "AMOUNT IS REQUIRED!!!", "warning");
    }else if (txtORNumber == '' && txtAmount == '')
    {
        swal("Required Field!!!", "OR NUMBER AND AMOUNT ARE REQUIRED!!!", "warning");
    }else
    {
        swal({
            title: 'Are you sure?',
            text: '',
            type: "info",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "SAVE",
            cancelButtonText: "CANCEL",
            showCancelButton: true,
            allowEscapeKey: false,
            allowOutsideClick: false,
            closeOnConfirm: false
        }, function (isConfirm) 
        {
            if (isConfirm) 
            {
                $.ajax({
                    url: window.location.origin + "/office-of-admissions/accounting/savePayment",
                    type:"POST",
                    dataType: 'JSON',
                    data: 
                    { 
                        paymentID: action == "update" ? $('[name="paymentID"]').val() : "", 
                        studentID: action == "insert" ? $('[name="idNumber"]').val() : $('[name="studID"]').val(), 
                        semester: action == "insert" ? $('[name="semesterID"]').val() : $('[name="semesterPay"]').val(),
                        transID: action == "update" ? $('[name="transID"]').val() : "",
                        orNumber: action == "insert" ? $('[name="ORnumber"]').val() : $('[name="orNumberUpdate"]').val(),
                        amount: action == "insert" ? $('[name="amount"]').val() : $('[name="amountUpdate"]').val(),
                        action: action
                    },
                    beforeSend: function ()
                    {
                        $('#status-loading').html('<span class="loader"></span>');
                    },
                    success: function(data)
                    {
                        swal("OFFICE OF ADMISSIONS", data.msg, data.icon);
                        if (data.sys_msg == "success") 
                        {
                            // $('#studentEnrollment').DataTable().cell(($('[name="dataRow"]').val()), 8).data($('[name="ORnumber"]').val());
                            // $('#studentEnrollment').DataTable().cell(($('[name="dataRow"]').val()), 9).data($('[name="amount"]').val());
                            // $('#studentEnrollment').DataTable().draw(false);

                            // $('[name="ORnumber"]').val("");
                            // $('[name="amount"]').val("");
                            accountingData.draw();
                            $('#assessmentModal').modal('hide');
                            $('[name="orNumberUpdate"]').val();
                            $('[name="amountUpdate"]').val();
                        }
                    },
                    complete: function () 
                    {
                        $('#status-loading').html('');
                    },
                    error: function (jqXHR, textStatus, errorThrown) 
                    {
                        swal({
                            title: 'Session Expired, please re-login',
                            text: '',
                            type: "info",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "LOGIN",
                            cancelButtonText: "CANCEL",
                            showCancelButton: true,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            closeOnConfirm: false
                        }, function (isConfirm) 
                        {
                            if (isConfirm) 
                            {
                                window.open(window.location.origin + "/office-of-admissions/", "_SELF");
                            }
                        });
                    }
                });
            }
        });
    }
}

function updateOR(paymentID, transID, studid, semester, amount) 
{
    $('#updatePaymentModal').modal(
    {
        backdrop: 'static', 
        position: 'center',
        keyboard: false
    }, 
    'show');
    $('[name="studID"]').val(studid);
    $('[name="paymentID"]').val(paymentID);
    $('[name="transID"]').val(transID);
    $('[name="orNumberUpdate"]').val(transID);
    $('[name="semesterPay"]').val(semester);
    $('[name="amountUpdate"]').val(amount);
}

function gradeDetails(studentID, semesterID)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/studentGradeList",
        type: "POST",
        data: { studentID: studentID, semesterID: semesterID },
        dataType: "JSON",
        success: function (response)
        {
            $("#gradeList").html(response.data);
            $("[name='studentID']").val(studentID);
            $('#gradeModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
        },
        complete: function () 
        {
            
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            console.log(errorThrown);
        }
    });
}

=======
>>>>>>> Stashed changes
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
let map = "";
function pwdMapLocation() {
  if ($('#map').length > 0) {
    map = L.map('map', {
            zoomSnap: 0.15 
        }).setView([15.735859, 120.934876], 16); //Center point
        map.addControl(new L.Control.Fullscreen());

        map.on('fullscreenchange', function () {
            if (map.isFullscreen()) {
                // console.log('entered fullscreen');
                map.setView([15.735859, 120.934876], 16);
            } else {
                // console.log('exited fullscreen');
                map.setView([15.735859, 120.934876], 16);
            }
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 20}).addTo(map);

        L.control.browserPrint({position: 'topleft', title: 'Print ...'}).addTo(map);
        
        // L.Control.Watermark = L.Control.extend({
        //     onAdd: function(map) {
        //         let img = L.DomUtil.create('img');

        //         img.src = window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/wr.png';
        //         img.style.width = '100px';

        //         return img;
        //     },

        //     onRemove: function(map) {
        //         // Nothing to do here
        //     }
        // });

        // L.control.watermark = function(opts) {
        //     return new L.Control.Watermark(opts);
        // }

        // L.control.watermark({ position: 'bottomright' }).addTo(map);

        let legend = L.control({position: 'topright'});

        legend.onAdd = function (map) {

            let div = L.DomUtil.create('div', 'row clearfix'),
                region = ['REGION II', 'REGION III', 'REGION VI'],
                legend = ['REGION II', 'REGION III', 'REGION VI'],
                labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            ///for (let i = 0; i < region.length; i++) {
            //}
                            
                                
            /*div.innerHTML += '<div class="col-md-12 pull-right"><div class="card"><div class="header bg-blue">' +
                                '<h2>' +
                                    'LEGEND<small>waterice.philrice.gov.ph</small>' +
                                '</h2>' +
                                '<ul class="header-dropdown m-r--5">' +
                                    '<li>' +
                                        '<a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="rotation" data-loading-color="lightGreen">' +
                                            '<i class="material-icons">loop</i>' +
                                        '</a>' + 
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                            '<div class="body">' + 
                                'Quis ' +
                            '</div></div></div>';*/


            /*div.innerHTML += '<div class="box-body">'+
                                '<div class="box-header">' +
                                  '<h2 class="box-title">' +
                                    'Legends' +
                                  '</h2>' +
                                '</div>' +
                                '<div class="box-body">' +
                                  '<div class="row">' +
                                    '<div class="col-md-12">' +
                                      //'<center><button class="btn btn-primary btn-sm btn-flat" onclick="reload_map()">REFRESH</button></center>' +
                                    '</div>' +
                                  '</div>' +
                                '</div>' +
                              '</div>';*/

            return div;
        };

        legend.addTo(map); 
        let marker;
        let customPopup = "";
        let markerIcon = L.icon({
            iconUrl: window.location.origin + '/office-of-admissions/assets/leaflet-color-markers-master/img/r.png',
            iconSize: [20, 20], // size of the icon
            popupAnchor: [0,-15]
        });
        let customOptions = { 'minWidth': '350', 'keepInView': 'true' }
        // marker = L.marker([15.735859, 120.934876], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);
        // marker = L.marker([15.735859, 120.944876], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);

        // $.ajax({
        //     url : window.location.origin + "/" + window.location.pathname.split('/', 2)[1] + "/system_admin/automon_marker_map",
        //     type: "POST",
        //     data: {uid: 0},
        //     dataType: "JSON",
        //     success: function(response)
        //     {
        //         //console.log((response));
        //         let marker;
        //         for(let automon in response){
        //             //console.log((response[automon].longitude));
        //             // create custom icon
        //             /*switch(response[automon].cluster.split(",")[0]){
        //                 case "REGION II":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-green.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 case "REGION III":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-blue.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 case "REGION VI":
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-red.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //                 default:
        //                     let markerIcon = L.icon({
        //                         iconUrl: get_url + 'assets/leaflet-color-markers-master/img/marker-icon-2x-black.png',
        //                         iconSize: [15, 25], // size of the icon
        //                         popupAnchor: [0,-15]
        //                     });
        //                     break;
        //             }
        //             */
        //             let markerIcon = L.icon({
        //                 iconUrl: window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/leaflet-color-markers-master/img/marker-icon-2x-red.png',
        //                 iconSize: [25, 35], // size of the icon
        //                 popupAnchor: [0,-15]
        //             });
        //             let customPopup = '<ul class="list-group">' +
        //                                   '<li class="list-group-item">' + 
        //                                     '<b>AUTOMON NAME</b>' +
        //                                     '<h4 class="col-teal">'+ response[automon].automon +'</h4>' + 
        //                                   '</li>' +
        //                                   '<li class="list-group-item">' + 
        //                                     '<b>LOCATION</b>' +
        //                                     '<h4 class="col-teal">'+ response[automon].cluster +'</h4>' + 
        //                                   '</li>' +
        //                                   '<li class="list-group-item">' +
        //                                     '<b>REPORTS (<small>Water Level & Battery Percentage</small>)</b>' +
        //                                     '<br><small>'+ response[automon].reading_date +'</small>' +
        //                                     '<div class="row clearfix" style="margin-top: 15px;">' +
        //                                       '<div class="col-md-6">' + 
        //                                         '<img src="'+window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/water.png'+'" height="50">' +
        //                                         '<span class="col-teal" style="font-size: 24px; font-weight: bolder;">&nbsp;'+ parseInt(((response[automon].reading / 48) * -1) * 100) +'% <small>'+response[automon].reading+'</small></span>' + 
        //                                       '</div>' +
        //                                       '<div class="col-md-6">' + 
        //                                         '<img src="'+window.location.origin + "/" + window.location.pathname.split("/", 2)[1] + '/assets/images/battery.png'+'" height="50">' +
        //                                         '<span class="col-teal" style="font-size: 24px; font-weight: bolder;">&nbsp;'+ parseInt((response[automon].batt / 4.1) * 100) +'% <small>'+response[automon].batt+'</small></span>' + 
        //                                       '</div>' +
        //                                     '</div>' +
        //                                   '</li>' +
        //                                   '<li class="list-group-item"><center><a href="#">SHOW MORE <i class="fa fa-arrow-circle-right"></i></a></center></li>' +
        //                               '</ul>';
        //             let customOptions = { 'minWidth': '350', 'keepInView': 'true' }
        //             marker = L.marker([response[automon].latitude, response[automon].longitude], {icon: markerIcon}).bindPopup(customPopup,customOptions).addTo(map);
                     
        //         }
                
        //     },
        //     error: function (jqXHR, textStatus, errorThrown)
        //     {
        //         alert(errorThrown);
        //     }
        // });
  }
  
}pwdMapLocation();


//TinyMCE
// tinymce.init({
//     selector: "textarea#tinymce",
//     theme: "modern",
//     height: 300,
//     plugins: [
//         'advlist autolink lists link image charmap print preview hr anchor pagebreak',
//         'searchreplace wordcount visualblocks visualchars code fullscreen',
//         'insertdatetime media nonbreaking save table contextmenu directionality',
//         'emoticons template paste textcolor colorpicker textpattern imagetools'
//     ],
//     toolbar1: 'insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
//     toolbar2: 'print preview media | forecolor backcolor emoticons',
//     fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
//     indent: false,
//     image_advtab: true,
//     visualblocks_default_state: true
// });
// tinymce.suffix = ".min";
// tinyMCE.baseURL = window.location.origin + '/office-of-admissions/node_modules/adminbsb-materialdesign/plugins/tinymce';

//CKEditor
CKEDITOR.replace('ckeditor',
{
    extraPlugins: 'uicolor,colorbutton,colordialog,font,div,showblocks,table',
});
CKEDITOR.plugins.add( 'ckeditor', {
    init: function( editor ) {
        var pluginDirectory = this.path;
        editor.addContentsCss( pluginDirectory + window.location.origin + '/office-of-admissions/node_modules/adminbsb-materialdesign/plugins/bootstrap/css/bootstrap.css' );
        editor.addContentsCss( pluginDirectory + window.location.origin + '/office-of-admissions/node_modules/adminbsb-materialdesign/css/style.css' );
    }
});
CKEDITOR.config.height = 300;
CKEDITOR.config.allowedContent = true;
CKEDITOR.config.startupOutlineBlocks = true;

//Datetimepicker plugin
$('.datetimepicker').bootstrapMaterialDatePicker({
    format: 'YYYY-MM-DD HH:mm:s',
    clearButton: true,
    weekStart: 1
});

function previewLetter()
{
    $("#previewContent").html(CKEDITOR.instances.ckeditor.getData());
}

function copyToClipboard(str = "")
{
    let textToCopy = "";
    switch (str) {
        case 1:
            textToCopy = '<h1 class="applicantID" style="font-size: 24;">#APPLICANT ID</h1>';
            break;
        case 2:
            textToCopy = '<p style="font-size: 24px; font-weight: regular;" class="releaseDate">#RELEASE DATE</p>';
            break;
        case 3:
            textToCopy = '<b style="font-size: 24px; font-weight: bold;" class="name">#NAME</b>';
            break;
        case 4:
            textToCopy = '<b style="font-size: 24px; font-weight: bold;" class="course">#COURSE</b>';
            break;
        case 5:
            textToCopy = '<b style="font-size: 24px; font-weight: bold;" class="dateFrom">#DATE FROM</b>';
            break;
        case 6:
            textToCopy = '<b style="font-size: 24px; font-weight: bold;" class="dateTo">#DATE TO</b>';
            break;
        case 7:
            textToCopy = '<ol style="font-size: 24px; font-weight: regular;" class="program_for_other_qualifier" type="1"><li>#LIST</li></ol>';
            break;
        case 8:
            textToCopy = 'https://oad.clsu2.edu.ph/applicants1/assets/img/photo_requirements.png';
            break;
        case 9:
            textToCopy = 'https://oad.clsu2.edu.ph/applicants1/assets/img/signature_requirements.png';
            break;
    
        default:
            
        break;
    }
    navigator.clipboard.writeText(textToCopy);
}