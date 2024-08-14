window.onload = function () {
    const menu_btn = document.querySelector('.hamburger');
    const mobile_menu = document.querySelector('.mobile-nav');

    menu_btn.addEventListener('click', function () {
        menu_btn.classList.toggle('is-active');
        mobile_menu.classList.toggle('is-active');
    });

    const ctx = document.getElementById('workoutScatterChart').getContext('2d');

    // Få den nuværende dato
    const today = moment();

    const workoutBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Workouts',
                data: workoutData,
                backgroundColor: '#EA0300',
                borderColor: '#191A19',
                borderWidth: 0.1,
                borderRadius: 2,
                barThickness: 15,
                maxBarThickness: 10
            },
            {
                label: 'Hovedpiner',
                data: painData,
                backgroundColor: '#191A19',
                borderColor: '#EA0300',
                borderWidth: 0.1,
                borderRadius: 2,
                barThickness: 15,
                maxBarThickness: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 4,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'MMM YYYY',
                        displayFormats: {
                            month: 'MMM YYYY'
                        }
                    },
                    min: moment(workoutData[0].x).toDate(),
                    max: moment(workoutData[workoutData.length - 1].x).toDate(),
                    ticks: {
                        source: 'auto',
                    }
                },
                y: {
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

    // Initial scroll to the current month
    setTimeout(function() {
        const frontpageCharts = document.querySelector('.frontpage-charts');
        const totalMonths = workoutData.length;
        const currentMonthIndex = workoutData.findIndex(d => d.x.startsWith(today.format('YYYY-MM')));

        // Beregn scroll-position
        const scrollPosition = (frontpageCharts.scrollWidth / totalMonths) * currentMonthIndex;

        // Juster scroll-position
        frontpageCharts.scrollLeft = scrollPosition - (frontpageCharts.clientWidth / 2);
    }, 100);  // Giver grafen tid til at loade før scroll
}
