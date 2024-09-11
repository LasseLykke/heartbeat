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

// NY LINE BAR

const ctx = document.getElementById('workoutLineChart').getContext('2d');

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
            tension: 0.4 // Gør linjen mere smooth
        },
        {
            label: 'Abs Kilo',
            data: absKiloData,
            borderColor: 'rgba(153, 102, 255, 1)',
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderWidth: 2,
            fill: false,
            tension: 0.4 // Gør linjen mere smooth
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
                    tooltipFormat: 'DD MM',
                    displayFormats: {
                        day: 'DD/MM'
                    }
                },
                min: moment(absRepData[0].x).toDate(), // Start fra første dato
                max: moment(absRepData[absRepData.length - 1].x).toDate(), // Slut ved sidste dato
                ticks: {
                    source: 'auto',
                }
            },
            y: {
                beginAtZero: true,
                suggestedMax: 100 //Maks load på maskinen.
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

// Initial scroll to the current day for workoutLineChart
setTimeout(function() {
    const lineChartContainer = document.querySelector('#workoutLineChart').parentNode; // Forvent at grafen er i dens parent container
    const totalDays = absRepData.length;
    const todayStr = today.format('DD-MM'); // Formaterer dagens dato til 'YYYY-MM-DD'
    
    // Find indekset for den nuværende dag
    const currentDayIndex = absRepData.findIndex(d => moment(d.x).format('DD-MM') === todayStr);

    // Hvis den nuværende dag ikke findes i dataene, brug den sidste dag
    const indexToScrollTo = currentDayIndex === -1 ? totalDays - 1 : currentDayIndex;

    // Beregn scroll-position for linjegraf
    const scrollPosition = (chartWidth / totalDays) * indexToScrollTo;

    // Juster scroll-position til at centrere den aktuelle dag
    lineChartContainer.scrollLeft = scrollPosition - (chartContainerWidth / 2);
}, 100);  // Giver grafen tid til at loade før scroll