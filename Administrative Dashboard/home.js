fetch('fetch_chart_data.php')
    .then(response => response.json())
    .then(data => {
        const userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Students - Active', 'Students - Inactive', 'Lecturers - Active', 'Lecturers - Inactive'],
                datasets: [{
                    label: 'User Status',
                    data: [
                        data.active_students,
                        data.inactive_students,
                        data.active_lecturers,
                        data.inactive_lecturers
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Active and Inactive Users'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Users'
                        }
                    }
                }
            }
        });
    });
