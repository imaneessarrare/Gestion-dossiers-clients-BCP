<?php
// app/Exports/ComptesExport.php

namespace App\Exports;

use App\Models\Compte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ComptesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithColumnFormatting
{
    protected $comptes;

    public function __construct($comptes = null)
    {
        $this->comptes = $comptes ?? Compte::with('client')->get();
    }

    public function collection()
    {
        return $this->comptes;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Numéro de compte',
            'Client',
            'Type',
            'Solde (DH)',
            'Date ouverture',
            'Statut'
        ];
    }

    public function map($compte): array
    {
        return [
            $compte->id_compte,
            $compte->numero_compte,
            $compte->client->nom . ' ' . $compte->client->prenom,
            $compte->type_compte,
            $compte->solde,
            $compte->date_ouverture->format('d/m/Y'),
            $compte->statut
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => [
                      'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                      'startColor' => ['rgb' => 'D2691E']
                  ]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 30,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 10
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
        ];
    }
}