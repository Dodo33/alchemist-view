function getRandomColor(opacity) {
    var n1 = Math.random()*256|0;
    var n2 = Math.random()*256|0;
    var n3 = Math.random()*256|0;

    return "rgba(" + n1 + ", " + n2 + ", " + n3 + ", " + opacity + ")";
}


var allocation_label = [];
var amount = [];
var colors = [];
var perc = 0;

for(var i=0;i<ptf_allocation.length;i++){
    allocation_label = allocation_label.concat(ptf_allocation[i]["ticker"]);
    btc_amount = ptf_allocation[i]["amount"] * tickers_price[ptf_allocation[i]["ticker"]];

    perc = Math.round(btc_amount / last_aum * 100);

    amount = amount.concat(perc);
    colors = colors.concat(getRandomColor(0.60));

    console.log(ptf_allocation[i]["ticker"] + " : " + perc + "%");
}

var doughnut_options = {
    cutoutPercentage: 50,
    responsive: true,
    maintainAspectRatio: false,
    legend: {
        display: true,
        position: "left",
    },
    tooltips: {
        callbacks: {
            title: function(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
                return data['datasets'][0]['data'][tooltipItem['index']] + "%";
            },
        },
    },
}

var allocation = document.getElementById("allocation");
var barChart = new Chart(allocation, {
    type: 'doughnut',
    data: {
        labels: allocation_label,
        datasets: [{
            borderColor: "black",
            data: amount,
            backgroundColor: colors,
        }],
    }, 
    options : doughnut_options,
});