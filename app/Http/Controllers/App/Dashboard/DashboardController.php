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
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Gd\Encoder;
use Noodlehaus\FileParser\Json;

use function PHPUnit\Framework\isNull;

class DashboardController extends Controller
{
    // public function __construct(DashboardService $service)
    // {
    //     $this->service = $service;
    // }

    public function abonnements()
    {
        return Abonnement::select('abonnements.id', 'abonnements.email', 'abonnements.password', 'produits.nom AS produit', 'abonnements.dateDebut', 'abonnements.datefin', 'abonnements.resultatcreation', 'abonnements.etat')->join('produits', 'produits.id', '=', 'abonnements.produit')->get();    
    }
    public function transactions()
    {
        return Transaction::select('transactions.id', 'e.nom AS emeteur', 'r.nom AS recepteur', 'transactions.date', 'transactions.heure', 'transactions.montant', 'm.modalitePaiement')->join('comptes AS r', 'r.id', '=', 'transactions.idCompteRecepteur')->join('comptes AS e', 'e.id', '=', 'transactions.idCompteEmeteur')->join('modalite_de_paiements AS m', 'm.id', '=', 'transactions.modalitePaiement')->get();
    }
    public function pannesAbonnement()
    {
        return PanneAbonnement::select('panne_abonnements.id', 'abonnements.email', 'panne_abonnements.date', 'panne_abonnements.heure', 'pannes.panne', 'panne_abonnements.Etat')->join('abonnements', 'abonnements.id', '=', 'panne_abonnements.abonnement')->join('pannes', 'pannes.id', '=', 'panne_abonnements.panne')->get();
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
    public function comptes()
    {
        return Compte::all();
    }
    public function getAbonnement($email, $pdw)
    {
        $a = Abonnement::where('email', $email)->where('password', $pdw)->latest('id')->first();
        if (!$a)
        {
            return 'non ok';
        }else return 'ok';
    }
    public function storeComptes(Request $request)
    {
        $compte = new Compte();
        $compte->nom = $request->first_name . " " . $request->last_name;
        $compte->mobile = $request->telephone;
        $compte->email = $request->email;
        $compte->adresse = $request->adresse;
        $compte->password = Hash::make($request->password);
        $compte->wilaya = $request->wilaya;
        $compte->commune = $request->commune;
        $compte->balanceCharge = 0;
        $compte->totalAchatAbonnement = 0;
        $compte->balanceActuel = 0;
        $compte->save();

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status_id = 2;
        $user->save();
    }
    public function store(Request $request)
    {
        $d = $request->produit;
        $produit = Produit::where('nom', $d)->first(); 
        $abonn = new Abonnement();
        $startdate = date("Y-m-d");
        $d = $produit->duree;
        $tmp = ($d > 1) ? ' Months' : ' Month';
        $d = '+'.$d;
        $d = '+' . $d . $tmp;
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
        $abonn->etat = 'inactif';
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
        $modpaie->modalitePaiement = $request->modalitePaiement;
        $modpaie->save();
    }
    public function storePanneAbonnement(Request $request)
    {
        $pa = new PanneAbonnement();
        $p = Panne::select('id')->where('panne', $request->panne)->first();
        $a = Abonnement::where('email', $request->email)->where('password', $request->password)->latest('id')->first();

        $pa->abonnement = $a->id;
        $pa->date = date("Y-m-d");
        $pa->heure = date("H:i:s");
        $pa->panne = $p->id;
        $pa->Etat = "pending";
        $a->etat = "inactif";
        $a->save();
        $pa->save();
    }
    public function updatePanneAbonnement(Request $request, $id)
    {
        $pa = PanneAbonnement::findOrfail($id);
        $p = Panne::select('id')->where('panne', $request->panne)->get();
        $pa->date = date("Y-m-d", strtotime($request->date));
        $pa->heure = date("H:i:s", strtotime($request->heure));
        $pa->panne = $p[0]->id;
        $pa->Etat = $request->Etat;
        return $pa->save();
    }
    public function updateAbonnement(Request $request, $id)
    {
        $d = $request->produit;
        $produit = Produit::where('nom', $d)->first(); 
        $abonn = Abonnement::findOrFail($id);
        $startdate = date("Y-m-d", strtotime($request->dateDebut));
        $d = $produit->duree;
        $tmp = ($d > 1) ? ' Months' : ' Month';
        $d = $request->dateDebut . ' +' . $d . $tmp;
        $enddate = date("Y-m-d", strtotime($d));
        
        $abonn->produit = $produit->id;
        $abonn->dateDebut = $startdate;
        $abonn->datefin = $enddate;
        $abonn->email = $request->email;
        $abonn->password = $request->password;
        $abonn->tarifVente = $produit->tarifVenteRevendeur;
        $abonn->tarifAchatEuro = $produit->tarifAchatEuro;
        $abonn->tarifAchatDinar = $produit->tarifAchatDinar;
        $abonn->typeCompte = "client";
        $abonn->marge = $produit->tarifAchatDinar - $produit->tarifVenteRevendeur;
        $abonn->resultatcreation = $request->resultatcreation;
        $abonn->etat = $request->etat;
        $abonn->save();
    }
    public function updateTransaction(Request $request, $id)
    {
        $emeteur = Compte::select('id')->where('nom', $request->emeteur)->get();
        $recepteur = Compte::select('id')->where('nom', $request->recepteur)->get();
        $modalite = Modalite_de_paiement::select('id')->where('modalitePaiement', $request->modalitePaiement)->get();
        $t = Transaction::findOrFail($id);
        $t->idCompteEmeteur = $emeteur[0]->id;
        $t->idCompteRecepteur = $recepteur[0]->id;
        $t->date = $request->date;
        $t->heure = $request->heure;
        $t->montant = intval($request->montant);
        $t->modalitePaiement = $modalite[0]->id;
        $t->save();
    }
    public function updatePanne(Request $request, $id)
    {
        $panne = Panne::findOrFail($id);
        $panne->panne = $request->panne;
        $panne->color = $request->color;
        $panne->save();
    }
    public function updateModalite(Request $request, $id)
    {
        $modpaie = Modalite_de_paiement::findOrFail($id);
        $modpaie->modalitePaiement = $request->modalitePaiement;
        $modpaie->save();
    }
    public function deleteAbonnement($id)
    {
        Abonnement::destroy($id);
    }
    public function deleteTransaction($id)
    {
        Transaction::destroy($id);
    }
    public function deletePanneAbonnement($id)
    {
        PanneAbonnement::destroy($id);
    }
    public function deletePanne($id)
    {
        Panne::destroy($id);
    }
    public function deleteModalite($id)
    {
        Modalite_de_paiement::destroy($id);
    }
}
