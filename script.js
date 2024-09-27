window.onload = function () {
  const menu_btn = document.querySelector(".hamburger");
  const mobile_menu = document.querySelector(".mobile-nav");

  menu_btn.addEventListener("click", function () {
    menu_btn.classList.toggle("is-active");
    mobile_menu.classList.toggle("is-active");
  });

  const ctx = document.getElementById("workoutBarChart").getContext("2d");

  // Få den nuværende dato
  const today = moment();

  // Opret en gradient for workoutData
  const workoutGradient = ctx.createLinearGradient(0, 0, 0, 800);
  workoutGradient.addColorStop(0, "#FF4F18"); // Start farve
  workoutGradient.addColorStop(1, "#FFD700"); // Slut farve


  const workoutBarChart = new Chart(ctx, {
    type: "bar",
    data: {
      datasets: [
        {
          label: "Workouts",
          data: workoutData,
          backgroundColor: workoutGradient,
          borderColor: "#191A19",
          borderWidth: 0.1,
          borderRadius: 2,
          barThickness: 20,
          maxBarThickness: 25,
        },
        {
          label: "", // SPACING HACK - adds spacing between bars.
          borderColor: "#191A19",
          borderWidth: 0.1,
          borderRadius: 2,
          barThickness: 20,
          maxBarThickness: 25,
        },

        {
          label: "Hovedpiner",
          data: painData,
          backgroundColor: '#B98473',
          borderColor: "#191A19",
          borderWidth: 0.1,
          borderRadius: 2,
          barThickness: 20,
          maxBarThickness: 25,
        },
      ],
    },
    options: {
      backgroundColor: "#EA0300",
      responsive: true,
      maintainAspectRatio: true,
      aspectRatio: 4,
      scales: {
        x: {
          type: "time",
          time: {
            unit: "month",
            tooltipFormat: "MMM YYYY",
            displayFormats: {
              month: "MMM YYYY",
            },
          },
          min: moment(workoutData[0].x).toDate(),
          max: moment(workoutData[workoutData.length - 1].x).toDate(),
          ticks: {
            source: "auto",
          },
        },
        y: {
          beginAtZero: true,
          suggestedMax: 20,
        },
      },
      plugins: {
        legend: {
          position: "", //indsæt possion for labels
          labels: {
            padding: 20,
            font: {
              size: 12,
            },
          },
        },
        tooltip: {
          displayColors: false, // Fjerner farve for når man hover over.
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || "";
              if (label) {
                label += ": ";
              }
              if (context.parsed.y !== null) {
                label += context.parsed.y;
              }
              return label;
            },
          },
        },
      },
    },
  });

  // Initial scroll to the current month
  setTimeout(function () {
    const frontpageCharts = document.querySelector(".frontpage-charts");
    const totalMonths = workoutData.length;
    const currentMonthIndex = workoutData.findIndex((d) =>
      d.x.startsWith(today.format("YYYY-MM"))
    );

    // Beregn scroll-position
    const scrollPosition =
      (frontpageCharts.scrollWidth / totalMonths) * currentMonthIndex;

    // Juster scroll-position
    frontpageCharts.scrollLeft =
      scrollPosition - frontpageCharts.clientWidth / 2;
  }, 100); // Giver grafen tid til at loade før scroll
};

// Collapsible tables
document.addEventListener("DOMContentLoaded", function () {
  var coll = document.getElementsByClassName("collapsible");
  for (var i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function () {
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
