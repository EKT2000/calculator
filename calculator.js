function calculateHoursFromTimeStrings(von, bis) {
    if (von !== "" && bis !== "") {
        const vonDayMinutes = getMinutesOfTimeString(von);
        let bisDayMinutes = getMinutesOfTimeString(bis);

        return calculateHourDifference(vonDayMinutes, bisDayMinutes, true);
    }
}

function calculateHourDifference(von, bis, useHours) {
    debugger
    let minutesWorked;

    if (bis <= von) {
        bis = bis + 1440;
    }
    minutesWorked = bis - von;
    return !useHours ? minutesWorked : getMinutesAndHoursOfMinutes(minutesWorked);

}

function getMinutesAndHoursOfMinutes(minutes) {
    const isEven = minutes % 60 === 0;
    const hoursWorked = minutes / 60
    if (isEven) {
        return {
            hours: hoursWorked,
            minutes: 0
        }
    } else {
        const hours = Math.floor(hoursWorked);
        const minuteRatio = hoursWorked - hours;
        const minutes = Math.round(minuteRatio * 60);
        return {
            hours: hours,
            minutes: minutes
        }
    }
}

function getMinutesOfTimeString(timeString) {
    const timeObj = getHoursAndMinutesFromTimeString(timeString)
    return timeObj.hours * 60 + timeObj.minutes;

}

function getHoursAndMinutesFromTimeString(timeStr) {
    const bisHours = Number.parseInt(timeStr.slice(0, 2))
    const bisMinutes = Number.parseInt(timeStr.slice(3, 5))
    return {
        hours: bisHours,
        minutes: bisMinutes
    }
}

function calculateNightAndDayWork(fromTime, toTime, nightWorkStart, nightWorkEnd) {
    let regularMins = 0;
    let nightMins = 0;
    if (fromTime < toTime) {
        if (toTime < nightWorkEnd) {
            console.log("Begin after 0 and end before 6 same day")
            nightMins = calculateHourDifference(fromTime, toTime);
        } else if (fromTime <= nightWorkEnd && toTime >= nightWorkEnd && toTime < nightWorkStart) {
            console.log("Begin before 6 and end after 6 and before 23")
            nightMins = calculateHourDifference(fromTime, nightWorkEnd);
            regularMins = calculateHourDifference(nightWorkEnd, toTime);
        } else if (fromTime < nightWorkEnd && toTime >= nightWorkStart) {
            console.log("Start before 6 and end after 23 same day")
            nightMins = calculateHourDifference(fromTime, nightWorkEnd) + calculateHourDifference(nightWorkStart, toTime)
            regularMins = calculateHourDifference(nightWorkEnd, nightWorkStart);
        } else if (fromTime >= nightWorkEnd && fromTime < nightWorkStart && toTime >= nightWorkStart) {
            console.log("Start after 6 and before 23 and end after 23 same day")
            nightMins = calculateHourDifference(nightWorkStart, toTime);
            regularMins = calculateHourDifference(fromTime, nightWorkStart);
        } else if (fromTime >= nightWorkEnd && fromTime >= nightWorkStart && toTime >= nightWorkStart) {
            console.log("Start after 23 and end after 23 same day")
            nightMins = calculateHourDifference(fromTime, toTime);
        }
    } else {
        if (fromTime < nightWorkEnd) {
            console.log("Begin between 0 and 6 and end next day between 0 and 6")
            nightMins = calculateHourDifference(fromTime, nightWorkEnd) + calculateHourDifference(nightWorkStart, toTime);
            regularMins = calculateHourDifference(nightWorkEnd, nightWorkStart);
        } else if (fromTime >= nightWorkEnd && fromTime < nightWorkStart && toTime >= nightWorkEnd && toTime < nightWorkStart) {
            console.log("Beginn after 6 and before 23 and end next day after 6 and before 23")
            nightMins = calculateHourDifference(nightWorkStart, nightWorkEnd);
            regularMins = calculateHourDifference(fromTime, nightWorkStart) + calculateHourDifference(nightWorkEnd, toTime);
        } else if (fromTime >= nightWorkStart && toTime >= nightWorkEnd && toTime < nightWorkStart) {
            console.log("Beginn after 23 and end after 6 and before 23 the next day")
            nightMins = calculateHourDifference(fromTime, nightWorkEnd);
            regularMins = calculateHourDifference(nightWorkEnd, toTime);
        } else if (fromTime < nightWorkStart && toTime < nightWorkEnd) {
            console.log("Beginn before 23 and end before 6 the next day");
            nightMins = calculateHourDifference(nightWorkStart, toTime);
            regularMins = calculateHourDifference(fromTime, nightWorkStart);
        } else if (fromTime >= nightWorkStart && toTime < nightWorkEnd) {
            console.log("Beginn after 23 and end before 6 the next day")
            nightMins = calculateHourDifference(fromTime, toTime)
        } else if (fromTime >= nightWorkStart && toTime >= nightWorkStart) {
            console.log("Start after 23 and end after 23 next day")
            nightMins = calculateHourDifference(fromTime, nightWorkEnd);
            regularMins = calculateHourDifference(nightWorkEnd, toTime);
        }
    }

    console.log(regularMins)
    const dayHH = getMinutesAndHoursOfMinutes(regularMins);
    const nightHH = getMinutesAndHoursOfMinutes(nightMins)
    return {
        dayHours: dayHH,
        nightHours: nightHH,
    }
}

function calculateWorkingTimes() {
    const vonZeitStr = $('#arbeitsBeginn')[0].value;
    const bisZeitStr = $('#arbeitsEnde')[0].value;

    if (bisZeitStr !== "" && vonZeitStr !== "") {
        const fromTimeMin = getMinutesOfTimeString(vonZeitStr);
        const toTimeMin = getMinutesOfTimeString(bisZeitStr);
        const nightWorkStart = getMinutesOfTimeString("23:00")
        const nightWorkEnd = getMinutesOfTimeString("06:00")

        let nightWorkPresent = true;

        if (fromTimeMin > nightWorkEnd && fromTimeMin < nightWorkStart && toTimeMin < nightWorkStart && toTimeMin > nightWorkEnd && fromTimeMin < toTimeMin) {
            console.log("Time is not influenced by night")
            nightWorkPresent = false;
        }

        let returnObj;

        if (nightWorkPresent) {
            returnObj = calculateNightAndDayWork(fromTimeMin, toTimeMin, nightWorkStart, nightWorkEnd)
        } else {
            const timeObj = calculateHoursFromTimeStrings(vonZeitStr, bisZeitStr, true)
            returnObj = {
                dayHours: timeObj,
                nightHours: {hours: 0, minutes: 0},
            }
        }

        $('#dayHoursValue')[0].innerHTML = returnObj.dayHours.hours;
        $('#dayMinutesValue')[0].innerHTML = returnObj.dayHours.minutes;
        $('#nightHoursValue')[0].innerHTML = returnObj.nightHours.hours;
        $('#nightMinutesValue')[0].innerHTML = returnObj.nightHours.minutes;
    }
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
    berechneZuschlag()
}

function getCheckZuschlagValue() {
    return $('input[name="zuschlagSätze"]:checked')[0].value;
}

function berechneZuschlag() {
    const zuschlagProzentStr = getCheckZuschlagValue()
    const wageStr = $('#hourlyZuschlagWage')[0].value;
    if (zuschlagProzentStr !== "" && wageStr !== "") {
        const wage = Number.parseFloat(wageStr);
        const zuschlagProzent = Number.parseFloat(zuschlagProzentStr);
        $('#zuschlagProStunde')[0].innerHTML = "" +  wage * zuschlagProzent / 100
    }
}