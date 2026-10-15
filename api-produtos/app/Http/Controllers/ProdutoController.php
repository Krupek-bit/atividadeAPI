<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        return ProdutoResource::collection(Produto::all());
    }

    public function store(ProdutoRequest $request)
    {
        $produto = Produto::create($request->validated());

        return (new ProdutoResource($produto))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }

    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->validated());

        return new ProdutoResource($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return response()->noContent();
    }
}
