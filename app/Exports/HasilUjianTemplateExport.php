<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HasilUjianTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['Ahmad Santoso', '2025-10-15', 'Juz 1', 'Lancar'],
            ['Siti Aisyah', '2025-10-15', 'Juz 2', 'Perlu latihan lebih'],
            ['Muhammad Ali', '2025-10-15', 'Juz 3', 'Sangat baik'],
            ['Fatimah Zahra', '2025-10-15', 'Juz 4', 'Cukup baik'],
            ['Abdullah Rahman', '2025-10-15', 'Juz 5', 'Perlu perbaikan tajwid'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'nama',
            'tanggal',
            'juz',
            'keterangan'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
            // Data rows styling
            'A2:D6' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // nama
            'B' => 15, // tanggal
            'C' => 12, // juz
            'D' => 25, // keterangan
        ];
    }
}
