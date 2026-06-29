<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssuntoRequest;
use App\Models\Assunto;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssuntoController extends Controller
{
    public function index(): View
    {
        $assuntos = Assunto::withCount('livros')
            ->orderBy('Descricao')
            ->paginate(15);

        return view('assuntos.index', compact('assuntos'));
    }

    public function create(): View
    {
        return view('assuntos.create');
    }

    public function store(AssuntoRequest $request): RedirectResponse
    {
        try {
            Assunto::create($request->validated());

            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto cadastrado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', 'Erro ao cadastrar assunto: ' . $e->getMessage());
        }
    }

    public function show(Assunto $assunto): View
    {
        $assunto->load('livros');
        return view('assuntos.show', compact('assunto'));
    }

    public function edit(Assunto $assunto): View
    {
        return view('assuntos.edit', compact('assunto'));
    }

    public function update(AssuntoRequest $request, Assunto $assunto): RedirectResponse
    {
        try {
            $assunto->update($request->validated());

            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto atualizado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar assunto: ' . $e->getMessage());
        }
    }

    public function destroy(Assunto $assunto): RedirectResponse
    {
        try {
            if ($assunto->livros()->exists()) {
                return back()->with('error', 'Não é possível excluir um assunto que possui livros vinculados.');
            }

            $assunto->delete();

            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto removido com sucesso!');

        } catch (QueryException $e) {
            return back()->with('error', 'Erro ao excluir assunto: ' . $e->getMessage());
        }
    }
}
