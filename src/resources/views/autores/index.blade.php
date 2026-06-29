@extends('layouts.app')
@section('title', 'Autores')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Autores</h4>
    <a href="{{ route('autores.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Novo Autor
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th class="text-center">Livros</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($autores as $autor)
                    <tr>
                        <td class="text-muted small">{{ $autor->CodAu }}</td>
                        <td>{{ $autor->Nome }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $autor->livros_count }}</span>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('autores.show', $autor) }}"
                               class="btn btn-sm btn-outline-info btn-acao"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('autores.edit', $autor) }}"
                               class="btn btn-sm btn-outline-warning btn-acao"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('autores.destroy', $autor) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Excluir autor \'{{ $autor->Nome }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-acao">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Nenhum autor cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($autores->hasPages())
        <div class="card-footer">{{ $autores->links() }}</div>
    @endif
</div>
@endsection
