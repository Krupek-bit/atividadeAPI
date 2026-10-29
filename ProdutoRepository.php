<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Collection;

class ProdutoRepository
{
    public function all(): Collection
    {
        return Produto::all();
    }

    public function find(int $id): ?Produto
    {
        return Produto::find($id);
    }

    /**
     * Busca produtos aplicando filtros opcionais.
     *
     * Filtros aceitos:
     *  - nome       : busca parcial no nome
     *  - preco_min  : preço maior ou igual (filtro novo 1: faixa de preço)
     *  - preco_max  : preço menor ou igual (filtro novo 1: faixa de preço)
     *  - em_estoque : true = só produtos com estoque > 0, false = só esgotados (filtro novo 2)
     */
    public function search(array $filtros = []): Collection
    {
        $query = Produto::query();

        if (!empty($filtros['nome'])) {
            $query->where('nome', 'like', '%' . $filtros['nome'] . '%');
        }

        if (isset($filtros['preco_min']) && $filtros['preco_min'] !== '') {
            $query->where('preco', '>=', $filtros['preco_min']);
        }

        if (isset($filtros['preco_max']) && $filtros['preco_max'] !== '') {
            $query->where('preco', '<=', $filtros['preco_max']);
        }

        if (isset($filtros['em_estoque']) && $filtros['em_estoque'] !== '') {
            $emEstoque = filter_var($filtros['em_estoque'], FILTER_VALIDATE_BOOLEAN);
            $query->where('estoque', $emEstoque ? '>' : '=', 0);
        }

        return $query->get();
    }

    public function create(array $dados): Produto
    {
        return Produto::create($dados);
    }

    public function update(Produto $produto, array $dados): Produto
    {
        $produto->update($dados);

        return $produto->refresh();
    }

    public function delete(Produto $produto): bool
    {
        return (bool) $produto->delete();
    }
}
