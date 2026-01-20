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

        <form method="POST" action="{{ url('/vehicules') }}" class="row g-3" enctype="multipart/form-data">
          @csrf

          <div class="col-12">
            <label class="form-label">Modèle</label>
            <div class="input-group">
              <select name="id_modele" id="id_modele" class="form-select" required>
                <option value="" disabled {{ old('id_modele') ? '' : 'selected' }}>Choisir un modèle</option>
                @foreach ($modeles as $modele)
                  <option value="{{ $modele->id_modele }}" {{ (string) old('id_modele') === (string) $modele->id_modele ? 'selected' : '' }}>
                    {{ $modele->marque?->libelle }} - {{ $modele->libelle }}
                  </option>
                @endforeach
              </select>
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAddModele">
                <i class="bi bi-plus-lg"></i>
              </button>
            </div>
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
            <select name="id_couleur" class="form-select" required>
              <option value="" disabled {{ old('id_couleur') ? '' : 'selected' }}>Choisir une couleur</option>
              @foreach ($couleurs as $couleur)
                <option value="{{ $couleur->id_couleur }}" {{ (string) old('id_couleur') === (string) $couleur->id_couleur ? 'selected' : '' }}>
                  {{ $couleur->libelle }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Nombre en stock</label>
            <input type="number" name="nombre_stock" class="form-control" value="{{ old('nombre_stock', 1) }}" min="0" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Kilométrage</label>
            <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage') }}" min="0">
          </div>

          <div class="col-12">
            <label class="form-label">Numéro chassis</label>
            <input type="text" name="numero_chassis" class="form-control" value="{{ old('numero_chassis') }}" maxlength="50">
          </div>

          <div class="col-12">
            <label class="form-label">Image véhicule</label>
            <input type="file" name="img_vehicule" class="form-control" accept="image/*">
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

  <!-- Modal Nouveau Modèle -->
  <div class="modal fade" id="modalAddModele" tabindex="-1" aria-labelledby="modalAddModeleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddModeleLabel">Nouveau modèle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formAddModele">
          @csrf
          <div class="modal-body row g-3">
            <div class="col-12">
              <label class="form-label">Marque</label>
              <div class="input-group" id="container_marque_select">
                <select name="id_marque" id="modal_id_marque" class="form-select">
                  <option value="" disabled selected>Choisir une marque</option>
                  @foreach ($marques as $marque)
                    <option value="{{ $marque->id_marque }}">{{ $marque->libelle }}</option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="btn_toggle_new_marque">
                  <i class="bi bi-plus-lg"></i>
                </button>
              </div>
              <div class="input-group d-none" id="container_marque_input">
                <input type="text" name="nom_marque" id="modal_nom_marque" class="form-control" placeholder="Nom de la nouvelle marque">
                <button type="button" class="btn btn-outline-secondary" id="btn_cancel_new_marque">
                  <i class="bi bi-x-lg"></i>
                </button>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">Libellé du modèle</label>
              <input type="text" name="libelle" id="modal_libelle_modele" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Enregistrer le modèle</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const formAddModele = document.getElementById('formAddModele');
      const selectModele = document.getElementById('id_modele');
      const modalElement = document.getElementById('modalAddModele');
      const modal = new bootstrap.Modal(modalElement);

      const btnToggleNewMarque = document.getElementById('btn_toggle_new_marque');
      const btnCancelNewMarque = document.getElementById('btn_cancel_new_marque');
      const containerMarqueSelect = document.getElementById('container_marque_select');
      const containerMarqueInput = document.getElementById('container_marque_input');
      const selectMarque = document.getElementById('modal_id_marque');
      const inputMarque = document.getElementById('modal_nom_marque');

      btnToggleNewMarque.addEventListener('click', function() {
        containerMarqueSelect.classList.add('d-none');
        containerMarqueInput.classList.remove('d-none');
        selectMarque.value = "";
        inputMarque.focus();
      });

      btnCancelNewMarque.addEventListener('click', function() {
        containerMarqueSelect.classList.remove('d-none');
        containerMarqueInput.classList.add('d-none');
        inputMarque.value = "";
      });

      formAddModele.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(formAddModele);
        
        fetch("{{ url('/modeles/ajax') }}", {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Ajouter la nouvelle option au select
            const option = new Option(`${data.modele.marque_libelle} - ${data.modele.libelle}`, data.modele.id_modele, true, true);
            selectModele.add(option);
            
            // Fermer le modal
            modal.hide();
            
            // Réinitialiser le formulaire
            formAddModele.reset();
            containerMarqueSelect.classList.remove('d-none');
            containerMarqueInput.classList.add('d-none');
            
            // Optionnel : Notification de succès
            alert('Modèle ajouté avec succès !');
          } else {
            alert(data.message || 'Erreur lors de l\'ajout du modèle.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Une erreur est survenue.');
        });
      });
    });
  </script>
@endsection
