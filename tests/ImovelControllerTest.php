<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Controllers/ImovelController.php';
require_once __DIR__ . '/../Models/Imovel.php';
require_once __DIR__ . '/../Utils/Validator.php';
require_once __DIR__ . '/../Utils/ImageUploader.php';

class ImovelControllerTest extends TestCase
{
    private $testFilePath;
    public $imovelController;
    public $mockImovel;

    protected function setUp(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        $_POST = [];
        $_FILES = [];
        $_SERVER = [];

        $this->mockImovel = $this->createMock(Imovel::class);
        $this->imovelController = new ImovelController($this->mockImovel);

        $this->testFilePath = __DIR__ . '/test_image.jpg';
        file_put_contents($this->testFilePath, 'dummy image content');
    }

    public function testCadastrarSuccess()
    {
        $_FILES['imagem'] = [
            'name' => 'imagem.jpg',
            'tmp_name' => $this->testFilePath,
            'error' => UPLOAD_ERR_OK
        ];

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'titulo' => 'Casa Nova',
            'preco' => 350000.0,
            'descricao' => 'Linda casa com 3 quartos',
            'endereco' => 'Rua das Flores, 123',
            'garagem' => 2,
        ];

        $this->mockImovel->expects($this->once())
            ->method('criar')
            ->with(
                $this->equalTo('Casa Nova'),
                $this->equalTo(350000.0),
                $this->equalTo('Linda casa com 3 quartos'),
                $this->equalTo('Rua das Flores, 123'),
                $this->equalTo(2),
                $this->stringContains('public/uploads/')
            )
            ->willReturn(1);

        $this->imovelController->cadastrar();

        $this->assertEquals('Imóvel cadastrado com sucesso!', $_SESSION['success_message']);
    }

    public function testCadastrarFailure()
    {
        $_FILES['imagem'] = [
            'name' => 'image.jpg',
            'tmp_name' => $this->testFilePath,
            'error' => UPLOAD_ERR_OK
        ];

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'titulo' => 'Apartamento',
            'preco' => 250000,
            'descricao' => 'A nice apartment.',
            'endereco' => 'Rua A, 123',
            'garagem' => 2,
        ];

        $this->mockImovel->expects($this->once())
            ->method('criar')
            ->willReturn(false);

        $this->imovelController->cadastrar();

        $this->assertSessionMessage('Erro ao cadastrar imóvel.', false);
    }

    public function testExcluirSuccess()
    {
        $this->mockImovel->expects($this->once())
            ->method('deletar')
            ->with(1)
            ->willReturn(true);

        $this->imovelController->excluir(1);

        $this->assertSessionMessage('Imóvel excluído com sucesso!', true);
    }

    public function testExcluirFailure()
    {
        $this->mockImovel->expects($this->once())
            ->method('deletar')
            ->with(1)
            ->willReturn(false);

        $this->imovelController->excluir(1);

        $this->assertSessionMessage('Erro ao excluir imóvel.', false);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    private function assertSessionMessage($expectedMessage, $success)
    {
        $messageKey = $success ? 'success_message' : 'error_message';
        $this->assertEquals($expectedMessage, $_SESSION[$messageKey]);
    }
}
