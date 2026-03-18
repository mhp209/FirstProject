$(document).ready(function(){
    // show_loader()
    // dashboardData();
    // setTimeout(function(){
    //     hide_loader();
    // }, 500);
    // $("#search").click(function(){
    //     show_loader();
    //     setTimeout(function(){
    //         dashboardData();
    //         hide_loader();
    //     }, 500);
    // });
    GoogleCharts();
});

function drawCharts(charts,Columntitle,type,sdate='',edate=''){
   var containerId = charts;
   var data = {};

   $.ajax({
        url: site_url +'admin/'+ charts,
        method: 'POST',
        data: {'sdate' : sdate ,'edate' : edate},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function(response) {
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(function () {
                drawGoogleChart(response, containerId, type, Columntitle);
            });
        },
        error: function(error) {
            console.log('Error:', error);
        }
    });

    function drawGoogleChart(chartdata, containerId, chartType, Columntitle) {

        var data = new google.visualization.DataTable();
        var ColName = [];

        $.each(Columntitle, function (intIndex, objValue) {
            data.addColumn(objValue.type, objValue.name);
            ColName.push(objValue.name);
        });

        $.each(chartdata, function (i, cdata) {
            var rowData = [];
            $.each(Columntitle, function (j, col) {
                if(col.type == 'number'){
                    rowData.push(parseFloat(cdata[col.name]));
                }else if(col.type == 'date'){
                    // console.log(col.type);
                    // console.log($.type(cdata[col.name]));
                    // rowData.push(new date(cdata[col.name]));
                }
                else{
                    rowData.push(cdata[col.name]);
                }
            });
            data.addRow(rowData);
        });

        var chart;
        var view = new google.visualization.DataView(data);
        if (chartType == 'bar') {

            var options = {
                title: '',
                legend: {position: 'bottom',textStyle:{fontSize:11}},
                bar:{groupWidth: 25},
                bars: 'horizontal',
                is3D: true,
                chartArea:{left:0,top:0,width:'100%',height:'80%'}
            };

            view.setColumns([0,
                1,
                {
                    calc: getValueAt.bind(undefined, 1),
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation",
            }]);
            chart = new google.visualization.ColumnChart(document.getElementById(containerId));
        }
        if(chartType == 'pie'){
            var options = {
                pieSliceText: 'label',
                tooltip: { isHtml: true } ,
                legend:{position:'right',textStyle:{fontSize:14}},
                is3D: true,
                chartArea: { left: 20, top: 20, width: '100%', height: '100%' },
                colors:['#6189F8','#BD5CE1','#FF9EE1','#EFB701','#E61B1B','#26E600','#00AACD']
                // 00AACD
                // colors: ['#f36c23', '#1f8ef1', '#35cd96', '#ea4c88', '#fec007','#7FFFD4','#4EE2EC'],
            };
            chart = new google.visualization.PieChart(document.getElementById(containerId));
        }
        chart.draw(view, options);
    }

    function getValueAt(column, dataTable, row) {
        return dataTable.getFormattedValue(row, column);
    }
}

function GoogleCharts(){
        // Get the current date and the first day of the current month
    var currentDate = moment();
    var firstDayOfMonth = moment().startOf('month');

    // Create the initial date ranges
    var DateRange = {
        startDate: firstDayOfMonth,
        endDate: currentDate
    };

    $('#OrderDateRange').daterangepicker(DateRange);
    $('#AlertDateRange').daterangepicker(DateRange);
    $('#EmergencyDateRange').daterangepicker(DateRange);
    $('#UserDateRange').daterangepicker(DateRange);
    $('#VehicleDateRange').daterangepicker(DateRange);
    $('#InsuranceDateRange').daterangepicker(DateRange);

    // Apply the selected date range to filter data on map
    $('#OrderDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('OrderChart',DaywiseEnqColumn,'bar',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    $('#AlertDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('AlertChart', TypeColumn, 'pie',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    $('#EmergencyDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('EmergencyChart',DaywiseEnqColumn,'bar',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    $('#UserDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('UserChart',DaywiseEnqColumn,'bar',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    $('#VehicleDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('VehicleChart',DaywiseEnqColumn,'bar',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    $('#InsuranceDateRange').on('apply.daterangepicker', function(ev, picker) {
        // $("#SurveyorChartDiv #preloader").css("display", "block");
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        drawCharts('InsuranceChart', TypeColumn, 'pie',startDate,endDate);
        // $("#SurveyorChartDiv #preloader").css("display", "none");
    });

    var DaywiseEnqColumn = [
      { name: "day", type: "string" },
      { name: "count", type: "number" }
    ];

    var TypeColumn = [
        { name: "type", type: "string" },
        { name: "count", type: "number" }
    ];

    var DatePicker = $('#OrderDateRange').data('daterangepicker');
    var startDate = DatePicker.startDate.format('YYYY-MM-DD');
    var endDate = DatePicker.endDate.format('YYYY-MM-DD');

    drawCharts('OrderChart', DaywiseEnqColumn, 'bar',startDate,endDate);
    drawCharts('EmergencyChart', DaywiseEnqColumn, 'bar',startDate,endDate);
    drawCharts('UserChart', DaywiseEnqColumn, 'bar',startDate,endDate);
    drawCharts('VehicleChart', DaywiseEnqColumn, 'bar',startDate,endDate);

    drawCharts('InsuranceChart', TypeColumn, 'pie',startDate,endDate);
    drawCharts('AlertChart', TypeColumn, 'pie',startDate,endDate);
}

function GoogleCharts1() {
    // Get the current date and the first day of the current month
    var currentDate = new Date();
    var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

    // Create the initial date ranges
    var DateRange = {
        startDate: firstDayOfMonth,
        endDate: currentDate
    };

    // Initialize flatpickr
    flatpickr('#OrderDateRange', {
        mode: 'range',
        onChange: function(selectedDates, dateStr, instance) {
            var startDate = moment(selectedDates[0]).format('YYYY-MM-DD');
            var endDate = moment(selectedDates[1]).format('YYYY-MM-DD');
            drawCharts('OrderChart', DaywiseEnqColumn, 'bar', startDate, endDate);
        }
    });

    var DaywiseEnqColumn = [
        { name: "day", type: "string" },
        { name: "count", type: "number" }
    ];

    // Initialize flatpickr and get selected start and end dates
    var EnquiryPicker = flatpickr('#OrderDateRange').selectedDates;
    var startDate = moment(EnquiryPicker[0]).format('YYYY-MM-DD');
    var endDate = moment(EnquiryPicker[1]).format('YYYY-MM-DD');
    // console.log(startDate+' '+endDate);
    // Draw charts using the selected start and end dates
    drawCharts('OrderChart', DaywiseEnqColumn, 'bar', startDate, endDate);
}

