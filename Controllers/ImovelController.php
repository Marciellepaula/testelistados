<?php
require_once __DIR__ . '/../Models/Imovel.php';
require_once __DIR__ . '/../Utils/Validator.php';
require_once __DIR__ . '/../Utils/ImageUploader.php';

class ImovelController
{
    public $imovel;

    public function __construct($imovel = null)
    {
        $this->imovel = $imovel ?: new Imovel();
    }

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/', 'Método inválido.', false);
        }

        try {
            $data = $this->sanitizeAndValidateData($_POST, $_FILES);
            $created = $this->imovel->criar(
                $data['titulo'],
                $data['preco'],
                $data['descricao'],
                $data['endereco'],
                $data['garagem'],
                $data['imagem']
            );

            if ($created) {
                $this->redirect('/', 'Imóvel cadastrado com sucesso!', true);
            } else {
                $this->redirect('/cadastrar', 'Erro ao cadastrar imóvel.', false);
            }
        } catch (Exception $e) {
            $this->redirect('/cadastrar', $e->getMessage(), false);
        }
    }

    public function listar()
    {
        $imoveis = $this->imovel->obterTodos();
        include '../View/index.php';
    }

    public function obterPorId($id)
    {
        $imovel = $this->imovel->obterPorId($id);
        include '../View/editar.php';
    }

    public function editar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/', 'Método inválido.', false);
        }

        try {
            $imovelExistente = $this->imovel->obterPorId($id);

            if (!$imovelExistente) {
                $this->redirect('/', 'Imóvel não encontrado.', false);
            }

            $data = $this->sanitizeAndValidateData($_POST, $_FILES, $imovelExistente['imagem']);
            $updated = $this->imovel->atualizar(
                $id,
                $data['titulo'],
                $data['preco'],
                $data['descricao'],
                $data['endereco'],
                $data['garagem'],
                $data['imagem']
            );

            if ($updated) {
                $this->redirect('/', 'Imóvel atualizado com sucesso!', true);
            } else {
                $this->redirect("/editar?id={$id}", 'Erro ao atualizar imóvel.', false);
            }
        } catch (Exception $e) {
            $this->redirect("/editar?id={$id}", $e->getMessage(), false);
        }
    }

    public function excluir($id)
    {
        try {
            $deleted = $this->imovel->deletar($id);

            if ($deleted) {
                $this->redirect('/', 'Imóvel excluído com sucesso!', true);
            } else {
                $this->redirect('/', 'Erro ao excluir imóvel.', false);
            }
        } catch (Exception $e) {
            $this->redirect('/', $e->getMessage(), false);
        }
    }


    private function sanitizeAndValidateData($postData, $fileData, $existingImagePath = null)
    {
        $titulo = Validator::sanitize($postData['titulo']);
        $descricao = Validator::sanitize($postData['descricao']);
        $preco = Validator::validatePrice($postData['preco']);
        $endereco = Validator::sanitize($postData['endereco']);
        $garagem = Validator::validateGaragem($postData['garagem']);

        if (isset($fileData['imagem']) && $fileData['imagem']['error'] == 0) {
            $imagem = ImageUploader::upload($fileData['imagem'], true, $existingImagePath);
        } else {
            $imagem = $existingImagePath;
        }


        return compact('titulo', 'descricao', 'preco', 'endereco', 'garagem', 'imagem');
    }

    private function redirect($url, $message, $success = true)
    {
        $_SESSION[$success ? 'success_message' : 'error_message'] = $message;

        header("Location: {$url}");
    }
}
