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
            columns: [2,3,4,5,6,7,8]
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
            columns: [2,3,4,5,6,7,8]
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
        { orderable: false, targets: [0, 1, 8] }
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
        { data: "section" }, 
        { data: "view_grades" }
    ]
});

$('#gradeCourse').change(function(){
    gradeData.draw();
});

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

function saveSchedule()
{
   console.log($('#day1 option:selected').val());
}

function getCourse(college = 0)
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