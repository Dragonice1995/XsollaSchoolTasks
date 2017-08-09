<?php
//здесь a и b - массивы
function cmp($a, $b)
{
    if ($a[0] == $b[0]) {
        return 0;
    }
    return ($a[0] < $b[0]) ? -1 : 1;
}
function maxCountAndTimeInterval($str) {
    $strArray = explode(" ", $str);
    $allTimes = array();
    //разбиваем интервалы на начальное и конечное время
    //записываем время в массив
    //и помечаем каждое время (0 - начальное или 1 - конечное в промежутке)
    for ($i = 0; $i < count($strArray); $i++) {
        $times = explode("-", $strArray[$i]);
        array_push($allTimes, array(new DateTime($times[0]), 0));
        array_push($allTimes, array(new DateTime($times[1]), 1));
    }
    //сортируем по первым элементам массивов (времени)
    usort($allTimes, "cmp");
    $maxCount = 0; //макисмальное количество посетителей
    $maxStart = new DateTime(); //начало искомого промежутка
    $maxEnd = new DateTime(); //конец искомого промежутка
    $curCount = 0; //текущее количество посетителей
    //если время начальное (0), то увеличиваем количество текущих посетителей
    //и запоминаем это число и время, если количество больше запомненного максимального,
    //если же время конечное (1), то уменьшаем текущее количество посетителей
    //и запоминаем конечное время, если оно не запомнено (-1)
    for ($i = 0; $i < count($allTimes); $i++) {
        if ($allTimes[$i][1] == 0) {
            $curCount++;
            if ($curCount > $maxCount) {
                $maxCount = $curCount;
                $maxStart = $allTimes[$i][0];
                $maxEnd = -1;
            }
        } else {
            $curCount--;
            if ($maxEnd == -1) {
                $maxEnd = $allTimes[$i][0];
            }
        }
    }
    return "$maxCount ".$maxStart->format("H:i")."-".$maxEnd->format("H:i");
}