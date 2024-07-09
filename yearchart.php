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
    var chartData = <?php echo $chartDataJSON; ?>;


    // Extracting unique years and months for labels
    var years = chartData.map(data => data.year);
    var uniqueYears = [...new Set(years)];
    var months = chartData.map(data => data.month);
    var uniqueMonths = [...new Set(months)];

    // Sorting unique months (optional)
    uniqueMonths.sort((a, b) => a - b);

    // Prepare datasets for Chart.js
    var datasets = [];
    uniqueYears.forEach(year => {
        var dataByYear = chartData.filter(data => data.year === year);
        var dataValues = uniqueMonths.map(month => {
            var foundData = dataByYear.find(data => data.month === month);
            return foundData ? foundData.count : 0;
        });

        datasets.push({
            label: year.toString(),
            backgroundColor: 'rgba(' + getRandomColor() + ', 0.2)',
            borderColor: 'rgba(' + getRandomColor() + ', 1)',
            borderWidth: 1,
            data: dataValues
        });
    });

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: uniqueMonths.map(month => getMonthLabel(month)),
            datasets: datasets
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            var datasetLabel = context.dataset.label || '';
                            var monthLabel = context.label || '';
                            var value = context.raw || 0;
                            return `${datasetLabel}:  ${monthLabel} (PM calls) - ${value} `;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Calls'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });

    // Function to generate random RGB color
    function getRandomColor() {
        return `${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}`;
    }

    // Function to get month label from month number (1-based)
    function getMonthLabel(monthNumber) {
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return monthNames[monthNumber - 1];
    }
</script>