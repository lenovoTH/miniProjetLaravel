<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getFournisseurs()
    {
        $fournisseurs = Compte::pluck('fournisseur');
        return response()->json($fournisseurs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $phone = $request->telephone;
        $fourn = $request->fournisseur;
        $client = Client::where('telephone', $phone)->first();
        $client_id = $client->id;
        $clienExist = Client::find($client_id);

        if (!$clienExist) {
            return response()->json(['message' => 'Client non trouvé.'], 404);
        } else {
            if ($fourn == "wave") {
                $compte = Compte::create([
                    'client_id' => $client_id,
                    'fournisseur' => $fourn,
                    'numerocompte' => 'WV' . '_' . $phone,
                    'code' => 'WV'
                ]);
            } elseif ($fourn == "orange_money") {
                $compte = Compte::create([
                    'client_id' => $client_id,
                    'fournisseur' => $fourn,
                    'numerocompte' => 'OM' . '_' . $phone,
                    'code' => 'OM'
                ]);
            } else {
                $code = substr($fourn, 0, 2);
                $codeMaj = strtoupper($code);
                $compte = Compte::create([
                    'client_id' => $client_id,
                    'fournisseur' => $fourn,
                    'numerocompte' => $codeMaj . '_' . $phone,
                    'code' => $codeMaj
                ]);
            }
            return response()->json($compte);
        }
    }

    public function fermerOuBloquer(Request $request)
    {
        $compteExist = Compte::find($request->id);
        if (!$compteExist) {
            return response()->json("ce compte n'existe pas");
        }
        $compteExist->statut = $request->statut;
        $compteExist->save();
        return response()->json("le compte a été fermé!");
    }


    /**
     * Display the specified resource.
     */
    public function show(Compte $compte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compte $compte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compte $compte)
    {
        //
    }
}
