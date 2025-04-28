<?php
include('header.php');
?>

<body>

    <div class="container mt-5">
        <h5 class="mb-4 text-secondary">Cadastro de Imóvel</h5>
        <form method="POST" action="/imovel" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="preco" class="form-label">Preço (R$)</label>
                <input type="number" id="preco" name="preco" class="form-control" step="0.01">
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" id="endereco" name="endereco" class="form-control">
            </div>

            <div class="mb-3">
                <label for="garagem" class="form-label">Garagem</label>
                <input type="number" id="garagem" name="garagem" class="form-control">
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Imóvel</button>
        </form>

        <a class="btn btn-secondary mt-3" href="index.php">← Voltar à lista de imóveis</a>
    </div>



</body>

<?php include('footer.php'); ?>