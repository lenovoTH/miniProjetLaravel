<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    public function generate($length)
    {
        $random = "";
        for ($i = 0; $i < $length; $i++) {
            $random .= mt_rand(0, 9);
        }
        return $random;
    }

    public function transfert(Request $request)
    {
        if ($request->typetransaction == "transfert" && $request->fournisseur == "wave" && $request->montant < 500) {
            return response()->json("le montant doit etre superieur à 500");
        } elseif ($request->typetransaction == "transfert" && $request->fournisseur == "orange_money" && $request->montant < 500) {
            return response()->json("le montant doit etre superieur à 500");
        } elseif ($request->typetransaction == "transfert" && $request->fournisseur == "wari" && $request->montant < 1000) {
            return response()->json("le montant doit etre superieur à 1000");
        } elseif ($request->typetransaction == "transfert" && $request->fournisseur == "cb" && $request->montant < 10000) {
            return response()->json("le montant doit etre superieur à 10000");
        } elseif ($request->typetransaction == "depot" && $request->fournisseur == "wave" && $request->montant < 500) {
            return response()->json("le montant doit etre superieur à 500");
        } elseif ($request->typetransaction == "depot" && $request->fournisseur == "orange_money" && $request->montant < 500) {
            return response()->json("le montant doit etre superieur à 500");
        } elseif ($request->typetransaction == "depot" && $request->fournisseur == "wari" && $request->montant < 1000) {
            return response()->json("le montant doit etre superieur à 1000");
        } elseif ($request->typetransaction == "depot" && $request->fournisseur == "cb" && $request->montant < 10000) {
            return response()->json("le montant doit etre superieur à 10000");
        }
        // ----------------------------------------------------------------------------------------------

        $montant = $request->montant;
        $expediteur = Client::where([
            'telephone' => $request->expediteur
        ])->first();
        $recepteur = Client::where([
            'telephone' => $request->recepteur
        ])->first();
        $compte_exp = $expediteur != null ? Compte::where([
            'client_id' => $expediteur->id,
            'fournisseur' => $request->fournisseur
        ])->first() : null;
        $compte_recep = $recepteur != null ? Compte::where([
            'client_id' => $recepteur->id,
            'fournisseur' => $request->fournisseur
        ])->first() : null;
        $compte_id_exp = $compte_exp != null ? $compte_exp->id : $compte_exp;
        $compte_id_recep = $compte_recep != null ? $compte_recep->id : $compte_recep;
        $numero = "";

        if ($compte_recep != null && $compte_recep->statut == "fermer") {
            return response()->json("Ce compte est fermé !");
        }
        if ($compte_exp != null && $compte_exp->statut == "fermer") {
            return response()->json("Ce compte est fermé !");
        }

        if ($compte_exp->statut == "bloquer" && ($request->typetransaction == 'retrait' || $request->typetransaction == 'transfert')) {
            return response()->json("Ceci est un compte bloqué.");
        }

        // ----------------------------------------------------------------------------------------------


        else {
            if ($request->typetransaction == "transfert") {
                if ($request->fournisseur != "wari") {
                    $numero = $request->is_code ? $this->generate(25) : null;
                } else {
                    $numero = $this->generate(15);
                }
                $transfert = Transaction::create([
                    'typetransaction' => $request->typetransaction,
                    'montant' => $montant,
                    'date' => date('y-m-d'),
                    'expediteur_id' => $compte_id_exp,
                    'recepteur_id' => $compte_id_recep,
                    'code' => $numero
                ]);
                // $compte_recep->solde = $compte_recep->solde + $montant;
                // $compte_recep->save();
                return response()->json($transfert);
            }

            // ----------------------------------------------------------------------------------------------


            if ($request->typetransaction == "depot" && $compte_recep) {
                if ($request->fournisseur == "wari") {
                    $numero = $this->generate(15);
                }
                $transfert = Transaction::create([
                    'typetransaction' => $request->typetransaction,
                    'montant' => $montant,
                    'date' => date('y-m-d'),
                    'expediteur_id' => $compte_id_exp,
                    'recepteur_id' => $compte_id_recep,
                ]);
                $compte_recep->solde = $compte_recep->solde + $montant;
                $compte_recep->save();
                return response()->json($transfert);
            }


            // ----------------------------------------------------------------------------------------------


            elseif ($request->typetransaction == "retrait" && $compte_exp) {
                $transfert = Transaction::create([
                    'typetransaction' => $request->typetransaction,
                    'montant' => $montant,
                    'date' => date('y-m-d'),
                    'expediteur_id' => $compte_id_exp,
                ]);
                $compte_exp->solde = $compte_exp->solde - $montant;
                $compte_exp->save();
                return response()->json($transfert);
            } elseif ($request->typetransaction == "depot" && !$compte_recep) {
                return response()->json("compte introuvable!");
            } elseif ($request->typetransaction == "retrait" && !$compte_exp) {
                return response()->json("compte introuvable!");
            }
        }
    }

    public function autocomplete(Request $request)
    {
        $client = Client::where('telephone', $request->telephone)->first();
        return $client;
    }

    public function historiqueByClient(Request $request)
    {
        $num_compte = "";
        if ($request->fournisseur == 'wave') {
            $num_compte = "WV_" . $request->telephone;
        } elseif ($request->fournisseur == 'orange_money') {
            $num_compte = "OM_" . $request->telephone;
        }
        $comp = Compte::with('transactions')->where([
            'numerocompte' => $num_compte
        ])->get();
        return $comp;
    }

    public function annulerTransaction($idTrans)
    {
        $trans = Transaction::find($idTrans);
        $last = Transaction::latest('id')->value('id');
        if ($trans->id != $last) {
            return response()->json("erreur!!!");
        }
        if ($trans->typetransaction == 'depot' || $trans->typetransaction == 'transfert') {
            $compt = Compte::find($trans->recepteur_id);
            $compt->solde - $trans->montant;
            $trans->annuler = 0;
            $trans->save();
        }
        return response()->json("la transaction a été annulée");
    }


    // public function historiqueByClient($numero, $fournisseur)
    // {
    //     $num_compte = "";
    //     if ($fournisseur == 'wave') {
    //         $num_compte = "WV_" . $numero;
    //     } elseif ($fournisseur == 'orange_money') {
    //         $num_compte = "OM_" . $numero;
    //     }
    //     $comp = Compte::with('transactions')->where([
    //         'numerocompte' => $num_compte
    //     ])->get();
    //     return $comp;
    // }






























    // public function historique(Request $request)
    // {
    //     // OM_774715759
    //     $phone = $request->telephone;
    //     if (strpos($phone, '_') != false) {
    //         $fourn = Compte::where('numerocompte', $phone)->first();
    //         if ($fourn != null) {
    //             $cmpt = substr($phone, -9);
    //             $client = Client::where('telephone', $cmpt)->first()->id;
    //         }
    //     } else {
    //         $client = Client::where('telephone', $phone)->first()->id;
    //     }
    //     if ($client != null) {
    //         $trans1 = Transaction::where('expediteur_id', $client)->get();
    //         $trans2 = Transaction::where('recepteur_id', $client)->get();
    //         $all_trans = $trans1->merge($trans2);
    //         return $all_trans;
    //     }
    //     return "le client n'existe pas!";
    // }


    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
