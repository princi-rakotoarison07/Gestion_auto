@extends('layouts.header')

@section('title', 'Paiements - Liste')

@section('content')
  <div class="pagetitle">
    <h1>Paiements</h1>
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
        <h5 class="card-title">Historique des paiements</h5>

        <div class="d-flex justify-content-end">
          <a href="{{ route('paiements.create') }}" class="btn btn-primary">
            Nouveau Paiement
          </a>
        </div>

        @if (session('success'))
          <div class="alert alert-success mt-3">
            {{ session('success') }}
          </div>
        @endif

        <div class="table-responsive mt-3">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th style="width: 50px;"></th>
                <th>Date</th>
                <th>Client</th>
                <th>Véhicule</th>
                <th class="text-end">Montant Total Payé</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($paiementsGroupes as $index => $groupe)
                @php
                    // Récupérer les détails des paiements pour ce groupe (même vente, même date)
                    $details = \App\Models\Paiement::where('id_vente', $groupe->id_vente)
                        ->where('date_paiement', $groupe->date_paiement)
                        ->with('modePaiement')
                        ->get();
                @endphp
                <tr data-bs-toggle="collapse" data-bs-target="#details-{{ $index }}" style="cursor: pointer;">
                  <td>
                    <button class="btn btn-sm btn-outline-primary p-0" style="width: 24px; height: 24px;">
                      <i class="bi bi-plus"></i>
                    </button>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($groupe->date_paiement)->format('d/m/Y') }}</td>
                  <td>{{ $groupe->vente->client->nom }} {{ $groupe->vente->client->prenom }}</td>
                  <td>
                    <strong>{{ $groupe->vente->vehicule->modele->marque->libelle }} {{ $groupe->vente->vehicule->modele->libelle }}</strong>
                  </td>
                  <td class="text-end fw-bold">{{ number_format($groupe->total_journalier, 2, ',', ' ') }} €</td>
                </tr>
                <tr class="collapse" id="details-{{ $index }}">
                  <td colspan="5" class="bg-light">
                    <div class="p-3">
                      <h6 class="fw-bold mb-2">Détails de la transaction :</h6>
                      <table class="table table-sm table-bordered mb-0 bg-white">
                        <thead class="table-secondary">
                          <tr>
                            <th>Mode de paiement</th>
                            <th>Référence</th>
                            <th class="text-end">Montant</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($details as $detail)
                            <tr>
                              <td>{{ $detail->modePaiement->libelle }}</td>
                              <td>{{ $detail->reference ?? '-' }}</td>
                              <td class="text-end">{{ number_format($detail->montant, 2, ',', ' ') }} €</td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr class="fw-bold">
                            <td colspan="2" class="text-end">Total</td>
                            <td class="text-end">{{ number_format($groupe->total_journalier, 2, ',', ' ') }} €</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">
                    <div class="alert alert-info mb-0 text-center">
                      Aucun paiement enregistré.
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

@section('page_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Optionnel : Changer l'icône + en - quand c'est ouvert
  const collapseElements = document.querySelectorAll('.collapse');
  collapseElements.forEach(el => {
    el.addEventListener('show.bs.collapse', function () {
      const btn = this.previousElementSibling.querySelector('i');
      btn.classList.replace('bi-plus', 'bi-dash');
    });
    el.addEventListener('hide.bs.collapse', function () {
      const btn = this.previousElementSibling.querySelector('i');
      btn.classList.replace('bi-dash', 'bi-plus');
    });
  });
});
</script>
@endsection
