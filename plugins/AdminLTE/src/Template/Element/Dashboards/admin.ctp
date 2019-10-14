<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>Upgraded Members</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>44</h3>

                            <p>Live Chats</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>65</h3>

                            <p>Support Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- AREA CHART -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Area Chart</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="areaChart" style="height:250px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <script src="/plugins/chartjs/Chart.min.js"></script>
                    <script>
                        $(function () {
                            /* ChartJS
                             * -------
                             * Here we will create a few charts using ChartJS
                             */

                            //--------------
                            //- AREA CHART -
                            //--------------

                            // Get context with jQuery - using jQuery's .get() method.
                            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
                            // This will get the first returned node in the jQuery collection.
                            var areaChart = new Chart(areaChartCanvas);

                            var areaChartData = {
                                labels: ["January", "February", "March", "April", "May", "June", "July"],
                                datasets: [
                                    {
                                        label: "Electronics",
                                        fillColor: "rgba(210, 214, 222, 1)",
                                        strokeColor: "rgba(210, 214, 222, 1)",
                                        pointColor: "rgba(210, 214, 222, 1)",
                                        pointStrokeColor: "#c1c7d1",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                        data: [65, 59, 80, 81, 56, 55, 40]
                                    },
                                    {
                                        label: "Digital Goods",
                                        fillColor: "rgba(60,141,188,0.9)",
                                        strokeColor: "rgba(60,141,188,0.8)",
                                        pointColor: "#3b8bba",
                                        pointStrokeColor: "rgba(60,141,188,1)",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(60,141,188,1)",
                                        data: [28, 48, 40, 19, 86, 27, 90]
                                    }
                                ]
                            };

                            var areaChartOptions = {
                                //Boolean - If we should show the scale at all
                                showScale: true,
                                //Boolean - Whether grid lines are shown across the chart
                                scaleShowGridLines: false,
                                //String - Colour of the grid lines
                                scaleGridLineColor: "rgba(0,0,0,.05)",
                                //Number - Width of the grid lines
                                scaleGridLineWidth: 1,
                                //Boolean - Whether to show horizontal lines (except X axis)
                                scaleShowHorizontalLines: true,
                                //Boolean - Whether to show vertical lines (except Y axis)
                                scaleShowVerticalLines: true,
                                //Boolean - Whether the line is curved between points
                                bezierCurve: true,
                                //Number - Tension of the bezier curve between points
                                bezierCurveTension: 0.3,
                                //Boolean - Whether to show a dot for each point
                                pointDot: false,
                                //Number - Radius of each point dot in pixels
                                pointDotRadius: 4,
                                //Number - Pixel width of point dot stroke
                                pointDotStrokeWidth: 1,
                                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                                pointHitDetectionRadius: 20,
                                //Boolean - Whether to show a stroke for datasets
                                datasetStroke: true,
                                //Number - Pixel width of dataset stroke
                                datasetStrokeWidth: 2,
                                //Boolean - Whether to fill the dataset with a color
                                datasetFill: true,
                                //String - A legend template
                                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                maintainAspectRatio: true,
                                //Boolean - whether to make the chart responsive to window resizing
                                responsive: true
                            };

                            //Create the line chart
                            areaChart.Line(areaChartData, areaChartOptions);
                        });
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Message Counts by Day</h3>
                        </div>
                        <div class="box-body">
                            <!-- Styles -->
                            <style>
                                #chartdiv {
                                    width	: 100%;
                                    height	: 500px;
                                }

                            </style>

                            <!-- Resources -->
                            <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
                            <script src="https://www.amcharts.com/lib/3/serial.js"></script>
                            <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
                            <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
                            <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

                            <!-- Chart code -->
                            <script>
                                var chart = AmCharts.makeChart("chartdiv", {
                                    "type": "serial",
                                    "theme": "light",
                                    "marginRight": 40,
                                    "marginLeft": 40,
                                    "autoMarginOffset": 20,
                                    "mouseWheelZoomEnabled":true,
                                    "dataDateFormat": "YYYY-MM-DD",
                                    "valueAxes": [{
                                        "id": "v1",
                                        "axisAlpha": 0,
                                        "position": "left",
                                        "ignoreAxisWidth":true
                                    }],
                                    "balloon": {
                                        "borderThickness": 1,
                                        "shadowAlpha": 0
                                    },
                                    "graphs": [{
                                        "id": "g1",
                                        "balloon":{
                                            "drop":true,
                                            "adjustBorderColor":false,
                                            "color":"#ffffff"
                                        },
                                        "bullet": "round",
                                        "bulletBorderAlpha": 1,
                                        "bulletColor": "#FFFFFF",
                                        "bulletSize": 5,
                                        "hideBulletsCount": 50,
                                        "lineThickness": 2,
                                        "title": "red line",
                                        "useLineColorForBulletBorder": true,
                                        "valueField": "value",
                                        "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                                    }],
                                    "chartScrollbar": {
                                        "graph": "g1",
                                        "oppositeAxis":false,
                                        "offset":30,
                                        "scrollbarHeight": 80,
                                        "backgroundAlpha": 0,
                                        "selectedBackgroundAlpha": 0.1,
                                        "selectedBackgroundColor": "#888888",
                                        "graphFillAlpha": 0,
                                        "graphLineAlpha": 0.5,
                                        "selectedGraphFillAlpha": 0,
                                        "selectedGraphLineAlpha": 1,
                                        "autoGridCount":true,
                                        "color":"#AAAAAA"
                                    },
                                    "chartCursor": {
                                        "pan": true,
                                        "valueLineEnabled": true,
                                        "valueLineBalloonEnabled": true,
                                        "cursorAlpha":1,
                                        "cursorColor":"#258cbb",
                                        "limitToGraph":"g1",
                                        "valueLineAlpha":0.2,
                                        "valueZoomable":true
                                    },
                                    "valueScrollbar":{
                                        "oppositeAxis":false,
                                        "offset":50,
                                        "scrollbarHeight":10
                                    },
                                    "categoryField": "date",
                                    "categoryAxis": {
                                        "parseDates": true,
                                        "dashLength": 1,
                                        "minorGridEnabled": true
                                    },
                                    "export": {
                                        "enabled": true
                                    },
                                    "dataProvider": [{
                                        "date": "2012-07-27",
                                        "value": 13
                                    }, {
                                        "date": "2012-07-28",
                                        "value": 11
                                    }, {
                                        "date": "2012-07-29",
                                        "value": 15
                                    }, {
                                        "date": "2012-07-30",
                                        "value": 16
                                    }, {
                                        "date": "2012-07-31",
                                        "value": 18
                                    }, {
                                        "date": "2012-08-01",
                                        "value": 13
                                    }, {
                                        "date": "2012-08-02",
                                        "value": 22
                                    }, {
                                        "date": "2012-08-03",
                                        "value": 23
                                    }, {
                                        "date": "2012-08-04",
                                        "value": 20
                                    }, {
                                        "date": "2012-08-05",
                                        "value": 17
                                    }, {
                                        "date": "2012-08-06",
                                        "value": 16
                                    }, {
                                        "date": "2012-08-07",
                                        "value": 18
                                    }, {
                                        "date": "2012-08-08",
                                        "value": 21
                                    }, {
                                        "date": "2012-08-09",
                                        "value": 26
                                    }, {
                                        "date": "2012-08-10",
                                        "value": 24
                                    }, {
                                        "date": "2012-08-11",
                                        "value": 29
                                    }, {
                                        "date": "2012-08-12",
                                        "value": 32
                                    }, {
                                        "date": "2012-08-13",
                                        "value": 18
                                    }, {
                                        "date": "2012-08-14",
                                        "value": 24
                                    }, {
                                        "date": "2012-08-15",
                                        "value": 22
                                    }, {
                                        "date": "2012-08-16",
                                        "value": 18
                                    }, {
                                        "date": "2012-08-17",
                                        "value": 19
                                    }, {
                                        "date": "2012-08-18",
                                        "value": 14
                                    }, {
                                        "date": "2012-08-19",
                                        "value": 15
                                    }, {
                                        "date": "2012-08-20",
                                        "value": 12
                                    }, {
                                        "date": "2012-08-21",
                                        "value": 8
                                    }, {
                                        "date": "2012-08-22",
                                        "value": 9
                                    }, {
                                        "date": "2012-08-23",
                                        "value": 8
                                    }, {
                                        "date": "2012-08-24",
                                        "value": 7
                                    }, {
                                        "date": "2012-08-25",
                                        "value": 5
                                    }, {
                                        "date": "2012-08-26",
                                        "value": 11
                                    }, {
                                        "date": "2012-08-27",
                                        "value": 13
                                    }, {
                                        "date": "2012-08-28",
                                        "value": 18
                                    }, {
                                        "date": "2012-08-29",
                                        "value": 20
                                    }, {
                                        "date": "2012-08-30",
                                        "value": 29
                                    }, {
                                        "date": "2012-08-31",
                                        "value": 33
                                    }, {
                                        "date": "2012-09-01",
                                        "value": 42
                                    }, {
                                        "date": "2012-09-02",
                                        "value": 35
                                    }, {
                                        "date": "2012-09-03",
                                        "value": 31
                                    }, {
                                        "date": "2012-09-04",
                                        "value": 47
                                    }, {
                                        "date": "2012-09-05",
                                        "value": 52
                                    }, {
                                        "date": "2012-09-06",
                                        "value": 46
                                    }, {
                                        "date": "2012-09-07",
                                        "value": 41
                                    }, {
                                        "date": "2012-09-08",
                                        "value": 43
                                    }, {
                                        "date": "2012-09-09",
                                        "value": 40
                                    }, {
                                        "date": "2012-09-10",
                                        "value": 39
                                    }, {
                                        "date": "2012-09-11",
                                        "value": 34
                                    }, {
                                        "date": "2012-09-12",
                                        "value": 29
                                    }, {
                                        "date": "2012-09-13",
                                        "value": 34
                                    }, {
                                        "date": "2012-09-14",
                                        "value": 37
                                    }, {
                                        "date": "2012-09-15",
                                        "value": 42
                                    }, {
                                        "date": "2012-09-16",
                                        "value": 49
                                    }, {
                                        "date": "2012-09-17",
                                        "value": 46
                                    }, {
                                        "date": "2012-09-18",
                                        "value": 47
                                    }, {
                                        "date": "2012-09-19",
                                        "value": 55
                                    }, {
                                        "date": "2012-09-20",
                                        "value": 59
                                    }, {
                                        "date": "2012-09-21",
                                        "value": 58
                                    }, {
                                        "date": "2012-09-22",
                                        "value": 57
                                    }, {
                                        "date": "2012-09-23",
                                        "value": 61
                                    }, {
                                        "date": "2012-09-24",
                                        "value": 59
                                    }, {
                                        "date": "2012-09-25",
                                        "value": 67
                                    }, {
                                        "date": "2012-09-26",
                                        "value": 65
                                    }, {
                                        "date": "2012-09-27",
                                        "value": 61
                                    }, {
                                        "date": "2012-09-28",
                                        "value": 66
                                    }, {
                                        "date": "2012-09-29",
                                        "value": 69
                                    }, {
                                        "date": "2012-09-30",
                                        "value": 71
                                    }, {
                                        "date": "2012-10-01",
                                        "value": 67
                                    }, {
                                        "date": "2012-10-02",
                                        "value": 63
                                    }, {
                                        "date": "2012-10-03",
                                        "value": 46
                                    }, {
                                        "date": "2012-10-04",
                                        "value": 32
                                    }, {
                                        "date": "2012-10-05",
                                        "value": 21
                                    }, {
                                        "date": "2012-10-06",
                                        "value": 18
                                    }, {
                                        "date": "2012-10-07",
                                        "value": 21
                                    }, {
                                        "date": "2012-10-08",
                                        "value": 28
                                    }, {
                                        "date": "2012-10-09",
                                        "value": 27
                                    }, {
                                        "date": "2012-10-10",
                                        "value": 36
                                    }, {
                                        "date": "2012-10-11",
                                        "value": 33
                                    }, {
                                        "date": "2012-10-12",
                                        "value": 31
                                    }, {
                                        "date": "2012-10-13",
                                        "value": 30
                                    }, {
                                        "date": "2012-10-14",
                                        "value": 34
                                    }, {
                                        "date": "2012-10-15",
                                        "value": 38
                                    }, {
                                        "date": "2012-10-16",
                                        "value": 37
                                    }, {
                                        "date": "2012-10-17",
                                        "value": 44
                                    }, {
                                        "date": "2012-10-18",
                                        "value": 49
                                    }, {
                                        "date": "2012-10-19",
                                        "value": 53
                                    }, {
                                        "date": "2012-10-20",
                                        "value": 57
                                    }, {
                                        "date": "2012-10-21",
                                        "value": 60
                                    }, {
                                        "date": "2012-10-22",
                                        "value": 61
                                    }, {
                                        "date": "2012-10-23",
                                        "value": 69
                                    }, {
                                        "date": "2012-10-24",
                                        "value": 67
                                    }, {
                                        "date": "2012-10-25",
                                        "value": 72
                                    }, {
                                        "date": "2012-10-26",
                                        "value": 77
                                    }, {
                                        "date": "2012-10-27",
                                        "value": 75
                                    }, {
                                        "date": "2012-10-28",
                                        "value": 70
                                    }, {
                                        "date": "2012-10-29",
                                        "value": 72
                                    }, {
                                        "date": "2012-10-30",
                                        "value": 70
                                    }, {
                                        "date": "2012-10-31",
                                        "value": 72
                                    }, {
                                        "date": "2012-11-01",
                                        "value": 73
                                    }, {
                                        "date": "2012-11-02",
                                        "value": 67
                                    }, {
                                        "date": "2012-11-03",
                                        "value": 68
                                    }, {
                                        "date": "2012-11-04",
                                        "value": 65
                                    }, {
                                        "date": "2012-11-05",
                                        "value": 71
                                    }, {
                                        "date": "2012-11-06",
                                        "value": 75
                                    }, {
                                        "date": "2012-11-07",
                                        "value": 74
                                    }, {
                                        "date": "2012-11-08",
                                        "value": 71
                                    }, {
                                        "date": "2012-11-09",
                                        "value": 76
                                    }, {
                                        "date": "2012-11-10",
                                        "value": 77
                                    }, {
                                        "date": "2012-11-11",
                                        "value": 81
                                    }, {
                                        "date": "2012-11-12",
                                        "value": 83
                                    }, {
                                        "date": "2012-11-13",
                                        "value": 80
                                    }, {
                                        "date": "2012-11-14",
                                        "value": 81
                                    }, {
                                        "date": "2012-11-15",
                                        "value": 87
                                    }, {
                                        "date": "2012-11-16",
                                        "value": 82
                                    }, {
                                        "date": "2012-11-17",
                                        "value": 86
                                    }, {
                                        "date": "2012-11-18",
                                        "value": 80
                                    }, {
                                        "date": "2012-11-19",
                                        "value": 87
                                    }, {
                                        "date": "2012-11-20",
                                        "value": 83
                                    }, {
                                        "date": "2012-11-21",
                                        "value": 85
                                    }, {
                                        "date": "2012-11-22",
                                        "value": 84
                                    }, {
                                        "date": "2012-11-23",
                                        "value": 82
                                    }, {
                                        "date": "2012-11-24",
                                        "value": 73
                                    }, {
                                        "date": "2012-11-25",
                                        "value": 71
                                    }, {
                                        "date": "2012-11-26",
                                        "value": 75
                                    }, {
                                        "date": "2012-11-27",
                                        "value": 79
                                    }, {
                                        "date": "2012-11-28",
                                        "value": 70
                                    }, {
                                        "date": "2012-11-29",
                                        "value": 73
                                    }, {
                                        "date": "2012-11-30",
                                        "value": 61
                                    }, {
                                        "date": "2012-12-01",
                                        "value": 62
                                    }, {
                                        "date": "2012-12-02",
                                        "value": 66
                                    }, {
                                        "date": "2012-12-03",
                                        "value": 65
                                    }, {
                                        "date": "2012-12-04",
                                        "value": 73
                                    }, {
                                        "date": "2012-12-05",
                                        "value": 79
                                    }, {
                                        "date": "2012-12-06",
                                        "value": 78
                                    }, {
                                        "date": "2012-12-07",
                                        "value": 78
                                    }, {
                                        "date": "2012-12-08",
                                        "value": 78
                                    }, {
                                        "date": "2012-12-09",
                                        "value": 74
                                    }, {
                                        "date": "2012-12-10",
                                        "value": 73
                                    }, {
                                        "date": "2012-12-11",
                                        "value": 75
                                    }, {
                                        "date": "2012-12-12",
                                        "value": 70
                                    }, {
                                        "date": "2012-12-13",
                                        "value": 77
                                    }, {
                                        "date": "2012-12-14",
                                        "value": 67
                                    }, {
                                        "date": "2012-12-15",
                                        "value": 62
                                    }, {
                                        "date": "2012-12-16",
                                        "value": 64
                                    }, {
                                        "date": "2012-12-17",
                                        "value": 61
                                    }, {
                                        "date": "2012-12-18",
                                        "value": 59
                                    }, {
                                        "date": "2012-12-19",
                                        "value": 53
                                    }, {
                                        "date": "2012-12-20",
                                        "value": 54
                                    }, {
                                        "date": "2012-12-21",
                                        "value": 56
                                    }, {
                                        "date": "2012-12-22",
                                        "value": 59
                                    }, {
                                        "date": "2012-12-23",
                                        "value": 58
                                    }, {
                                        "date": "2012-12-24",
                                        "value": 55
                                    }, {
                                        "date": "2012-12-25",
                                        "value": 52
                                    }, {
                                        "date": "2012-12-26",
                                        "value": 54
                                    }, {
                                        "date": "2012-12-27",
                                        "value": 50
                                    }, {
                                        "date": "2012-12-28",
                                        "value": 50
                                    }, {
                                        "date": "2012-12-29",
                                        "value": 51
                                    }, {
                                        "date": "2012-12-30",
                                        "value": 52
                                    }, {
                                        "date": "2012-12-31",
                                        "value": 58
                                    }, {
                                        "date": "2013-01-01",
                                        "value": 60
                                    }, {
                                        "date": "2013-01-02",
                                        "value": 67
                                    }, {
                                        "date": "2013-01-03",
                                        "value": 64
                                    }, {
                                        "date": "2013-01-04",
                                        "value": 66
                                    }, {
                                        "date": "2013-01-05",
                                        "value": 60
                                    }, {
                                        "date": "2013-01-06",
                                        "value": 63
                                    }, {
                                        "date": "2013-01-07",
                                        "value": 61
                                    }, {
                                        "date": "2013-01-08",
                                        "value": 60
                                    }, {
                                        "date": "2013-01-09",
                                        "value": 65
                                    }, {
                                        "date": "2013-01-10",
                                        "value": 75
                                    }, {
                                        "date": "2013-01-11",
                                        "value": 77
                                    }, {
                                        "date": "2013-01-12",
                                        "value": 78
                                    }, {
                                        "date": "2013-01-13",
                                        "value": 70
                                    }, {
                                        "date": "2013-01-14",
                                        "value": 70
                                    }, {
                                        "date": "2013-01-15",
                                        "value": 73
                                    }, {
                                        "date": "2013-01-16",
                                        "value": 71
                                    }, {
                                        "date": "2013-01-17",
                                        "value": 74
                                    }, {
                                        "date": "2013-01-18",
                                        "value": 78
                                    }, {
                                        "date": "2013-01-19",
                                        "value": 85
                                    }, {
                                        "date": "2013-01-20",
                                        "value": 82
                                    }, {
                                        "date": "2013-01-21",
                                        "value": 83
                                    }, {
                                        "date": "2013-01-22",
                                        "value": 88
                                    }, {
                                        "date": "2013-01-23",
                                        "value": 85
                                    }, {
                                        "date": "2013-01-24",
                                        "value": 85
                                    }, {
                                        "date": "2013-01-25",
                                        "value": 80
                                    }, {
                                        "date": "2013-01-26",
                                        "value": 87
                                    }, {
                                        "date": "2013-01-27",
                                        "value": 84
                                    }, {
                                        "date": "2013-01-28",
                                        "value": 83
                                    }, {
                                        "date": "2013-01-29",
                                        "value": 84
                                    }, {
                                        "date": "2013-01-30",
                                        "value": 81
                                    }]
                                });

                                chart.addListener("rendered", zoomChart);

                                zoomChart();

                                function zoomChart() {
                                    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
                                }
                            </script>

                            <!-- HTML -->
                            <div id="chartdiv"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="chart" id="sales-chart" style="height: 265px; position: relative;"></div>
        </div>
        <div class="item">
            <img src="http://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap" alt="Third slide">

            <div class="carousel-caption">
                Third Slide
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="fa fa-angle-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="fa fa-angle-right"></span>
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/plugins/morris/morris.min.js"></script>
<script>
    $(function () {
        "use strict";
        //DONUT CHART
        var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
                {label: "Download Sales", value: 12},
                {label: "In-Store Sales", value: 30},
                {label: "Mail-Order Sales", value: 20}
            ],
            hideHover: 'auto'
        });

        // LINE CHART
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
                {y: '2011 Q1', item1: 2666},
                {y: '2011 Q2', item1: 2778},
                {y: '2011 Q3', item1: 4912},
                {y: '2011 Q4', item1: 3767},
                {y: '2012 Q1', item1: 6810},
                {y: '2012 Q2', item1: 5670},
                {y: '2012 Q3', item1: 4820},
                {y: '2012 Q4', item1: 15073},
                {y: '2013 Q1', item1: 10687},
                {y: '2013 Q2', item1: 8432}
            ],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Item 1'],
            lineColors: ['#3c8dbc'],
            hideHover: 'auto'
        });
    });
</script>


