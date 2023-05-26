const clusters = _clusters_data();
let year = new Date().getFullYear();

function getApplicantInfo(appID)
{
    $.ajax({
        url: window.location.origin + "/office-of-admissions/applicant/applicantInfo",
        type:"POST",
        dataType: 'JSON',
        data: 
        { 
            "appID" :	appID
        },
        beforeSend: function ()
        {
            // $('#saveApplicantPreload').html('<span class="loader1"></span>');
            $('.fullscreen-loading').css("display", "block");
        },
        success: function(data)
        {
            $('.applicantID').html(data.profile.appID);
            $('.releaseDate').html(data.profile.releaseDate);
            $('.name').html(data.profile.name);
            $('.course').html(data.profile.program);
            $('.dateFrom').html(data.profile.dateFrom);
            $('.dateTo').html(data.profile.dateTo);
            $('.program_for_other_qualifier').html(data.profile.nonqoutaprograms);
            
            // swal({
            //     title: "Office of Admissions",
            //     text: data.msg,
            //     type: data.icon
            // });
            // $("#applicantInfoForm")[0].reset();
            // $('#applicant_info_modal').modal('toggle');;
            // applicantData.draw();
        },
        complete: function () 
        {
            // $('#saveApplicantPreload').html('');
            $('.fullscreen-loading').css("display", "none");
        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            
        }
    });
}

function updateIndividualForm(appID, securityCode)
{
    swal({
        title: 'Important Notice',
        text: '<h3>Please do review and update your profile information. Kindly fill-out all the required fields. Thank you.</h3>',
        type: "info",
        html: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: "PROCEED TO UPDATE",
        cancelButtonText: "CANCEL",
        showCancelButton: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false
    }, function (isConfirm) 
    {
        if (isConfirm) 
        {
            window.open(window.location.origin + "/office-of-admissions/app-update-form/"+appID+"/"+securityCode, "_SELF");
        }
    });
}

$("#signatories1").change(function() {
    if(this.checked) 
    {
        $("#signatories2").prop("checked", false);
        $("#signatories3").prop("checked", false);
    }
});

$("#signatories2").change(function() {
    if(this.checked) 
    {
        $("#signatories1").prop("checked", false);
        $("#signatories3").prop("checked", false);
    }
});

$("#signatories3").change(function() {
    if(this.checked) 
    {
        $("#signatories1").prop("checked", false);
        $("#signatories2").prop("checked", false);
    }
});

$('[name="gender"]').click(function() {
    // alert($(this).val());
    if ($(this).val() == "other")
    {
        $('[name="gender6"]').css("display", "block");
    }else
    {
        $('[name="gender6"]').css("display", "none");
    }
});

$('[name="civilStatus"]').click(function() {
    // alert($(this).val());
    if ($(this).val() == "other")
    {
        $('[name="civilStatus4"]').css("display", "block");
    }else
    {
        $('[name="civilStatus4"]').css("display", "none");
    }
});

$('[name="indigenous"]').click(function() {
    // alert($(this).val());
    if ($(this).val() == "yes")
    {
        $('#indigenousType').css("display", "block");
    }else
    {
        $('#indigenousType').css("display", "none");
    }
});

$('#participateActivity13').on('click',function(){
    if(this.checked)
    {
        $('#participateActivity12').css("display", "block");
    }else
    {
        $('#participateActivity12').css("display", "none");
    }
});

if($('#participateActivity13').is(':checked'))
{
    $('#participateActivity12').css("display", "block");
}else
{
    $('#participateActivity12').css("display", "none");
}

function submitForm()
{
    let form = $(this).closest('form');

    form = form.serializeArray();

    form = form.concat([
        { name: "applicant_id", value: _validation($('[name="applicantID"]')) },
        { name: "lastname", value:  _validation($('[name="lastname"]')) },
        { name: "firstname", value:  _validation($('[name="firstname"]')) },
        { name: "middlename", value:  _validation($('[name="middlename"]')) },
        { name: "age", value:  _validation($('[name="age"]')) },
        { name: "sex", value:  _validation($('[name="sex"]')) } 
    ]);

    console.log(form);
}

function _validation(htmlDOM)
{
    console.log(htmlDOM);
    // if ($.inArray(htmlDOM.attr('type'), ["text", "number"]) !== 1)
    // {
    //     if (htmlDOM.val() == "")
    //     {
    //         swal({
    //             title: "Office of Admissions",
    //             text: htmlDOM.attr('placeholder') + " is required!!!",
    //             type: "error"
    //         });
    //     }else
    //     {
    //         return htmlDOM.val();
    //     }

    // }else if ($.inArray(htmlDOM.attr('type'), ["checkbox"]) !== 1)
    // {
    //     console.log(htmlDOM.attr('type'));
    // }else if ($.inArray(htmlDOM.attr('type'), ["radio"]) !== 1)
    // {
    //     return htmlDOM.attr('type');
    // }else
    // {
    //     console.log(htmlDOM.attr('type'));
    // }
}

function _getObject(obj)
{

}

function _clusters_data() 
{
    let cluster = new Array();
    $.ajax({
        "url": window.location.origin + '/office-of-admissions/assets/clusters.json',
        "dataType": 'JSON',
        "success": function (data) {
            for (let x in data){
                cluster.push(data[x]);
            }
        }
    })
    return cluster;
}

function populateYear()
{
    $htmlData = '<option value="">-- SELECT YEAR --</option>';
    for (let index = parseInt(year, 10); index >= 1990; index--) 
    {
        $htmlData += '<option value='+index+'>'+index+'</option>';
    }
    $('[name="highSchoolYearGraduated"]').html($htmlData);
}populateYear();

function _region1() 
{
    let html_content = '';
    let region_arr = new Array();
    for(let x in clusters)
    {
        region_arr.push(clusters[x].region_name);
        // html_content += '<option value="'+clusters[x].region_name+'">'+clusters[x].region_name+'</option>';
    }
    region_arr.sort();
    html_content += '<option value="">-- SELECT REGION --</option>';
    for(let i = 0; i < region_arr.length; i++)
    {
        html_content += '<option value="'+region_arr[i]+'">'+region_arr[i]+'</option>';
    }
    // console.log(clusters['0']);
    $('.region1').html(html_content).trigger('change');
}
  
function _province1() 
{
    // alert($('#region option:selected').val());
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT PROVINCE --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region1 option:selected').val()) 
        {
            // html_content += '<option value="'+clusters[x].province_list+'">'+clusters[x].province_list+'</option>';
            for (let i in clusters[x].province_list)
            {
                html_content += '<option value="'+i+'">'+i+'</option>';
            }
        }
    }

    $('.province1').html(html_content).trigger('change');
}

function _municipality1() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT MUNICIPALITY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region1 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province1 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        html_content += '<option value="'+z+'">'+z+'</option>';
                    }
                }
            }
        }
    }

    $('.municipality1').html(html_content).trigger('change');
}

function _barangay1() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT BARANGAY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region1 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province1 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        if (z == $('.municipality1 option:selected').val()) 
                        {
                            for(let y = 0; y < clusters[x].province_list[i].municipality_list[z].barangay_list.length; y++)
                            {
                                html_content += '<option value="'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'">'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'</option>';
                            }
                        }
                    }
                }
            }
        }
    }

    $('.barangay1').html(html_content);
}

function _region2() 
{
    let html_content = '';
    let region_arr = new Array();
    for(let x in clusters)
    {
        region_arr.push(clusters[x].region_name);
        // html_content += '<option value="'+clusters[x].region_name+'">'+clusters[x].region_name+'</option>';
    }
    region_arr.sort();
    html_content += '<option value="">-- SELECT REGION --</option>';
    for(let i = 0; i < region_arr.length; i++)
    {
        html_content += '<option value="'+region_arr[i]+'">'+region_arr[i]+'</option>';
    }
    // console.log(clusters['0']);
    $('.region2').html(html_content).trigger('change');
}
  
function _province2() 
{
    // alert($('#region option:selected').val());
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT PROVINCE --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region2 option:selected').val()) 
        {
            // html_content += '<option value="'+clusters[x].province_list+'">'+clusters[x].province_list+'</option>';
            for (let i in clusters[x].province_list)
            {
                html_content += '<option value="'+i+'">'+i+'</option>';
            }
        }
    }

    $('.province2').html(html_content).trigger('change');
}

function _municipality2() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT MUNICIPALITY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region2 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province2 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        html_content += '<option value="'+z+'">'+z+'</option>';
                    }
                }
            }
        }
    }

    $('.municipality2').html(html_content).trigger('change');
}

function _barangay2() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT BARANGAY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region2 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province2 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        if (z == $('.municipality2 option:selected').val()) 
                        {
                            for(let y = 0; y < clusters[x].province_list[i].municipality_list[z].barangay_list.length; y++)
                            {
                                html_content += '<option value="'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'">'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'</option>';
                            }
                        }
                    }
                }
            }
        }
    }

    $('.barangay2').html(html_content);
}

function _region3() 
{
    let html_content = '';
    let region_arr = new Array();
    for(let x in clusters)
    {
        region_arr.push(clusters[x].region_name);
        // html_content += '<option value="'+clusters[x].region_name+'">'+clusters[x].region_name+'</option>';
    }
    region_arr.sort();
    html_content += '<option value="">-- SELECT REGION --</option>';
    for(let i = 0; i < region_arr.length; i++)
    {
        html_content += '<option value="'+region_arr[i]+'">'+region_arr[i]+'</option>';
    }
    // console.log(clusters['0']);
    $('.region3').html(html_content).trigger('change');
}
  
function _province3() 
{
    // alert($('#region option:selected').val());
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT PROVINCE --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region3 option:selected').val()) 
        {
            // html_content += '<option value="'+clusters[x].province_list+'">'+clusters[x].province_list+'</option>';
            for (let i in clusters[x].province_list)
            {
                html_content += '<option value="'+i+'">'+i+'</option>';
            }
        }
    }

    $('.province3').html(html_content).trigger('change');
}

function _municipality3() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT MUNICIPALITY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region3 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province3 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        html_content += '<option value="'+z+'">'+z+'</option>';
                    }
                }
            }
        }
    }

    $('.municipality3').html(html_content).trigger('change');
}

function _barangay3() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="">-- SELECT BARANGAY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('.region3 option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('.province3 option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        if (z == $('.municipality3 option:selected').val()) 
                        {
                            for(let y = 0; y < clusters[x].province_list[i].municipality_list[z].barangay_list.length; y++)
                            {
                                html_content += '<option value="'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'">'+clusters[x].province_list[i].municipality_list[z].barangay_list[y]+'</option>';
                            }
                        }
                    }
                }
            }
        }
    }

    $('.barangay3').html(html_content);
}

function data_privacy(applicantID) 
{
    $.ajax({
        url: window.location.origin + '/office-of-admissions/applicant/check_data_privacy',
        type: "POST",
        data: { uid: applicantID, vaccine: $('[name="vaccine"] option:selected').val() },
        dataType: "JSON",
        success: function (privacy_data)
        {
            // console.log(privacy_data); 
            if (privacy_data.confirm == 0) 
            {
                $('#data_privacy').modal(
                {
                    backdrop: 'static', 
                    keyboard: false
                }, 
                'show');
            }else
            {
                window.open(window.location.origin + "/office-of-admissions/app-enrollment-form/"+applicantID, "_self");
            }
        },
        complete: function () 
        {

        },
        error: function (jqXHR, textStatus, errorThrown) 
        {
            swal({
                title: "Office of Admissions",
                text: "Something went wrong, please try again.",
                type: "info"
            });
        }
    });
    // $.ajax({
    //       url: window.location.origin + '/office-of-admissions/applicant/check_data_privacy',
    //       type: "POST",
    //       data: { uid: applicant },
    //       dataType: "JSON",
    //       success: function (privacy_data){
    //         // console.log(privacy_data); 
    //         if (privacy_data.confirm == 0) {
    //             Swal.fire({
    //                 icon: 'info',
    //                 title: '<h1>Data Privacy</h1>',
    //                 html: '<p style="text-align: left;">The Office of Admissions (OAd) is committed to ensure that your data privacy rights are upheld and protected.  Please read our full Data Privacy Notice from our website: <a href="https://oad.clsu2.edu.ph/data-privacy/" target="_blank">https://oad.clsu2.edu.ph/data-privacy/</a> before proceeding with your registration.</p>',
    //                 input: 'checkbox',
    //                 inputAttributes: {
    //                     checked: false
    //                 },
    //                 width: '600px',
    //                 showCancelButton: false,
    //                 allowOutsideClick: false,
    //                 allowEscapeKey: false,
    //                 inputPlaceholder: '<p style="text-align: left;">I confirm that I have read the data privacy notice of the OAd and I understand it.  I give OAd my permission to collect and process my personal information, including sharing them for legitimate purposes, as described in the said notice.</p><br><br><p>For data privacy concerns, please contact us at <br> oad-privacy@clsu2.edu.ph.</p>',
    //                 confirmButtonText: 'Confirm & Continue <i class="fa fa-arrow-right"></i>',
    //                 inputValidator: (result) => {
    //                     return !result && 'You need to confirm. Please click the checkbox.'
    //                 }
    //             }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     $.ajax({
    //                         url: window.location.origin + '/office-of-admissions/applicant/agree_to_data_privacy',
    //                         type: "POST",
    //                         data: { uid: applicant },
    //                         dataType: "JSON",
    //                         success: function (privacy_data){
    //                             // console.log(privacy_data); 
    //                             window.open(window.location.origin + "/office-of-admissions/app-enrollment-form/"+applicant, "_self");
    //                         },
    //                         complete: function () {
    
    //                         },
    //                         error: function (jqXHR, textStatus, errorThrown) {
    //                             Swal.fire({
    //                                 icon: 'warning',
    //                                 title: 'Something went wrong!!!'+errorThrown,
    //                                 text: 'Please try again.',
    //                                 showConfirmButton: true,
    //                                 confirmButtonText: 'Refresh',
    //                                 allowOutsideClick: false,
    //                                 allowEscapeKey: false,
    //                             }).then((res) => {
    //                                 if (res.isConfirmed) {
    //                                     window.open("https://ctec.clsu2.edu.ph/clsucat/", "_self");
    //                                 }
    //                             });
    //                         }
    //                     });
    //                 // window.open('admissions-enrollment', '_top');
    //                 }
    //             })
    //         }
    //       },
    //       complete: function () {

    //       },
    //       error: function (jqXHR, textStatus, errorThrown) {
    //           Swal.fire({
    //               icon: 'warning',
    //               title: 'Something went wrong!!!'+errorThrown,
    //               text: 'Please try again.',
    //               showConfirmButton: true,
    //               confirmButtonText: 'Refresh',
    //               allowOutsideClick: false,
    //               allowEscapeKey: false,
    //           }).then((res) => {
    //                 if (res.isConfirmed) {
    //                     window.open("https://ctec.clsu2.edu.ph/clsucat/", "_self");
    //                 }
    //           });
    //       }
    //   });
}

function submitDataPrivacy(applicantID)
{
    if ($("#chkDataPrivacy1").is(":checked"))
    {
        $.ajax({
            url: window.location.origin + '/office-of-admissions/applicant/agree_to_data_privacy',
            type: "POST",
            data: { uid: applicantID, vaccine: $('[name="vaccine"] option:selected').val() },
            dataType: "JSON",
            success: function (privacy_data){
                // console.log(privacy_data); 
                window.open(window.location.origin + "/office-of-admissions/app-enrollment-form/"+applicantID, "_self");
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
    }else
    {
        swal({
            title: "Office of Admissions",
            text: "You need to confirm. Please click the checkbox.",
            type: "info"
        });
    }
}