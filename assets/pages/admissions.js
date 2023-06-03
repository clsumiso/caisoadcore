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
    'url': window.location.origin + "/office-of-admissions/admissions/applicantList",
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
        { data: "confirmation_date" }
    ]
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