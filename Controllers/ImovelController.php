<?php
// ImovelController.php
require_once 'Models/Imovel.php';

class ImovelController
{

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
            $titulo = $this->sanitizeInput($_POST['titulo']);
            $descricao = $this->sanitizeInput($_POST['descricao']);
            $preco = $this->validatePrice($_POST['preco']);
            $endereco = $this->sanitizeInput($_POST['endereco']);
            $garagem = $this->validateGaragem($_POST['garagem']);

            $caminhoImagem = $this->handleImageUpload();

            $imovel = new Imovel();
            if ($imovel->criar($titulo, $preco, $descricao, $endereco, $garagem, $caminhoImagem)) {
                $_SESSION['success_message'] = "✅ Imóvel cadastrado com sucesso!";
                header("Location: /imoveis/listar");
                exit;
            } else {
                $_SESSION['error_message'] = "❌ Erro ao cadastrar imóvel. Tente novamente mais tarde.";
                header("Location: /imoveis/cadastrar");
                exit;
            }
        }
    }

    private function sanitizeInput($data)
    {
        return htmlspecialchars(trim($data));
    }

    private function validatePrice($price)
    {
        if (is_numeric($price) && $price > 0) {
            return $price;
        } else {
            $_SESSION['error_message'] = "❌ Preço inválido.";
            header("Location: /imoveis/cadastrar");
            exit;
        }
    }

    private function validateGaragem($garagem)
    {
        if (is_numeric($garagem) && $garagem >= 0) {
            return $garagem;
        } else {
            $_SESSION['error_message'] = "❌ Número de garagens inválido.";
            header("Location: /imoveis/cadastrar");
            exit;
        }
    }

    private function handleImageUpload()
    {
        if (isset($_FILES['imagem'])) {
            if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $imagemTmp = $_FILES['imagem']['tmp_name'];
                $nomeImagem = basename($_FILES['imagem']['name']);
                $destino = 'uploads/' . uniqid() . '-' . $nomeImagem;

                if (move_uploaded_file($imagemTmp, $destino)) {
                    return $destino;
                } else {
                    $_SESSION['error_message'] = "❌ Erro ao mover o arquivo de imagem. Tente novamente mais tarde.";
                    header("Location: /imoveis/cadastrar");
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "❌ Erro no envio da imagem: " . $_FILES['imagem']['error'];
                header("Location: /imoveis/cadastrar");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "❌ Campo 'imagem' não foi enviado.";
            header("Location: /imoveis/cadastrar");
            exit;
        }
    }




    public function listar()
    {
        $imovel = new Imovel();
        $imoveis = $imovel->obterTodos();

        foreach ($imoveis as $im) {
            echo "ID: " . $im['id'] . " - Nome: " . $im['titulo'] . " - Descrição: " . $im['descricao'] . "<br>";
        }
    }

    public function editar($id)
    {
        $imovel = new Imovel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'];
            $preco = $_POST['preco'];
            $descricao = $_POST['descricao'];
            $garagem = $_POST['garagem'];
            $endereco = $_POST['endereco'];

            if ($imovel->atualizar($id, $titulo, $preco,  $descricao, $endereco, $garagem)) {
                echo "Imóvel atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar imóvel.";
            }
        } else {
            $imovelData = $imovel->obterPorId($id);
            // Exibir os dados do imóvel no formulário para edição
        }
    }

    public function excluir($id)
    {
        $imovel = new Imovel();
        if ($imovel->deletar($id)) {
            echo "Imóvel excluído com sucesso!";
        } else {
            echo "Erro ao excluir imóvel.";
        }
    }
}
