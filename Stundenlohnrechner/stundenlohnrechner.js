function calculateBruttoStundenLohn() {
    const weeklyHours = $('#weeklyHoursInput')[0].value;
    const bruttoWage = $('#bruttoWage')[0].value;

    if (!weeklyHours || weeklyHours === "") {
        return;
    }
    if ((weeklyHours.match('^[0-9,]*$') || weeklyHours.match('^[0-9.]*$'))) {
        this.monthlyHours = (Number.parseFloat(weeklyHours) * 4.35).toFixed(2);
        $("#monthlyHours")[0].innerHTML = this.monthlyHours;
        $("#monthlyHours2")[0].value = this.monthlyHours;
    }

    if (bruttoWage && bruttoWage !== "" && bruttoWage.match('^[0-9,]*$') || bruttoWage.match('^[0-9.]*$')) {
        this.bruttoWage = bruttoWage;
        if (this.monthlyHours) {
            $('#wagePerHourBrutto')[0].innerHTML = (this.bruttoWage / this.monthlyHours).toFixed(2);
        }
    }
}