document.addEventListener('DOMContentLoaded', () => {
    const dates = <?php echo json_encode($dates); ?>;
    const notes = <?php echo json_encode($notes); ?>;
    const message = document.getElementsByClassName('no-data-message')[0];
    const chartCanvas = document.getElementById('myChart');

    if (dates.length === 0 || notes.length === 0) {
        chartCanvas.style.display = 'none';
        message.style.display = 'block';
        return;
    }

    new Chart(document.getElementById('myChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: "Notes en fonction des dates",
                data: notes.map(Number), // convertit en nombres
                borderWidth: 2,
                borderColor: "blue",
                fill: false,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: Math.min(...notes) - 1,
                    suggestedMax: Math.max(...notes) + 1
                }
            }
        }
    });
});
