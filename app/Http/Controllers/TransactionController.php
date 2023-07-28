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

    public function transfert(Request $request)
    {
        if ($request->typetransaction == 'transfert') {
            if ($request->is_code == true) {
                $client = Client::where([
                    'telephone' => $request->recepteur
                ])->first();
                if ($client) {
                    $compte = Compte::where([
                        'client_id' => $client->id,
                        'fournisseur' => $request->fournisseur
                    ]);
                }
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
