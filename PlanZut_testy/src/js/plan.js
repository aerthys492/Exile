import '../css/plan.css';

var Schedule = /** @class */ (function () {
    function Schedule() {
        this.filters = {
            sala: "",
            wykladowca: "",
            przedmiot: "",
            grupa: "",
            student: "",
            dateRange: "tydzien",
        };
        this.initEventListeners();
        this.fetchLessons();
    }

    Schedule.prototype.initEventListeners = function () {
        var _this = this;
        var salaInput = document.getElementById("sala");
        var wykladowcaInput = document.getElementById("wykladowca");
        var przedmiotInput = document.getElementById("przedmiot");
        var grupaInput = document.getElementById("grupa");
        var studentInput = document.getElementById("student");

        salaInput === null || salaInput === void 0 ? void 0 : salaInput.addEventListener("input", function (e) {
            return _this.updateFilter("sala", e.target.value);
        });
        wykladowcaInput === null || wykladowcaInput === void 0 ? void 0 : wykladowcaInput.addEventListener("input", function (e) {
            return _this.updateFilter("wykladowca", e.target.value);
        });
        przedmiotInput === null || przedmiotInput === void 0 ? void 0 : przedmiotInput.addEventListener("input", function (e) {
            return _this.updateFilter("przedmiot", e.target.value);
        });
        grupaInput === null || grupaInput === void 0 ? void 0 : grupaInput.addEventListener("input", function (e) {
            return _this.updateFilter("grupa", e.target.value);
        });
        studentInput === null || studentInput === void 0 ? void 0 : studentInput.addEventListener("input", function (e) {
            return _this.updateFilter("student", e.target.value);
        });

        var dateRangeInputs = document.querySelectorAll('input[name="dateRange"]');
        dateRangeInputs.forEach(function (input) {
            return input.addEventListener("change", function (e) {
                return _this.updateFilter("dateRange", e.target.value);
            });
        });

        var viewButtons = document.querySelectorAll('.view-buttons button');
        viewButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                viewButtons.forEach(function (btn) {
                    btn.classList.remove("selected");
                });
                button.classList.add("selected");
            });
        });

        document.getElementById("day-view").addEventListener("click", function () {
            _this.updateFilter("dateRange", "dzień");
            _this.showDay(new Date());
        });
        document.getElementById("week-view").addEventListener("click", function () {
            _this.updateFilter("dateRange", "tydzien");
            _this.showWeek();
        });
        document.getElementById("month-view").addEventListener("click", function () {
            _this.updateFilter("dateRange", "miesiac");
            _this.showMonth();
        });
    };

    Schedule.prototype.updateFilter = function (key, value) {
        if (key === "dateRange") {
            if (value === "tydzien") {
                this.filters[key] = value;
                this.showWeek();
            } else if (value === "dzień") {
                this.filters[key] = value;
                this.showDay(new Date()); // Show the current day
            } else if (value === "miesiac") {
                this.filters[key] = value;
                this.showMonth();
            } else {
                console.error(`Invalid value for ${key}: ${value}`);
            }
        } else {
            this.filters[key] = value;
        }
        console.log(`Updated filter: ${key} = ${this.filters[key]}`);
    };

    Schedule.prototype.fetchLessons = function () {
        var _this = this;
        fetch('./src/js/fetch_lessons.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetched lessons:', data); // Log fetched data
                _this.lessons = data;
                _this.showWeek(); // Automatically display the weekly schedule on page load
            })
            .catch(error => console.error('Error fetching lessons:', error));
    };

    Schedule.prototype.showWeek = function () {
        const calendar = document.querySelector('.calendar-grid');
        calendar.innerHTML = '';

        const currentDate = new Date();
        const currentDay = currentDate.getDay();
        const startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDay + (currentDay === 0 ? -6 : 1)); // Poniedziałek

        for (let i = 0; i < 7; i++) {
            const day = new Date(startOfWeek);
            day.setDate(startOfWeek.getDate() + i);

            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.innerHTML = `
                <div class="day-header">${day.toLocaleDateString('pl-PL', {
                weekday: 'long',
                day: 'numeric',
                month: 'numeric',
            })}</div>
            `;

            for (let hour = 8; hour <= 20; hour++) {
                const hourElement = document.createElement('div');
                hourElement.className = 'hour-slot';
                hourElement.innerHTML = `
                    <div class="hour-header">${hour}:00</div>
                    <div class="hour-content"></div>
                `;
                dayElement.appendChild(hourElement);
            }

            calendar.appendChild(dayElement);
        }

        this.renderLessons();
        console.log("Wyświetlono cały tydzień.");
    };

    Schedule.prototype.showDay = function (date) {
        const calendar = document.querySelector('.calendar-grid');
        calendar.innerHTML = '';

        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.innerHTML = `
        <div class="day-header">${date.toLocaleDateString('pl-PL', {
            weekday: 'long',
            day: 'numeric',
            month: 'numeric',
        })}</div>
    `;

        for (let hour = 8; hour <= 20; hour++) {
            const hourElement = document.createElement('div');
            hourElement.className = 'hour-slot';
            hourElement.innerHTML = `
            <div class="hour-header">${hour}:00</div>
            <div class="hour-content">Brak wydarzeń</div>
        `;
            dayElement.appendChild(hourElement);
        }

        calendar.appendChild(dayElement);
        console.log(`Wyświetlono tylko ${date.toLocaleDateString('pl-PL', { weekday: 'long' })}`);
    };

    Schedule.prototype.showMonth = function () {
        // Clear the current calendar view
        const calendar = document.querySelector('.calendar-grid');
        calendar.innerHTML = '';

        // Get the current date
        const currentDate = new Date();
        const startOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const endOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

        // Generate the month view
        for (let day = startOfMonth; day <= endOfMonth; day.setDate(day.getDate() + 1)) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.innerHTML = `
            <div class="day-header">${day.toLocaleDateString('pl-PL', { day: 'numeric', month: 'numeric' })}</div>
            <div class="day-content">No events</div>
        `;

            calendar.appendChild(dayElement);
        }

        console.log("Displaying the entire month");
    };

    Schedule.prototype.renderLessons = function () {
        if (!this.lessons) {
            console.error('Lessons data is not available.');
            return;
        }

        const calendar = document.querySelector('.calendar-grid');
        this.lessons.forEach(lesson => {
            const lessonDate = new Date(lesson.date_lessons);
            const dayIndex = (lessonDate.getDay() + 6) % 7; // Adjust for Monday start
            const startHour = parseInt(lesson.time_start.split(':')[0]);
            const endHour = parseInt(lesson.time_end.split(':')[0]);
            const duration = endHour - startHour;

            const lessonElement = document.createElement('div');
            lessonElement.className = 'lesson';
            lessonElement.style.gridRow = `${startHour - 7} / span ${duration}`;
            lessonElement.style.gridColumn = dayIndex + 1;
            lessonElement.innerHTML = `
                <div class="lesson-content">
                    <div class="lesson-time">${lesson.time_start} - ${lesson.time_end}</div>
                    <div class="lesson-name">${lesson.description.split(',')[0]}</div>
                    <div class="lesson-type">${lesson.description.split(',')[1]}</div>
                </div>
            `;

            const lessonType = lesson.description.split(',')[1].trim().toLowerCase();
            lessonElement.classList.add(lessonType);

            calendar.appendChild(lessonElement);
        });
    };

    return Schedule;
}());

new Schedule();