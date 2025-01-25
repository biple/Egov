// Function to populate year, month, and day options for Gregorian calendar
function populateOptions() {
    var yearSelect = document.getElementById("dob_year");
    var monthSelect = document.getElementById("dob_month");
    var daySelect = document.getElementById("dob_day");
    var currentYear = new Date().getFullYear();

    // Populate year options
    for (var i = 1900; i <= currentYear; i++) {
        var option = document.createElement("option");
        option.text = i;
        option.value = i;
        yearSelect.add(option);
    }

    // Populate month options
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    months.forEach(function(month, index) {
        var option = document.createElement("option");
        var monthValue = index + 1;
        option.text = month;
        option.value = monthValue < 10 ? "0" + monthValue : monthValue;
        monthSelect.add(option);
    });

    // Function to dynamically update the number of days based on the selected year and month
    function updateDays() {
        var selectedYear = yearSelect.value;
        var selectedMonth = monthSelect.value;
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();

        // Remove existing day options
        daySelect.innerHTML = "<option value=''>Day</option>";

        // Populate day options
        for (var i = 1; i <= daysInMonth; i++) {
            var option = document.createElement("option");
            option.text = i < 10 ? "0" + i : i;
            option.value = i < 10 ? "0" + i : i;
            daySelect.add(option);
        }
    }

    // Call updateDays when year or month changes
    yearSelect.addEventListener("change", updateDays);
    monthSelect.addEventListener("change", updateDays);

    // Update days initially
    updateDays();
}

// Function to populate year, month, and day options for Nepali calendar
function populateNepaliOptions() {
    var nepaliYearSelect = document.getElementById("nepali_dob_year");
    var nepaliMonthSelect = document.getElementById("nepali_dob_month");
    var nepaliDaySelect = document.getElementById("nepali_dob_day");

    // Populate year options for Nepali calendar
    for (var i = 1950; i <= 2081; i++) {
        var option = document.createElement("option");
        option.text = i;
        option.value = i;
        nepaliYearSelect.add(option);
    }

    // Populate month options for Nepali calendar
    var nepaliMonths = ["Baishakh", "Jestha", "Ashadh", "Shrawan", "Bhadra", "Ashwin", "Kartik", "Mangsir", "Poush", "Magh", "Falgun", "Chaitra"];
    nepaliMonths.forEach(function(month, index) {
        var option = document.createElement("option");
        var monthValue = index + 1;
        option.text = month;
        option.value = monthValue < 10 ? "0" + monthValue : monthValue;
        nepaliMonthSelect.add(option);
    });

    // Function to dynamically update the number of days based on the selected year and month
    function updateNepaliDays() {
        var selectedYear = nepaliYearSelect.value;
        var selectedMonth = nepaliMonthSelect.value;
        var daysInMonth = 32; // Maximum days in any Nepali month

        // Adjust days for certain months
        if (selectedMonth === "01" || selectedMonth === "02" || selectedMonth === "04" || selectedMonth === "07" || selectedMonth === "09" || selectedMonth === "11") {
            daysInMonth = 31;
        } else if (selectedMonth === "03" || selectedMonth === "06" || selectedMonth === "08" || selectedMonth === "10") {
            daysInMonth = 32;
        } else if (selectedMonth === "05") {
            // Leap year calculation (Nepali calendar)
            if ((selectedYear % 100 !== 0 && selectedYear % 4 === 0) || (selectedYear % 400 === 0)) {
                daysInMonth = 33;
            } else {
                daysInMonth = 32;
            }
        } else if (selectedMonth === "12") {
            // Last month of Nepali year
            daysInMonth = 30;
        }

        // Remove existing day options
        nepaliDaySelect.innerHTML = "<option value=''>Day</option>";

        // Populate day options
        for (var i = 1; i <= daysInMonth; i++) {
            var option = document.createElement("option");
            option.text = i < 10 ? "0" + i : i;
            option.value = i < 10 ? "0" + i : i;
            nepaliDaySelect.add(option);
        }
    }

    // Call updateNepaliDays when year or month changes
    nepaliYearSelect.addEventListener("change", updateNepaliDays);
    nepaliMonthSelect.addEventListener("change", updateNepaliDays);

    // Update days initially
    updateNepaliDays();
}

// Call the functions to populate options when the page loads
populateOptions();
populateNepaliOptions();

// JavaScript to toggle spouse's name field based on checkbox state and adjust validation
document.addEventListener("DOMContentLoaded", function() {
    var hasSpouseCheckbox = document.getElementById("has_spouse");
    var spouseNameFields = document.querySelector(".spouse-name");
    var spouseFirstNameInput = document.getElementById("spouse_first_name");
    var spouseMiddleNameInput = document.getElementById("spouse_middle_name");
    var spouseLastNameInput = document.getElementById("spouse_last_name");

    // Function to toggle the disabled state and validation of spouse's name fields
    function toggleSpouseFields() {
        if (hasSpouseCheckbox.checked) {
            spouseNameFields.querySelectorAll("input").forEach(function(input) {
                input.disabled = false;
                // If the user confirms having a spouse, mark first and last name as required
                if (input === spouseFirstNameInput || input === spouseLastNameInput) {
                    input.required = true;
                } else {
                    // Middle name is optional if user has a spouse
                    input.required = false;
                }
            });
        } else {
            spouseNameFields.querySelectorAll("input").forEach(function(input) {
                input.disabled = true;
                input.required = false; // Reset required attribute
            });
        }
    }

    // Call toggleSpouseFields function initially
    toggleSpouseFields();

    // Add event listener to checkbox for toggling spouse's name fields
    hasSpouseCheckbox.addEventListener("change", toggleSpouseFields);
});
