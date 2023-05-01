const clusters = _clusters_data();
let year = new Date().getFullYear();

//Vertical form basic
$('#wizard_vertical').steps({
    headerTag: 'h2',
    bodyTag: 'section',
    transitionEffect: 'slideLeft',
    stepsOrientation: 'vertical',
    onInit: function (event, currentIndex) {
        setButtonWavesEffect(event);
    },
    onStepChanged: function (event, currentIndex, priorIndex) {
        setButtonWavesEffect(event);
    },
    onFinished: function (event, currentIndex)
    {
        let err = "";
        if (_validation()[0][0]['basic_information'].length > 0 || _validation()[0][1]['educational_background'].length > 0 || _validation()[0][2]['reference'].length > 0 || _validation()[0][3]['other'].length > 0 || _validation()[0][4]['attachment'].length > 0)
        {
            err += "<ul class='align-left' style='list-style: none;'>";

            if (_validation()[0][0]['basic_information'].length > 0)
            {
                err += "<li><h5>Basic Information</h5></li>";
                err += "<ul class='align-left' style='list-style: square;'>";
                for (let index = 0; index < _validation()[0][0]['basic_information'].length; index++) 
                {
                    err += "<li>"+_validation()[0][0]['basic_information'][index]+"</li>";
                }
                err += "</ul>";
            }

            if (_validation()[0][1]['educational_background'].length > 0)
            {
                err += "<li><h5>Educational Background</h5></li>";
                err += "<ul class='align-left' style='list-style: square;'>";
                for (let index = 0; index < _validation()[0][1]['educational_background'].length; index++) 
                {
                    err += "<li>"+_validation()[0][1]['educational_background'][index]+"</li>";
                }
                err += "</ul>";
            }

            if (_validation()[0][2]['reference'].length > 0)
            {
                err += "<li><h5>Reference</h5></li>";
                err += "<ul class='align-left' style='list-style: square;'>";
                for (let index = 0; index < _validation()[0][2]['reference'].length; index++) 
                {
                    err += "<li>"+_validation()[0][2]['reference'][index]+"</li>";
                }
                err += "</ul>";
            }

            if (_validation()[0][3]['other'].length > 0)
            {
                err += "<li><h5>Other</h5></li>";
                err += "<ul class='align-left' style='list-style: square;'>";
                for (let index = 0; index < _validation()[0][3]['other'].length; index++) 
                {
                    err += "<li>"+_validation()[0][3]['other'][index]+"</li>";
                }
                err += "</ul>";
            }

            if (_validation()[0][4]['attachment'].length > 0)
            {
                err += "<li><h5>Attachment</h5></li>";
                err += "<ul class='align-left' style='list-style: square;'>";
                for (let index = 0; index < _validation()[0][4]['attachment'].length; index++) 
                {
                    err += "<li>"+_validation()[0][4]['attachment'][index]+"</li>";
                }
                err += "</ul>";
            }
            
            err += "</ul>";

            $("#errContent").html(err);
            $("#errModal").modal('show');
        }else
        {
            swal({
                title: "Are you sure?",
                text: "Your application will be forwarded to the reference you specified",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) 
                {
                    // Get form
                    var form = $('#applicationForm')[0];
            
                    // Create an FormData object 
                    var data = new FormData(form);

                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: window.location.origin + "/office-of-admissions/admission_application/submitApplication",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "JSON",
                        success: function (data) 
                        {
                            swal({
                                title: data.sys_msg.toUpperCase(),
                                text: data.msg,
                                type: data.type,
                                showCancelButton: true,
                                confirmButtonText: "Submit",
                                cancelButtonText: "Cancel",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            }, function (isConfirm) 
                            {
                                if (isConfirm)
                                {
                                    $("#applicationForm")[0].reset();
                                    window.open(window.location.origin + "/office-of-admissions/grad-admission-verification", "_SELF");
                                }
                            });
                            
                        },
                        error: function (e) 
                        {
                            swal("System Message", e.responseText, "error");
                        }
                    });
                } 
            });
        }
    }
});


function _validation()
{
    let err = [];
    let errData = [];
    let basic_information = [];
    let educational_background = [];
    let reference = [];
    let other = [];
    let attachment = [];
    var emailReg = /^([\w-.]+@([\w-]+.)+[\w-]{2,4})?$/;
    var emailblockReg = /^([\w-.]+@(?!gmail\.com)(?!yahoo\.com)(?!hotmail\.com)([\w-]+.)+[\w-]{2,4})?$/;

    if (!$("[name='question_1']").is(":checked"))
    {
       basic_information.push("Are you currently enrolled in a degree program in CLSU or in other higher education institution? is <b class='col-red'>required!!!</b>");
    }

    if (!$("[name='question_2']").is(":checked"))
    {
       basic_information.push("Were you previously enrolled in a gradate program in CLSU (including DOT-Uni)? is <b class='col-red'>required!!!</b>");
    }

    if (!$("[name='question_3']").is(":checked"))
    {
       basic_information.push("Degree Program Applied for is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_4']").val() == "")
    {
       basic_information.push("Field of study is <b class='col-red'>required!!!</b>");
    }

    if (!$("[name='question_5']").is(":checked"))
    {
       basic_information.push("Title (Mr, Ms, or Mrs) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_6']").val() == "")
    {
       basic_information.push("Family Name is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_7']").val() == "")
    {
       basic_information.push("First Name is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_9']").val() == "")
    {
       basic_information.push("(House No., Street Name, Building) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_10'] option:selected").val() == "#")
    {
       basic_information.push("Region is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_11'] option:selected").val() == "#")
    {
       basic_information.push("Province is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_12'] option:selected").val() == "#")
    {
       basic_information.push("Municipality is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_13'] option:selected").val() == "#")
    {
       basic_information.push("Barangay is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_14']").val() == "")
    {
       basic_information.push("(Postal/Zip Code) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_15']").val() == "")
    {
       basic_information.push("(Country) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_16']").val() == "")
    {
       basic_information.push("(Email Address) is <b class='col-red'>required!!!</b>");
    }

    if (!emailReg.test($("[name='question_16']").val()))
    {
        basic_information.push("Invalid email address <b class='col-red'>*required</b>");
    }else
    {
        if(!emailblockReg.test($("[name='question_16']").val()))
        {
            basic_information.push("Please use a corporate email address <b class='col-red'>*required</b>");
        }
    }

    if ($("[name='question_17']").val() == "")
    {
       basic_information.push("(Mobile Phone Number) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_18']").val() == "")
    {
       basic_information.push("(Citizenship) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_19']").val() == "")
    {
       basic_information.push("(Present occupation or position) is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_20']").val() == "")
    {
       basic_information.push("(Name & Address of Employment) is <b class='col-red'>required!!!</b>");
    }

    // if ($("[name='question_23']").val() == "")
    // {
    //    other.push("(Field and Areas of Interes) is <b class='col-red'>required!!!</b>");
    // }

    if (!$("[name='question_26']").is(":checked"))
    {
        other.push("Have you previously applied for admission to a graduate program in CLSU? is <b class='col-red'>required!!!</b>");
    }

    if ($("[name='question_26']").is(":checked"))
    {
        if ($("[name='question_26']:checked").val() == "true")
        {
            if ($("[name='question_27']").val() == "")
            {
                other.push("Please specify the date you previously applied for admission to a graduate program in CLSU? is <b class='col-red'>required!!!</b>");
            }
        }
        
    }

    if (!$("[name='question_34']").is(":checked"))
    {
        other.push("Semester is <b class='col-red'>required!!!</b>");
    }

    if (!$("[name='question_35']").is(":checked"))
    {
        other.push("I certify that the information submitted in this application form is accurate is <b class='col-red'>required!!!</b>");
    }

    let question_21_val = $("[name='question_21[]']").map(function(){
        return $(this).val();
    });

    let question_22_val = $("[name='question_22[]']").map(function(){
        return $(this).val();
    });

    /**
     * Educational Background validation
     */
    let question_21 = getObject(question_21_val);

    if (question_21.length <= 0)
    {
        educational_background.push("Please specify College/University Attended Beyond High School <b class='col-red'>*required</b>");
    }
    
    if (question_21.length > 0)
    {
        if (question_21.length % 4 != 0)
        {
            educational_background.push("Please specify College/University Attended Beyond High School <b class='col-red'>*please complete all fields!!!</b>");
        }
    }
    /**
     * End of Educational Background validation
     */

    /**
     * Reference validation
     */
    let question_22 = getObject(question_22_val);

    if (question_22.length <= 0)
    {
        reference.push("Please specify your references <b class='col-red'>*required</b>");
    }

    if (question_22.length > 0)
    {
        if ($("[name='question_3']:checked").val() == "master")
        {
            if (question_22.length < 12) 
            {
                reference.push("Your applying for Master's Degree program. Please specify two (2) references <b class='col-red'>*required</b>");
            }else
            {
                if (!emailReg.test(question_22[4]) || !emailReg.test(question_22[10]))
                {
                    reference.push("Invalid email address <b class='col-red'>*required</b>");
                }else
                {
                    if(!emailblockReg.test(question_22[4]) || !emailblockReg.test(question_22[10]))
                    {
                        reference.push("Please use a corporate email address <b class='col-red'>*required</b>");
                    }
                }
            }
        }else if ($("[name='question_3']:checked").val() == "phd")
        {
            if (question_22.length < 18) 
            {
                reference.push("Your applying for PhD Degree program. Please specify three (3) references <b class='col-red'>*required</b>");
            }else
            {
                if (!emailReg.test(question_22[4]) || !emailReg.test(question_22[10]) || !emailReg.test(question_22[16]))
                {
                    reference.push("Invalid email address <b class='col-red'>*required</b>");
                }else
                {
                    if(!emailblockReg.test(question_22[4]) || !emailblockReg.test(question_22[10]) || !emailblockReg.test(question_22[16]))
                    {
                        reference.push("Please use a corporate email address <b class='col-red'>*required</b>");
                    }
                }
            }
        }

        if (question_22.length % 6 != 0)
        {
            reference.push("Reference information <b class='col-red'>*please complete all fields!!!</b>");
        }
    }
    
    /**
     * End of Reference validation
     */

    if ($("#torFile").val() == "")
    {
        attachment.push("Transcript of Records (TOR) is <b class='col-red'>required!!!</b>");
    }else if ($("#torFile").val() != "")
    {
        if (_validateFile($("#torFile")) === false)
        {
            attachment.push("Transcript of Records (TOR) <b class='col-red'>invalid FILE Type!!!</b>");
        }
    }

    if ($("#gwaFile").val() == "")
    {
        attachment.push("Certificate of Point Average from your previous school (GWA) is <b class='col-red'>required!!!</b>");
    }else if ($("#gwaFile").val() != "")
    {
        if (_validateFile($("#gwaFile")) === false)
        {
            attachment.push("Certificate of Point Average from your previous school (GWA) <b class='col-red'>invalid FILE Type!!!</b>");
        }
    }

    if ($("#pictureFile").val() == "")
    {
        attachment.push("2x2 Passport Size Picture is <b class='col-red'>required!!!</b>");
    }else if ($("#pictureFile").val() != "")
    {
        if (_validateFile($("#pictureFile")) === false)
        {
            attachment.push("2x2 Passport Size Picture <b class='col-red'>invalid FILE Type!!!</b>");
        }
    }


    errData = [
        { "basic_information"       :   basic_information },
        { "educational_background"  :   educational_background },
        { "reference"               :   reference },
        { "other"                   :   other },
        { "attachment"              :   attachment }
    ]

    err.push(errData);
    // console.log(question_21.length % 4);

    return err;
}

function _validateFile(dom)
{
    /* current this object refer to input element */
    var $input = $(dom);

    /* collect list of files choosen */
    var files = $input[0].files;

    var filename = files[0].name;

    /* getting file extenstion eg- .jpg,.png, etc */
    var extension = filename.substr(filename.lastIndexOf("."));

    /* define allowed file types */
    // var allowedExtensionsRegx = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    var allowedExtensionsRegx = ""
    if (dom.attr("id") == "torFile") 
    {
        allowedExtensionsRegx = /(\.pdf)$/i;
    }else if (dom.attr("id") == "gwaFile")
    {
        allowedExtensionsRegx = /(\.pdf)$/i;
    }else if (dom.attr("id") == "pictureFile")
    {
        allowedExtensionsRegx = /(\.jpg|\.jpeg)$/i;
    }
    

    /* testing extension with regular expression */
    var isAllowed = allowedExtensionsRegx.test(extension);

    if(isAllowed)
    {
        /* file upload logic goes here... */
        return true;
    }else
    {
        // swal({
        //     title: "Office of Admissions",
        //     text: "Invalid File Type",
        //     type: "error"
        // });
        return false;
    }
}

function getObject(dataVal)
{
    let tmpData = [];
    for (let index = 0; index < dataVal.get().length; index++) 
    {
        if (dataVal.get(index) != "")
        {
            tmpData.push(dataVal.get(index));
        }
    }

    return tmpData;
}

function wordCount(value)
{
    return value.split(' ').length;
}

// Set school year advance 10 years
for (let index = parseInt(year); index < parseInt(year) + 10; index++) 
{
    $('[name="question_33"]').append("<option value="+index+">"+index+"</option>");
}

$('input[type=radio][name="question_26"]').change(function() {
    // console.log($('input[type=radio][name="question_26"]:checked').val());
    if ($('input[type=radio][name="question_26"]:checked').val() == "true") 
    {
        $('#question_27_container').css("display", "block");
    }else
    {
        $('#question_27_container').css("display", "none");
    }
});

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

function setButtonWavesEffect(event) 
{
    $(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
    $(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
}

function _region() 
{
    let html_content = '';
    let region_arr = new Array();
    for(let x in clusters)
    {
        region_arr.push(clusters[x].region_name);
        // html_content += '<option value="'+clusters[x].region_name+'">'+clusters[x].region_name+'</option>';
    }
    region_arr.sort();
    html_content += '<option value="#">-- SELECT REGION --</option>';
    for(let i = 0; i < region_arr.length; i++)
    {
        html_content += '<option value="'+region_arr[i]+'">'+region_arr[i]+'</option>';
    }
    // console.log(clusters['0']);
    $('#region').html(html_content).trigger('change');
}
  
function _province() 
{
    // alert($('#region option:selected').val());
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="#">-- SELECT PROVINCE --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('#region option:selected').val()) 
        {
            // html_content += '<option value="'+clusters[x].province_list+'">'+clusters[x].province_list+'</option>';
            for (let i in clusters[x].province_list)
            {
                html_content += '<option value="'+i+'">'+i+'</option>';
            }
        }
    }

    $('#province').html(html_content).trigger('change');
}

function _municipality() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="#">-- SELECT MUNICIPALITY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('#region option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('#province option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        html_content += '<option value="'+z+'">'+z+'</option>';
                    }
                }
            }
        }
    }

    $('#municipality').html(html_content).trigger('change');
}

function _barangay() 
{
    let html_content = '';
    let region_arr = new Array();
    html_content += '<option value="#">-- SELECT BARANGAY --</option>';
    for(let x in clusters)
    {
        if (clusters[x].region_name == $('#region option:selected').val()) 
        {
            for (let i in clusters[x].province_list)
            {
                if (i == $('#province option:selected').val()) 
                {
                    for(let z in clusters[x].province_list[i].municipality_list)
                    {
                        if (z == $('#municipality option:selected').val()) 
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

    $('#barangay').html(html_content);
}