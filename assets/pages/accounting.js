function studentEnrollment() 
{
  if ($.fn.DataTable.isDataTable('#studentEnrollment')) { $('#studentEnrollment').DataTable().destroy(); }

  $('#studentEnrollment tbody').empty();

  $('#studentEnrollment').DataTable({
    dom: 'lBfrtip',
    responsive: true,
    buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9]
            },
            filename: 'ACCOUNTING RECORDS'
        },
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9]
            },
        },
        {
            extend: 'print',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9]
            },
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
    saveState: true,
    scrollX: true,
    columnDefs: [
        { orderable: false, targets: 0 }
    ],
    "order": [[ 0, 'asc' ]],
    "language": 
    {
      'loadingRecords': '<span class="loader"></span>'/*,
      "processing": "<span class='table-loader'></span>"*/
    },
    "ajax" : {
      url: window.location.origin + "/office-of-admissions/accounting/stundentEnrollment",
      type:"POST",
      data: { semester: $('#semester option:selected').val() },
      complete: function (data) 
      {
        // subject_filter();
        $('#status-loading').html('');
      },
      error: function (jqXHR, textStatus, errorThrown) 
      {
        swal("Something went wrong!!!", "No data, please try again ", "error");
        // console.log(errorThrown);
      }
    }/*,
    "initComplete": function(settings, json) {
      let response = settings.json;
      console.log(response['sess']);
    }*/
  });
}

function assess(studentID, semester, row) 
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
            $('[name="dataRow"]').val(row);
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
    if ($('[name="ORnumber"]').val() == '' && $('[name="amount"]').val() != '') 
    {
        swal("Required Field!!!", "OR NUMBER IS REQUIRED!!!", "warning");
    }else if ($('[name="ORnumber"]').val() != '' && $('[name="amount"]').val() == '')
    {
        swal("Required Field!!!", "AMOUNT IS REQUIRED!!!", "warning");
    }else if ($('[name="ORnumber"]').val() == '' && $('[name="amount"]').val() == '')
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
                        studentID: action == 'insert' ? $('[name="idNumber"]').val() : "", 
                        semester: action == 'insert' ? $('[name="semesterID"]').val() : "",
                        orNumber: $('[name="ORnumber"]').val(),
                        amount: $('[name="amount"]').val(),
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
                            studentEnrollment();
                            $('#assessmentModal').modal('hide');
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

function updateOR(paymentID, row) 
{
    // body...
}