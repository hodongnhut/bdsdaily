document.addEventListener("DOMContentLoaded", function () {
    const calendarBody = document.getElementById("calendar-body");
    const monthYearDisplay = document.getElementById("monthYear");
    const prevMonthButton = document.getElementById("prevMonth");
    const nextMonthButton = document.getElementById("nextMonth");

    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    // Render calendar for the current month and year
    function renderCalendar(year, month) {
        // Clear existing calendar cells
        calendarBody.innerHTML = "";

        // Get the first day of the month
        const firstDay = new Date(year, month, 1).getDay();
        // Get the number of days in the month
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Update month and year display
        monthYearDisplay.textContent = `${year} - Tháng ${month + 1}`;

        // Generate calendar rows
        let date = 1;
        for (let i = 0; i < 6; i++) {
            const row = document.createElement("tr");

            for (let j = 0; j < 7; j++) {
                const cell = document.createElement("td");

                if (i === 0 && j < firstDay) {
                    // Empty cells before the first day of the month
                    cell.textContent = "";
                } else if (date > daysInMonth) {
                    // Empty cells after the last day of the month
                    cell.textContent = "";
                } else {
                    cell.textContent = date;

                    // Highlight today's date
                    if (
                        date === today.getDate() &&
                        month === today.getMonth() &&
                        year === today.getFullYear()
                    ) {
                        cell.classList.add("today");
                    }

                    // Add lunar date
                    try {
                        const lunarDate = Lunar.fromDate(new Date(year, month, date));
                        const lunarDay = lunarDate.getDay();
                        const lunarMonth = lunarDate.getMonth();

                        const lunarInfo = document.createElement("small");
                        lunarInfo.textContent = ` ${lunarDay}/${lunarMonth}`;
                        lunarInfo.style.display = "block"; // Ensure it doesn't disrupt layout
                        cell.appendChild(lunarInfo);
                    } catch (error) {
                        console.error("Lunar.js error:", error);
                    }

                    date++;
                }

                row.appendChild(cell);
            }

            calendarBody.appendChild(row);
        }
    }

    // Move to the previous month
    prevMonthButton.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentYear, currentMonth);
    });

    // Move to the next month
    nextMonthButton.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentYear, currentMonth);
    });

    // Initial render
    renderCalendar(currentYear, currentMonth);
});
