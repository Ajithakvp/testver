<?php
// Sample data generation
$data = [
    "2022" => [10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65],
    "2023" => [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60],
    "2024" => [10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65]
];

// $chartData[] = [
//     'year' => $year,
//     'month' => $month,
//     'count' => $count
// ];

?>
<canvas id="myChart" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chartData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [
        <?php foreach ($data as $year => $values): ?>
            {
                label: '<?php echo $year; ?>',
                backgroundColor: 'rgba(<?php echo rand(0,255); ?>, <?php echo rand(0,255); ?>, <?php echo rand(0,255); ?>, 0.2)',
                borderColor: 'rgba(<?php echo rand(0,255); ?>, <?php echo rand(0,255); ?>, <?php echo rand(0,255); ?>, 1)',
                borderWidth: 1,
                data: <?php echo json_encode($values); ?>
            },
        <?php endforeach; ?>
    ]
};
var myChart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
