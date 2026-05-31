<?php

if (!function_exists('formatAngka')) {
    function formatAngka(int|float $number): string
    {
        if ($number >= 1_000_000_000) {
            return number_format($number / 1_000_000_000, 1, ',', '.') . ' M';
        }
        if ($number >= 1_000_000) {
            return number_format($number / 1_000_000, 1, ',', '.') . ' Jt';
        }
        if ($number >= 100_000) {
            return number_format($number / 1_000, 1, ',', '.') . ' Rb';
        }
        return number_format($number, 0, ',', '.');
    }
}