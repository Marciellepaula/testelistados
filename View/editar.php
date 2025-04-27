<?php
include('header.php');


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo '<div class="container mt-5"><div class="alert alert-danger">ID inválido!</div></div>';
    include('footer.php');
    exit;
}

require_once __DIR__ . '/../Controllers/ImovelController.php';

$baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

$imovelController = new ImovelController();
$imovel = $imovelController->obterPorId($id);
?>

<div class="container mt-5">
    <h5 class="mb-4 text-secondary">Editar Imóvel</h5>


    <?php if ($imovel): ?>
        <form method="POST" action="View/index.php?acao=editar&id=<?= $imovel['id'] ?>" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    class="form-control"
                    value="<?= htmlspecialchars($imovel['titulo'], ENT_QUOTES, 'UTF-8') ?>"
                    required>
                <div class="invalid-feedback">Por favor, informe o título do imóvel.</div>
            </div>


            <div class="mb-3">
                <label for="preco" class="form-label">Preço (R$)</label>
                <input
                    type="number"
                    name="preco"
                    id="preco"
                    class="form-control"
                    step="0.01"
                    min="0"
                    value="<?= htmlspecialchars($imovel['preco'], ENT_QUOTES, 'UTF-8') ?>">
            </div>


            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                <textarea
                    name="descricao"
                    id="descricao"
                    class="form-control"
                    rows="4"
                    required><?= htmlspecialchars($imovel['descricao'], ENT_QUOTES, 'UTF-8') ?></textarea>
                <div class="invalid-feedback">Por favor, forneça uma descrição.</div>
            </div>


            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input
                    type="text"
                    name="endereco"
                    id="endereco"
                    class="form-control"
                    value="<?= htmlspecialchars($imovel['endereco'], ENT_QUOTES, 'UTF-8') ?>">
            </div>


            <div class="mb-3">
                <label for="garagem" class="form-label">Garagem</label>
                <input
                    type="number"
                    name="garagem"
                    id="garagem"
                    class="form-control"
                    min="0"
                    value="<?= htmlspecialchars($imovel['garagem'], ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Escolher Nova Imagem:</label>
                <div class="d-flex align-items-center gap-3">
                    <img
                        src="<?= $baseUrl ?>/<?= htmlspecialchars($imovel['imagem'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="Imagem do Imóvel"
                        class="img-thumbnail"
                        style="max-width: 150px; height: auto;">
                    <div class="flex-grow-1">
                        <input
                            type="file"
                            id="imagem"
                            name="imagem"
                            class="form-control"
                            accept="image/*">
                    </div>
                </div>
            </div>



            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    Atualizar Imóvel
                </button>
                <a href="index.php?acao=listar" class="btn btn-secondary">
                    Voltar à Lista
                </a>
            </div>
        </form>

        <script>
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })();
        </script>

    <?php else: ?>
        <div class="alert alert-warning">
            Imóvel não encontrado!
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>