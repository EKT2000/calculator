<html lang="de">
<head>
    <title>Zuschlagcalculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
            integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"/>
    <script src="https://kit.fontawesome.com/7734d1125e.js" crossorigin="anonymous"></script>

    <script><?php include_once "calculator.js" ?></script>
    <style>
        <?php include_once "styles.css"?>
    </style>
</head>
<body>
<div class="container p-5">
    <h1 class="fw-lighter">Zuschlagscalculator</h1>
    <p class="mb-3">Berechnen Sie anhand ihrer Arbeitszeiten den Zuschlag, der Ihnen zusteht.</p>
    <div class="d-inline-block">
        <div class="d-flex flex-row align-items-center">
            <div class="d-flex flex-row align-items-center p-3 timeFormContainer">
                <div class="mb-3 me-3">
                    <label for="arbeitsBeginn" class="form-label">Arbeitsbeginn</label>
                    <input onchange="calculateWorkingTimes()" type="time" class="form-control" id="arbeitsBeginn"
                           aria-describedby="emailHelp">
                </div>
                <i class="fa-solid fa-clock"></i>
                <div class="mb-3 ms-3">
                    <label for="arbeitsEnde" class="form-label">Arbeitsende</label>
                    <input onchange="calculateWorkingTimes()" type="time" class="form-control" id="arbeitsEnde">
                </div>
            </div>
            <div class="ms-4 me-4 h-100">
                <i class="fa-solid fa-equals"></i>
            </div>
            <div class="d-flex p-3 h-100 align-items-center timeFormResultContainer timeResultDay">
                <i class="fa-solid fa-sun m-3 fs-1"></i>
                <span id="dayHoursValue" class="h2"></span><span class="h2 ms-2 me-2">Std.</span>
                <span id="dayMinutesValue" class="h2"></span><span class="h2 ms-2">Min.</span>
            </div>
            <div class="d-flex p-3 m-3 h-100 align-items-center timeFormResultContainer timeResultNight">
                <i class="fa-solid fa-moon m-3 fs-1"></i>
                <span id="nightHoursValue" class="h2"></span><span class="h2 ms-2 me-2">Std.</span>
                <span id="nightMinutesValue" class="h2"></span><span class="h2 ms-2">Min.</span>
            </div>
        </div>
        <div class="d-flex flex-row align-items-center">
            <input class="form-control w-25" placeholder="Enter hourly wage (€)" type="text" id="hourlyZuschlagWage" alt="hourly wage"/>
            <i class="fa-solid fa-x m-3"></i>
            <div class="d-flex flex-column">
                <div class="checkboxes mt-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" onchange="changeZuschlag()" type="radio" name="zuschlagSätze" id="zuschlag1" value="25">
                        <label class="form-check-label" for="zuschlag1">
                            25 %
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" onchange="changeZuschlag()" type="radio" name="zuschlagSätze" id="zuschlag2" value="35">
                        <label class="form-check-label" for="zuschlag2">
                            35 %
                        </label>
                    </div>
                    <div class="form-check mb-2 d-flex flex-row align-items-center">
                        <input class="form-check-input" onchange="changeZuschlag()" type="radio" name="zuschlagSätze" id="zuschlag3" value="">
                        <div class="d-flex flex-row align-items-center">
                            <input id="zuschlag3Input" onchange="updateZuschlagInputValue()" type="text" class="w-50 form-control ms-2 me-2"> <span> %</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ms-4 mt-3 me-4 h-100">
                <i class="fa-solid fa-equals"></i>
            </div>
            <div class="d-flex p-3 m-3 h-100 align-items-center additionalWageResultContainer">
                <span id="zuschlagProStunde" class="h2"></span><span class="h2 ms-2 me-2">Zuschlag pro Std.</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>

