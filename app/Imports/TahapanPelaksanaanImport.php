<?php

namespace App\Imports;

use App\Models\TahapanPelaksanaanProyek;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;

class TahapanPelaksanaanImport implements ToCollection
{
    protected $periode_id;

    public function __construct($periode_id)
    {
        $this->periode_id = $periode_id;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception("File kosong atau tidak memiliki data.");
        }

        // Validasi format header
        $header = $rows[0];
        if (strtolower(trim($header[0])) !== 'tahapan' || strtolower(trim($header[1])) !== 'score') {
            throw new \Exception("Format file tidak sesuai. Pastikan kolom pertama adalah 'tahapan' dan kedua adalah 'score'.");
        }

        // Validasi jumlah baris (minimal 1 data, tidak termasuk header)
        if ($rows->count() - 1 < 1) {
            throw new \Exception("File harus memiliki minimal 1 baris data setelah header.");
        }

        // Validasi jumlah baris (maksimal 16 data, tidak termasuk header)
        if ($rows->count() - 1 > 16) {
            throw new \Exception("Maksimal hanya boleh 16 baris data. Ditemukan: " . ($rows->count() - 1));
        }

        $totalScore = 0;
        $dataToInsert = [];

        foreach ($rows->skip(1) as $index => $row) {
            $tahapan = trim($row[0]);
            $score = $row[1];

            if ($tahapan === null || $score === null) {
                continue; // lewati baris kosong
            }

            if (!is_numeric($score) || $score < 5 || $score > 10) {
                throw new \Exception("Score tidak valid pada baris " . ($index + 2) . ". Nilai harus antara 5 sampai 10.");
            }

            $totalScore += floatval($score);

            $dataToInsert[] = [
                'periode_id' => $this->periode_id,
                'tahapan' => $tahapan,
                'score' => $score,
            ];
        }

        if ($totalScore > 100) {
            throw new \Exception("Total score tidak boleh lebih dari 100%. Saat ini: $totalScore%");
        }

        // Hapus data lama & simpan baru
        TahapanPelaksanaanProyek::where('periode_id', $this->periode_id)->delete();
        TahapanPelaksanaanProyek::insert($dataToInsert);
    }
}

