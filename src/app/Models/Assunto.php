<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assunto extends Model
{
    protected $table = 'Assunto';
    protected $primaryKey = 'codAs';

    protected $fillable = ['Descricao'];

    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(
            Livro::class,
            'Livro_Assunto',
            'Assunto_codAs',
            'Livro_Codl'
        );
    }
}
