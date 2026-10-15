<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function show(string $nome)
    {
        $resposta = Http::get('https://pokeapi.co/api/v2/pokemon/' . strtolower($nome));

        if ($resposta->failed()) {
            return response()->json(['erro' => 'Pokémon não encontrado'], 404);
        }

        $dados = $resposta->json();

        return response()->json([
            'nome'   => $dados['name'],
            'altura' => $dados['height'],
            'peso'   => $dados['weight'],
            'tipos'  => collect($dados['types'])->pluck('type.name'),
            'imagem' => $dados['sprites']['front_default'],
        ]);
    }
}
