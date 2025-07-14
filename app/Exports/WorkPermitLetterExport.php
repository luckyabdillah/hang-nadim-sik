<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

use Carbon\Carbon;

class WorkPermitLetterExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithStyles, WithCustomStartCell, WithColumnFormatting
{
    protected $letters;
    protected $period;

    public function __construct($letters, $period)
    {
        Carbon::setLocale('id');
        $this->letters = $letters;
        $this->period = $period;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->letters);
    }

    public function startCell(): string
    {
        return 'B2';
    }

    public function headings(): array
    {
        return [
            ["SURAT IZIN KERJA ($this->period)", '', '', '', '', '', ''],
            ['NO', 'VENDOR', 'TIPE PEKERJAAN', 'LOKASI PEKERJAAN', 'NO. SURAT', 'DESKRIPSI', 'TANGGAL MULAI', 'TANGGAL SELESAI', 'PIC EKSTERNAL', 'NO. PIC EKSTERNAL', 'PIC INTERNAL', 'NO. PIC INTERNAL', 'DIAJUKAN TANGGAL', 'STATUS'],
        ];
    }

    public function map($letters): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $statusMap = [
            'submitted' => 'Disubmit',
            'verified' => 'Diverifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'finished' => 'Selesai'
        ];

        return [
            $rowNumber,
            $letters->vendor->user->name . ' (' . $letters->vendor->legal_name . ')',
            $letters->workType->type,
            $letters->work_location,
            $letters->letter_number,
            $letters->description,
            Carbon::parse($letters->started_at)->translatedFormat('d F Y'),
            Carbon::parse($letters->ended_at)->translatedFormat('d F Y'),
            $letters->external_pic_name,
            $letters->external_pic_number,
            $letters->internal_pic_name,
            $letters->internal_pic_number,
            Carbon::parse($letters->created_at)->translatedFormat('d F Y'),
            $statusMap[$letters->status],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('B2:O2');
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(30);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $dataRows = $sheet->getHighestDataRow();

        $sheet->getStyle('B2:O' . $dataRows)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle('B2:O3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('B2')->applyFromArray([
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('B2:O' . $dataRows)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('B2:O2')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'C4D79B'],
            ],
        ]);

        $sheet->getStyle('B3:O3')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F2F20D'],
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER,
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
