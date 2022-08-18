<?php

function convert_to_number($number)
{
    return is_numeric($number) ? ($number + 0) : FALSE;
}

function toFixed($number, $decimals)
{
    return number_format($number, $decimals, '.', "");
}

class WorkHoursDistribution
{
    public HoursMinutes $dayHours;
    public HoursMinutes $nightHours;
    public bool $nightHoursEnough;

    public function __construct(HoursMinutes $dayHours, HoursMinutes $nightHours, ?bool $nightHoursEnough = true)
    {
        $this->dayHours = $dayHours;
        $this->nightHours = $nightHours;
        $this->nightHoursEnough = $nightHoursEnough;
    }
}


class HoursMinutes
{
    public int $minutes;
    public int $hours;

    public function __construct(int $hours, int $minutes)
    {
        $this->hours = $hours;
        $this->minutes = $minutes;
    }

    public function returnInMinutes(): int
    {
        return $this->hours * 60 + $this->minutes;
    }

    public static function getHoursMinutesOfString(string $timeString): ?HoursMinutes
    {
        if (preg_match(' /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $timeString)) {
            $hourStr = substr($timeString, 0, 2);
            $minStr = substr($timeString, 3, 2);
            $hours = convert_to_number($hourStr);
            $minutes = convert_to_number($minStr);
            return new HoursMinutes($hours, $minutes);
        }
        return null;
    }

    public static function getHoursMinutesOfOnlyMinutes(int $minutes): ?HoursMinutes
    {
        $rest = $minutes % 60;
        $hoursWorked = $minutes / 60;
        if ($rest == 0) {
            return new HoursMinutes($minutes / 60, 0);
        } else {
            $downRound = floor($hoursWorked);
            return new HoursMinutes($downRound, $rest);

        }
    }

    public static function calculateDifference(HoursMinutes $from, HoursMinutes $to, ?bool $showInMinutes = false): HoursMinutes|int
    {
        $fromMinutes = $from->returnInMinutes();
        $toMinutes = $to->returnInMinutes();

        if ($toMinutes < $fromMinutes) {
            return !$showInMinutes ? HoursMinutes::getHoursMinutesOfOnlyMinutes($toMinutes + 1440 - $fromMinutes) : $toMinutes + 1440 - $fromMinutes;
        } else {
            return !$showInMinutes ? HoursMinutes::getHoursMinutesOfOnlyMinutes($toMinutes - $fromMinutes) : $toMinutes - $fromMinutes;
        }
    }

    public static function calculateNightHours(HoursMinutes $from, HoursMinutes $to, HoursMinutes $nightWorkStart, HoursMinutes $nightWorkEnd, int $minNightHours): WorkHoursDistribution
    {
        $regularMins = HoursMinutes::getHoursMinutesOfOnlyMinutes(0);
        $nightMins = HoursMinutes::getHoursMinutesOfOnlyMinutes(0);

        $fromTimeMins = $from->returnInMinutes();
        $toTimeMins = $to->returnInMinutes();


        $nightWorkEndMins = $nightWorkEnd->returnInMinutes();
        $nightWorkStartMins = $nightWorkStart->returnInMinutes();

        if ($fromTimeMins > $nightWorkEndMins && $fromTimeMins < $nightWorkStartMins && $toTimeMins < $nightWorkStartMins && $toTimeMins > $nightWorkEndMins && $fromTimeMins < $toTimeMins) {
            return new WorkHoursDistribution(HoursMinutes::calculateDifference($from, $to), new HoursMinutes(0,0));
        }

        if ($fromTimeMins < $toTimeMins) {
            if ($toTimeMins < $nightWorkEndMins) {
            $nightMins = HoursMinutes::calculateDifference($from, $to);
        } else if ($fromTimeMins <= $nightWorkEndMins && $toTimeMins < $nightWorkStartMins) {
            $nightMins = HoursMinutes::calculateDifference($from, $nightWorkEnd);
            $regularMins = HoursMinutes::calculateDifference($nightWorkEnd, $to);
        } else if ($fromTimeMins < $nightWorkEndMins && $toTimeMins >= $nightWorkStartMins) {
            $nightMins = HoursMinutes::getHoursMinutesOfOnlyMinutes(HoursMinutes::calculateDifference($from, $nightWorkEnd,true) + HoursMinutes::calculateDifference($nightWorkStart, $to, true));
            $regularMins = HoursMinutes::calculateDifference($nightWorkEnd, $nightWorkStart);
        } else if ($fromTimeMins >= $nightWorkEndMins && $fromTimeMins < $nightWorkStartMins && $toTimeMins >= $nightWorkStartMins) {
            $nightMins = HoursMinutes::calculateDifference($nightWorkStart, $to);
            $regularMins = HoursMinutes::calculateDifference($from, $nightWorkStart);
        } else if ($fromTimeMins >= $nightWorkEndMins && $fromTimeMins >= $nightWorkStartMins && $toTimeMins >= $nightWorkStartMins) {
            $nightMins = HoursMinutes::calculateDifference($from, $to);
        }
        } else {
            if ($fromTimeMins < $nightWorkEndMins) {
                $nightMins = HoursMinutes::getHoursMinutesOfOnlyMinutes(HoursMinutes::calculateDifference($from, $nightWorkEnd, true) + HoursMinutes::calculateDifference($nightWorkStart, $to,true));
                $regularMins = HoursMinutes::calculateDifference($nightWorkEnd, $nightWorkStart);
        } else if ($fromTimeMins < $nightWorkStartMins && $toTimeMins >= $nightWorkEndMins && $toTimeMins < $nightWorkStartMins) {
                $nightMins = HoursMinutes::calculateDifference($nightWorkStart, $nightWorkEnd);
                $regularMins = HoursMinutes::getHoursMinutesOfOnlyMinutes(HoursMinutes::calculateDifference($from, $nightWorkStart, true) + HoursMinutes::calculateDifference($nightWorkEnd, $to, true));
        } else if ($fromTimeMins >= $nightWorkStartMins && $toTimeMins >= $nightWorkEndMins && $toTimeMins < $nightWorkStartMins) {
                $nightMins = HoursMinutes::calculateDifference($from, $nightWorkEnd);
                $regularMins = HoursMinutes::calculateDifference($nightWorkEnd, $to);
        } else if ($fromTimeMins < $nightWorkStartMins && $toTimeMins < $nightWorkEndMins) {
                $nightMins = HoursMinutes::calculateDifference($nightWorkStart, $to);
                $regularMins = HoursMinutes::calculateDifference($from, $nightWorkStart);
            } else if ($fromTimeMins >= $nightWorkStartMins && $toTimeMins < $nightWorkEndMins) {
                $nightMins = HoursMinutes::calculateDifference($from, $to);
        } else if ($fromTimeMins >= $nightWorkStartMins && $toTimeMins >= $nightWorkStartMins) {
                $nightMins = HoursMinutes::calculateDifference($from, $nightWorkEnd);
                $regularMins = HoursMinutes::calculateDifference($nightWorkEnd, $to);
        }
        }
        if ($nightMins->returnInMinutes() > $minNightHours) {
            return new WorkHoursDistribution($regularMins, $nightMins);
        } else {
            $regularMinNightAdded = $regularMins->returnInMinutes() + $nightMins->returnInMinutes();
            return new WorkHoursDistribution(HoursMinutes::getHoursMinutesOfOnlyMinutes($regularMinNightAdded), new HoursMinutes(0, 0), false);
        }
    }
}

$method = $_GET["method"];

if ($method == "calculateDayAndNight") {
    $from = $_GET['from'];
    $to = $_GET['to'];
    if ($from !== null && $to !== null) {
        $time = HoursMinutes::getHoursMinutesOfString($from);
        $time2 = HoursMinutes::getHoursMinutesOfString($to);
        $nightWork23 = HoursMinutes::getHoursMinutesOfString("23:00");
        $nightWork06 = HoursMinutes::getHoursMinutesOfString("06:00");
    }
    if ($time !== null && $time2 !== null && $nightWork23 !== null && $nightWork06 !== null) {
        // Mindestnachtzeit beträgt 120 min
        $workDis = HoursMinutes::calculateNightHours($time, $time2, $nightWork23, $nightWork06, 120);
        echo json_encode($workDis);
    } else {
        echo "error: Inputs are not correct";
    }
} elseif ($method == "calculateWagePerHour") {
    $hourly = $_GET["hourly"];
    $percent = $_GET["percent"];
    echo $hourly * $percent / 100;
}


?>
