
<div class="statistic_content">
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
                    label: "International",
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
                    pointBorderWidth: 2,
                    /*  pointStyle: 'rect'*/
                },
                {
                    label: "Domestic",
                    data: [<?php
                        if(!empty($dom_arr)){
                            echo implode($dom_arr,',');
                        }
                        ?>],
                    lineTension: 0.3,
                    fill: false,
                    borderColor: 'purple',
                    backgroundColor: 'transparent',
                    pointBorderColor: 'transparent',
                    pointBackgroundColor: 'purple',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBorderWidth: 2,

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
