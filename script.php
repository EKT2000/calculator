<?php

$rootHost = $protocol = $_SERVER['HTTP_HOST'] . "/";
$rootDocument = $_SERVER['DOCUMENT_ROOT'] . "/";

?>
<script>
    async function calculateWorkingTimes() {
        const vonZeitStr = $('#arbeitsBeginn')[0].value;
        const bisZeitStr = $('#arbeitsEnde')[0].value;


        const response = await fetch(`calculator.php?method=calculateDayAndNight&from=${vonZeitStr}&to=${bisZeitStr}`);
        const data = await response.json();
        console.log(data)

        this.workingTimeObj = data;
        calculateInDecimalHours()

        $('#dayHoursValue')[0].innerHTML = this.workingTimeObj.dayHours.hours < 10 ? "0" + this.workingTimeObj.dayHours.hours : this.workingTimeObj.dayHours.hours;
        $('#dayMinutesValue')[0].innerHTML = this.workingTimeObj.dayHours.minutes < 10 ? "0" + this.workingTimeObj.dayHours.minutes : this.workingTimeObj.dayHours.minutes;
        $('#nightHoursValue')[0].innerHTML = this.workingTimeObj.nightHours.hours < 10 ? "0" + this.workingTimeObj.nightHours.hours : this.workingTimeObj.nightHours.hours;
        $('#nightMinutesValue')[0].innerHTML = this.workingTimeObj.nightHours.minutes < 10 ? "0" + this.workingTimeObj.nightHours.minutes : this.workingTimeObj.nightHours.minutes;
    }

    // AB HIER ZUSCHLAGSBERECHNUNG

    function updateZuschlagInputValue() {
        const input = $('#zuschlag3Input')[0];
        const checkBox = $('#zuschlag3')[0];
        if (input.value.match('^[0-9,]*$') || input.value.match('^[0-9.]*$')) {
            input.classList.remove("is-invalid");
            const value = input.value.replace(",", ".")
            checkBox.value = Number.parseFloat(value);
            berechneZuschlag()
        } else if (input.value === "") {
            input.classList.remove("is-invalid");
        } else {
            input.classList.add("is-invalid");
        }
    }

    function changeZuschlag() {
        updateZuschlagInputValue()
        berechneZuschlag()
        const hours = Number.parseFloat($('#nightHoursFloat')[0].innerHTML);
        if (hours && this.zuschlagProStunde && this.workingTimeObj) {
            this.zuschlagProTag = (hours * this.zuschlagProStunde)
            $('#dailyZuschlag')[0].innerHTML = this.zuschlagProTag.toFixed(2);
        }
    }

    function getCheckZuschlagValue() {
        const comp = $('input[name="zuschlagSätze"]:checked')[0];
        return comp.value !== "NaN" ? comp.value : null;
    }

    async function berechneZuschlag() {
        const zuschlagProzentStr = getCheckZuschlagValue()
        const wageStr = $('#hourlyZuschlagWage')[0].value;
        if (zuschlagProzentStr && zuschlagProzentStr !== "" && wageStr !== "") {
            const wage = Number.parseFloat(wageStr);
            const zuschlagProzent = Number.parseFloat(zuschlagProzentStr);
            const response = await fetch(`calculator.php?method=calculateWagePerHour&hourly=${wage}&percent=${zuschlagProzent}`);
            const inner = await response.json();
            this.zuschlagProStunde = inner
            $('#zuschlagProStunde')[0].innerHTML = "" + inner
            $('#zuschlagProStunde2')[0].innerHTML = "" + inner
        }
    }

    function calculateInDecimalHours() {
        if (this.workingTimeObj) {
            $('#nightHoursFloat')[0].innerHTML = ((this.workingTimeObj.nightHours.hours * 60 + this.workingTimeObj.nightHours.minutes) / 60).toFixed(2)
        }
    }
</script>