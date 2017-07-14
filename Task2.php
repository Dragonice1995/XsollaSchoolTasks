<?php
class MaximumUniqueSubstring
{
    public function findMaximumUniqueSubstring($str) {
        $result = "";
        $curSubStr = ""; //текущая уникальная подстрока
        $curChars = array(); //символы текущей уникальной подстроки
        for ($i = 0; $i < strlen($str); $i++) {
            //если символа нет в текущей подстроке
            if (!in_array($str[$i], $curChars)) {
                //добавляем символ к текущей подстроке
                $curSubStr .= $str[$i];
                array_push($curChars, $str[$i]);
            } else {
                //сравниваем длины текущей уникальной подстроки и предыдущей
                //если длина текущей больше, то запоминаем текущую подстроку
                if (strlen($result) < strlen($curSubStr)) {
                    $result = $curSubStr;
                }
                $curSubStr = $str[$i];
                $curChars = array($str[$i]);
            }
        }
        if (strlen($result) < strlen($curSubStr)) {
            $result = $curSubStr;
        }
        return $result;
    }
}
