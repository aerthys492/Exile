type Filter = {
    sala: string;
    wykladowca: string;
    przedmiot: string;
    grupa: string;
    student: string;
    dateRange: "tydzien" | "miesiac";
};

class Schedule {
    filters: Filter = {
        sala: "",
        wykladowca: "",
        przedmiot: "",
        grupa: "",
        student: "",
        dateRange: "tydzien",
    };

    constructor() {
        this.initEventListeners();
    }

    initEventListeners() {
        document.getElementById("sala")?.addEventListener("input", (e) =>
            this.updateFilter("sala", (e.target as HTMLInputElement).value)
        );
        document.getElementById("wykladowca")?.addEventListener("input", (e) =>
            this.updateFilter("wykladowca", (e.target as HTMLInputElement).value)
        );
        document.getElementById("przedmiot")?.addEventListener("input", (e) =>
            this.updateFilter("przedmiot", (e.target as HTMLInputElement).value)
        );
        document.getElementById("grupa")?.addEventListener("input", (e) =>
            this.updateFilter("grupa", (e.target as HTMLInputElement).value)
        );
        document.getElementById("student")?.addEventListener("input", (e) =>
            this.updateFilter("student", (e.target as HTMLInputElement).value)
        );

        const dateRangeInputs = document.querySelectorAll('input[name="dateRange"]');
        dateRangeInputs.forEach((input) =>
            input.addEventListener("change", (e) =>
                this.updateFilter("dateRange", (e.target as HTMLInputElement).value)
            )
        );
    }

    updateFilter(key: keyof Filter, value: string) {
        if (key === "dateRange" && (value === "tydzien" || value === "miesiac")) {
            // Obsługa pola dateRange z walidacją
            this.filters[key] = value;
        } else if (key !== "dateRange") {
            // Obsługa pozostałych pól
            this.filters[key] = value;
        } else {
            console.error(`Invalid value for ${key}: ${value}`);
        }
        console.log(`Updated filter: ${key} = ${this.filters[key]}`);
    }
}

new Schedule();
