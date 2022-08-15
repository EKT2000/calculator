function calculateHours(von, bis) {
    const vonZeitStr = von;
    const bisZeitStr = bis;
    if (vonZeitStr !== "" && bisZeitStr !== "") {
        const vonHours = Number.parseInt(vonZeitStr.slice(0,2))
        const vonMinutes = Number.parseInt(vonZeitStr.slice(3,5))
        const vonDayMinutes = vonHours * 60 + vonMinutes;

        const bisHours = Number.parseInt(bisZeitStr.slice(0,2))
        const bisMinutes = Number.parseInt(bisZeitStr.slice(3,5))
        let bisDayMinutes = bisHours * 60 + bisMinutes;

        let minutesWorked;

        if(bisDayMinutes < vonDayMinutes) {
            bisDayMinutes = bisDayMinutes + 1440;
        }
        minutesWorked = bisDayMinutes - vonDayMinutes;
        const isEven = minutesWorked % 60 === 0;
        const hoursWorked = minutesWorked / 60
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

}

function calculateWorkingTimes() {
    const vonZeitStr = $('#arbeitsBeginn')[0].value;
    const bisZeitStr = $('#arbeitsEnde')[0].value;

    const timeObj = calculateHours(vonZeitStr, bisZeitStr)

    $('#hoursValue')[0].innerHTML = timeObj.hours;
    $('#minutesValue')[0].innerHTML = timeObj.minutes;
}