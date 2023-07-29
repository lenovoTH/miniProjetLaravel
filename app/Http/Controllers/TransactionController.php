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
        Transaction::create([]);
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
        }elseif ($request->typetransaction == "transfert" && $request->fournisseur == "wari" && $request->montant < 1000) {
            return response()->json("le montant doit etre superieur à 1000");
        }elseif ($request->typetransaction == "transfert" && $request->fournisseur == "cb" && $request->montant < 10000) {
            return response()->json("le montant doit etre superieur à 10000");
        }

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
        if ($request->typetransaction == "transfert") {
            if ($request->fournisseur != "wari") {
                $numero = $request->is_code ? $this->generate(25) : null;
            } else {
                $numero = $this->generate(15);
            }
            $transfert = Transaction::create([
                'typetransaction' => $request->typetransaction,
                'montant' => $request->montant,
                'date' => date('y-m-d'),
                'expediteur_id' => $compte_id_exp,
                'recepteur_id' => $compte_id_recep,
                'code' => $numero
            ]);
            return response()->json($transfert);
        } else {
            if ($request->typetransaction == "depot" && $compte_recep) {
                $transfert = Transaction::create([
                    'typetransaction' => $request->typetransaction,
                    'montant' => $request->montant,
                    'date' => date('y-m-d'),
                    'expediteur_id' => $compte_id_exp,
                    'recepteur_id' => $compte_id_recep,
                ]);
                return response()->json($transfert);
            } elseif ($request->typetransaction == "depot" && !$compte_recep) {
                return response()->json("compte introuvable!");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
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
