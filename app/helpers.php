<?php

function format_money($money)
{
    if(!$money) {
        return "0 VNĐ";
    }

    $money = number_format($money, 0);

    if(strpos($money, '-') !== false) {
        $formatted = explode('-', $money);
        return "-$formatted[1] VND";
    }

    return "$money VNĐ";
}


