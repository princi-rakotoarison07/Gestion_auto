@extends('layouts.header')

@section('title', 'Véhicules - Liste')

@section('content')
  <div class="pagetitle">
    <h1>Véhicules</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Liste</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Liste des véhicules</h5>

        <div class="d-flex justify-content-end">
          <a href="{{ url('/vehicules/create') }}" class="btn btn-primary">
            Nouveau
          </a>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Immat.</th>
                <th>Année</th>
                <th>Couleur</th>
                <th>Kilométrage</th>
                <th>Prix vente</th>
                <th>Statut</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($vehicules as $vehicule)
                <tr>
                  <td>{{ $vehicule->id_vehicule }}</td>
                  <td>{{ $vehicule->modele?->marque?->libelle }}</td>
                  <td>{{ $vehicule->modele?->libelle }}</td>
                  <td>{{ $vehicule->immatriculation }}</td>
                  <td>{{ $vehicule->annee }}</td>
                  <td>{{ $vehicule->couleur }}</td>
                  <td>{{ $vehicule->kilometrage }}</td>
                  <td>{{ $vehicule->prix_vente }}</td>
                  <td>{{ $vehicule->statut }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="9">
                    <div class="alert alert-info mb-0">
                      Aucun véhicule enregistré.
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
@endsection
