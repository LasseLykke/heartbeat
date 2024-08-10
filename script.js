window.onload = function () {
    const menu_btn = document.querySelector('.hamburger');
    const mobile_menu = document.querySelector('.mobile-nav');

    menu_btn.addEventListener('click', function () {
        menu_btn.classList.toggle('is-active');
        mobile_menu.classList.toggle('is-active');
    });




    const ctx = document.getElementById('workoutScatterChart').getContext('2d');
    const workoutScatterChart = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Workouts Over Time',
                data: workoutData,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                pointRadius: 6,
                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                //pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBorderWidth: 2,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: 'rgba(255, 206, 86, 1)',
                pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'MMM DD, YYYY',
                        displayFormats: {
                            day: 'MMM DD'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Workout Presence'
                    },
                    ticks: {
                        display: false, // Skjuler y-aksen, da værdien altid er 1
                        beginAtZero: true,
                        suggestedMax: 2
                    }
                }
            }
        }
    });
}