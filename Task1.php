<?php
class Brackets
{
    public function isBracketSequenceCorrect($str) {
        $brackets = [
            ']' => '[',
            ')' => '(',
            '}' => '{'
        ];
        $stack = array();
        for ($i = 0; $i < strlen($str); $i++) {
            //если открывающаяся скобка,
            // то добавляем в стек
            if (in_array($str[$i], $brackets)) {
                array_push($stack, $str[$i]);
            }
            //если закрывающаяся скобка,
            //то проверяем соответствует ли она открывающейся
            elseif (array_key_exists($str[$i], $brackets)) {
                $token = array_pop($stack);
                if ($brackets[$str[$i]] != $token) {
                    return false;
                }
            } else {
                return false;
            }
        }
        //если остались открывающиеся скобки
        //или исходная строка пустая
        if (count($stack) != 0 || strlen($str) == 0)
        {
            return false;
        }
        return true;
    }
}