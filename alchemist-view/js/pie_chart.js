function getRandomColor(opacity) {
    var n1 = Math.random()*256|0;
    var n2 = Math.random()*256|0;
    var n3 = Math.random()*256|0;

    return "rgba(" + n1 + ", " + n2 + ", " + n3 + ", " + opacity + ")";
}

var colors = [];
for(var key in sum_aum)
    colors = colors.concat(getRandomColor(0.60));

var pie_options = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        display: true,
        position: "right",
    },
    tooltips: {
        callbacks: {
            title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']].toFixed(2) + " $";
            },
            afterLabel: function(tooltipItem, data) {
                var dataset = data['datasets'][0];
                var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][0]['total']) * 100)
                return percent + " %";
            },
        },
    },
}

var inst_all = document.getElementById("inst_all");
var barChart = new Chart(inst_all, {
    type: 'pie',
    data: {
        labels: Object.keys(sum_aum),
        datasets: [{
            borderColor: "black",
            data: Object.values(sum_aum),
            backgroundColor: colors,
        }],
    }, 
    options : pie_options,
});