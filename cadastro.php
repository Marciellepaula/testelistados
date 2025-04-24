<!-- cadastrar.php -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Imóvel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
        }

        button {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            color: white;
            background-color: rgb(235, 86, 17);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Cadastro de Imóvel</h1>

    <form method="POST" action="ImovelController.php?acao=cadastrar" enctype="multipart/form-data">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="preco">Preço (R$)</label>
        <input type="number" id="preco" name="preco" step="0.01">

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>

        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco">

        <label for="garagem">Garagem</label>
        <input type="number" id="garagem" name="garagem">
        <label for="imagem">Imagem</label>
        <input type="file" id="imagem" name="imagem" accept="image/*" required>



        <button type="submit">Salvar Imóvel</button>
    </form>

    <a class="back-link" href="index.php">← Voltar à lista de imóveis</a>
</body>

</html>