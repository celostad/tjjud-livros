<?php

namespace Database\Seeders;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Autores
        $autores = [
            ['Nome' => 'Machado de Assis'],
            ['Nome' => 'Clarice Lispector'],
            ['Nome' => 'Guimarães Rosa'],
            ['Nome' => 'Jorge Amado'],
            ['Nome' => 'Carlos Drummond de Andrade'],
        ];

        foreach ($autores as $a) {
            Autor::create($a);
        }

        // Assuntos
        $assuntos = [
            ['Descricao' => 'Romance'],
            ['Descricao' => 'Conto'],
            ['Descricao' => 'Poesia'],
            ['Descricao' => 'Literatura'],
            ['Descricao' => 'Ficção'],
        ];

        foreach ($assuntos as $s) {
            Assunto::create($s);
        }

        // Livros com relacionamentos
        $livro1 = Livro::create([
            'Titulo'        => 'Dom Casmurro',
            'Editora'       => 'Companhia das Letras',
            'Edicao'        => 2,
            'AnoPublicacao' => '1899',
            'Valor'         => 39.90,
        ]);
        $livro1->autores()->attach(1); // Machado de Assis
        $livro1->assuntos()->attach([1, 4]); // Romance, Literatura

        $livro2 = Livro::create([
            'Titulo'        => 'A Hora da Estrela',
            'Editora'       => 'Rocco',
            'Edicao'        => 1,
            'AnoPublicacao' => '1977',
            'Valor'         => 34.50,
        ]);
        $livro2->autores()->attach(2); // Clarice Lispector
        $livro2->assuntos()->attach([2, 5]); // Conto, Ficção

        $livro3 = Livro::create([
            'Titulo'        => 'Grande Sertão: Veredas',
            'Editora'       => 'Nova Fronteira',
            'Edicao'        => 3,
            'AnoPublicacao' => '1956',
            'Valor'         => 59.90,
        ]);
        $livro3->autores()->attach(3); // Guimarães Rosa
        $livro3->assuntos()->attach([1, 4]); // Romance, Literatura

        $livro4 = Livro::create([
            'Titulo'        => 'Gabriela, Cravo e Canela',
            'Editora'       => 'Companhia das Letras',
            'Edicao'        => 5,
            'AnoPublicacao' => '1958',
            'Valor'         => 44.90,
        ]);
        $livro4->autores()->attach(4); // Jorge Amado
        $livro4->assuntos()->attach([1]); // Romance

        // Livro com dois autores (demonstra N:N)
        $livro5 = Livro::create([
            'Titulo'        => 'Antologia Brasileira',
            'Editora'       => 'Edições Brasil',
            'Edicao'        => 1,
            'AnoPublicacao' => '2000',
            'Valor'         => 79.00,
        ]);
        $livro5->autores()->attach([1, 5]); // Machado + Drummond
        $livro5->assuntos()->attach([3, 4]); // Poesia, Literatura
    }
}
