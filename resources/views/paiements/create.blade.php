@extends('layouts.header')

@section('title', 'Paiements - Nouveau')

@section('content')
  <div class="pagetitle">
    <h1>Enregistrer un Paiement</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('paiements.index') }}">Paiements</a></li>
        <li class="breadcrumb-item active">Nouveau</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Détails du paiement</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('paiements.store') }}" method="POST" id="formPaiement">
              @csrf

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label">Sélectionner la Vente</label>
                  <select name="id_vente" id="id_vente" class="form-select" required>
                    <option value="" selected disabled>Choisir une vente...</option>
                    @foreach ($ventes as $vente)
                      <option value="{{ $vente->id_vente }}" data-reste="{{ $vente->reste_a_payer }}">
                        Vente #{{ $vente->id_vente }} - {{ $vente->client->nom }} {{ $vente->client->prenom }} 
                        ({{ $vente->vehicule->modele->marque->libelle }} {{ $vente->vehicule->modele->libelle }})
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Date de paiement</label>
                  <input type="date" name="date_paiement" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
              </div>

              <!-- Infos Vente (Affichées dynamiquement) -->
              <div id="infoVente" class="alert alert-light border d-none mb-4">
                <div class="row">
                  <div class="col-md-4"><strong>Client:</strong> <span id="clientNom">-</span></div>
                  <div class="col-md-4"><strong>Véhicule:</strong> <span id="vehiculeInfo">-</span></div>
                  <div class="col-md-4 text-end">
                    <span class="text-muted">Total: <span id="montantTotal">0</span> €</span><br>
                    <span class="text-danger fw-bold">Reste à payer: <span id="resteAPayer">0</span> €</span>
                  </div>
                </div>
              </div>

              <h6 class="fw-bold mb-3">Répartition du paiement</h6>
              
              <div class="table-responsive">
                <table class="table table-bordered" id="tablePaiements">
                  <thead class="bg-light">
                    <tr>
                      <th style="width: 30%;">Mode de paiement</th>
                      <th style="width: 25%;">Montant (€)</th>
                      <th>Référence (N° Chèque, Transaction...)</th>
                      <th style="width: 50px;"></th>
                    </tr>
                  </thead>
                  <tbody id="paiementRows">
                    <tr class="paiement-row">
                      <td>
                        <select name="paiements[0][id_mode_paiement]" class="form-select" required>
                          @foreach ($modes as $mode)
                            <option value="{{ $mode->id_mode_paiement }}">{{ $mode->libelle }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <input type="number" step="0.01" name="paiements[0][montant]" class="form-control montant-input" placeholder="0.00" required>
                      </td>
                      <td>
                        <input type="text" name="paiements[0][reference]" class="form-control" placeholder="Optionnel">
                      </td>
                      <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row d-none">
                          <i class="bi bi-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddRow">
                          <i class="bi bi-plus-circle"></i> Ajouter un autre mode de paiement (Paiement Multiple)
                        </button>
                      </td>
                    </tr>
                    <tr class="table-info">
                      <td class="text-end fw-bold">Total saisi:</td>
                      <td colspan="3" class="fw-bold"><span id="totalSaisi">0.00</span> €</td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="text-end mt-4">
                <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success" id="btnSubmit">Enregistrer le paiement</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('page_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const idVenteSelect = document.getElementById('id_vente');
  const infoVente = document.getElementById('infoVente');
  const paiementRows = document.getElementById('paiementRows');
  const btnAddRow = document.getElementById('btnAddRow');
  const totalSaisiSpan = document.getElementById('totalSaisi');
  
  let rowCount = 1;

  // Charger les détails de la vente
  idVenteSelect.addEventListener('change', function() {
    const idVente = this.value;
    if (!idVente) return;

    fetch(`/ventes/${idVente}/details`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          infoVente.classList.remove('d-none');
          document.getElementById('clientNom').textContent = data.client;
          document.getElementById('vehiculeInfo').textContent = data.vehicule;
          document.getElementById('montantTotal').textContent = parseFloat(data.montant_total).toLocaleString('fr-FR');
          document.getElementById('resteAPayer').textContent = parseFloat(data.reste_a_payer).toLocaleString('fr-FR');
          
          // Mettre le reste à payer par défaut dans la première ligne
          const firstMontantInput = paiementRows.querySelector('.montant-input');
          if (firstMontantInput && !firstMontantInput.value) {
            firstMontantInput.value = data.reste_a_payer;
            updateTotal();
          }
        }
      });
  });

  // Ajouter une ligne
  btnAddRow.addEventListener('click', function() {
    const newRow = paiementRows.querySelector('.paiement-row').cloneNode(true);
    
    // Reset inputs
    newRow.querySelectorAll('input').forEach(input => {
      input.value = '';
      const name = input.getAttribute('name');
      input.setAttribute('name', name.replace(/\[\d+\]/, `[${rowCount}]`));
    });
    
    const select = newRow.querySelector('select');
    const selectName = select.getAttribute('name');
    select.setAttribute('name', selectName.replace(/\[\d+\]/, `[${rowCount}]`));
    
    // Show remove button
    const removeBtn = newRow.querySelector('.remove-row');
    removeBtn.classList.remove('d-none');
    
    paiementRows.appendChild(newRow);
    rowCount++;
    
    attachRowEvents(newRow);
  });

  // Gérer la suppression et le calcul total
  function attachRowEvents(row) {
    row.querySelector('.remove-row').addEventListener('click', function() {
      row.remove();
      updateTotal();
    });

    row.querySelector('.montant-input').addEventListener('input', updateTotal);
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.montant-input').forEach(input => {
      total += parseFloat(input.value) || 0;
    });
    totalSaisiSpan.textContent = total.toFixed(2);
  }

  // Attacher aux lignes existantes
  document.querySelectorAll('.paiement-row').forEach(attachRowEvents);
});
</script>
@endsection
