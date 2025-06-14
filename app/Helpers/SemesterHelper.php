<?php

if (!function_exists('semesterDariKategori')) {
    function semesterDariKategori($kategori)
    {
        return $kategori === 'Ganjil' ? [1, 3, 5] : [2, 4, 6];
    }
}
