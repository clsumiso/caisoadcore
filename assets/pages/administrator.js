
$(document).ready(function(){

   let scheduleData = $('#scheduleTable').DataTable({
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

   $('#scheduleCount').change(function(){
      console.log($('#scheduleCount option:selected').val());

   });

   let arrDay = ["M_", "T_", "W_", "TH_", "F_", "S_"]; 

});

function updateSchedule(schedid, semester) 
{
   $('#classScheduleModal').modal(
   {
       backdrop: 'static', 
       keyboard: false
   }, 
   'show');

   $('.modal-title').text('Class Scehdule (' + $('#semester option:selected').text() + ")");
}

function saveSchedule()
{
   console.log($('#day1 option:selected').val());
}