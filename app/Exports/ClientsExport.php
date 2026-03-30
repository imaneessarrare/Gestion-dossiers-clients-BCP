<?php
// app/Exports/ClientsExport.php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $clients;

    public function __construct($clients = null)
    {
        $this->clients = $clients ?? Client::all();
    }

    public function collection()
    {
        return $this->clients;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'CIN',
            'Email',
            'Téléphone',
            'Adresse',
            'Date création',
            'Statut'
        ];
    }

    public function map($client): array
    {
        return [
            $client->id_client,
            $client->nom,
            $client->prenom,
            $client->cin,
            $client->email,
            $client->telephone,
            $client->adresse,
            $client->created_at->format('d/m/Y'),
            $client->statut
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
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 30,
            'F' => 15,
            'G' => 30,
            'H' => 15,
            'I' => 10,
        ];
    }
}