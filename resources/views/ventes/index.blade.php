@extends('layouts.header')

@section('title', 'Ventes - Liste')

@section('content')
  <div class="pagetitle">
    <h1>Ventes</h1>
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
        <h5 class="card-title">Liste des ventes</h5>

        <div class="d-flex justify-content-end">
          <a href="{{ route('ventes.create') }}" class="btn btn-primary">
            Nouvelle Vente
          </a>
        </div>

        @if (session('success'))
          <div class="alert alert-success mt-3">
            {{ session('success') }}
          </div>
        @endif

        <div class="table-responsive mt-3">
          <table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>Date</th>
                <th>Véhicule</th>
                <th>Client</th>
                <th>Montant Total</th>
                <th>Reste à payer</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($ventes as $vente)
                @php
                    $v = \App\Models\Vente::find($vente->id_vente);
                @endphp
                <tr>
                  <td>{{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</td>
                  <td>
                    <strong>{{ $vente->marque_nom }} {{ $vente->modele_libelle }}</strong><br>
                    <small class="text-muted">{{ $vente->immatriculation }}</small>
                  </td>
                  <td>{{ $vente->client_nom }} {{ $vente->client_prenom }}</td>
                  <td>{{ number_format($vente->montant_total, 2, ',', ' ') }} €</td>
                  <td class="text-danger fw-bold">{{ number_format($v->reste_a_payer, 2, ',', ' ') }} €</td>
                  <td>
                    @php
                        $badgeClass = match($vente->id_statut_paiement) {
                            1 => 'bg-danger',   // Non payé
                            2 => 'bg-warning',  // Partiel
                            3 => 'bg-success',  // Payé
                            default => 'bg-secondary'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $vente->statut_libelle }}</span>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-info" title="Détails">
                      <i class="bi bi-eye"></i>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="alert alert-info mb-0">
                      Aucune vente enregistrée.
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
