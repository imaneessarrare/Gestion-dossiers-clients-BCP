@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Gestion des utilisateurs</h1>
                <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvel utilisateur
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Login</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Dernière connexion</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateurs as $user)
                                <tr>
                                    <td>{{ $user->id_user }}</td>
                                    <td>{{ $user->login }}</td>
                                    <td>{{ $user->nom }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'superviseur' ? 'warning' : 'info') }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->statut == 'actif')
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->derniere_connexion ? $user->derniere_connexion->format('d/m/Y H:i') : 'Jamais' }}</td>
                                    <td>
                                        <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.utilisateurs.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Désactiver cet utilisateur ?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection