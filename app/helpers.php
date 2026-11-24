<?php

if (! function_exists('rp')) {
    function rp($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}