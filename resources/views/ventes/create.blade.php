@extends('layouts.header')

@section('title', 'Ventes - Nouvelle Vente')

@section('content')
  <div class="pagetitle">
    <h1>Nouvelle Vente</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ventes.index') }}">Ventes</a></li>
        <li class="breadcrumb-item active">Nouveau</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Informations de la vente</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('ventes.store') }}" method="POST" class="row g-3">
              @csrf

              <div class="col-md-6">
                <label class="form-label">Date de vente</label>
                <input type="date" name="date_vente" class="form-control" value="{{ old('date_vente', date('Y-m-d')) }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Véhicule</label>
                <select name="id_vehicule" class="form-select" required>
                  <option value="" disabled {{ old('id_vehicule') ? '' : 'selected' }}>Choisir un véhicule</option>
                  @foreach ($vehicules as $vehicule)
                    <option value="{{ $vehicule->id_vehicule }}" {{ (string) old('id_vehicule') === (string) $vehicule->id_vehicule ? 'selected' : '' }}>
                      {{ $vehicule->marque_nom }} {{ $vehicule->modele_libelle }} ({{ $vehicule->immatriculation }})
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Client</label>
                <div class="input-group">
                  <select name="id_client" id="id_client" class="form-select" required>
                    <option value="" disabled {{ old('id_client') ? '' : 'selected' }}>Choisir un client</option>
                    @foreach ($clients as $client)
                      <option value="{{ $client->id_client }}" {{ (string) old('id_client') === (string) $client->id_client ? 'selected' : '' }}>
                        {{ $client->nom }} {{ $client->prenom }}
                      </option>
                    @endforeach
                  </select>
                  <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalClient">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Employé (Vendeur)</label>
                <select name="id_employe" class="form-select" required>
                  <option value="" disabled {{ old('id_employe') ? '' : 'selected' }}>Choisir un employé</option>
                  @foreach ($employes as $employe)
                    <option value="{{ $employe->id_employe }}" {{ (string) old('id_employe') === (string) $employe->id_employe ? 'selected' : '' }}>
                      {{ $employe->nom }} {{ $employe->prenom }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Montant Total (€)</label>
                <input type="number" step="0.01" name="montant_total" class="form-control" value="{{ old('montant_total') }}" required>
              </div>

              <div class="col-md-4">
                <label class="form-label">Statut Paiement</label>
                <select name="id_statut_paiement" class="form-select" required>
                  @foreach ($statuts as $statut)
                    <option value="{{ $statut->id_statut_paiement }}" {{ (string) old('id_statut_paiement', '1') === (string) $statut->id_statut_paiement ? 'selected' : '' }}>
                      {{ $statut->libelle }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Date Paiement Complet</label>
                <input type="date" name="date_paiement_complet" class="form-control" value="{{ old('date_paiement_complet') }}">
              </div>

              <div class="col-12 text-end mt-4">
                <a href="{{ route('ventes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer la vente</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Nouveau Client -->
  <div class="modal fade" id="modalClient" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nouveau Client</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formClientAjax">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nom</label>
              <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Prénom</label>
              <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Téléphone</label>
              <input type="text" name="telephone" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control">
            </div>
          </form>
          <div id="clientAjaxErrors" class="alert alert-danger d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-primary" id="btnSaveClient">Enregistrer</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const btnSaveClient = document.getElementById('btnSaveClient');
  const formClient = document.getElementById('formClientAjax');
  const clientSelect = document.getElementById('id_client');
  const errorDiv = document.getElementById('clientAjaxErrors');
  const modalElement = document.getElementById('modalClient');
  const modal = new bootstrap.Modal(modalElement);

  btnSaveClient.addEventListener('click', function() {
    const formData = new FormData(formClient);
    errorDiv.classList.add('d-none');
    errorDiv.innerHTML = '';

    fetch('/clients/ajax', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Ajouter le nouveau client au select
        const option = new Option(`${data.client.nom} ${data.client.prenom}`, data.client.id_client);
        clientSelect.add(option);
        clientSelect.value = data.client.id_client;

        // Fermer le modal et réinitialiser
        modal.hide();
        formClient.reset();
      } else {
        // Afficher les erreurs
        errorDiv.classList.remove('d-none');
        if (data.errors) {
          let errorHtml = '<ul class="mb-0">';
          Object.values(data.errors).forEach(err => {
            errorHtml += `<li>${err[0]}</li>`;
          });
          errorHtml += '</ul>';
          errorDiv.innerHTML = errorHtml;
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      errorDiv.classList.remove('d-none');
      errorDiv.innerHTML = 'Une erreur est survenue lors de l\'enregistrement.';
    });
  });
});
</script>
@endsection
