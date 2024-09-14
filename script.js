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



// ABS GRAF

    // Formaterer datoerne manuelt til DD/MM format
    const formattedDates = absRepData.map(data => {
        const date = new Date(data.x); // Opretter dato objekt
        const day = String(date.getDate()).padStart(2, '0'); // Henter dag med 2 cifre
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Henter måned med 2 cifre (0-indekseret)
        return `${day}/${month}`; // Returnerer i DD/MM format
    });

    // Chart.js konfiguration
    const ctx = document.getElementById('workoutLineChart').getContext('2d');
    const workoutLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedDates, // Brug de formaterede datoer som labels
            datasets: [
                {
                    label: 'Reps',
                    data: absRepData.map(data => data.y), // Brug kun y-værdierne (reps)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Kilo',
                    data: absKiloData.map(data => data.y), // Brug kun y-værdierne (kilo)
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 4,
            scales: {
                x: {
                    type: 'category',
                time: {
                    unit: 'day',
                    tooltipFormat: 'DD/MM',
                    displayFormats: {
                        day: 'DD/MM'
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
                    title: {
                        display: true,
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
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


// Collapsible tables
document.addEventListener("DOMContentLoaded", function() {
    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }
});
