<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Services/ImovelService.php';
require_once __DIR__ . '/../Controllers/ImovelController.php';

class ImovelControllerTest extends TestCase
{
    public function testCadastrarFail()
    {
        $mockService = $this->createMock(ImovelService::class);
        $mockService->method('cadastrar')->willReturn(['success' => false, 'message' => 'Falha ao cadastrar imóvel.']);
        $controller = new ImovelController($mockService);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_GET['acao'] = 'cadastrar';

        $_POST = [
            'titulo' => 'Casa Nova',
            'preco' => 350000.0,
            'descricao' => 'Linda casa com 3 quartos',
            'endereco' => 'Rua das Flores, 123',
            'garagem' => 2
        ];
        $_FILES['imagem'] = [
            'name' => 'test_image.jpg',
            'tmp_name' => '/path/to/test_image.jpg',
            'error' => 0,
            'size' => 12345
        ];

        $imagem = 'path/to/test_image.jpg';

        ob_start();
        $controller->cadastrar($_POST, $_FILES);
        $output = ob_get_clean();

        $this->assertEquals('Falha ao cadastrar imóvel.', $_SESSION['error_message']);
        $this->assertEquals('Location: /cadastrar', $this->getHeaders()[0]);
    }

    public function testEditarPost()
    {
        $mockService = $this->createMock(ImovelService::class);
        $mockService->method('editar')->willReturn(['success' => true, 'message' => 'Imóvel atualizado com sucesso.']);
        $controller = new ImovelController($mockService);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_GET['acao'] = 'editar';
        $_GET['id'] = 1;
        $_POST = ['name' => 'Imóvel Editado', 'price' => 150000];

        ob_start();
        $controller->editar(1);
        $output = ob_get_clean();

        $this->assertEquals('Imóvel atualizado com sucesso.', $_SESSION['success_message']);
        $this->assertEquals('Location: /index', $this->getHeaders()[0]);
    }

    public function testExcluir()
    {
        $mockService = $this->createMock(ImovelService::class);
        $mockService->method('excluir')->willReturn(['success' => true, 'message' => 'Imóvel excluído com sucesso.']);
        $controller = new ImovelController($mockService);

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET['acao'] = 'excluir';
        $_GET['id'] = 1;

        ob_start();
        $controller->excluir(1);
        $output = ob_get_clean();

        $this->assertEquals('Imóvel excluído com sucesso.', $_SESSION['success_message']);
        $this->assertEquals('Location: /index', $this->getHeaders()[0]);
    }
    private function getHeaders()
    {
        return headers_list();
    }
}
