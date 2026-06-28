<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LivroController extends Controller
{
    public function index(): View
    {
        $livros = Livro::with(['autores', 'assuntos'])
            ->orderBy('Titulo')
            ->paginate(15);

        return view('livros.index', compact('livros'));
    }

    public function create(): View
    {
        $autores  = Autor::orderBy('Nome')->get();
        $assuntos = Assunto::orderBy('Descricao')->get();

        return view('livros.create', compact('autores', 'assuntos'));
    }

    public function store(LivroRequest $request): RedirectResponse
    {
        try {
            $livro = Livro::create($request->safe()->except(['autores', 'assuntos']));
            $livro->autores()->sync($request->validated('autores', []));
            $livro->assuntos()->sync($request->validated('assuntos', []));

            return redirect()->route('livros.index')
                ->with('success', 'Livro cadastrado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', $this->tratarErroDB($e));
        }
    }

    public function show(Livro $livro): View
    {
        $livro->load(['autores', 'assuntos']);
        return view('livros.show', compact('livro'));
    }

    public function edit(Livro $livro): View
    {
        $livro->load(['autores', 'assuntos']);
        $autores  = Autor::orderBy('Nome')->get();
        $assuntos = Assunto::orderBy('Descricao')->get();

        return view('livros.edit', compact('livro', 'autores', 'assuntos'));
    }

    public function update(LivroRequest $request, Livro $livro): RedirectResponse
    {
        try {
            $livro->update($request->safe()->except(['autores', 'assuntos']));
            $livro->autores()->sync($request->validated('autores', []));
            $livro->assuntos()->sync($request->validated('assuntos', []));

            return redirect()->route('livros.index')
                ->with('success', 'Livro atualizado com sucesso!');

        } catch (QueryException $e) {
            return back()->withInput()
                ->with('error', $this->tratarErroDB($e));
        }
    }

    public function destroy(Livro $livro): RedirectResponse
    {
        try {
            $livro->delete();

            return redirect()->route('livros.index')
                ->with('success', 'Livro removido com sucesso!');

        } catch (QueryException $e) {
            return back()->with('error', $this->tratarErroDB($e));
        }
    }

    private function tratarErroDB(QueryException $e): string
    {
        return match ($e->getCode()) {
            '23000' => 'Não é possível excluir este registro pois possui vínculos.',
            '42S02' => 'Tabela não encontrada no banco de dados.',
            default => 'Erro no banco de dados: ' . $e->getMessage(),
        };
    }
}
