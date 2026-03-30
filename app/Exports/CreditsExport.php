<?php
// app/Exports/CreditsExport.php

namespace App\Exports;

use App\Models\Credit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CreditsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $credits;

    public function __construct($credits = null)
    {
        $this->credits = $credits ?? Credit::with('client')->get();
    }

    public function collection()
    {
        return $this->credits;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'Montant (DH)',
            'Taux (%)',
            'Durée (mois)',
            'Mensualité (DH)',
            'Date début',
            'Date fin',
            'Statut'
        ];
    }

    public function map($credit): array
    {
        return [
            $credit->id_credit,
            $credit->client->nom . ' ' . $credit->client->prenom,
            $credit->montant,
            $credit->taux_interet,
            $credit->duree_mois,
            $credit->calculerMensualite(),
            $credit->date_debut->format('d/m/Y'),
            $credit->date_fin->format('d/m/Y'),
            $credit->statut
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
            'D' => 10,
            'E' => 12,
            'F' => 15,
            'G' => 12,
            'H' => 12,
            'I' => 12
        ];
    }
}