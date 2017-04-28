$(document).ready(function(){
    $("#refresh").click(function(){
        date_slider();
    });

    $.fn.editable.defaults.mode = 'popup';
    $('.sensor-description').editable({
        inputclass: 'description',
        placement: 'right',
        rows: 2,
        showbuttons: 'bottom',
        emptytext: 'Double click to add description',
        toggle: 'dblclick',
        url: '../infrastructure/UpdateConfig.php',
    });
    $('.sensor-name').editable({
        inputclass: 'description',
        placement: 'right',
        showbuttons: 'bottom',
        emptytext: 'Unnamed',
        toggle: 'dblclick',
        url: '../infrastructure/UpdateConfig.php',
    });
    var ctx = document.getElementById('power_chart').getContext('2d');
    var power_chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: 0,
            datasets: [{
                label: $("#sensor1-name").val(),
                data: 0,
                pointRadius: 0,
                backgroundColor: 'rgba(204, 231, 244, 0.3)',
           },{
                label: $("#sensor2-name").val(),
                data: 0,
                pointRadius: 0,
                backgroundColor: 'rgba(87, 129, 69, 0.3)',
            },{
                label: $("#sensor3-name").val(),
                data: 0,
                pointRadius: 0,
                backgroundColor: 'rgba(250, 243, 210, 0.3)',
            },]
        },
    });
    date_slider();

function date_slider(){
    var date_values = [];
    var date_last_values = [];
    var start_date = '';
    var end_date = '';
	$.getJSON("../infrastructure/ListDates.php", function(result){
        $.each(result, function(i, value){
            date_values[i] = value['date_entry'];
            date_last_values[i] = value['date_last_entry'];
        });
        $( function() {
            $("#date-slider").slider({
                range: true,
                min: 0,
                max: date_values.length - 1,
                step: 1,
                values: [ date_values.length - 1, date_values.length -1 ],
                slide: function( event, ui ) {
                    $("#interval-value").html( date_values[ui.values[0]] + " - " + date_values[ui.values[1]]);
                },
                stop: function( event, ui ) {
                    $("#spinner").removeClass("hidden");
                    day_slider(date_last_values[ui.values[0]], date_last_values[ui.values[1]]);
                },
            });
        day_slider(date_last_values[$("#date-slider").slider("values", 0)],date_last_values[$("#date-slider").slider("values", 1)]);
        });
    });
}

function day_slider(start_date, end_date){
    $.post({
        url : '../infrastructure/ListDays.php',
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success:function (data) {
                var reply=jQuery.parseJSON(data);
                var day_values = [];
                $.each(reply, function(i, value){
                    day_values[i] = value['date_entry'];
                });
                $( function() {
                    $("#day-slider").slider({
                        range: true,
                        min: 0,
                        max: day_values.length - 1,
                        step: 1,
                        values: [ day_values.length - 1, day_values.length -1 ],
                        slide: function( event, ui ) {
                            $("#interval-value").html( day_values[ui.values[0]] + " - " + day_values[ui.values[1]]);
                        },
                        stop: function( event, ui ) {
                            $("#spinner").removeClass("hidden");
                            hour_slider(day_values[ui.values[0]], day_values[ui.values[1]]);
                        },
                    });
                    hour_slider(day_values[$("#day-slider").slider("values", 0)], day_values[$("#day-slider").slider("values", 1)]);
                });
            }
    });
}

function hour_slider(start_date, end_date){
    $.post({
        url : '../infrastructure/ListHours.php',
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success:function (data) {
                var reply=jQuery.parseJSON(data);
                var hour_values = [];
                $.each(reply, function(i, value){
                    hour_values[i] = value['date_entry'];
                });
                $("#spinner").addClass("hidden");
                $( function() {
                    $("#hour-slider").slider({
                        range: true,
                        min: 0,
                        max: hour_values.length - 1,
                        step: 1,
                        values: [ 0, hour_values.length -1 ],
                        slide: function( event, ui ) {
                            $("#interval-value").html( hour_values[ui.values[0]] + ":00 - " + hour_values[ui.values[1]] + ":59");
                        },
                        stop: function( event, ui ) {
                            loadkWhdata( hour_values[ui.values[0]] + ":00 - ", hour_values[ui.values[1]] + ":59");
                            getChartData( hour_values[ui.values[0]] + ":00 - ", hour_values[ui.values[1]] + ":59");
                        },
                    });
                    $("#interval-value").html(hour_values[$("#hour-slider").slider("values", 0)] + ":00 - " + hour_values[$("#hour-slider").slider("values", 1)] + ":59");
                    loadkWhdata(hour_values[$("#hour-slider").slider("values", 0)] + ":00:00", hour_values[$("#hour-slider").slider("values", 1)] + ":59:59");
                    getChartData(hour_values[$("#hour-slider").slider("values", 0)] + ":00:00", hour_values[$("#hour-slider").slider("values", 1)] + ":59:59");
                });
            }
    });
}

function loadkWhdata(start_date, end_date){
    $(".kwh-spinner").removeClass("hidden");
    $.post({
        url : '../infrastructure/kWh.php',
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success:function (data) {
                var reply=jQuery.parseJSON(data);
	            $.each(reply, function(i, value){
        	        $('#' + i).html(value['kWh'] + ' kWh');
                    var from = value['from'].split(' ');
                    var to = value['to'].split(' ');
    	            $('#' + i + '-period').html(from[0] + ' - ' + to[0]);
                });
                $(".kwh-spinner").addClass("hidden");
            }
    });
}

function getChartData(start_date, end_date){
    $("#chart-spinner").removeClass("hidden");
    $.post({
        url : '../infrastructure/Chart.php',
            data: {
                start_date: start_date,
                end_date: end_date,
            },
            success:function (data) {
                var reply=jQuery.parseJSON(data);
                power_chart.data.labels = reply.date;
                power_chart.data.datasets[0].data = reply.sensor1;
                power_chart.data.datasets[1].data = reply.sensor2;
                power_chart.data.datasets[2].data = reply.sensor3;
                power_chart.update();
                $("#chart-spinner").addClass("hidden");
            }
    });
}


});

