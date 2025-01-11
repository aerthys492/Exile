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
    };

    Schedule.prototype.updateFilter = function (key, value) {
        if (key === "dateRange") {
            if (value === "tydzien" || value === "miesiac") {
                this.filters[key] = value;
                // Show the entire week
                this.showWeek();
            } else if (value === "dzień") {
                this.filters[key] = value;
                // Show only one day (Monday)
                this.showDay("Monday");
            } else {
                console.error(`Invalid value for ${key}: ${value}`);
            }
        } else {
            this.filters[key] = value;
        }
        console.log(`Updated filter: ${key} = ${this.filters[key]}`);
    };

    Schedule.prototype.showWeek = function () {
        // Logic to display the entire week
        console.log("Displaying the entire week");
    };

    Schedule.prototype.showDay = function (day) {
        // Logic to display only one day
        console.log(`Displaying only ${day}`);
    };

    return Schedule;
}());

new Schedule();