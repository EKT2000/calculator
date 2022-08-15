    <html lang="de">
    <head>
        <title>Zuschlagcalculator</title>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
                integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"/>
        <script src="https://kit.fontawesome.com/7734d1125e.js" crossorigin="anonymous"></script>

        <script><?php include_once "calculator.js"?></script>
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
                        <input onchange="calculateWorkingTimes()" type="time" class="form-control" id="arbeitsBeginn" aria-describedby="emailHelp">
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
                <div class="d-flex p-3 h-100 timeFormResultContainer">
                    <span id="hoursValue" class="h2">7</span><span class="h2 ms-2 me-2">Stunden</span>
                    <span id="minutesValue" class="h2">7</span><span class="h2 ms-2">Minuten</span>
                </div>
            </div>
        </div>

    </div>
    </body>
    </html>

