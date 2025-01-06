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
        var _a, _b, _c, _d, _e;
        (_a = document.getElementById("sala")) === null || _a === void 0 ? void 0 : _a.addEventListener("input", function (e) {
            return _this.updateFilter("sala", e.target.value);
        });
        (_b = document.getElementById("wykladowca")) === null || _b === void 0 ? void 0 : _b.addEventListener("input", function (e) {
            return _this.updateFilter("wykladowca", e.target.value);
        });
        (_c = document.getElementById("przedmiot")) === null || _c === void 0 ? void 0 : _c.addEventListener("input", function (e) {
            return _this.updateFilter("przedmiot", e.target.value);
        });
        (_d = document.getElementById("grupa")) === null || _d === void 0 ? void 0 : _d.addEventListener("input", function (e) {
            return _this.updateFilter("grupa", e.target.value);
        });
        (_e = document.getElementById("student")) === null || _e === void 0 ? void 0 : _e.addEventListener("input", function (e) {
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
        if (key === "dateRange" && (value === "tydzien" || value === "miesiac")) {
            // Obsługa pola dateRange z walidacją
            this.filters[key] = value;
        }
        else if (key !== "dateRange") {
            // Obsługa pozostałych pól
            this.filters[key] = value;
        }
        else {
            console.error("Invalid value for ".concat(key, ": ").concat(value));
        }
        console.log("Updated filter: ".concat(key, " = ").concat(this.filters[key]));
    };
    return Schedule;
}());
new Schedule();
