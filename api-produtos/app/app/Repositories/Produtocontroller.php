<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoRepository $repository)
    {
    }

    // GET /api/produtos?nome=teclado&preco_min=50&preco_max=300&em_estoque=true
    public function index(Request $request)
    {
        $produtos = $this->repository->search(
            $request->only(['nome', 'preco_min', 'preco_max', 'em_estoque'])
        );

        return ProdutoResource::collection($produtos);
    }

    public function store(ProdutoRequest $request)
    {
        $produto = $this->repository->create($request->validated());

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
        $produto = $this->repository->update($produto, $request->validated());

        return new ProdutoResource($produto);
    }

    public function destroy(Produto $produto)
    {
        $this->repository->delete($produto);

        return response()->noContent();
    }
}
