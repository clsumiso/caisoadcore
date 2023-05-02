var MyGlobalObject={};
var currentlyHovered;

function gradesAnlyticsPieChart(semesterID)
{

    if(MyGlobalObject["gradesAnlyticsPieChart"])
    {   //check if exist chart dispose that
        MyGlobalObject["gradesAnlyticsPieChart"].dispose()
    }
    
    // // Create root element
    // // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("gradesAnlyticsPieChart");

    var myTheme = am5.Theme.new(root);

    myTheme.rule("Grid", ["base"]).setAll({
        strokeOpacity: 0.1
    }); 
    
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root),
        myTheme
    ]);

    MyGlobalObject["gradesAnlyticsPieChart"]=root;

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX: true,
        })
    );
    
    
    // Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX: true
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
xRenderer.labels.template.setAll({
  rotation: -90,
  centerY: am5.p50,
  centerX: am5.p100,
  paddingRight: 15
});

xRenderer.grid.template.setAll({
  location: 1
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  maxDeviation: 0.3,
  categoryField: "cat_no",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  })
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "value",
  sequencedInterpolation: true,
  categoryXField: "cat_no",
  tooltip: am5.Tooltip.new(root, {
    labelText: "{valueY}"
  })
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
series.columns.template.adapters.add("fill", function(fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

series.columns.template.adapters.add("stroke", function(stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});


// Set data
// var data = [{
//   cat_no: "USA",
//   value: 2.5
// }, {
//   cat_no: "China",
//   value: 1.24
// }];

        // xAxis.data.setAll(data);
        // series.data.setAll(data);


        // // Make stuff animate on load
        // // https://www.amcharts.com/docs/v5/concepts/animations/
        // series.appear(1000);
        // chart.appear(1000, 100);

        // console.log(data);
// var data = [];
$.ajax({
    url: window.location.origin + "/office-of-admissions/students/gradesPieChart",
    type: "POST",
    data: { semesterID: semesterID },
    dataType: "JSON",
    success: function(response) 
    {
        // for (let index = 0; index < response.length; index++) 
        // {
        //     data.push(response[index]);
        // }
        console.log(response);
        
        xAxis.data.setAll(response);
        series.data.setAll(response);


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
    }
});

    // $.ajax({
    //     url: window.location.origin + "/office-of-admissions/students/gradesPieChart",
    //     type: "POST",
    //     data: { semesterID: semesterID },
    //     dataType: "JSON",
    //     success: function(response) 
    //     {
    //         // for (let index = 0; index < response.length; index++) 
    //         // {
    //         //     data.push(response[index]);
    //         // }
            
    //         yAxis.data.setAll(response);
    //         series.data.setAll(response);
            
    //         // Make stuff animate on load
    //         // https://www.amcharts.com/docs/v5/concepts/animations/
    //         series.appear(1000);
    //         chart.appear(1000, 100);
    //     }
    // });
}
  
function handleHover(dataItem, orientation) 
{
    if (dataItem && currentlyHovered != dataItem) {
    handleOut(orientation);
    currentlyHovered = dataItem;
    var bullet = dataItem.bullets[0];
    bullet.animate({
        key: orientation,
        to: 1,
        duration: 600,
        easing: am5.ease.out(am5.ease.cubic)
    });
    }
}

function handleOut(orientation) 
{
    if (currentlyHovered) {
    var bullet = currentlyHovered.bullets[0];
    bullet.animate({
        key: orientation,
        to: 0,
        duration: 600,
        easing: am5.ease.out(am5.ease.cubic)
    });
    }
}