@extends('layouts.app')

@section('title', 'Liste des clients')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des clients</h1>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouveau client
                </a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
    
    <div>
        <!-- BOUTON EXPORT EXCEL -->
        <a href="{{ route('export.clients.excel') }}" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        
    </div>
</div>

    <!-- Recherche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('clients.index') }}" class="row g-3">
                        <div class="col-md-10">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Rechercher par nom, prénom, CIN ou email..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des clients -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom & Prénom</th>
                                    <th>CIN</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Comptes</th>
                                    <th>Impayés</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                <tr>
                                    <td>{{ $client->id_client }}</td>
                                    <td>
                                        <strong>{{ $client->nom }} {{ $client->prenom }}</strong>
                                    </td>
                                    <td>{{ $client->cin }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->telephone }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $client->comptes_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if(($client->impayes_count ?? 0) > 0)
                                            <span class="badge bg-danger">{{ $client->impayes_count }}</span>
                                        @else
                                            <span class="badge bg-success">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($client->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('clients.show', $client) }}" 
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('clients.edit', $client) }}" 
                                               class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Archiver"
                                                    onclick="if(confirm('Archiver ce client ?')) { document.getElementById('delete-form-{{ $client->id_client }}').submit(); }">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                            <form id="delete-form-{{ $client->id_client }}" 
                                                  action="{{ route('clients.destroy', $client) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        Aucun client trouvé
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection