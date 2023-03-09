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
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none"
        })
    );
    
    
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var yRenderer = am5xy.AxisRendererY.new(root, { minGridDistance: 30 });
    yRenderer.grid.template.set("location", 1);
    
    var yAxis = chart.yAxes.push(
        am5xy.CategoryAxis.new(root, {
            maxDeviation: 0,
            categoryField: "country",
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
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "value",
            sequencedInterpolation: true,
            categoryYField: "country",
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
    var data = [{
        country: "USA",
        value: 2025
    }, {
        country: "China",
        value: 1882
    }, {
        country: "Japan",
        value: 1809
    }, {
        country: "Germany",
        value: 1322
    }, {
        country: "UK",
        value: 1122
    }];
    
    yAxis.data.setAll(data);
    series.data.setAll(data);
    
    
    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear(1000);
    chart.appear(1000, 100);
}enrollPerCourse();

// Axis sorting
function sortCategoryAxis() {
    // Sort by value
    series.dataItems.sort(function(x, y) {
    return y.get("graphics").y() - x.get("graphics").y();
    });

    var easing = am5.ease.out(am5.ease.cubic);

    // Go through each axis item
    am5.array.each(yAxis.dataItems, function(dataItem) {
    // get corresponding series item
    var seriesDataItem = getSeriesItem(dataItem.get("category"));

    if (seriesDataItem) {
        // get index of series data item
        var index = series.dataItems.indexOf(seriesDataItem);

        var column = seriesDataItem.get("graphics");

        // position after sorting
        var fy =
        yRenderer.positionToCoordinate(yAxis.indexToPosition(index)) -
        column.height() / 2;

        // set index to be the same as series data item index
        if (index != dataItem.get("index")) {
        dataItem.set("index", index);

        // current position
        var x = column.x();
        var y = column.y();

        column.set("dy", -(fy - y));
        column.set("dx", x);

        column.animate({ key: "dy", to: 0, duration: 600, easing: easing });
        column.animate({ key: "dx", to: 0, duration: 600, easing: easing });
        } else {
        column.animate({ key: "y", to: fy, duration: 600, easing: easing });
        column.animate({ key: "x", to: 0, duration: 600, easing: easing });
        }
    }
    });

    // Sort axis items by index.
    // This changes the order instantly, but as dx and dy is set and animated,
    // they keep in the same places and then animate to true positions.
    yAxis.dataItems.sort(function(x, y) {
    return x.get("index") - y.get("index");
    });
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
  
    