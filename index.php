<?php
$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
require_once 'Controllers/ImovelController.php';

$controller = new ImovelController();

$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    case 'cadastrar':
        $controller->cadastrar();
        exit;
    case 'listar':
        $imoveis = $controller->listar();
        break;
    case 'editar':
        $id = $_GET['id'] ?? null;
        $controller->editar($id);
        exit;
    case 'excluir':
        $id = $_GET['id'] ?? null;
        $controller->excluir($id);
        exit;
    default:
        echo "Ação inválida!";
        exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Imóveis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Imóveis</h1>
        <a href="/cadastro.php" class="btn btn-success mb-3">Cadastrar Novo Imóvel</a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço (R$)</th>
                        <th>Endereço</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($imoveis) && !empty($imoveis)): ?>
                        <?php foreach ($imoveis as $imovel): ?>
                            <tr>
                                <td><?= htmlspecialchars($imovel['id']) ?></td>
                                <td><?= htmlspecialchars($imovel['titulo']) ?></td>
                                <td><?= htmlspecialchars($imovel['descricao']) ?></td>
                                <td><?= number_format($imovel['preco'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($imovel['endereco']) ?></td>
                                <td>
                                    <img src="<?= $baseUrl ?>/<?= $imovel['imagem'] ?>" alt="Imagem do Imóvel" class="img-fluid" style="max-width: 150px; height: auto; border-radius: 8px;">
                                </td>
                                <td>
                                    <a href="editar.php?id=<?= $imovel['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <a href="index.php?acao=excluir&id=<?= $imovel['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este imóvel?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum imóvel encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>