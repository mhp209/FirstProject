
      document.addEventListener("DOMContentLoaded", function () {
        const calendarContainer = document.getElementById("calendar-container");
  
        function generateCalendar(year, month) {
          const daysInMonth = new Date(year, month + 1, 0).getDate();
          const firstDayOfMonth = new Date(year, month, 1).getDay();
  
          let tableHtml = "<table>";
          tableHtml += "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
  
          let dayCounter = 1;
  
          for (let i = 0; i < 6; i++) {
            tableHtml += "<tr>";
  
            for (let j = 0; j < 7; j++) {
              if (i === 0 && j < firstDayOfMonth) {
                tableHtml += "<td></td>";
              } else if (dayCounter > daysInMonth) {
                tableHtml += "<td></td>";
              } else {
                tableHtml += `<td onclick="alert('Clicked on ${year}-${month + 1}-${dayCounter}')">${dayCounter}</td>`;
                dayCounter++;
              }
            }
  
            tableHtml += "</tr>";
          }
  
          tableHtml += "</table>";
          calendarContainer.innerHTML = tableHtml;
        }
  
        // Set the initial calendar to the current month
        const currentDate = new Date();
        generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
  
        // You can add navigation controls to switch between months or years as needed
        // For simplicity, I'll just show the next month for demonstration purposes
        document.addEventListener("click", function () {
          const nextMonthDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
          generateCalendar(nextMonthDate.getFullYear(), nextMonthDate.getMonth());
        });
      });
