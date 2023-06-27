function evaluation() 
{
  if ($.fn.DataTable.isDataTable('#student_evaluation')) { $('#student_evaluation').DataTable().destroy(); }

  $('#student_evaluation tbody').empty();

  $('#student_evaluation').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
            },
            filename: 'EVALUATION TEMPLATE'
        },
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
            },
        },
        {
            extend: 'print',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
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
    columnDefs: [
        { orderable: false, targets: 0 }
    ],
    "order": [[ 7, 'desc' ], [ 8, 'desc' ], [ 9, 'desc' ], [ 10, 'desc' ], [ 11, 'desc' ], [ 12, 'desc' ], [ 13, 'desc' ], [ 14, 'desc' ], [ 15, 'desc' ], [ 16, 'desc' ], [ 17, 'desc' ], [ 18, 'desc' ]],
    "language": 
    {
      'loadingRecords': '<span class="loader"></span>'/*,
      "processing": "<span class='table-loader'></span>"*/
    },
    "ajax" : {
      url: window.location.origin + "/office-of-admissions/records_in_charge/evaluation",
      type:"POST",
      data: { semester: $('#semester option:selected').val(), course: $('#course_filter option:selected').val() },
      complete: function () 
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

$('#student_evaluation tbody').on('click', 'tr', function(){
  let table = $('#student_evaluation').DataTable();
  if ($(this).hasClass('selected')) 
  {
    $(this).removeClass('selected');
  }else
  {
    table.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
  }
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
  'url': window.location.origin + "/office-of-admissions/records_in_charge/gradeList",
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

$('#gradeCourse').change(function(){
  gradeData.draw();
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

function remove_evaluation(evaluation_id) 
{
  let table = $('#student_evaluation').DataTable();
  swal({
    title: 'Are you sure?',
    text: '',
    type: "info",
    allowOutsideClick: false,
    allowEscapeKey: false,
    confirmButtonText: "REMOVE",
    cancelButtonText: "CANCEL",
    showCancelButton: true,
    allowEscapeKey: false,
    allowOutsideClick: false,
    closeOnConfirm: false
  }, function (isConfirm) 
  {
      if (isConfirm) 
      {
        // window.location = "https://oad.clsu2.edu.ph/user-login/";
        // _session();
        $.ajax({
          url: window.location.origin + "/office-of-admissions/records_in_charge/remove_evaluation",
          type:"POST",
          dataType: 'JSON',
          data: { evaluation_id: evaluation_id },
          beforeSend: function ()
          {
            $('#status-loading').html('<span class="loader"></span>');
          },
          success: function(data)
          {
            swal(data.msg, "", data.icon);
            if (data.sys_msg == 1) 
            {
              // table.row('.selected').remove().draw(false);
              evaluation();
              swal(data.msg, "Successfully remove!!!", data.icon);
            }
          },
          complete: function () 
          {
            $('#status-loading').html('');
          },
          error: function (jqXHR, textStatus, errorThrown) 
          {
            swal("Something went wrong!!!", "No data, please try again", "error");
          }
        });
        // $('#student_evaluation').DataTable().row($(event).parents('tr')).remove();


      }
  });
}
  
function update_evaluation(idnumber, lname, fname, mname, course) 
{
  $('#evaluation_modal').modal('show');
  $('#studid').val(idnumber);
  $('#firstname').val(fname);
  $('#middlename').val(mname);
  $('#lastname').val(lname);
  $('#course').val(course);
  $('#evaluation_sem').html($('#semester option:selected').text());
  show_semester_student_individual_data(idnumber);
  updateEvaluationComponents(idnumber);
}

function updateEvaluationComponents(idnumber) 
{
  let entranceCredentialsHtml = '';
  let entranceCredentialsArr = ["ENROLLMENT FORM (application for admission)", "FORM 137A", "FORM 138", "PSA (birth certificate)", "RECOMMENDATION LETTER (must be 3 for PhD, 2 for MS)", "TOR (Transfer Credential)", "COMPLETE"];
  let entranceCredentials = [];
  let isSelected = false;
  let test = "";
  $.ajax({
    async: false,
    url: window.location.origin + "/office-of-admissions/records_in_charge/evaluation_modal",
    type:"POST",
    dataType: 'JSON',
    data: { idnumber: idnumber, semester: $('#semester option:selected').val() },
    beforeSend: function ()
    {
      $('#status-loading').html('<span class="loader"></span>');
    },
    success: function(data)
    {
      for (let x = 0; x < entranceCredentialsArr.length; x++)
      {
        for (let i = 0; i < data[0][4].split('|').length; i++) 
        {
          entranceCredentials = $.trim(data[0][4].split('|')[i]);
          if (entranceCredentialsArr[x] == entranceCredentials) 
          {
            isSelected = true;
            break;
          }
          /*
            <option>ENROLLMENT FORM (application for admission)</option>
            <option>FORM 137A</option>
            <option>FORM 138</option>
            <option>PSA (birth certificate)</option>
            <option>RECOMMENDATION LETTER (must be 3 for PhD, 2 for MS)</option>
            <option>TOR (Transfer Credential)</option>
            <option>COMPLETE</option>
          */
        }

        if (isSelected == true) 
        {
          entranceCredentialsHtml += "<option selected>"+entranceCredentialsArr[x]+"</option>";
          isSelected = false;
        }else
        {
          entranceCredentialsHtml += "<option>"+entranceCredentialsArr[x]+"</option>";
        }  
      }
      // console.log(test);
      $('#date_admitted').val(data[0][2]);
      $('#residency').val(data[0][3]);
      $('#entrance_credential').html(entranceCredentialsHtml);
      $('#entrance_credential').selectpicker('refresh');
      $('#inc_cond_grades').val(data[0][5]);
      $('#lapse').val(data[0][6]);
      $('#nod_grades').val(data[0][7]);
      $('#forceDrop').val(data[0][8]);
      $('#behind_subjects').val(data[0][9]);
      $('#other_concern').val(data[0][10]);
      $('#instruction').val(data[0][11]);
      $('#max_units_allowed').val(data[0][12]);
    },
    complete: function () 
    {
      $('#status-loading').html('');
    },
    error: function (jqXHR, textStatus, errorThrown) 
    {
      swal("Something went wrong!!!", "No data, please try again", "error");
    }
  });
}

function evaluation_components(idnumber) 
{
  $.ajax({
    async: false,
    url: window.location.origin + "/office-of-admissions/records_in_charge/evaluation_modal_components",
    type:"POST",
    dataType: 'JSON',
    data: { course: $('#course_filter option:selected').val(), idnumber: idnumber, semester: $('#semester option:selected').val(), semester:  $('#semester option:selected').val() },
    beforeSend: function ()
    {
      $('#status-loading').html('<span class="loader"></span>');
    },
    success: function(data)
    {
      $('#section').html(data.section_content);
      $('#major').html(data.major_content);
      $('#section').selectpicker('refresh');
      $('#major').selectpicker('refresh');
      show_subject_enrolled_per_sem();
    },
    complete: function () 
    {
      $('#status-loading').html('');
    },
    error: function (jqXHR, textStatus, errorThrown) 
    {
      swal("Something went wrong!!!", "No data, please try again", "error");
    }
  });
}

function submit_evaluation() 
{
  // console.log($('#entrance_credential').val());
  let data = {
    "studid": $('[name="studid"]').val(),
    "lastname": $('[name="lastname"]').val(),
    "firstname": $('[name="firstname"]').val(),
    "middlename": $('[name="middlename"]').val(),
    "semester": $('#semester option:selected').val(),
    "course": $('[name="course"]').val(),
    "major": $('[name="major"]').val(),
    "section": $('[name="section"]').val(),
    "date_admitted": $('[name="date_admitted"]').val(),
    "residency": $('[name="residency"]').val(),
    "entrance_credential": $('[name="entrance_credential"]').val(),
    "inc_cond_grades": $('[name="inc_cond_grades"]').val(),
    "lapse": $('[name="lapse"]').val(),
    "nod_grades": $('[name="nod_grades"]').val(),
    "forceDrop": $('[name="forceDrop"]').val(),
    "behind_subjects": $('[name="behind_subjects"]').val(),
    "other_concern": $('[name="other_concern"]').val(),
    "instruction": $('[name="instruction"]').val(),
    "max_units_allowed": $('[name="max_units_allowed"]').val()
  }

    
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
          url: window.location.origin + "/office-of-admissions/records_in_charge/add_edit_evaluation",
          type:"POST",
          dataType: 'JSON',
          data: { data: data },
          beforeSend: function ()
          {
            $('#status-loading').html('<span class="loader"></span>');
          },
          success: function(data)
          {
            if (data.sys_msg == 1) 
            {
              // table.row('.selected').remove().draw(false);
              evaluation();
              swal(data.msg, "Office of Admissions", data.icon);
            }
          },
          complete: function () 
          {
            $('#status-loading').html('');
            $('#eval_form')[0].reset();
            $('#entrance_credential').selectpicker('refresh');
            $('#evaluation_modal').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown) 
          {
            swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
          }
        });
      }
  });
}

function show_subject_enrolled_per_sem() 
{
  $.ajax({
    url: window.location.origin + "/office-of-admissions/records_in_charge/student_registration_individual",
    type:"POST",
    dataType: 'JSON',
    data: { idnumber: $('#studid').val(), semester: $('#student_registration_semester option:selected').val() },
    beforeSend: function ()
    {
      $('#status-loading').html('<span class="loader"></span>');
    },
    success: function(data)
    {
      $('#student_registration').html(data.registration_content);
    },
    complete: function () 
    {
      $('#status-loading').html('');
    },
    error: function (jqXHR, textStatus, errorThrown) 
    {
      swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
    }
  });
}

function show_semester_student_individual_data(idnumber) 
{
  $.ajax({
    url: window.location.origin + "/office-of-admissions/records_in_charge/semester_student_individual_data",
    type:"POST",
    dataType: 'JSON',
    data: { idnumber: idnumber },
    beforeSend: function ()
    {
      $('#status-loading').html('<span class="loader"></span>');
    },
    success: function(data)
    {
      $('#student_registration_semester').html(data.semester_content);
      $('#student_registration_semester').selectpicker('refresh');
    },
    complete: function () 
    {
      $('#status-loading').html('');
      evaluation_components(idnumber);
    },
    error: function (jqXHR, textStatus, errorThrown) 
    {
      swal("Something went wrong!!!", "No data, please try again"+errorThrown, "error");
    }
  });
}

function importEvaluation() 
{
  // let file_data = $('#file_import').prop('files')[0];
  // let form_data = new FormData();
  // form_data.append('file', file_data);
  // $.ajax({
  //   url: window.location.origin + "/office-of-admissions/records_in_charge/import_evaluation", // point to server-side controller method
  //   dataType: 'JSON', // what to expect back from the server
  //   cache: false,
  //   contentType: false,
  //   processData: false,
  //   data: form_data,
  //   type: 'POST',
  //   success: function (response) 
  //   {
  //     console.log(response);
  //   },
  //   error: function (response) 
  //   {

  //   }
  // });
}

function exportEvaluation() 
{
  /*$.ajax({
    url: window.location.origin + "/office-of-admissions/records_in_charge/export_evaluation", // point to server-side controller method
    dataType: 'JSON', // what to expect back from the server
    data: { semester: $('#export_semester option:selected').val(), course: $('#export_course option:selected').val() },
    type: 'POST',
    success: function (response) 
    {
      console.log(response);
    },
    error: function (response) 
    {
      console.log(response);
    }
  });*/
  window.open(window.location.origin + "/office-of-admissions/records_in_charge/export_evaluation/"+$('#export_course option:selected').val()+"/"+$('#export_semester option:selected').val(), "_BLANK");
}

function force_drop(idnumber, semester, schedid, status) 
{
  swal({
    title: 'Are you sure?',
    text: '',
    type: "info",
    allowOutsideClick: false,
    allowEscapeKey: false,
    confirmButtonText: "YES",
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
          url: window.location.origin + "/office-of-admissions/records_in_charge/force_drop",
          type:"POST",
          dataType: 'JSON',
          data: { idnumber: idnumber, semester: semester, schedid: schedid, status: status },
          beforeSend: function ()
          {
            swal("Please wait....", "Office of Admissions", "info");
          },
          success: function(data)
          {
            if (data.sys_msg == 1) 
            {
              // table.row('.selected').remove().draw(false);
              show_subject_enrolled_per_sem();
              swal(data.msg, "Office of Admissions", data.icon);
            }
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
  });
}

function get_enrollment() 
{
  if ($.fn.DataTable.isDataTable('#student_enrollment')) { $('#student_enrollment').DataTable().destroy(); }

  $('#student_enrollment tbody').empty();

  $('#student_enrollment').DataTable({
    dom: 'Bfrtip',
    responsive: true,
    buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [2,3,4,5,6,7,8]
            },
            filename: 'EVALUATION TEMPLATE'
        },
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8]
            },
        },
        {
            extend: 'print',
            messageTop: 'Student Copy',
            title: 'OFFICE OF ADMISSIONS',
            exportOptions: {
                columns: [2,3,4,5,6,7,8]
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
    columnDefs: [
        { orderable: false, targets: 0 }
    ],
    "order": [[ 3, 'asc' ]],
    "language": 
    {
      'loadingRecords': '<span class="loader"></span>'/*,
      "processing": "<span class='table-loader'></span>"*/
    },
    "ajax" : {
      url: window.location.origin + "/office-of-admissions/records_in_charge/enrollment",
      type:"POST",
      data: { sem: $('#enrollment-semester option:selected').val(), course_id: $('#enrollment-course-filter option:selected').val(), yrlevel: $('#year_level option:selected').val() },
      complete: function () 
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

/*Enrolmment component*/

function showSubject() 
{
    if ($('#addingSemester option:selected').val() == '#')
    {
      alert("Please select semester");
    }else
    {
      $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/showSubjects",
        type:"POST",
        dataType: 'JSON',
        data: 
        { 
          studid: $('#studid_enrollment').val(), 
          filter: $('#subject').val(), 
          section: $('#section_list option:selected').val(),
          semester: $('#addingSemester option:selected').val()
        },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#name').html(data.name);
            // $('#course').html(data.course);
            // $('#section').html(data.section);
            $('#subjects').html(data.htmlData);
            subjectEnrolled();
        },
        complete: function () 
        {
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
    }
    
}

function studentEnrollment() 
{
  if ($('#addingSemester option:selected').val() == '#')
  {
    alert("Please select semester");
  }else
  {
    $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/enrollment_components",
        type:"POST",
        dataType: 'JSON',
        data: 
        { 
          studid: $('#studid_enrollment').val(), 
          course: $('#course_list option:selected').val(), 
          section: $('#section_list option:selected').val(),
          semester: $('#addingSemester option:selected').val()
        },
        beforeSend: function ()
        {
          $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
          $('#name').html(data.name);
          // $('#course').html(data.course);
          // $('#section').html(data.section);
          $('#subjects').html("");
          subjectEnrolled();
      },
        complete: function () 
        {
          $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
          swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
  }
  
}
/*END Enrolmment component*/

function getCourse(collegeID) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/getCourse",
        type:"POST",
        dataType: 'JSON',
        data: { collegeID: collegeID },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
          $('#gradeCourse').html(data.courseData);
          $('#gradeCourse').selectpicker('refresh');
          $('#course_list').html(data.courseData);
          $('#course_list').selectpicker('refresh');
        },
        complete: function () 
        {
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
}

function gradeDetails(studentID, semesterID)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/studentGradeList",
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

function getSection(courseID) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/getSection",
        type:"POST",
        dataType: 'JSON',
        data: { courseID: courseID },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#section_list').html(data.sectionData);
            $('#section_list').selectpicker('refresh');
        },
        complete: function () 
        {
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
}

function getStudentInformation(studid) 
{
   $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/enrollment_components",
        type:"POST",
        dataType: 'JSON',
        data: { studid: $('#studid_enrollment').val(), course: $('#course_list option:selected').val(), section: $('#section_list option:selected').val() },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#name').html(data.name);
            subjectEnrolled();
        },
        complete: function () 
        {
            $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
}

function subjectEnrolled() 
{
  $.ajax({
        url: window.location.origin + "/office-of-admissions/records_in_charge/subject_enrolled",
        type:"POST",
        dataType: 'JSON',
        data: 
        { 
          studid: $('#studid_enrollment').val(),
          semester: $('#addingSemester option:selected').val()
        },
        beforeSend: function ()
        {
          $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
          $('#subjectsEnrolled').html(data.htmlData);
      },
        complete: function () 
        {
          $('#status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
          swal("Something went wrong!!!", "No data, please try again", "error");
        }
    });
}

function register(studid, sem, schedid, section) 
{
  swal({
    title: 'Are you sure?',
    text: '',
    type: "info",
    allowOutsideClick: false,
    allowEscapeKey: false,
    confirmButtonText: "CONTINUE",
    cancelButtonText: "CANCEL",
    showCancelButton: true,
    allowEscapeKey: false,
    allowOutsideClick: false,
    closeOnConfirm: false
  }, function (isConfirm) 
  {
      if (isConfirm) 
      {
        if ($('#college option:selected').val() == -1 || $('#course_list option:selected').val() == -1 || $('#section_list option:selected').val() == -1) 
        {
          swal("Office of Admissions", "Please select College, Course or Section.", "warning");
        }else
        {
          $.ajax({
              url: window.location.origin + "/office-of-admissions/records_in_charge/enroll",
              type: 'POST',
              data: { studid: studid, semester: sem, schedid: schedid, section: section },
              dataType: 'JSON',
              beforeSend: function ()
              {
                $('#status-loading').html('<span class="loader"></span>');
              },
              success: function (data)
              {
                // swal(data.sys_msg, data.msg, "info");
				swal(data.sys_msg, data.msg + " " + data.no_slot, "info");
                subjectEnrolled();
              },
              complete: function () 
              {
                $('#status-loading').html('');
              },
              error: function (jqXHR, textStatus, errorThrown) 
              {
                swal("Something went wrong!!!", "No data, please try again", "error");
              }
          })
        }  
      }
  });
  
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
                url: window.location.origin + "/office-of-admissions/records_in_charge/saveGrade",
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

function remove(studid, sem, schedid) 
{
  swal({
    title: 'Are you sure?',
    text: '',
    type: "info",
    allowOutsideClick: false,
    allowEscapeKey: false,
    confirmButtonText: "REMOVE",
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
          url: window.location.origin + "/office-of-admissions/records_in_charge/removeEnroll",
          type: 'POST',
          data: { studid: studid, semester: sem, schedid: schedid },
          dataType: 'JSON',
          beforeSend: function ()
          {
            $('#status-loading').html('<span class="loader"></span>');
          },
          success: function (data)
          {
            swal(data.sys_msg, data.msg, "info");
              subjectEnrolled();
          },
          complete: function () 
          {
            $('#status-loading').html('');
          },
          error: function (jqXHR, textStatus, errorThrown) 
          {
            swal("Something went wrong!!!", "No data, please try again", "error");
          }
      })
      }
  });
  
}