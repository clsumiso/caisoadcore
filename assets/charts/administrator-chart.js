var MyGlobalObject={};
var currentlyHovered;

function enrollPerCollege(semester)
{
    if(MyGlobalObject["enrollPerCollege"]){   //check if exist chart dispose that
        MyGlobalObject["enrollPerCollege"].dispose()
    }
    // // Create root element
    // // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("enrollPerCollege");

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    MyGlobalObject["enrollPerCollege"]=root;

    var data = [];

    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/enrollPerCollegeChart",
        type: "POST",
        data: { sem: semester },
        dataType: "JSON",
        success: function(response) 
        {
            for (let index = 0; index < response.length; index++) 
            {
                data.push(response[index]);
            }
            
            series.data.setAll(data);
            xAxis.data.setAll(data);
            
            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear();
            chart.appear(1000, 100);
        }
    });
  
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX: true,
        paddingBottom: 50,
        paddingTop: 40
        })
    );
  
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
  
    var xRenderer = am5xy.AxisRendererX.new(root, {});
    xRenderer.grid.template.set("visible", false);
    
    var xAxis = chart.xAxes.push(
        am5xy.CategoryAxis.new(root, {
        paddingTop:40,
        categoryField: "college",
        renderer: xRenderer
        })
    );
  
  
    var yRenderer = am5xy.AxisRendererY.new(root, {});
    yRenderer.grid.template.set("strokeDasharray", [3]);
    
    var yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
        min: 0,
        renderer: yRenderer
        })
    );
  
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(
            am5xy.ColumnSeries.new(root, {
            name: "Enroll per college",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            categoryXField: "college",
            sequencedInterpolation: true,
            calculateAggregates: true,
            maskBullets: false,
            tooltip: am5.Tooltip.new(root, {
                dy: -30,
                pointerOrientation: "vertical",
                labelText: "{valueY}"
            })
        })
    );
  
    series.columns.template.setAll({
        strokeOpacity: 0,
        cornerRadiusBR: 10,
        cornerRadiusTR: 10,
        cornerRadiusBL: 10,
        cornerRadiusTL: 10,
        maxWidth: 50,
        fillOpacity: 0.8
    });
    
    series.columns.template.events.on("pointerover", function (e) {
        handleHover(e.target.dataItem, "locationY");
    });
    
    series.columns.template.events.on("pointerout", function (e) {
        handleOut("locationY");
    });

    var circleTemplate = am5.Template.new({});
    
    series.bullets.push(function (root, series, dataItem) {
        var bulletContainer = am5.Container.new(root, {});
        var circle = bulletContainer.children.push(
        am5.Circle.new(
            root,
            {
            radius: 34
            },
            circleTemplate
        )
        );
    
        var maskCircle = bulletContainer.children.push(
            am5.Circle.new(root, { radius: 27 })
        );
    
        // only containers can be masked, so we add image to another container
        var imageContainer = bulletContainer.children.push(
            am5.Container.new(root, {
                mask: maskCircle
            })
        );
    
        var image = imageContainer.children.push(
            am5.Picture.new(root, {
                templateField: "pictureSettings",
                centerX: am5.p50,
                centerY: am5.p50,
                width: 60,
                height: 60
            })
        );
    
        return am5.Bullet.new(root, {
            locationY: 0,
            sprite: bulletContainer
        });
    });
  
    // heatrule
    series.set("heatRules", [
        {
        dataField: "valueY",
        min: am5.color(0xe5dc36),
        max: am5.color(0x5faa46),
        target: series.columns.template,
        key: "fill"
        },
        {
        dataField: "valueY",
        min: am5.color(0xe5dc36),
        max: am5.color(0x5faa46),
        target: circleTemplate,
        key: "fill"
        }
    ]);
    
    
  
    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineX.set("visible", false);
    cursor.lineY.set("visible", false);
    
    cursor.events.on("cursormoved", function () {
        var dataItem = series.get("tooltip").dataItem;
        if (dataItem) 
        {
            handleHover(dataItem, "locationY");
        } else 
        {
            handleOut("locationY");
        }
    });
} enrollPerCollege($('#semester option:selected').val());

function enrollPerCourse()
{
    if(MyGlobalObject["enrollPerCourse"])
    {   //check if exist chart dispose that
        MyGlobalObject["enrollPerCourse"].dispose()
    }
    // // Create root element
    // // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("enrollPerCourse");

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

    MyGlobalObject["enrollPerCourse"]=root;

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
    
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var yRenderer = am5xy.AxisRendererY.new(root, { minGridDistance: 30 });
    yRenderer.grid.template.set("location", 1);
    
    var yAxis = chart.yAxes.push(
        am5xy.CategoryAxis.new(root, {
            start: 0.1,
            maxDeviation: 0,
            categoryField: "course",
            renderer: yRenderer
        })
    );
    
    var xAxis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            maxDeviation: 0,
            min: 0,
            renderer: am5xy.AxisRendererX.new(root, {
                visible: true,
                strokeOpacity: 0.1
            })
        })
    );
    
    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            name: "Enroll per course",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "value",
            sequencedInterpolation: true,
            categoryYField: "course",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{valueX}"
            })
        })
    );
    
    var columnTemplate = series.columns.template;
    
    columnTemplate.setAll({
        draggable: false,
        cursorOverStyle: "pointer",
        tooltipText: "drag to rearrange",
        cornerRadiusBR: 10,
        cornerRadiusTR: 10,
        strokeOpacity: 0
    });

    chart.get("colors").set("colors", [
        am5.color("#4caf50"),
    ]);

    columnTemplate.adapters.add("fill", (fill, target) => {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
    });
    
    columnTemplate.adapters.add("stroke", (stroke, target) => {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
    });
    
    // columnTemplate.events.on("dragstop", () => {
    //     sortCategoryAxis();
    // });
    
    // Get series item by category
    // function getSeriesItem(category) {
    //     for (var i = 0; i < series.dataItems.length; i++) {
    //     var dataItem = series.dataItems[i];
    //     if (dataItem.get("categoryY") == category) {
    //         return dataItem;
    //     }
    //     }
    // }
    
    // Set data
    var data = [];

    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/enrollPerCourse",
        type: "POST",
        data: { sem: $("#enrollPerSemFilter option:selected").val(), college: $("#enrollPerSemCollegeFilter option:selected").val() },
        dataType: "JSON",
        success: function(response) 
        {
            for (let index = 0; index < response.length; index++) 
            {
                data.push(response[index]);
            }
            
            yAxis.data.setAll(data);
            series.data.setAll(data);
            
            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

            enrollPerCoursePie();
        }
    });
}enrollPerCourse();

function enrollPerCoursePie()
{

    if(MyGlobalObject["enrollPerCoursePie"])
    {   //check if exist chart dispose that
        MyGlobalObject["enrollPerCoursePie"].dispose()
    }
    // // Create root element
    // // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("enrollPerCoursePie");

    MyGlobalObject["enrollPerCoursePie"]=root;

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);


    // Create chart
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
    var chart = root.container.children.push(am5percent.PieChart.new(root, {
        layout: root.verticalLayout
    }));


    // Create series
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
    var series = chart.series.push(am5percent.PieSeries.new(root, {
        alignLabels: true,
        calculateAggregates: true,
        valueField: "value",
        categoryField: "course"
    }));

    series.slices.template.setAll({
        strokeWidth: 3,
        stroke: am5.color(0xffffff)
    });

    series.labelsContainer.set("paddingTop", 30)


    // Set up adapters for variable slice radius
    // https://www.amcharts.com/docs/v5/concepts/settings/adapters/
    series.slices.template.adapters.add("radius", function (radius, target) {
        var dataItem = target.dataItem;
        var high = series.getPrivate("valueHigh");

        if (dataItem) {
            var value = target.dataItem.get("valueWorking", 0);
            return radius * value / high
        }
        return radius;
    });


    // Set data
    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
    var data = [];

    // series.data.setAll([{
    // value: 10,
    // category: "One"
    // }, {
    // value: 9,
    // category: "Two"
    // }, {
    // value: 6,
    // category: "Three"
    // }, {
    // value: 5,
    // category: "Four"
    // }, {
    // value: 4,
    // category: "Five"
    // }, {
    // value: 3,
    // category: "Six"
    // }]);

    $.ajax({
        url: window.location.origin + "/office-of-admissions/administrator/enrollPerCourse",
        type: "POST",
        data: { sem: $("#enrollPerSemFilter option:selected").val(), college: $("#enrollPerSemCollegeFilter option:selected").val() },
        dataType: "JSON",
        success: function(response) 
        {
            for (let index = 0; index < response.length; index++) 
            {
                data.push(response[index]);
            }

            series.data.setAll(data);
            
            legend.data.setAll(series.dataItems);

            // Play initial series animation
            // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
            series.appear(1000, 100);
        }
    });


    // Create legend
    // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
    var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50,
        marginTop: 15,
        marginBottom: 15
    }));

    
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
  
    