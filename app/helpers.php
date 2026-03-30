<?php
// app/helpers.php

if (!function_exists('format_mad')) {
    function format_mad($amount)
    {
        return number_format($amount, 2, ',', ' ') . ' DH';
    }
}