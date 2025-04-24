<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Imóvel</title>
</head>

<body>
    <h1>Editar Imóvel</h1>
    <form method="POST" action="atualizar_imovel.php?id=<?= $imovel['id'] ?>">
        <label for="titulo">Título:</label><br>
        <input type="text" name="titulo" value="<?= htmlspecialchars($imovel['titulo'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <label for="preco">Preço (R$):</label><br>
        <input type="number" name="preco" step="0.01" value="<?= htmlspecialchars($imovel['preco'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao" rows="4" required><?= htmlspecialchars($imovel['descricao'], ENT_QUOTES, 'UTF-8') ?></textarea><br><br>

        <label for="endereco">Endereço:</label><br>
        <input type="text" name="endereco" value="<?= htmlspecialchars($imovel['endereco'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="garagem">Garagem:</label><br>
        <input type="number" name="garagem" value="<?= htmlspecialchars($imovel['garagem'], ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="imagem">Imagem (URL ou nome do arquivo):</label><br>
        <input type="text" name="imagem" value="<?= htmlspecialchars($imovel['imagem'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <button type="submit">Atualizar Imóvel</button>
    </form>

    <br>
    <a href="index.php?acao=listar">Voltar à Lista</a>
</body>

</html>