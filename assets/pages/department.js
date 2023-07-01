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
    'url': window.location.origin + "/office-of-admissions/department/graduateLevelList",
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
        if (data.department == "pending")
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
        url: window.location.origin + '/office-of-admissions/department/applicationInfo',
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
        url: window.location.origin + '/office-of-admissions/department/viewReferenceForm',
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

function endorsedToDean(applicationID)
{
    swal({
        title: 'ENDORSED REGULAR',
        text: '<p>Please check if all the requirements are complete</p>',
        type: "info",
        html: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "ENDORSED REGULAR",
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
                url: window.location.origin + '/office-of-admissions/department/deanEndorse',
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
                url: window.location.origin + '/office-of-admissions/department/returnApplication',
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

    // swal({
    //     title: 'Are you sure?',
    //     text: '<p>Application will return to the Office of Admissions</p>',
    //     type: "info",
    //     html: true,
    //     allowOutsideClick: false,
    //     allowEscapeKey: false,
    //     confirmButtonText: "RETURN",
    //     confirmButtonColor: "#e74c3c",
    //     cancelButtonText: "CANCEL",
    //     showCancelButton: true,
    //     allowEscapeKey: false,
    //     allowOutsideClick: false,
    //     closeOnConfirm: true
    // }, function (isConfirm) 
    // {
    //     if (isConfirm) 
    //     {
    //         $.ajax({
    //             url: window.location.origin + '/office-of-admissions/department/returnApplication',
    //             type: "POST",
    //             data: { appID: applicationID },
    //             dataType: "JSON",
    //             success: function (response)
    //             {
    //                 swal({
    //                     title: "Office of Admissions",
    //                     text: response.msg,
    //                     type: response.type
    //                 });

    //                 applicantData.draw();
    //             },
    //             complete: function () {
    
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 swal({
    //                     title: "Office of Admissions",
    //                     text: "Something went wrong, please try again.",
    //                     type: "info"
    //                 });
    //             }
    //         });
    //     }
    // });
}

function adiviseWithdraw(applicationID)
{
    swal({
        title: "ADVISED TO WITHDRAW",
        text: "Remarks",
        type: "input",
        width: '1800px',
        showCancelButton: true,
        confirmButtonText: "ADVISED TO WITHDRAW",
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
                url: window.location.origin + '/office-of-admissions/department/withdrawApplication',
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

    // swal({
    //     title: 'Are you sure?',
    //     text: '<p>Application will return to the Office of Admissions</p>',
    //     type: "info",
    //     html: true,
    //     allowOutsideClick: false,
    //     allowEscapeKey: false,
    //     confirmButtonText: "RETURN",
    //     confirmButtonColor: "#e74c3c",
    //     cancelButtonText: "CANCEL",
    //     showCancelButton: true,
    //     allowEscapeKey: false,
    //     allowOutsideClick: false,
    //     closeOnConfirm: true
    // }, function (isConfirm) 
    // {
    //     if (isConfirm) 
    //     {
    //         $.ajax({
    //             url: window.location.origin + '/office-of-admissions/department/returnApplication',
    //             type: "POST",
    //             data: { appID: applicationID },
    //             dataType: "JSON",
    //             success: function (response)
    //             {
    //                 swal({
    //                     title: "Office of Admissions",
    //                     text: response.msg,
    //                     type: response.type
    //                 });

    //                 applicantData.draw();
    //             },
    //             complete: function () {
    
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 swal({
    //                     title: "Office of Admissions",
    //                     text: "Something went wrong, please try again.",
    //                     type: "info"
    //                 });
    //             }
    //         });
    //     }
    // });
}

function endorsedToDeanProbationary(applicationID)
{
    swal({
        title: "ENDORSED PROBATIONARY",
        text: "Remarks",
        type: "input",
        width: '1800px',
        showCancelButton: true,
        confirmButtonText: "ENDORSED PROBATIONARY",
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
                url: window.location.origin + '/office-of-admissions/department/endorseProbationary',
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

function show_subject() {
    let semester = '';
    semester = $('#school_year option:selected').val();
    let loading = Swal.fire({
        title: 'OFFICE OF ADMISSIONS',
        html: 'Loading...please wait',
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });
    
    if ($.fn.DataTable.isDataTable('#subject_list')) { $('#subject_list').DataTable().destroy(); }
    
    $('#subject_list tbody').empty();
    $('#subject_list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "responsive": true,
        "scrollX": false,
        "autoWidth": false,
        "stateSave": true,
        "ajax" : {
            url: window.location.origin + "/office-of-admissions/department/department_subject",
            type:"POST",
            data: { semid: semester, rog_filter: $('#rog_filter option:selected').val() },
            complete: function () {
                loading.close();
            },
            error: function (jqXHR, textStatus, errorThrown,) {
                console.log(jqXHR);
                loading.close();
                Swal.fire({
                    icon: 'warning',
                    title: 'Something went wrong!!!',
                    text: 'No data, please try again.',
                    showConfirmButton: true,
                    confirmButtonText: 'RELOAD',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((res) => {
                    if (res.isConfirmed) {
                        show_subject();
                    }
                });
            }
        }/* ,
        "rowCallback": function( row, data, index ) {
            if (data[10] == 'NO GRADE SUBMITTED') 
            {
                $('td:nth(1)', row).css('background-color', '#dc3545');
            }else if(data[10] == 'DEAN')
            {
                $('td:nth(1)', row).css('background-color', '#ffc107');
            }else if(data[10] == 'DEPARTMENT HEAD')
            {
                $('td:nth(1)', row).css('background-color', '#28a745');
            }
        }  */
    });
}show_subject($('.select2 option:selected').val());

function view_rog(schedid, sem, cat_no, faculty, faculty_id) {
    let loading = Swal.fire({
        title: 'OFFICE OF ADMISSIONS',
        html: 'Loading...please wait',
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });

    let html_list = '';
    let i = 1;
    let ctr_dean = 0;
    let ctr_approved = 0;
    $.ajax({
        url: window.location.origin + '/office-of-admissions/department/view_rog',
        type: 'POST',
        data: { schedid: schedid, sem: sem, faculty_id: faculty_id },
        dataType: 'JSON',
        success: function (data){
            loading.close();
            html_list += '<table class="table table-bordered">';
            html_list += '<tr>';
                html_list += '<th>';
                    html_list += 'COLOR CODES:';
                html_list += '</th>';
                // html_list += '<th>';
                //     // html_list += 'TO SUBMIT';
                // html_list += '</th>';
                html_list += '<th class="bg-success">';
                    html_list += 'APPROVAL OF DEPT. HEAD';
                html_list += '</th>';
                html_list += '<th class="bg-warning">';
                    html_list += 'APPROVAL OF DEAN';
                html_list += '</th>';
            html_list += '</tr>';
            html_list += '<tr>';
                html_list += '<th colspan="5">';
                    html_list += '';
                html_list += '</th>';
            html_list += '</tr>';
            html_list += '<tr>';
                html_list += '<th>';
                    html_list += '#';
                html_list += '</th>';
                html_list += '<th>';
                    html_list += 'ID NUMBER';
                html_list += '</th>';
                html_list += '<th>';
                    html_list += 'NAME';
                html_list += '</th>';
                html_list += '<th>';
                    html_list += 'SUBJECT';
                html_list += '</th>';
                html_list += '<th>';
                    html_list += 'FINAL GRADE';
                html_list += '</th>';
            html_list += '</tr>';
            for (let x in data)
            {
                // alert(data[x]['student_id']);
                    html_list += '<tr>';
                        html_list += '<td>';
                            html_list += (i++);
                        html_list += '</td>';
                        html_list += '<td>';
                            html_list += data[x]['student_id'];
                        html_list += '</td>';
                        html_list += '<td>';
                            html_list += data[x]['name'];
                        html_list += '</td>';
                        html_list += '<td>';
                            html_list += data[x]['cat_no'];
                        html_list += '</td>';
                        
                        if(data[x]['status'] == 'faculty' || data[x]['status'] == 'pending')
                        {
                            html_list += '<td class="bg-primary">';
                        }else if(data[x]['status'] == 'department head')
                        {
                            html_list += '<td class="bg-success">';
                        }else if(data[x]['status'] == 'dean')
                        {
                            html_list += '<td class="bg-warning">';
                            ctr_dean++;
                        }else if(data[x]['status'] == 'approved')
                        {
                            html_list += '<td>';
                            ctr_approved++;
                        }else{
                            html_list += '<td class="bg-danger">';
                        }

                            html_list += data[x]['grades'];
                        html_list += '</td>';
                    html_list += '</tr>';
            }
            if (data.length === 0) {
                html_list += '<tr>';
                    html_list += '<td colspan="4">';
                        html_list += 'NOTHING TO VERIFIED AND FOUND CORRECT';
                    html_list += '</td>';
                html_list += '</tr>';
            }
            html_list += '<table>';

            show_list_of_student_for_submission(html_list, cat_no, sem, faculty, schedid, faculty_id, ctr_dean, data.length, ctr_approved);
        },
        complete: function () {
            loading.close();
            // setTimeout(function(){
            //     show_enrolled($('[name="crid"]').val(), $('[name="crid"]').val().split('_')[1]);
            //  }, 30000);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            loading.close();
            Swal.fire({
                icon: 'warning',
                title: 'Something went wrong!!!',
                text: 'FAILED, TRY AGAIN',
                showConfirmButton: true,
                confirmButtonText: 'OKAY',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((res) => {
                if (res.isConfirmed) {
                    // get_activity_task($('[name="crid"]').val());
                }
            });
        }
    })
}

function show_list_of_student_for_submission(list, cat_no, sem, faculty, schedid, faculty_id, ctr_dean, total_record, ctr_approved) {
    Swal.fire({
        // icon: 'warning',
        title: 'SUBMIT ROG OF THE FOLLOWING STUDENTS',
        html: list,
        showConfirmButton: ctr_dean == total_record ? false : (ctr_approved == total_record ? false : true),
        showCancelButton: true,
        showDenyButton: ctr_dean == total_record ? false : (ctr_approved == total_record ? false : true),
        confirmButtonText: 'VERIFIED AND FOUND CORRECT',
        denyButtonText: 'RETURN TO FACULTY',
        showLoaderOnConfirm: true,
        showLoaderOnDeny: true,
        width:  '950px',
        preConfirm: (login) => {
            return $.ajax({
                url: window.location.origin + '/star/department_head/submit_rog',
                type: 'POST',
                data: { cat_no: cat_no, sem: sem, faculty_id: faculty_id, schedid: schedid },
                dataType: 'JSON',
                success: function (data){
                    Swal.fire({
                        icon: data.icon,
                        title: data.sys_msg,
                        html: data.msg,
                        showConfirmButton: true,
                        confirmButtonText: 'OKAY',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((res) => {
                        if (res.isConfirmed) {
                            show_subject($('.select2 option:selected').val());
                        }
                    });
                },
                complete: function () {
                    // loading.close();
                    // setTimeout(function(){
                    //     show_enrolled($('[name="crid"]').val(), $('[name="crid"]').val().split('_')[1]);
                    //  }, 30000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Something went wrong!!!',
                        text: 'FAILED, TRY AGAIN',
                        showConfirmButton: true,    
                        confirmButtonText: 'OKAY',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    })
                }
            })
          },
          preDeny: (login) => {
              return $.ajax({
                  url: window.location.origin + '/star/department_head/return_rog',
                  type: 'POST',
                  data: { cat_no: cat_no, sem: sem, faculty_id: faculty_id, schedid: schedid },
                  dataType: 'JSON',
                  success: function (data){
                      Swal.fire({
                          icon: data.icon,
                          title: data.sys_msg,
                          html: data.msg,
                          showConfirmButton: true,
                          confirmButtonText: 'OKAY',
                          allowOutsideClick: false,
                          allowEscapeKey: false
                      }).then((res) => {
                          if (res.isConfirmed) {
                              show_subject($('.select2 option:selected').val());
                          }
                      });
                  },
                  complete: function () {
                      // loading.close();
                      // setTimeout(function(){
                      //     show_enrolled($('[name="crid"]').val(), $('[name="crid"]').val().split('_')[1]);
                      //  }, 30000);
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                      Swal.fire({
                          icon: 'warning',
                          title: 'Something went wrong!!!',
                          text: 'FAILED, TRY AGAIN',
                          showConfirmButton: true,    
                          confirmButtonText: 'OKAY',
                          allowOutsideClick: false,
                          allowEscapeKey: false,
                      })
                  }
              })
          },
          allowOutsideClick: () => !Swal.isLoading(),
          backdrop: true
    }).then((res) => {
        if (res.isConfirmed) {
            
        }
    });
}