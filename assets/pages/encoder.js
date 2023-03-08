// function studentEnrollment() 
// {
// 	$.ajax({
//       	url: window.location.origin + "/office-of-admissions/encoder/enrollment_components",
//       	type:"POST",
//       	dataType: 'JSON',
//       	data: { data: $('#studid').val() },
//       	beforeSend: function ()
//       	{
//         	$('#status-loading').html('<span class="loader"></span>');
//       	},
//       	success: function(data)
//       	{
//         	if (data.sys_msg == 1) 
//         	{
//           		// table.row('.selected').remove().draw(false);
          	
// 	          	// swal(data.msg, "Office of Admissions", data.icon);
// 	        }else if (data.sys_msg == "no data") 
// 	        {

// 	        }
// 	    },
//       	complete: function () 
//       	{
// 	        $('#status-loading').html('');
//       	},
//       	error: function (jqXHR, textStatus, errorThrown) 
//       	{
//         	swal("Something went wrong!!!", "No data, please try again", "error");
//       	}
//     });
// }

function showSubject() 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/encoder/showSubjects",
        type:"POST",
        dataType: 'JSON',
        data: { studid: $('#studid').val(), filter: $('#subject').val(), section: $('#section option:selected').val() },
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

function studentEnrollment() 
{
	$.ajax({
      	url: window.location.origin + "/office-of-admissions/encoder/enrollment_components",
      	type:"POST",
      	dataType: 'JSON',
      	data: { studid: $('#studid').val(), course: $('#course option:selected').val(), section: $('#section option:selected').val() },
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

function getCourse(collegeID) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/encoder/getCourse",
        type:"POST",
        dataType: 'JSON',
        data: { collegeID: collegeID },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#course').html(data.courseData);
            $('#course').selectpicker('refresh');
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

function getSection(courseID) 
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/encoder/getSection",
        type:"POST",
        dataType: 'JSON',
        data: { courseID: courseID },
        beforeSend: function ()
        {
            $('#status-loading').html('<span class="loader"></span>');
        },
        success: function(data)
        {
            $('#section').html(data.sectionData);
            $('#section').selectpicker('refresh');
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
        url: window.location.origin + "/office-of-admissions/encoder/enrollment_components",
        type:"POST",
        dataType: 'JSON',
        data: { studid: $('#studid').val(), course: $('#course option:selected').val(), section: $('#section option:selected').val() },
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
      	url: window.location.origin + "/office-of-admissions/encoder/subject_enrolled",
      	type:"POST",
      	dataType: 'JSON',
      	data: { studid: $('#studid').val() },
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
            if ($('#college option:selected').val() == -1 || $('#course option:selected').val() == -1 || $('#section option:selected').val() == -1) 
            {
              swal("Office of Admissions", "Please select College, Course or Section.", "warning");
            }else
            {
                $.ajax({
                    url: window.location.origin + "/office-of-admissions/encoder/enroll",
                    type: 'POST',
                    data: { studid: studid, semester: sem, schedid: schedid, section: section },
                    dataType: 'JSON',
                    beforeSend: function ()
                    {
                        $('#status-loading').html('<span class="loader"></span>');
                    },
                    success: function (data)
                    {
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

function remove(studid, sem, schedid) 
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
            if ($('#college option:selected').val() == -1 || $('#course option:selected').val() == -1 || $('#section option:selected').val() == -1) 
            {
              swal("Office of Admissions", "Please select College, Course or Section.", "warning");
            }else
            {
                $.ajax({
                    url: window.location.origin + "/office-of-admissions/encoder/removeEnroll",
                    type: 'POST',
                    data: { studid: studid, semester: sem, schedid: schedid },
                    dataType: 'JSON',
                    beforeSend: function ()
                    {
                        $('#status-loading').html('<span class="loader"></span>');
                    },
                    success: function (data)
                    {
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