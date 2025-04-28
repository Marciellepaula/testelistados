<?php
require_once('header.php');
$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
?>

<div class="container mt-4">
    <h5><i class="bi bi-house-door-fill"></i> Meus imóveis</h5>

    <?php if (!empty($imoveis)): ?>
        <?php foreach ($imoveis as $imovel): ?>
            <div class="row align-items-center border-bottom py-3">
                <div class="col-md-2 text-center position-relative">
                    <?php if (!empty($imovel['imagem'])): ?>
                        <img src="<?= $baseUrl ?>/<?= $imovel['imagem'] ?>" class="img-fluid rounded" style="width: 100%; height: 120px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light d-flex justify-content-center align-items-center rounded" style="width: 100%; height: 120px;">
                            <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-7">
                    <h6 class="fw-bold"><?= htmlspecialchars($imovel['titulo']) ?></h6>

                    <?php if (!empty($imovel['preco'])): ?>
                        <p class="text-success fw-bold mb-1">
                            <i class="bi bi-currency-dollar"></i> R$ <?= number_format($imovel['preco'], 2, ',', '.') ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($imovel['descricao'])): ?>
                        <p class="mb-1"><?= htmlspecialchars($imovel['descricao']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($imovel['endereco'])): ?>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($imovel['endereco']) ?>
                        </small><br>
                    <?php endif; ?>

                    <?php if (!empty($imovel['garagem'])): ?>
                        <small class="text-muted">
                            <i class="bi bi-car-front-fill"></i> Garagem: <?= htmlspecialchars($imovel['garagem']) ?>
                        </small>
                    <?php endif; ?>
                </div>

                <div class="col-md-3 text-end">
                    <a href="/imoveis/<?= $imovel['id'] ?>/editar" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>

                    <a href="/imoveis/<?= $imovel['id'] ?>/excluir" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este imóvel?')">
                        <i class="bi bi-trash-fill"></i> Excluir
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-5">
            <i class="bi bi-exclamation-triangle-fill"></i> Nenhum imóvel encontrado.
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>