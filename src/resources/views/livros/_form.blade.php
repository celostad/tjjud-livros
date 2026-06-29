{{-- Erros de validação --}}
@if($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle me-1"></i>Corrija os erros abaixo:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label for="Titulo" class="form-label required-star">Título</label>
        <input type="text" name="Titulo" id="Titulo" maxlength="40"
               class="form-control @error('Titulo') is-invalid @enderror"
               value="{{ old('Titulo', $livro->Titulo ?? '') }}" required>
        @error('Titulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="Valor" class="form-label required-star">Valor (R$)</label>
        <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" name="Valor" id="Valor"
                   class="form-control input-valor @error('Valor') is-invalid @enderror"
                   value="{{ old('Valor', isset($livro) ? number_format($livro->Valor, 2, ',', '.') : '') }}"
                   placeholder="0,00" required>
            @error('Valor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="Editora" class="form-label required-star">Editora</label>
        <input type="text" name="Editora" id="Editora" maxlength="40"
               class="form-control @error('Editora') is-invalid @enderror"
               value="{{ old('Editora', $livro->Editora ?? '') }}" required>
        @error('Editora')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="Edicao" class="form-label required-star">Edição</label>
        <input type="number" name="Edicao" id="Edicao" min="1"
               class="form-control @error('Edicao') is-invalid @enderror"
               value="{{ old('Edicao', $livro->Edicao ?? '') }}" required>
        @error('Edicao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="AnoPublicacao" class="form-label required-star">Ano de Publicação</label>
        <input type="text" name="AnoPublicacao" id="AnoPublicacao" maxlength="4"
               class="form-control @error('AnoPublicacao') is-invalid @enderror"
               value="{{ old('AnoPublicacao', $livro->AnoPublicacao ?? '') }}"
               placeholder="AAAA" required>
        @error('AnoPublicacao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label required-star">Autores</label>
        <div class="border rounded p-2" style="max-height: 180px; overflow-y: auto;">
            @foreach($autores as $autor)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="autores[]" value="{{ $autor->CodAu }}"
                           id="autor_{{ $autor->CodAu }}"
                           {{ in_array($autor->CodAu, old('autores', isset($livro) ? $livro->autores->pluck('CodAu')->toArray() : [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="autor_{{ $autor->CodAu }}">
                        {{ $autor->Nome }}
                    </label>
                </div>
            @endforeach
            @if($autores->isEmpty())
                <span class="text-muted small">
                    Nenhum autor cadastrado.
                    <a href="{{ route('autores.create') }}" target="_blank">Cadastrar</a>
                </span>
            @endif
        </div>
        @error('autores')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Assuntos</label>
        <div class="border rounded p-2" style="max-height: 180px; overflow-y: auto;">
            @foreach($assuntos as $assunto)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="assuntos[]" value="{{ $assunto->codAs }}"
                           id="assunto_{{ $assunto->codAs }}"
                           {{ in_array($assunto->codAs, old('assuntos', isset($livro) ? $livro->assuntos->pluck('codAs')->toArray() : [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="assunto_{{ $assunto->codAs }}">
                        {{ $assunto->Descricao }}
                    </label>
                </div>
            @endforeach
            @if($assuntos->isEmpty())
                <span class="text-muted small">
                    Nenhum assunto cadastrado.
                    <a href="{{ route('assuntos.create') }}" target="_blank">Cadastrar</a>
                </span>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Máscara de moeda para o campo Valor
document.getElementById('Valor').addEventListener('blur', function () {
    let val = this.value.replace(/[^\d,]/g, '').replace(',', '.');
    let num = parseFloat(val);
    if (!isNaN(num)) {
        this.value = num.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
});

// Converter vírgula em ponto antes do submit
document.querySelector('form').addEventListener('submit', function () {
    let campo = document.getElementById('Valor');
    campo.value = campo.value.replace(/\./g, '').replace(',', '.');
});
</script>
@endpush
