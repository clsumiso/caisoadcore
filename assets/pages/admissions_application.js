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
        _validation();
    }
});

function _validation()
{
    if (!$("[name='question']").is(":checked"))
    {
        // alert("is required");
        return false;
    }
    return false;
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