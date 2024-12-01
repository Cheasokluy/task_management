document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('taskStatusChart').getContext('2d');
    const taskStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                label: 'Number of Tasks',
                data: [taskCounts.pending, taskCounts.inProgress, taskCounts.completed],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});