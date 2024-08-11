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
                label: 'Workouts',
                data: workoutData,  // Aggregated workout data by month
                backgroundColor: '#C0C0C0',
                borderColor: 'var(--grey)',
                borderWidth: 1,
                borderRadius: 2,
                barThickness: 15,
                maxBarThickness: 10
            },
            {
                label: 'Hovedpiner',
                data: painData,  // Aggregated pain data by month
                backgroundColor: 'var(--feat)',
                borderColor: 'var(--grey)',
                borderWidth: 1,
                borderRadius: 2,
                barThickness: 15,
                maxBarThickness: 10
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',  // Gruppér dataene efter måned
                        tooltipFormat: 'MMM YYYY',
                        displayFormats: {
                            month: 'MMM YYYY'
                        }
                    },
                    title: {
                        display: true,
                        text: ''
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: ''
                    },
                    beginAtZero: true,
                    suggestedMax: 30
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