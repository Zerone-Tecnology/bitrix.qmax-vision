<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- Склонения слов
function i_declOfNum($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number.' '.$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}