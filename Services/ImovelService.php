<?php
require_once __DIR__ . '/../Models/Imovel.php';
require_once __DIR__ . '/../Utils/Validator.php';
require_once __DIR__ . '/../Utils/ImageUploader.php';

class ImovelService
{
    private $imovel;

    public function __construct($imovel = null)
    {

        $this->imovel = $imovel ?: $this->getImovelInstance();
    }

    public function getImovelInstance()
    {
        return new Imovel();
    }

    public function cadastrar($data, $files)
    {
        try {

            $titulo = Validator::sanitize($data['titulo']);
            $descricao = Validator::sanitize($data['descricao']);
            $preco = Validator::validatePrice($data['preco']);
            $endereco = Validator::sanitize($data['endereco']);
            $garagem = Validator::validateGaragem($data['garagem']);
            $caminhoImagem = ImageUploader::upload($files['imagem']);

            $created = $this->imovel->criar($titulo, $preco, $descricao, $endereco, $garagem, $caminhoImagem);

            return [
                'success' => $created,
                'message' => $created ? 'Imóvel cadastrado com sucesso!' : 'Erro ao cadastrar imóvel.'
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function listar()
    {
        return  $this->imovel->obterTodos();
    }

    public function obterPorId($id)
    {

        return  $this->imovel->obterPorId($id);
    }

    public function editar($id, $data, $files)
    {
        try {
            $imovelExistente = $this->imovel->obterPorId($id);

            $titulo = Validator::sanitize($data['titulo']);
            $preco = Validator::validatePrice($data['preco']);
            $descricao = Validator::sanitize($data['descricao']);
            $garagem = Validator::validateGaragem($data['garagem']);
            $endereco = Validator::sanitize($data['endereco']);

            $imagemAntiga = $imovelExistente['imagem'];

            if (isset($files['imagem']) && $files['imagem']['error'] == 0) {
                $caminhoImagem = ImageUploader::upload($files['imagem'], true, $imagemAntiga);
            } else {

                $caminhoImagem = $imagemAntiga;
            }

            $updated = $this->imovel->atualizar($id, $titulo, $preco, $descricao, $endereco, $garagem, $caminhoImagem);

            return [
                'success' => $updated,
                'message' => $updated ? 'Imóvel atualizado com sucesso!' : 'Erro ao atualizar imóvel.'
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function excluir($id)
    {

        $deleted =  $this->imovel->deletar($id);

        return [
            'success' => $deleted,
            'message' => $deleted ? 'Imóvel excluído com sucesso!' : 'Erro ao excluir imóvel.'
        ];
    }
}
