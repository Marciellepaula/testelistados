<?php
// index.php
require_once 'Controllers/ImovelController.php';

$controller = new ImovelController();
$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    case 'cadastrar':
        $controller->cadastrar();
        exit;
    case 'listar':
        $imoveis = $controller->listar(); // Supondo que listar retorna os imóveis
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

<!-- HTML para a lista de imóveis (view) -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Imóveis</title>
</head>

<body>
    <h1>Lista de Imóveis</h1>
    <a href="/cadastro.php">Cadastrar Novo Imóvel</a>
    <br><br>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço (R$)</th>
                <th>Localização</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imoveis as $imovel): ?>
                <tr>
                    <td><?= $imovel['id'] ?></td>
                    <td><?= htmlspecialchars($imovel['nome']) ?></td>
                    <td><?= htmlspecialchars($imovel['descricao']) ?></td>
                    <td><?= number_format($imovel['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($imovel['localizacao']) ?></td>
                    <td>
                        <a href="index.php?acao=editar&id=<?= $imovel['id'] ?>">Editar</a> |
                        <a href="index.php?acao=excluir&id=<?= $imovel['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este imóvel?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>