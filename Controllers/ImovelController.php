<?php
require_once __DIR__ . '/../Services/ImovelService.php';



class ImovelController
{
    public $imovelService;

    public function __construct()
    {
        $this->imovelService = new ImovelService();
    }

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['acao']) && $_GET['acao'] === 'cadastrar') {
            $result = $this->imovelService->cadastrar($_POST, $_FILES);

            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
                header("Location: /index");
            } else {
                $_SESSION['error_message'] = $result['message'];
                header("Location: /cadastrar");
            }
            exit;
        }
    }

    public function listar()
    {
        return $this->imovelService->listar();
    }

    public function obterPorId($id)
    {
        return $this->imovelService->obterPorId($id);
    }

    public function editar($id)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->imovelService->editar($id, $_POST, $_FILES);
            if ($result['success']) {
                $_SESSION['success_message'] = $result['message'];
                header("Location: /index");
            } else {
                $_SESSION['error_message'] = $result['message'];
                header("Location: /editar?id={$id}");
            }
            exit;
        } else {
            return $this->imovelService->obterPorId($id);
        }
    }

    public function excluir($id)
    {
        $result = $this->imovelService->excluir($id);
        $_SESSION[$result['success'] ? 'success_message' : 'error_message'] = $result['message'];
        header("Location: /index");
        exit;
    }
}
