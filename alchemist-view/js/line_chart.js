var aum_datetime = [];
var aum_value = [];

for(var i=0; i<aum_history.length;i++){
    aum_datetime = aum_datetime.concat(aum_history[i]["aum_datetime"]);
    aum_value = aum_value.concat(aum_history[i]["aum"]);
}

var line_options = {
    responsive: true,
    maintainAspectRatio: false,
    elements: {
        line: {
            tension: 0.000001,
        },
        point : {
            radius: 1,
        },
    },
    scales: {
        xAxes: [{
            gridLines: {
                display: false,
            },
            display: true,
            ticks: {
                callback: function(value) { 
                    return new Date(value).toLocaleDateString('en-US', {day: "2-digit", 
                                                                        month:"2-digit",
                                                                        year:"2-digit"}); 
                },
            },
        }],
        yAxes: [{
            scaleLabel:{
                display: true,
                labelString: "Assets under management",
            },
        }],
    },
    legend: {
        display: false,
    },
    tooltips: {
        intersect: false,
        callbacks: {
            title: function(tooltipItem, data) {
                var title = data['labels'][tooltipItem[0]['index']];
                title = title.substring(0, title.length - 3);//Remove seconds
                return title;
            },
            label: function(tooltipItem, data) {
                return "AUM: " + data['datasets'][0]['data'][tooltipItem['index']];
            },
        },
    },
}

var aum = document.getElementById("aum");
var barChart = new Chart(aum, {
    type: 'line',
    data: {
        labels: aum_datetime,
        datasets: [{
            backgroundColor: "rgba(0, 191, 255, 0.08)",
            borderColor: "blue",
            data: aum_value,
            fill: "start",
            steppedLine: false,
            borderWidth: 2,
        }],
    },
    options: line_options,
});
