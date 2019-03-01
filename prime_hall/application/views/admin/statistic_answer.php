
<div style="height: 600px">

    <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            type: 'category',
            labels: ['<?php
                if(!empty($date_arr)){
                    echo implode($date_arr,"','");
                }?>'],
            datasets: [
                {
                    label: "User",
                    data: [
                        <?php
                        if(!empty($int_arr)){
                            echo implode($int_arr,',');
                        }
                        ?>],
                    lineTension: 0.3,
                    fill: false,
                    borderColor: 'red',
                    backgroundColor: 'transparent',
                    pointBorderColor: 'red',
                    pointBackgroundColor: 'red',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBorderWidth: 2
                    /*  pointStyle: 'rect'*/
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>