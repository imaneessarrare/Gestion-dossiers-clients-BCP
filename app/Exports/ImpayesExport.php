<?php
// app/Exports/ImpayesExport.php

namespace App\Exports;

use App\Models\Impaye;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ImpayesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $impayes;

    public function __construct($impayes = null)
    {
        $this->impayes = $impayes ?? Impaye::with('client')->get();
    }

    public function collection()
    {
        return $this->impayes;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'Montant (DH)',
            'Date impayé',
            'Jours de retard',
            'Statut',
            'Notes'
        ];
    }

    public function map($impaye): array
    {
        return [
            $impaye->id_impaye,
            $impaye->client->nom . ' ' . $impaye->client->prenom,
            $impaye->montant,
            $impaye->date_impaye->format('d/m/Y'),
            $impaye->date_impaye->diffInDays(now()),
            $impaye->statut,
            $impaye->notes
        ];
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 15,
            'D' => 12,
            'E' => 12,
            'F' => 15,
            'G' => 30
        ];
    }
}