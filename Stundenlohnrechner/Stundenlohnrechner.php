<script>
    <?php include_once "stundenlohnrechner.js"?>
</script>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"/>
<script src="https://kit.fontawesome.com/7734d1125e.js" crossorigin="anonymous"></script>
<style>
    <?php include_once "stundenlohnrechner.css"?>
</style>
<div>
    <div>
        <span class="fs-1 fw-light">Brutto-Stundenlohnrechner</span>
        <p class="mb-3">Berechnen Sie anhand ihrer Arbeitszeiten den Zuschlag, der Ihnen zusteht.</p>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between">
        <div>
            <label for="weeklyHoursInput">Wochenstunden</label>
            <input class="form-control" onchange="calculateBruttoStundenLohn()" placeholder="Enter weekly hours" type="text" id="weeklyHoursInput" alt="weekly hours"/>
        </div>
        <i class="fa-solid fa-x m-3"></i>
        <div>
            <label for="weeklyHourFactor">Faktor</label>
            <input class="form-control" onchange="" value="4.35" disabled type="text" id="weeklyHourFactor" alt="weekly hour factor"/>
        </div>
        <div class="mt-3 me-4">
            <i class="fa-solid fa-equals"></i>
        </div>
        <div style="min-width: 230px" class="d-flex p-3 align-items-center additionalWageResultContainer">
            <span id="monthlyHours" class="fs-3 me-2"></span>
            <span class="fs-4 ms-2 ">Monatsstunden</span>
        </div>
    </div>
    <div class="d-flex flex-row align-items-center justify-content-between mt-5">
        <div>
            <label for="bruttoWage">Bruttogehalt</label>
            <input class="form-control" onchange="calculateBruttoStundenLohn()" placeholder="Bruttogehalt" type="text" id="bruttoWage" alt="Bruttogehalt"/>
        </div>
        <i class="fa-solid fa-divide m-3"></i>
        <div>
            <label for="monthlyHours2">Monatsstunden</label>
            <input class="form-control" onchange="" disabled type="text" id="monthlyHours2" alt="Bruttogehalt"/>
        </div>
        <div class="mt-3 me-4">
            <i class="fa-solid fa-equals"></i>
        </div>
        <div style="min-width: 230px" class="d-flex p-3 align-items-center additionalWageResultContainer">
            <span id="wagePerHourBrutto" class="fs-3 me-2"></span>
            <span class="fs-4 ms-2 ">€ pro Std.</span>
        </div>
    </div>
</div>