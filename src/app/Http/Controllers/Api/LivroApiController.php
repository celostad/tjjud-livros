<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LivroRequest;
use App\Models\Livro;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class LivroApiController extends Controller
{
    public function index(): JsonResponse
    {
        $livros = Livro::with(['autores', 'assuntos'])
            ->orderBy('Titulo')
            ->paginate(15);

        return response()->json($livros);
    }

    public function store(LivroRequest $request): JsonResponse
    {
        try {
            $livro = Livro::create($request->safe()->except(['autores', 'assuntos']));
            $livro->autores()->sync($request->validated('autores', []));
            $livro->assuntos()->sync($request->validated('assuntos', []));
            $livro->load(['autores', 'assuntos']);

            return response()->json([
                'message' => 'Livro cadastrado com sucesso.',
                'data'    => $livro,
            ], 201);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    public function show(Livro $livro): JsonResponse
    {
        return response()->json($livro->load(['autores', 'assuntos']));
    }

    public function update(LivroRequest $request, Livro $livro): JsonResponse
    {
        try {
            $livro->update($request->safe()->except(['autores', 'assuntos']));
            $livro->autores()->sync($request->validated('autores', []));
            $livro->assuntos()->sync($request->validated('assuntos', []));

            return response()->json([
                'message' => 'Livro atualizado com sucesso.',
                'data'    => $livro->load(['autores', 'assuntos']),
            ]);

        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Livro $livro): JsonResponse
    {
        try {
            $livro->delete();
            return response()->json(['message' => 'Livro removido com sucesso.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Erro ao remover livro: ' . $e->getMessage()], 500);
        }
    }
}
