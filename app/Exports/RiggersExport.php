<?php

namespace App\Exports;

use App\Models\Rigger;
use App\Models\RiggerDocument;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill as StyleFill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RiggersExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    public function headings(): array
    {
        $documents = DB::table('rigger_documents')->distinct()->pluck('document_type')->toArray();
        $data = array_merge(['#', 'Names', 'Phone number', 'National ID'], $documents);

        return [
            ['MINEGA NETWORKS'],
            ['KICUKIRO - GIKONDO - KANSEREGE'],
            ['E-mail: info@mineganetworks.rw'],
            ['Telephone: +250788312962'],
            $data,
        ];
    }

    public function query()
    {
        return Rigger::query()->with('document');
    }

    public function styles(Worksheet $sheet)
    {
        for ($i = 1; $i <= 4; $i++) {
            $sheet->mergeCells('A'.$i.':E'.$i);
        }
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => StyleBorder::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $numberCol = DB::table('rigger_documents')->distinct()->select('document_type')->get()->count();
        $numberRow = DB::table('riggers')->distinct()->select('name')->get()->count();
        $alphabetCol = chr(($numberCol + 4) + 64);
        $sheet->getStyle('A5:'.$alphabetCol.($numberRow + 5))->applyFromArray($styleArray);
        $sheet->getStyle('A5:'.$alphabetCol.'5')->getFill()->setFillType(StyleFill::FILL_SOLID)->getStartColor()->setRGB(Color::COLOR_YELLOW);
        $sheet->getStyle('A1:'.$alphabetCol.($numberRow + 5))->getFont()->setName('Century Gothic');
        $sheet->insertNewRowBefore(5, 2);

        return [
            1 => ['font' => ['bold' => true]],
            7 => ['font' => ['bold' => true]],
        ];
    }

    public function map($rigger): array
    {
        $headers = $this->headings();
        $info = [$rigger->id,
            $rigger->name,
            $rigger->phone,
            $rigger->nid];
        for ($i = 4; $i < count($headers[4]); $i++) {
            $document = RiggerDocument::where('rigger_id', $rigger->id)->where('document_type', $headers[4][$i])->pluck('expiry_date')->first();
            if (! is_null($document)) {
                $info[] = date_format(date_create($document), 'd-m-Y');
            } else {
                $info[] = 'N/A';
            }
        }

        return $info;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();
                $sheet->getDelegate()->getRowDimension(7)->setRowHeight(25);
                $sheet->getDelegate()->getStyle('A7:'.$highestCol.$highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getDelegate()->getStyle('C7:'.$highestCol.$highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                for ($row = 8; $row <= $highestRow; $row++) {
                    $sheet->getDelegate()->getRowDimension($row)->setRowHeight(20);
                    for ($col = 'A'; $col <= $highestCol; $col++) {
                        $cellValue = $sheet->getCell($col.$row)->getValue();
                        $range = $col.$row;
                        if ($col >= 'E') {
                            if ($cellValue != 'N/A') {
                                $sheet->getStyle($range)->getFill()->setFillType(StyleFill::FILL_SOLID);
                                $sheet->getStyle($range)->getFill()->getStartColor()->setRGB('FF95B3D7');
                            } else {
                                $sheet->getStyle($range)->getFill()->setFillType(StyleFill::FILL_SOLID);
                                $sheet->getStyle($range)->getFill()->getStartColor()->setRGB('FFD09996');
                            }
                        } else {
                            $sheet->getStyle($range)->getFill()->setFillType(StyleFill::FILL_SOLID);
                            $sheet->getStyle($range)->getFill()->getStartColor()->setRGB('FFC8D6A1');
                        }
                    }
                }
            },
        ];
    }
}
