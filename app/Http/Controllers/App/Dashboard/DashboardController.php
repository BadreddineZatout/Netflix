<?php

namespace App\Http\Controllers\App\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Charge;
use App\Models\Compte;
use App\Models\Core\Auth\User;
use App\Models\Modalite_de_paiement;
use App\Models\Panne;
use App\Models\PanneAbonnement;
use App\Models\User_Role;
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
                                    /******************************Les Tables********************************/

    public function abonnements()
    {
        return Abonnement::select('abonnements.id', 'abonnements.email', 'abonnements.password', 'produits.nom AS produit', 'abonnements.dateDebut', 'abonnements.datefin', 'abonnements.resultatcreation', 'abonnements.etat', 'abonnements.transaction')
                        ->join('produits', 'produits.id', '=', 'abonnements.produit')
                        ->get();    
    }
    public function transactions()
    {
        return Transaction::select('transactions.id', 'e.nom AS emeteur', 'e.id AS idE', 'r.nom AS recepteur', 'r.id AS idR', 'transactions.type', 'transactions.date', 'transactions.montant', 'm.modalitePaiement', 'transactions.etat')
                            ->join('comptes AS r', 'r.id', '=', 'transactions.idCompteRecepteur')
                            ->join('comptes AS e', 'e.id', '=', 'transactions.idCompteEmeteur')
                            ->leftJoin('modalite_de_paiements AS m', 'm.id', '=', 'transactions.modalitePaiement')
                            ->get();
    }
    public function pannesAbonnement()
    {
        return PanneAbonnement::select('panne_abonnements.id', 'abonnements.email', 'panne_abonnements.date', 'panne_abonnements.heure', 'pannes.panne', 'panne_abonnements.Etat')
                                ->join('abonnements', 'abonnements.id', '=', 'panne_abonnements.abonnement')
                                ->join('pannes', 'pannes.id', '=', 'panne_abonnements.panne')
                                ->get();
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
    public function charges()
    {
        return Charge::select('charges.id', 'comptes.nom', 'comptes.id AS recepteur', 'm.modalitePaiement', 'charges.NumeroCompte', 'charges.somme', 'charges.etat', 'charges.date', 'charges.transaction')
                        ->join('comptes', 'comptes.id', '=', 'charges.compte')
                        ->join('modalite_de_paiements AS m', 'm.id', '=', 'charges.modalitePaiement')
                        ->get();
    }

                                            /******************************GET Requests********************************/

    public function getAbonnement($email, $pdw)
    {
        $a = Abonnement::where('email', $email)->where('password', $pdw)->latest('id')->first();
        if (!$a)
        {
            return 'non ok';
        }else return 'ok';
    }
    public function getBalance()
    {
        $balance = Compte::where('email', Auth::user()->email)->first()->balanceActuel;
        return $balance;
    }
    public function getAbonnPending()
    {
        return Abonnement::where('resultatcreation', 'pending')->get()->count();
    }
    public function getPannePending()
    {
        return PanneAbonnement::where('Etat', 'pending')->get()->count();
    }
    public function getUser()
    {
        return Compte::all()->count();
    }
    public function getAbonnTotal()
    {
        return Abonnement::all()->count();
    }
    public function getTransTotal()
    {
        return Transaction::all()->count();
    }
    public function getProduit()
    {
        return Produit::all()->count();
    }
    public function getPanneUser()
    {
        return PanneAbonnement::select('panne_abonnements.id', 'abonnements.email', 'panne_abonnements.date', 'panne_abonnements.heure', 'pannes.panne', 'panne_abonnements.Etat')->where('revendeur', Auth::user()->id)->join('abonnements', 'abonnements.id', '=', 'panne_abonnements.abonnement')->join('pannes', 'pannes.id', '=', 'panne_abonnements.panne')->get();
    }
    public function getTransUser()
    {
        $id = Compte::where('email', Auth::user()->email)->first()->id;
        return Transaction::select('transactions.id', 'e.nom AS emeteur', 'e.id AS idE', 'r.nom AS recepteur', 'r.id AS idR', 'transactions.type', 'transactions.date', 'transactions.montant', 'm.modalitePaiement', 'transactions.etat')
                            ->where('transactions.idCompteEmeteur', $id)
                            ->orWhere('transactions.idCompteRecepteur', $id)
                            ->join('comptes AS r', 'r.id', '=', 'transactions.idCompteRecepteur')
                            ->join('comptes AS e', 'e.id', '=', 'transactions.idCompteEmeteur')
                            ->leftJoin('modalite_de_paiements AS m', 'm.id', '=', 'transactions.modalitePaiement')
                            ->get();
    }
    public function getPanneAdmin()
    {
        return PanneAbonnement::select('panne_abonnements.id', 'abonnements.email', 'panne_abonnements.date', 'panne_abonnements.heure', 'pannes.panne', 'panne_abonnements.Etat')->where('panne_abonnements.Etat', 'pending')->join('abonnements', 'abonnements.id', '=', 'panne_abonnements.abonnement')->join('pannes', 'pannes.id', '=', 'panne_abonnements.panne')->get();
    }
    public function getAbonnAdmin()
    {
        return Abonnement::where('resultatcreation', 'pending')->get();
    }

                                            /******************************POST Requests********************************/          

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
        $user = Auth::user();
        $compte = Compte::where('email', $user->email)->first();

        $t = new Transaction();
        $t->date = date("Y-m-d");
        $t->montant = $request->produit[1]; 
        $t->idCompteEmeteur = $compte->id;
        $recep = User::where('id', User_Role::where('role_id', 1)->first()->user_id)->first();
        $recep = Compte::where('email', $recep->email)->first();
        $t->idCompteRecepteur = $recep->id;
        $t->type = 'Abonnement';
        $t->soldeAvant = $compte->balanceActuel;
        $t->soldeApres = $t->soldeAvant - $request->produit[1];
        $t->etat = 'non paye';
        $t->save();
        $t = Transaction::select('id')->latest('id')->first();

        $d = $request->produit[0];
        $produit = Produit::where('nom', $d)->first(); 
        $compte->totalAchatAbonnement = $compte->totalAchatAbonnement + $produit->tarifVenteRevendeur;
        $compte->balanceActuel = $compte->balanceActuel - $produit->tarifVenteRevendeur;
        $compte->save();

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
        $abonn->marge = $produit->tarifVenteRevendeur - $produit->tarifAchatDinar;
        $abonn->resultatcreation = 'pending';
        $abonn->etat = 'inactif';
        $abonn->transaction = $t->id;
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
        $modpaie->NumeroCompte = $request->NumeroCompte;
        $modpaie->save();
    }
    public function storeProduit(Request $request)
    {
        $produit = new Produit();
        $produit->nom = $request->nom;
        $produit->duree = $request->duree;
        $produit->tarifVenteRevendeur = $request->tarifVenteRevendeur;
        $produit->tarifVenteDetail = 0;
        $produit->tarifAchatEuro = $request->tarifAchatEuro;
        $produit->tarifAchatDinar = $request->tarifAchatDinar;
        $produit->save();
    }
    public function storePanneAbonnement(Request $request)
    {
        $pa = new PanneAbonnement();
        $p = Panne::select('id')->where('panne', $request->panne)->first();
        $a = Abonnement::where('email', $request->email)->where('password', $request->password)->latest('id')->first();
        $revendeur = Auth::user()->id;

        $pa->abonnement = $a->id;
        $pa->date = date("Y-m-d");
        $pa->heure = date("H:i:s");
        $pa->panne = $p->id;
        $pa->Etat = "pending";
        $pa->revendeur = $revendeur;
        $a->etat = "inactif";
        $a->save();
        $pa->save();
    }
    public function storeCharge(Request $request)
    {
        $user = Auth::user();
        $compte = Compte::where('email', $user->email)->first();
        
        $t = new Transaction();
        $t->date = date("Y-m-d");
        $t->montant = $request->somme; 
        $t->idCompteRecepteur = $compte->id;
        $emet = User::where('id', User_Role::where('role_id', 1)->first()->user_id)->first();
        $emet = Compte::where('email', $emet->email)->first();
        $t->idCompteEmeteur = $emet->id;
        $t->type = 'Chargement';
        $t->soldeAvant = $compte->balanceActuel;
        $t->soldeApres = $t->soldeAvant + $request->somme;
        $t->modalitePaiement = $request->modalite;
        $t->etat = 'non paye';
        $t->save();
        $t = Transaction::select('id')->latest('id')->first();

        $charge = new Charge();
        $charge->compte = $compte->id;
        $charge->modalitePaiement = $request->modalite;
        $charge->NumeroCompte = $request->numero;
        $charge->somme = $request->somme;
        $charge->etat = "pending";
        $charge->date = date("Y-m-d");
        $charge->transaction = $t->id;
        $charge->save();
    }

                                                /******************************PATCH Requests********************************/

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

        if ($request->oldresultatcreation=="created" && $request->resultatcreation=="annule")
        {
            return null;
        }
        if ($request->oldresultatcreation=="pending" && $request->resultatcreation=="annule")
        {
            $t = Transaction::findOrFail($request->transaction);
            $compte = Compte::where('id', $t->idCompteEmeteur)->first();
            $compte->totalAchatAbonnement = $compte->totalAchatAbonnement - $produit->tarifVenteRevendeur;
            $compte->balanceActuel = $compte->balanceActuel + $produit->tarifVenteRevendeur;
            $compte->save();
            $t->etat = 'annule';
            $t->save();
        }

        $abonn->produit = $produit->id;
        $abonn->dateDebut = $startdate;
        $abonn->datefin = $enddate;
        $abonn->email = $request->email;
        $abonn->password = $request->password;
        $abonn->tarifVente = $produit->tarifVenteRevendeur;
        $abonn->tarifAchatEuro = $produit->tarifAchatEuro;
        $abonn->tarifAchatDinar = $produit->tarifAchatDinar;
        $abonn->marge = $produit->tarifVenteRevendeur - $produit->tarifAchatDinar;
        $abonn->resultatcreation = $request->resultatcreation;
        $abonn->etat = $request->etat;
        $abonn->transaction = $request->transaction;
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
        $t->montant = intval($request->montant);
        $t->modalitePaiement = $modalite[0]->id;
        $t->etat = $request->etat;
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
    public function updateProduit(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->nom = $request->nom;
        $produit->duree = $request->duree;
        $produit->tarifVenteRevendeur = $request->tarifVenteRevendeur;
        $produit->tarifAchatEuro = $request->tarifAchatEuro;
        $produit->tarifAchatDinar = $request->tarifAchatDinar;
        $produit->save();
    }
    public function updateCharge(Request $request, $id)
    {
        if ($request->oldEtat=="pending" && $request->etat=="paye")
        {
            $compte = Compte::findOrFail($request->recepteur);
            $compte->balanceCharge = $compte->balanceCharge + $request->somme;
            $compte->balanceActuel = $compte->balanceActuel + $request->somme;
            $compte->save();
            $t = Transaction::findOrFail($request->transaction);
            $t->etat = 'paye';
            $t->save();
        }
        $charge = Charge::findOrFail($id);
        $mod = Modalite_de_paiement::where('modalitePaiement', $request->modalitePaiement)->first();
        $charge->modalitePaiement = $mod->id;
        $charge->NumeroCompte = $request->NumeroCompte;
        $charge->somme = $request->somme;
        $charge->etat = $request->etat;
        $charge->date = date("Y-m-d", strtotime($request->date));
        $charge->save();
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $compte = Compte::where('email', $user->email)->first();

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        
        $compte->nom = $request->first_name . " " . $request->last_name;
        $compte->save();
    }

                                                /******************************DELET Requests********************************/

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
    public function deleteProduit($id)
    {
        Produit::destroy($id);
    }
    public function deleteCharge($id)
    {
        Charge::destroy($id);
    }
    public function deleteUser($id)
    {
        $user = User::findorFail($id);
        $compte = Compte::where('email', $user->email)->first();
        $user->delete();
        Compte::destroy($compte->id);
    }
}
