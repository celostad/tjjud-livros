-- Criar banco (já criado pelo docker-compose, mas garantindo charset)
CREATE DATABASE IF NOT EXISTS tjjud_livros
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE tjjud_livros;

-- =========================================================
-- VIEW para relatório agrupado por Autor
-- (será criada após as migrations do Laravel)
-- =========================================================
-- Executada via migration separada, mas deixada aqui como referência:
--
-- CREATE OR REPLACE VIEW vw_relatorio_livros_por_autor AS
-- SELECT
--     a.CodAu,
--     a.Nome AS autor_nome,
--     l.Codl,
--     l.Titulo,
--     l.Editora,
--     l.Edicao,
--     l.AnoPublicacao,
--     l.Valor,
--     GROUP_CONCAT(DISTINCT s.Descricao ORDER BY s.Descricao SEPARATOR ', ') AS assuntos
-- FROM Autor a
-- INNER JOIN Livro_Autor la ON a.CodAu = la.Autor_CodAu
-- INNER JOIN Livro l ON l.Codl = la.Livro_Codl
-- LEFT JOIN Livro_Assunto las ON l.Codl = las.Livro_Codl
-- LEFT JOIN Assunto s ON s.codAs = las.Assunto_codAs
-- GROUP BY a.CodAu, a.Nome, l.Codl, l.Titulo, l.Editora, l.Edicao, l.AnoPublicacao, l.Valor
-- ORDER BY a.Nome, l.Titulo;
