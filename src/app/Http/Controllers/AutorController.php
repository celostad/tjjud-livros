<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutorRequest;
use App\Models\Autor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AutorController extends Controller
{
    public function index(): View
    {
        $autores = Autor::withCount('livros')
            ->orderBy('Nome')
            ->paginate(15);

        return view('autores.index', compact('autores'));
    }

    public function create(): View
    {
        return view('autores.create');
    }

    public function store(AutorRequest $request): RedirectResponse
    {
        try {
            Autor::create($request->validated());

            return redirect()->route('autores.index')
                ->with('success', 'Autor cadastrado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', 'Erro ao cadastrar autor: ' . $e->getMessage());
        }
    }

    public function show(Autor $autor): View
    {
        $autor->load('livros');
        return view('autores.show', compact('autor'));
    }

    public function edit(Autor $autor): View
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(AutorRequest $request, Autor $autor): RedirectResponse
    {
        try {
            $autor->update($request->validated());

            return redirect()->route('autores.index')
                ->with('success', 'Autor atualizado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar autor: ' . $e->getMessage());
        }
    }

    public function destroy(Autor $autor): RedirectResponse
    {
        try {
            if ($autor->livros()->exists()) {
                return back()->with('error', 'Não é possível excluir um autor que possui livros vinculados.');
            }

            $autor->delete();

            return redirect()->route('autores.index')
                ->with('success', 'Autor removido com sucesso!');

        } catch (QueryException $e) {
            return back()->with('error', 'Erro ao excluir autor: ' . $e->getMessage());
        }
    }
}
