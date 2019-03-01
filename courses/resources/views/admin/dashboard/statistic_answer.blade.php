
    <div style="height: 400px; width:1000px;">

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
                        label: "Visitor",
                        data: [
                            <?php
                            if(!empty($int_visit)){
                                echo implode($int_visit,',');
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
                        label: "All User",
                        data: [<?php
                            if(!empty($all_arr)){
                                echo implode($all_arr,',');
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

                    },
                    {
                        label: "Free User",
                        data: [<?php
                            if(!empty($free_arr)){
                                echo implode($free_arr,',');
                            }
                            ?>],
                        lineTension: 0.3,
                        fill: false,
                        borderColor: 'blue',
                        backgroundColor: 'transparent',
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'blue',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointHitRadius: 10,
                        pointBorderWidth: 2,

                    },
                    {
                        label: "premium User",
                        data: [<?php
                            if(!empty($premium_arr)){
                                echo implode($premium_arr,',');
                            }
                            ?>],
                        lineTension: 0.3,
                        fill: false,
                        borderColor: 'yellow',
                        backgroundColor: 'transparent',
                        pointBorderColor: 'transparent',
                        pointBackgroundColor: 'yellow',
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


