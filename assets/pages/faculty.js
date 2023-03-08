let manage_grade_table = null;

function get_grades() 
{
    _session();
    // $('#status-loading').html('<span class="loader"></span>');
    if ($.fn.DataTable.isDataTable('#student_grades')) { $('#student_grades').DataTable().destroy(); }
  
    $('#student_grades tbody').empty();

    manage_grade_table = $('#student_grades').DataTable({
      DOM: 'Bfrtip',
      responsive: true,
      columnDefs: [
          { orderable: false, targets: 0 }
      ],
      "language": 
      {
        'loadingRecords': '<span class="loader"></span>'/*,
        "processing": "<span class='table-loader'></span>"*/
      },
      "ajax" : {
        url: window.location.origin + "/office-of-admissions/faculty/manage_grades",
        type:"POST",
        data: { semid: $('#semester option:selected').val(), subject: $('#subject_filter option:selected').val() },
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

function _session() 
{
  let val = 0;
  let res = $.get( window.location.origin + '/office-of-admissions/faculty/verify_session', function( data ) {
    if(data==="1")
    {
      //session found stuff
      // alert('session exist');
      val = 1;
    }
    else{
      //session not found stuff
      // alert('session not exist');
      val = 0;
    }
  });

  return val;
}

function get_teaching_loads() 
{
  $('#teaching-loads-status-loading').html('<span class="loader"></span>');
  if ($.fn.DataTable.isDataTable('#teaching_loads')) { $('#teaching_loads').DataTable().destroy(); }

  $('#teaching_loads tbody').empty();

  $('#teaching_loads').DataTable({
      DOM: 'Bfrtip',
      // processing: true,
      responsive: true,
      columnDefs: [
          { orderable: false, targets: 0 }
      ],
      "language": 
      {
        'loadingRecords': '<span class="loader"></span>'/*,
        "processing": "<span class='table-loader'></span>"*/
      },
      "ajax" : 
      {
        url: window.location.origin + "/office-of-admissions/faculty/teaching_load_subject",
        type:"POST",
        data: { semid: $('#teaching-loads-semester option:selected').val() },
        complete: function () 
        {
          // subject_filter();
          // $('#teaching-loads-status-loading').html('');
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
          swal("Something went wrong!!!", "No data, please try again", "error");
        }
      }
  });
}

function subject_filter() 
{
  // _session();
  $.ajax({
    url: window.location.origin + "/office-of-admissions/faculty/subject_filter",
    type:"POST",
    dataType: 'JSON',
    data: { semid: $('#semester option:selected').val() },
    beforeSend: function ()
    {
      $('#status-loading').html('<span class="loader"></span>');
    },
    success: function(data)
    {
      $('#subject_filter').html(data.content);
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

function remove_to_my_loads(email, schedid, semid, row, status) 
{
  // $('#teaching_loads').DataTable().cell((row-1),1).data('<button class="btn btn-lg btn-primary waves-effect" onclick="add_to_my_loads(\''+email+'\', \''+schedid+'\', \''+semid+'\', \''+row+'\', \''+email+'\', \''+status+'\')">ADD TO MY LOADS</button>');
  console.log(_session());
  // swal({
  //   title: 'Are your sure?',
  //   text: '',
  //   type: "info",
  //   allowOutsideClick: false,
  //   allowEscapeKey: false,
  //   confirmButtonText: "REMOVE",
  //   cancelButtonText: "CANCEL",
  //   showCancelButton: true,
  //   allowEscapeKey: false,
  //   allowOutsideClick: false,
  //   closeOnConfirm: false
  // }, function (isConfirm) 
  // {
  //     if (isConfirm) 
  //     {
  //       // window.location = "https://oad.clsu2.edu.ph/user-login/";
  //       // _session();
  //       $.ajax({
  //         url: window.location.origin + "/office-of-admissions/faculty/remove_to_my_loads",
  //         type:"POST",
  //         dataType: 'JSON',
  //         data: { email: email, schedid: schedid, semid: semid, status: status},
  //         beforeSend: function ()
  //         {
  //           $('#status-loading').html('<span class="loader"></span>');
  //         },
  //         success: function(data)
  //         {
  //           swal(data.msg, "", data.icon);
  //           if (data.sys_msg == 1) 
  //           {
  //             $('#teaching_loads').DataTable().cell((row-1),1).data('<button class="btn btn-lg btn-primary waves-effect" onclick="add_to_my_loads(\''+email+'\', \''+schedid+'\', \''+semid+'\', \''+row+'\', \''+status+'\')">ADD TO MY LOADS</button>');
  //             $('#teaching_loads').DataTable().cell((row-1),11).data(status);
  //             $('#teaching_loads').DataTable().draw(false);
  //             // swal(data.msg, "No data, please try again", data.icon);
  //           }
  //         },
  //         complete: function () 
  //         {
  //           $('#status-loading').html('');
  //         },
  //         error: function (jqXHR, textStatus, errorThrown) 
  //         {
  //           swal("Something went wrong!!!", "No data, please try again", "error");
  //         }
  //       });
  //     } 
  // });
}

function add_to_my_loads(email, schedid, semid, row, status) 
{
  // $('#teaching_loads').DataTable().cell((row-1),1).data('<button class="btn btn-lg btn-danger waves-effect" onclick="remove_to_my_loads(\''+email+'\', \''+schedid+'\', \''+semid+'\', \''+row+'\')">REMOVE TO MY LOADS</button>');
  console.log(_session());
  // swal({
  //   title: 'Are your sure?',
  //   text: '',
  //   type: "info",
  //   allowOutsideClick: false,
  //   allowEscapeKey: false,
  //   confirmButtonText: "ADD",
  //   cancelButtonText: "CANCEL",
  //   showCancelButton: true,
  //   allowEscapeKey: false,
  //   allowOutsideClick: false,
  //   closeOnConfirm: false
  // }, function (isConfirm) 
  // {
  //     if (isConfirm) 
  //     {
  //       // window.location = "https://oad.clsu2.edu.ph/user-login/";
  //       // _session();
  //       $.ajax({
  //         url: window.location.origin + "/office-of-admissions/faculty/add_to_my_loads",
  //         type:"POST",
  //         dataType: 'JSON',
  //         data: { email: email, schedid: schedid, semid: semid, status: status},
  //         beforeSend: function ()
  //         {
  //           $('#status-loading').html('<span class="loader"></span>');
  //         },
  //         success: function(data)
  //         {
  //           swal(data.msg, "", data.icon);
  //           if (data.sys_msg == 1) 
  //           {
  //             $('#teaching_loads').DataTable().cell((row-1),1).data('<button class="btn btn-lg btn-danger waves-effect" onclick="remove_to_my_loads(\''+email+'\', \''+schedid+'\', \''+semid+'\', \''+row+'\', \''+status+'\')">REMOVE TO MY LOADS</button>');
  //             $('#teaching_loads').DataTable().cell((row-1),11).data(email);
  //             $('#teaching_loads').DataTable().draw(false);
  //             // swal(data.msg, "No data, please try again", data.icon);
  //           }
  //         },
  //         complete: function () 
  //         {
  //           $('#status-loading').html('');
  //         },
  //         error: function (jqXHR, textStatus, errorThrown) 
  //         {
  //           swal("Something went wrong!!!", "No data, please try again", "error");
  //         }
  //       });
  //     } 
  // });
}

function test() 
{
  $('#student_grades').DataTable();
  // $(this).parents('tr').data()[2].text('helloooo')
 
  $('#student_grades').DataTable().cell(1,2).data('<button class="btn btn-lg btn-primary waves-effect" onclick="remove_to_my_loads(email, schedid, semid, row)">REMOVE TO MY LOADS</button>');
  // console.log($('#student_grades').DataTable());
  // redraw table and keep current pagination
  $('#student_grades').DataTable().draw(false);
}