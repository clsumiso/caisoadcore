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
		'url': window.location.origin + "/office-of-admissions/admissions/graduateLevelList",
		'data': function(data)
		{
			// data.semester = $('#semesterGrades option:selected').val();
			data.status = $('#gradStatus option:selected').val();
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
        { data: "reference" },
        { data: "department_remarks" },
        { data: "dean_remarks" },
        { data: "noa" }
    ],
    "rowCallback": function( row, data, index ) 
	{
		if (data.department == "approved_regular" || data.department == "approved_probationary" && data.dean == "approved")
		{
			$("td", row).css("background-color", "#ffeaa7");
		} else
		{
			if (data.referenceCtr > 1)
			{
				$("td", row).css("background-color", "#2ecc71");
			}
		}
    }
});

$('#gradStatus').change(function () {
	applicantData.draw();
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

function endorsedToDepartment(applicationID)
{
    swal({
        title: 'Are you sure?',
        text: '<p>Please check if all the requirements are complete</p>',
        type: "info",
        html: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "ENDORSED TO DEPARTMENT",
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
                url: window.location.origin + '/office-of-admissions/admissions/departmentEndorse',
                type: "POST",
                data: { appID: applicationID },
                dataType: "JSON",
                success: function (response)
                {
                    // data_privacy(applicantID) 
                    swal({
                        title: "Office of Admissions",
                        text: response.msg,
                        type: response.type
                    });
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

function generateNOA(applicantID = "")
{
    $('#noaModal').modal(
    {
        backdrop: 'static', 
        keyboard: false
    }, 
    'show');
}
