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
                //ищем в каком месте повторение
                $index = array_search($str[$i], $curChars);
                //удаляем все символы из подстроки до этого места включительно
                //и добавляем текущий символ
                $curSubStr = substr($curSubStr, $index + 1).$str[$i];
                //тоже самое с символами текущей подстроки
                $curChars = array_slice($curChars, $index + 1, count($curChars) - $index + 1);
                array_push($curChars, $str[$i]);
            }
        }
        if (strlen($result) < strlen($curSubStr)) {
            $result = $curSubStr;
        }
        return $result;
    }
}