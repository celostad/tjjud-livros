<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Livro
        Schema::create('Livro', function (Blueprint $table) {
            $table->increments('Codl');
            $table->string('Titulo', 40);
            $table->string('Editora', 40);
            $table->unsignedInteger('Edicao');
            $table->char('AnoPublicacao', 4);
            $table->decimal('Valor', 10, 2)->default(0);
            $table->timestamps();
        });

        // Autor
        Schema::create('Autor', function (Blueprint $table) {
            $table->increments('CodAu');
            $table->string('Nome', 40);
            $table->timestamps();
        });

        // Assunto
        Schema::create('Assunto', function (Blueprint $table) {
            $table->increments('codAs');
            $table->string('Descricao', 20);
            $table->timestamps();
        });

        // Livro x Autor
        Schema::create('Livro_Autor', function (Blueprint $table) {
            $table->unsignedInteger('Livro_Codl');
            $table->unsignedInteger('Autor_CodAu');

            $table->primary(
                ['Livro_Codl', 'Autor_CodAu'],
                'Livro_Autor_FKIndex1'
            );

            $table->foreign('Livro_Codl', 'fk_livro_autor_livro')
                ->references('Codl')
                ->on('Livro')
                ->cascadeOnDelete();

            $table->foreign('Autor_CodAu', 'fk_livro_autor_autor')
                ->references('CodAu')
                ->on('Autor')
                ->cascadeOnDelete();
        });

        // Livro x Assunto
        Schema::create('Livro_Assunto', function (Blueprint $table) {
            $table->unsignedInteger('Livro_Codl');
            $table->unsignedInteger('Assunto_codAs');

            $table->primary(
                ['Livro_Codl', 'Assunto_codAs'],
                'Livro_Assunto_FKIndex1'
            );

            $table->foreign('Livro_Codl', 'fk_livro_assunto_livro')
                ->references('Codl')
                ->on('Livro')
                ->cascadeOnDelete();

            $table->foreign('Assunto_codAs', 'fk_livro_assunto_assunto')
                ->references('codAs')
                ->on('Assunto')
                ->cascadeOnDelete();
        });

        if (DB::getDriverName() === 'mysql') {

            DB::statement("
                CREATE OR REPLACE VIEW vw_relatorio_livros_por_autor AS
                SELECT
                    a.CodAu,
                    a.Nome AS autor_nome,
                    l.Codl,
                    l.Titulo,
                    l.Editora,
                    l.Edicao,
                    l.AnoPublicacao,
                    l.Valor,
                    GROUP_CONCAT(
                        DISTINCT s.Descricao
                        ORDER BY s.Descricao
                        SEPARATOR ', '
                    ) AS assuntos
                FROM Autor a
                INNER JOIN Livro_Autor la
                    ON la.Autor_CodAu = a.CodAu
                INNER JOIN Livro l
                    ON l.Codl = la.Livro_Codl
                LEFT JOIN Livro_Assunto ls
                    ON ls.Livro_Codl = l.Codl
                LEFT JOIN Assunto s
                    ON s.codAs = ls.Assunto_codAs
                GROUP BY
                    a.CodAu,
                    a.Nome,
                    l.Codl,
                    l.Titulo,
                    l.Editora,
                    l.Edicao,
                    l.AnoPublicacao,
                    l.Valor
                ORDER BY
                    a.Nome,
                    l.Titulo
            ");
        }
    }

    public function down(): void
    {
      if (DB::getDriverName() === 'mysql') {  
        DB::statement('DROP VIEW IF EXISTS vw_relatorio_livros_por_autor');
      }

        Schema::dropIfExists('Livro_Assunto');
        Schema::dropIfExists('Livro_Autor');
        Schema::dropIfExists('Assunto');
        Schema::dropIfExists('Autor');
        Schema::dropIfExists('Livro');
    }
};