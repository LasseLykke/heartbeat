window.onload = function () {
    const menu_btn = document.querySelector('.hamburger');
    const mobile_menu = document.querySelector('.mobile-nav');

    menu_btn.addEventListener('click', function () {
        menu_btn.classList.toggle('is-active');
        mobile_menu.classList.toggle('is-active');
    });




    const ctx = document.getElementById('workoutScatterChart').getContext('2d');
    const workoutBarChart = new Chart(ctx, {
        type: 'bar', 
        data: {
            datasets: [{
                label: 'Workouts Over Time',
                data: workoutData,  // Data fra din tidligere kode
                backgroundColor: 'var(--dark)',  // Skiftet til variabel farve
                borderColor: '#EA0300',
                borderWidth: 1,
                borderRadius: 2,
                barThickness: 2
            },
            {
                label: 'Pain Episodes Over Time',
                data: painData,  
                backgroundColor: 'rgba(255, 99, 132, 0.6)',  // Farve til det nye datasæt
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                borderRadius: 2,
                barThickness: 2
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'MMM DD',
                        displayFormats: {
                            day: 'MMM DD'
                        }
                    },
                    title: {
                        display: true,
                        text: 'month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Events'
                    },
                    beginAtZero: true,
                    suggestedMax: 10
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
    
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
}