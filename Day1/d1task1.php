<?php
//возвращает слово V или false, если слова нет
function getRepeatedWord($str) {
    $strArray = explode(" ", $str);
    if (count($strArray) == 3) {
        //находим слово с минимальной длинной
        $wordsLengths = array(strlen($strArray[0]), strlen($strArray[1]), strlen($strArray[2]));
        $indexMinWord = array_keys($wordsLengths, min($wordsLengths))[0];
        $flag = false;
        $subString = "";
        //берем подстроку из минимального слова
        //и смотрим вхождение данной построки в словах
        for ($i = 0; $i < strlen($strArray[$indexMinWord]) && !$flag; $i++) {
            $flag = true;
            //увеличиваем подстроку
            $subString = substr($strArray[$indexMinWord], 0, $i + 1);
            //находим количество вхождений данной подстроки в словах
            //flag будет true после данного цикла, если все слова прошли проверку
            for ($j = 0; $j < count($strArray); $j++) {
                $count = substr_count($strArray[$j], $subString);
                //true, если предыдущее слово удовлетворяет условию,
                //количество вхождений подстроки не равно 0,
                //и количество вхождений равно длине слова деленное на длину подстроки
                $flag = $flag && ($count != 0) && ($count == strlen($strArray[$j]) / strlen($subString));
            }
        }
        if ($flag && strlen($subString) != 0) {
            return $subString;
        } else {
            return false;
        }
    } else {
        return false;
    }
}