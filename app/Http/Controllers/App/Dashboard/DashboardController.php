<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Compte;
use App\Models\Core\Auth\User;
use App\Models\Modalite_de_paiement;
use App\Models\Panne;
use App\Models\PanneAbonnement;
use App\Models\Produit;
use App\Models\Transaction;
use App\Services\App\Dashboard\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Gd\Encoder;
use Noodlehaus\FileParser\Json;

class DashboardController extends Controller
{
    // public function __construct(DashboardService $service)
    // {
    //     $this->service = $service;
    // }

    public function abonnements()
    {
        return Abonnement::select('abonnements.email', 'produits.nom AS produit', 'abonnements.dateDebut', 'abonnements.datefin', 'abonnements.resultatcreation', 'abonnements.etat')->join('produits', 'produits.id', '=', 'abonnements.produit')->get();    
    }
    public function transactions()
    {
        return Transaction::select('e.nom AS emeteur', 'r.nom AS recepteur', 'transactions.date', 'transactions.heure', 'transactions.montant', 'm.modalitePaiement')->join('comptes AS r', 'r.id', '=', 'transactions.idCompteRecepteur')->join('comptes AS e', 'e.id', '=', 'transactions.idCompteEmeteur')->join('modalite_de_paiements AS m', 'm.id', '=', 'transactions.modalitePaiement')->get();
    }
    public function pannesAbonnement()
    {
        return PanneAbonnement::select('abonnements.email', 'panne_abonnements.date', 'panne_abonnements.heure', 'pannes.panne')->join('abonnements', 'abonnements.id', '=', 'panne_abonnements.abonnement')->join('pannes', 'pannes.id', '=', 'panne_abonnements.panne')->get();
    }
    public function produits()
    {
        return Produit::all();
    }
    public function pannes()
    {
        return Panne::all();
    }
    public function modalites()
    {
        return Modalite_de_paiement::all();
    }
    public function store(Request $request)
    {
        $d = $request->produit;
        $produit = Produit::where('duree', intval(explode(' ', $d)[0]))->first(); 
        $abonn = new Abonnement();
        $startdate = date("Y-m-d");
        $d = '+'.$d;
        $enddate = strtotime($d);

        $abonn->produit = $produit->id;
        $abonn->dateDebut = $startdate;
        $abonn->datefin = date("Y-m-d", $enddate);
        $abonn->email = $request->email;
        $abonn->password = $request->password;
        $abonn->tarifVente = $produit->tarifVenteRevendeur;
        $abonn->tarifAchatEuro = $produit->tarifAchatEuro;
        $abonn->tarifAchatDinar = $produit->tarifAchatDinar;
        $abonn->typeCompte = "client";
        $abonn->marge = $produit->tarifAchatDinar - $produit->tarifVenteRevendeur;
        $abonn->resultatcreation = 'pending';
        $abonn->etat = 'pending';
        $abonn->save();
        
    }
    public function storePannes(Request $request){
        $panne = new Panne();
        $panne->panne = $request->panne;
        $panne->color = $request->color;
        $panne->save();
    }
    public function storeModalites(Request $request){
        $modpaie = new Modalite_de_paiement();
        $modpaie->modalitePaiement = $request->modalite;
        $modpaie->save();
    }
}
