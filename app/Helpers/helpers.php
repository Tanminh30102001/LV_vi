<?php

function format_number($number)
{
    return number_format($number, 0, '.', ',');
}