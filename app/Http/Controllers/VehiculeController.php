<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use App\Models\Marque;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::query()
            ->leftJoin('couleur', 'vehicule.id_couleur', '=', 'couleur.id_couleur')
            ->select('vehicule.*', 'couleur.libelle as couleur_libelle')
            ->leftJoin('statut_vehicule', 'vehicule.id_statut_vehicule', '=', 'statut_vehicule.id_statut_vehicule')
            ->addSelect('statut_vehicule.libelle as statut_libelle')
            ->with(['modele.marque'])
            ->orderByDesc('id_vehicule')
            ->get();

        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $modeles = Modele::query()
            ->with('marque')
            ->orderBy('id_marque')
            ->orderBy('libelle')
            ->get();

        $marques = Marque::orderBy('libelle')->get();

        $couleurs = DB::table('couleur')
            ->orderBy('libelle')
            ->get();

        return view('vehicules.create', compact('modeles', 'couleurs', 'marques'));
    }

    public function storeModeleAjax(Request $request)
    {
        $request->validate([
            'id_marque' => 'nullable|exists:marque,id_marque',
            'nom_marque' => 'nullable|string|max:100',
            'libelle' => 'required|string|max:100',
        ], [
            'id_marque.exists' => 'La marque sélectionnée est invalide.',
            'nom_marque.max' => 'Le nom de la marque ne doit pas dépasser 100 caractères.',
            'libelle.required' => 'Le libellé du modèle est obligatoire.',
            'libelle.max' => 'Le libellé du modèle ne doit pas dépasser 100 caractères.',
        ]);

        $id_marque = $request->id_marque;

        // Si une nouvelle marque est saisie
        if ($request->filled('nom_marque')) {
            $marque = Marque::create([
                'libelle' => $request->nom_marque,
                'actif' => 1
            ]);
            $id_marque = $marque->id_marque;
        }

        if (!$id_marque) {
            return response()->json(['success' => false, 'message' => 'La marque est obligatoire.'], 422);
        }

        $modele = Modele::create([
            'id_marque' => $id_marque,
            'libelle' => $request->libelle,
            'actif' => 1,
        ]);

        $modele->load('marque');

        return response()->json([
            'success' => true,
            'modele' => [
                'id_modele' => $modele->id_modele,
                'libelle' => $modele->libelle,
                'marque_libelle' => $modele->marque->libelle,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_modele' => ['required', 'integer', 'exists:modele,id_modele'],
            'id_couleur' => ['required', 'integer', 'exists:couleur,id_couleur'],
            'nombre_stock' => ['required', 'integer', 'min:0'],
            'immatriculation' => ['nullable', 'string', 'max:20', 'unique:vehicule,immatriculation'],
            'annee' => ['required', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'kilometrage' => ['nullable', 'integer', 'min:0'],
            'numero_chassis' => ['nullable', 'string', 'max:50', 'unique:vehicule,numero_chassis'],
            'img_vehicule' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'prix_achat' => ['required', 'numeric', 'min:0', 'lt:prix_vente'],
            'prix_vente' => ['required', 'numeric', 'min:0', 'gt:prix_achat'],
            'date_acquisition' => ['required', 'date'],
        ], [
            'id_modele.required' => 'Le modèle est obligatoire.',
            'id_modele.exists' => 'Le modèle sélectionné est invalide.',
            'id_couleur.required' => 'La couleur est obligatoire.',
            'id_couleur.exists' => 'La couleur sélectionnée est invalide.',
            'nombre_stock.required' => 'Le nombre en stock est obligatoire.',
            'nombre_stock.integer' => 'Le nombre en stock doit être un nombre entier.',
            'nombre_stock.min' => 'Le nombre en stock ne peut pas être négatif.',
            'immatriculation.unique' => 'Cette immatriculation est déjà utilisée.',
            'immatriculation.max' => 'L\'immatriculation ne doit pas dépasser 20 caractères.',
            'annee.required' => 'L\'année est obligatoire.',
            'annee.integer' => 'L\'année doit être un nombre entier.',
            'annee.min' => 'L\'année doit être au moins 1900.',
            'annee.max' => 'L\'année ne peut pas dépasser ' . (now()->year + 1) . '.',
            'kilometrage.integer' => 'Le kilométrage doit être un nombre entier.',
            'kilometrage.min' => 'Le kilométrage ne peut pas être négatif.',
            'numero_chassis.unique' => 'Ce numéro de châssis est déjà utilisé.',
            'numero_chassis.max' => 'Le numéro de châssis ne doit pas dépasser 50 caractères.',
            'img_vehicule.mimes' => 'L\'image doit être au format : jpg, jpeg, png, webp.',
            'img_vehicule.max' => 'L\'image ne doit pas dépasser 4 Mo.',
            'prix_achat.required' => 'Le prix d\'achat est obligatoire.',
            'prix_achat.numeric' => 'Le prix d\'achat doit être un nombre.',
            'prix_achat.min' => 'Le prix d\'achat ne peut pas être négatif.',
            'prix_achat.lt' => "Le prix d'achat doit être strictement inférieur au prix de vente.",
            'prix_vente.required' => 'Le prix de vente est obligatoire.',
            'prix_vente.numeric' => 'Le prix de vente doit être un nombre.',
            'prix_vente.min' => 'Le prix de vente ne peut pas être négatif.',
            'prix_vente.gt' => "Le prix de vente doit être strictement supérieur au prix d'achat.",
            'date_acquisition.required' => 'La date d\'acquisition est obligatoire.',
            'date_acquisition.date' => 'La date d\'acquisition n\'est pas valide.',
        ]);

        $validated['id_statut_vehicule'] = 1; // Statut 'en stock' par défaut (ID 1)

        if ($request->hasFile('img_vehicule')) {
            $image = $request->file('img_vehicule');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/vehicule');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $imageName);
            $validated['img_vehicule'] = 'images/vehicule/' . $imageName;
        }

        Vehicule::create($validated);

        return redirect('/vehicules');
    }
}
