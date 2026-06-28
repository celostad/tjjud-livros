@extends('layouts.app')
@section('title', 'Assuntos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><i class="bi bi-tags me-2 text-primary"></i>Assuntos</h4>
    <a href="{{ route('assuntos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Novo Assunto
    </a>
</div>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th class="text-center">Livros</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assuntos as $assunto)
                    <tr>
                        <td class="text-muted small">{{ $assunto->codAs }}</td>
                        <td>{{ $assunto->Descricao }}</td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $assunto->livros_count }}</span>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('assuntos.show', $assunto) }}"
                               class="btn btn-sm btn-outline-info btn-acao"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('assuntos.edit', $assunto) }}"
                               class="btn btn-sm btn-outline-warning btn-acao"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('assuntos.destroy', $assunto) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Excluir assunto \'{{ $assunto->Descricao }}\'?')">
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
                            Nenhum assunto cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assuntos->hasPages())
        <div class="card-footer">{{ $assuntos->links() }}</div>
    @endif
</div>
@endsection
