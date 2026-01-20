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
                <th>Image</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Immat.</th>
                <th>Année</th>
                <th>Couleur</th>
                <th>Stock</th>
                <th>Kilométrage</th>
                <th>Prix vente</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($vehicules as $vehicule)
                <tr>
                  <td>
                    @if ($vehicule->img_vehicule)
                      <img src="{{ asset($vehicule->img_vehicule) }}" alt="Véhicule" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                    @else
                      <span class="text-muted">No image</span>
                    @endif
                  </td>
                  <td>{{ $vehicule->modele?->marque?->libelle }}</td>
                  <td>{{ $vehicule->modele?->libelle }}</td>
                  <td>{{ $vehicule->immatriculation }}</td>
                  <td>{{ $vehicule->annee }}</td>
                  <td>{{ $vehicule->couleur_libelle }}</td>
                  <td>{{ $vehicule->nombre_stock }}</td>
                  <td>{{ $vehicule->kilometrage }}</td>
                  <td>{{ $vehicule->prix_vente }}</td>
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
