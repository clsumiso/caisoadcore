let applicantData = $('#applicantList').DataTable({
    'dom': 'lBfrtip',
    'saveState': true,
    'buttons': [
    {
        extend: 'excelHtml5',
        exportOptions: {
            columns: [4,5,6,7]
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
            columns: [4,5,6,7]
        },
        "action": newexportaction
    },
    {
        extend: 'print',
        messageTop: 'Office of Admissions Copy',
        title: 'OFFICE OF ADMISSIONS',
        exportOptions: {
            columns: [4,5,6,7]
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
    'columnDefs': [
        { orderable: false, targets: [0, 1, 2] }
    ],
    //'searching': false, // Remove default Search Control
    'ajax': 
    {
    'url': window.location.origin + "/office-of-admissions/dean/graduateLevelList",
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
        { data: "requirements" },
        { data: "lname" },
        { data: "fname" },
        { data: "mname" },
        { data: "degree_programm" },
        { data: "level_applied" },
        { data: "date_applied" },
        { data: "department" },
        { data: "dean" }
    ],
    "rowCallback": function( row, data, index ) 
    {
        if (data.dean == "pending")
        {
            $("td", row).css("background-color","#74b9ff");
        }else
        {
            $("td", row).css("background-color","#2ecc71");
        }
    }
});

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

function viewApplicationForm(applicantID)
{
    $.ajax({
        url: window.location.origin + '/office-of-admissions/dean/applicationInfo',
        type: "POST",
        data: { appID: applicantID },
        dataType: "JSON",
        success: function (response)
        {
            // console.log(response.content);
            $('#formDataModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
            $('#formData').html(response.content);
        },
        complete: function () {

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Office of Admissions",
                text: "Something went wrong, please try again.",
                type: "info"
            });
        }
    });
}

function viewReferenceForm(reference)
{
    $.ajax({
        url: window.location.origin + '/office-of-admissions/dean/viewReferenceForm',
        type: "POST",
        data: { reference: reference },
        dataType: "JSON",
        success: function (response)
        {
            // console.log(response.content);
            $('#formDataModal').modal(
            {
                backdrop: 'static', 
                keyboard: false
            }, 
            'show');
            $('#formData').html(response.content);
        },
        complete: function () {

        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal({
                title: "Office of Admissions",
                text: "Something went wrong, please try again.",
                type: "info"
            });
        }
    });
}

function viewRequirements(documentUrl)
{
    if (documentUrl == "")
    {
        alert("Not Applicable");
    }else
    {
        $('#formDataModal').modal(
        {
            backdrop: 'static', 
            keyboard: false
        }, 
        'show');
    
        $('#requirementsContainer').attr('src', window.location.origin + documentUrl + "#toolbar=0");
    }
}

function submitApprove(applicationID)
{
    swal({
        title: 'Are you sure?',
        text: '<p>Application will be forwarded to the Office of Admissions</p>',
        type: "info",
        html: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "APPROVED",
        cancelButtonText: "CANCEL",
        showCancelButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        closeOnConfirm: true
    }, function (isConfirm) 
    {
        if (isConfirm) 
        {
            $.ajax({
                url: window.location.origin + '/office-of-admissions/dean/deanApprove',
                type: "POST",
                data: { appID: applicationID },
                dataType: "JSON",
                success: function (response)
                {
                    swal({
                        title: "Office of Admissions",
                        text: response.msg,
                        type: response.type
                    });

                    applicantData.draw();
                },
                complete: function () {
    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Office of Admissions",
                        text: "Something went wrong, please try again.",
                        type: "info"
                    });
                }
            });
        }
    });
}

function returnApplication(applicationID)
{
    swal({
        title: "RETURN TO OFFICE OF ADMISSIONS",
        text: "Remarks",
        type: "input",
        width: '1800px',
        showCancelButton: true,
        confirmButtonText: "RETURN",
        confirmButtonColor: "#e74c3c",
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Plase justify your action and/or add instructions/conditions for the applicant as necessary."
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") 
        {
            swal.showInputError("Plase justify your action and/or add instructions/conditions for the applicant as necessary."); return false
        }else
        {
            $.ajax({
                url: window.location.origin + '/office-of-admissions/dean/returnApplication',
                type: "POST",
                data: { appID: applicationID, remarks: inputValue },
                dataType: "JSON",
                success: function (response)
                {
                    // swal({
                    //     title: "Office of Admissions",
                    //     text: response.msg,
                    //     type: response.type
                    // });
                    swal("Office of Admissions", response.msg, response.type);

                    applicantData.draw();
                },
                complete: function () {
    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Office of Admissions",
                        text: "Something went wrong, please try again.",
                        type: "info"
                    });
                }
            });
            // swal("Nice!", "You wrote: " + inputValue, "success");
        }
    });
}

function returnApplicationToDepartment(applicationID)
{
    swal({
        title: "RETURN TO DEPARTMENT HEAD",
        text: "Remarks",
        type: "input",
        width: '1800px',
        showCancelButton: true,
        confirmButtonText: "RETURN",
        confirmButtonColor: "#e74c3c",
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Plase justify your action and/or add instructions/conditions for the applicant as necessary."
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") 
        {
            swal.showInputError("Plase justify your action and/or add instructions/conditions for the applicant as necessary."); return false
        }else
        {
            $.ajax({
                url: window.location.origin + '/office-of-admissions/dean/returnApplicationToDepartment',
                type: "POST",
                data: { appID: applicationID, remarks: inputValue },
                dataType: "JSON",
                success: function (response)
                {
                    // swal({
                    //     title: "Office of Admissions",
                    //     text: response.msg,
                    //     type: response.type
                    // });
                    swal("Office of Admissions", response.msg, response.type);

                    applicantData.draw();
                },
                complete: function () {
    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Office of Admissions",
                        text: "Something went wrong, please try again.",
                        type: "info"
                    });
                }
            });
            // swal("Nice!", "You wrote: " + inputValue, "success");
        }
    });
}

// function returnApplication(applicationID)
// {
//     swal({
//         title: 'Are you sure?',
//         text: '<p>Application will return to the Office of Admissions</p>',
//         type: "info",
//         html: true,
//         allowOutsideClick: false,
//         allowEscapeKey: false,
//         confirmButtonText: "RETURN",
//         confirmButtonColor: "#e74c3c",
//         cancelButtonText: "CANCEL",
//         showCancelButton: true,
//         allowEscapeKey: false,
//         allowOutsideClick: false,
//         closeOnConfirm: true
//     }, function (isConfirm) 
//     {
//         if (isConfirm) 
//         {
//             $.ajax({
//                 url: window.location.origin + '/office-of-admissions/dean/returnApplication',
//                 type: "POST",
//                 data: { appID: applicationID },
//                 dataType: "JSON",
//                 success: function (response)
//                 {
//                     swal({
//                         title: "Office of Admissions",
//                         text: response.msg,
//                         type: response.type
//                     });

//                     applicantData.draw();
//                 },
//                 complete: function () {
    
//                 },
//                 error: function (jqXHR, textStatus, errorThrown) {
//                     swal({
//                         title: "Office of Admissions",
//                         text: "Something went wrong, please try again.",
//                         type: "info"
//                     });
//                 }
//             });
//         }
//     });
// }