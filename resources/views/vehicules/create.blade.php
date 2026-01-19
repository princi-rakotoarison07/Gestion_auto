@extends('layouts.header')

@section('title', 'Véhicules - Nouveau')

@section('content')
  <div class="pagetitle">
    <h1>Nouveau véhicule</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/vehicules') }}">Véhicules</a></li>
        <li class="breadcrumb-item active">Nouveau</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Créer un véhicule</h5>

        @if ($errors->any())
          <div class="alert alert-danger">
            <div class="fw-bold">Erreur de validation</div>
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ url('/vehicules') }}" class="row g-3">
          @csrf

          <div class="col-12">
            <label class="form-label">Modèle</label>
            <select name="id_modele" class="form-select" required>
              <option value="" disabled {{ old('id_modele') ? '' : 'selected' }}>Choisir un modèle</option>
              @foreach ($modeles as $modele)
                <option value="{{ $modele->id_modele }}" {{ (string) old('id_modele') === (string) $modele->id_modele ? 'selected' : '' }}>
                  {{ $modele->marque?->libelle }} - {{ $modele->libelle }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control" value="{{ old('immatriculation') }}" maxlength="20">
          </div>

          <div class="col-md-6">
            <label class="form-label">Année</label>
            <input type="number" name="annee" class="form-control" value="{{ old('annee') }}" min="1900" max="{{ now()->year + 1 }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Couleur</label>
            <input type="text" name="couleur" class="form-control" value="{{ old('couleur') }}" maxlength="30">
          </div>

          <div class="col-md-6">
            <label class="form-label">Kilométrage</label>
            <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage') }}" min="0">
          </div>

          <div class="col-12">
            <label class="form-label">Numéro chassis</label>
            <input type="text" name="numero_chassis" class="form-control" value="{{ old('numero_chassis') }}" maxlength="50">
          </div>

          <div class="col-md-6">
            <label class="form-label">Prix achat</label>
            <input type="number" name="prix_achat" class="form-control" value="{{ old('prix_achat') }}" step="0.01" min="0" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Prix vente</label>
            <input type="number" name="prix_vente" class="form-control" value="{{ old('prix_vente') }}" step="0.01" min="0" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-select" required>
              @php($statut = old('statut', 'en_stock'))
              <option value="en_stock" {{ $statut === 'en_stock' ? 'selected' : '' }}>En stock</option>
              <option value="reserve" {{ $statut === 'reserve' ? 'selected' : '' }}>Réservé</option>
              <option value="en_reparation" {{ $statut === 'en_reparation' ? 'selected' : '' }}>En réparation</option>
              <option value="vendu" {{ $statut === 'vendu' ? 'selected' : '' }}>Vendu</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Date acquisition</label>
            <input type="date" name="date_acquisition" class="form-control" value="{{ old('date_acquisition', now()->toDateString()) }}" required>
          </div>

          <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ url('/vehicules') }}" class="btn btn-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
