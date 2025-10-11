<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class KaryawanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithTitle
{
    protected $data;
    protected $columns;

    public function __construct($data, array $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return array_map(function ($column) {
            return ucfirst(str_replace('_', ' ', $column));
        }, $this->columns);
    }

    public function map($user): array
    {
        $data = [];
    
        foreach ($this->columns as $column) {
            switch ($column) {
                case 'name':
                    $data[] = $user->name;
                    break;
                case 'email':
                    $data[] = $user->email;
                    break;
                case 'roles':
                    $data[] = $user->roles->pluck('name')->implode(', ');
                    break;
                    case 'nik':
                        // Add a single quote to force Excel to treat it as text
                        $nik = (string) $user->nik;
                        // Ensure nik is exactly 16 digits, otherwise return '-'
                        if (strlen($nik) === 16) {
                            $data[] = "'" . $nik;  // Prepend a single quote
                        } else {
                            $data[] = '-';
                        }
                        break;
                case 'agama':
                    $data[] = $user->agama ?? '-';
                    break;
                case 'tgl_lahir':
                    // Only format tgl_lahir if it is not '-' and is a valid date
                    $data[] = $user->tgl_lahir && $user->tgl_lahir !== '-' 
                        ? \Carbon\Carbon::parse($user->tgl_lahir)->translatedFormat('d F Y') 
                        : '-';
                    break;
                case 'jk':
                    $data[] = $user->jk ?? '-';
                    break;
                case 'status_perkawinan':
                    $data[] = $user->status_perkawinan ?? '-';
                    break;
                case 'no_hp':
                    $data[] = $user->no_hp ?? '-';
                    break;
                    case 'jabatan':
                        $data[] = $user->jabatan ?? '-';
                        break;
                    case 'divisi':
                        $data[] = $user->divisi ?? '-';
                        break;
                default:
                    $data[] = '-';
            }
        }
    
        return $data;
    }
    

    


    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return 'Data Karyawan';
    }

    public function styles(Worksheet $sheet)
    {
        // Menambahkan judul dan informasi cetak pada bagian atas
        $sheet->setCellValue('A1', 'Data Karyawan');
        $sheet->setCellValue('A2', 'Dicetak pada: ' . now()->format('d F Y H:i'));
        $sheet->setCellValue('A3', 'Dicetak oleh: Admin');

        // Mengatur gaya untuk header
        $sheet->getStyle('A5:' . $sheet->getHighestColumn() . '5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'ADD8E6'],
            ],
        ]);

        // Mengatur lebar kolom secara otomatis
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return $sheet;
    }
}
