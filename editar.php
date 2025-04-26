<?php
require_once 'Controllers/ImovelController.php';
$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
$imovelController = new ImovelController();
$imovel = $imovelController->obterPorId($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Editar Imóvel</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Imóvel</h1>
        <form method="POST" action="atualizar_imovel.php?id=<?= $imovel['id'] ?>" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($imovel['titulo'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>


            <div class="mb-3">
                <label for="preco" class="form-label">Preço (R$):</label>
                <input type="number" name="preco" id="preco" class="form-control" step="0.01" value="<?= htmlspecialchars($imovel['preco'], ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="4" required><?= htmlspecialchars($imovel['descricao'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>


            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço:</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= htmlspecialchars($imovel['endereco'], ENT_QUOTES, 'UTF-8') ?>">
            </div>


            <div class="mb-3">
                <label for="garagem" class="form-label">Garagem:</label>
                <input type="number" name="garagem" id="garagem" class="form-control" value="<?= htmlspecialchars($imovel['garagem'], ENT_QUOTES, 'UTF-8') ?>">
            </div>


            <div class="mb-3">
                <label class="form-label">Imagem Atual:</label>
                <div class="d-flex align-items-center">
                    <img src="<?= $baseUrl ?>/public/<?= $imovel['imagem'] ?>" alt="Imagem do Imóvel" class="img-thumbnail" style="max-width: 150px; height: auto;">
                </div>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Escolher Nova Imagem:</label>
                <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
            </div>


            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Atualizar Imóvel</button>
                <a href="index.php?acao=listar" class="btn btn-secondary">Voltar à Lista</a>
            </div>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>