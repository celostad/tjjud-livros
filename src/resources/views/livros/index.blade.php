@extends('layouts.app')

@section('title', 'Livros')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-journals me-2 text-primary"></i>Livros</h4>
    <a href="{{ route('livros.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Novo Livro
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Editora</th>
                        <th>Edição</th>
                        <th>Ano</th>
                        <th>Valor</th>
                        <th>Autores</th>
                        <th>Assuntos</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($livros as $livro)
                        <tr>
                            <td class="text-muted small">{{ $livro->Codl }}</td>
                            <td><strong>{{ $livro->Titulo }}</strong></td>
                            <td>{{ $livro->Editora }}</td>
                            <td class="text-center">{{ $livro->Edicao }}ª</td>
                            <td class="text-center">{{ $livro->AnoPublicacao }}</td>
                            <td class="text-end">
                                R$ {{ number_format($livro->Valor, 2, ',', '.') }}
                            </td>
                            <td>
                                @foreach($livro->autores as $autor)
                                    <span class="badge badge-autor me-1">{{ $autor->Nome }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($livro->assuntos as $assunto)
                                    <span class="badge badge-assunto me-1">{{ $assunto->Descricao }}</span>
                                @endforeach
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('livros.show', $livro) }}"
                                   class="btn btn-sm btn-outline-info btn-acao" title="Visualizar">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('livros.edit', $livro) }}"
                                   class="btn btn-sm btn-outline-warning btn-acao" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('livros.destroy', $livro) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Confirma exclusão do livro \'{{ $livro->Titulo }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-acao" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Nenhum livro cadastrado.
                                <a href="{{ route('livros.create') }}">Cadastrar agora</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($livros->hasPages())
        <div class="card-footer">
            {{ $livros->links() }}
        </div>
    @endif
</div>
@endsection
