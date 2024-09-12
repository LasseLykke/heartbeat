window.onload = function () {
    const menu_btn = document.querySelector('.hamburger');
    const mobile_menu = document.querySelector('.mobile-nav');

    menu_btn.addEventListener('click', function () {
        menu_btn.classList.toggle('is-active');
        mobile_menu.classList.toggle('is-active');
    });

    

    const ctx = document.getElementById('workoutBarChart').getContext('2d');
    
   
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
                barThickness: 20,
                maxBarThickness: 25
            },
            {
                label: '', // SPACING HACK - adds spacing between bars.
                borderColor: '#191A19',
                borderWidth: 0.1,
                borderRadius: 2,
                barThickness: 20,
                maxBarThickness: 25
            },
            
            {
                label: 'Hovedpiner',
                data: painData,
                backgroundColor: '#191A19',
                borderColor: '#191A19',
                borderWidth: 0.1,
                borderRadius: 2,
                barThickness: 20,
                maxBarThickness: 25
            }]
        },
        options: {
            backgroundColor: '#EA0300',
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
                    suggestedMax: 20
                }
            },
            plugins: {
                legend: {
                    position: '', //indsæt possion for labels 
                    labels: {
                      padding: 20,
                      font: {
                        size: 12
                      }}},
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
            }, 
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

const ctx = document.getElementById('workoutLineChart').getContext('2d');

// Opret chart
const workoutLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [{
            label: 'Abs Reps',
            data: absRepData,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            fill: false,
            tension: 0.4
        },
        {
            label: 'Abs Kilo',
            data: absKiloData,
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderWidth: 2,
            fill: false,
            tension: 0.4
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
                    unit: 'day',
                    tooltipFormat: 'DD/MM',
                    displayFormats: {
                        day: 'DD/MM',
                        suggestedMax: 10
                    }
                },
                ticks: {
                    source: 'auto',
                }
            },
            y: {
                position: 'right',
                beginAtZero: true,
                suggestedMax: 100,
                ticks: {
                    padding: 10 // Tilføj padding mellem ticks og aksen
            }
        }
        },
        layout: {
            padding: {
                left: 10 // Tilføj ekstra padding på venstre side af grafen
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    padding: 20,
                    font: {
                        size: 12
                    }
                }
            },
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

// Scroll til den seneste dato når grafen er færdig med at loade
setTimeout(function() {
    // Find containeren for grafen (f.eks. chart-container div'en)
    const chartContainer = document.querySelector('.export-charts');

    // Beregn total bredde af grafens scrollede område
    const totalWidth = chartContainer.scrollWidth;

    // Find indekset for den sidste dato i absRepData
    const lastIndex = absRepData.length - 1;

    // Beregn scroll-position
    const scrollPosition = (totalWidth / absRepData.length) * lastIndex;

    // Scroll containeren til sidste dato med data
    chartContainer.scrollLeft = scrollPosition - (chartContainer.clientWidth / 2);
}, 100);  // Vent et øjeblik for at sikre, at grafen er loadet