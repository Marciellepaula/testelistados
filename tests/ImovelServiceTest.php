<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Services/ImovelService.php';
require_once __DIR__ . '/../Models/Imovel.php';
require_once __DIR__ . '/../Utils/ImageUploader.php';

class ImovelServiceTest extends TestCase
{
    private $imagePath;

    protected function setUp(): void
    {
        $this->imagePath = tempnam(sys_get_temp_dir(), 'test_img');
        file_put_contents($this->imagePath, 'conteudo fake de imagem');
    }

    public function testCadastrarComDadosValidosRetornaSucesso()
    {
        $postData = [
            'titulo' => 'Casa Nova',
            'descricao' => 'Linda casa com 3 quartos',
            'preco' => 350000,
            'endereco' => 'Rua das Flores, 123',
            'garagem' => 2
        ];

        $fileData = [
            'imagem' => [
                'name' => 'casa.jpg',
                'tmp_name' => $this->imagePath,
                'error' => UPLOAD_ERR_OK
            ]
        ];

        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('criar')->willReturn(true);

        $service = new ImovelService($mockImovel);

        $mockImovel->expects($this->once())->method('criar')
            ->with(
                $this->equalTo('Casa Nova'),
                $this->equalTo(350000.0),
                $this->equalTo('Linda casa com 3 quartos'),
                $this->equalTo('Rua das Flores, 123'),
                $this->equalTo(2),
                $this->stringContains('uploads/')
            )
            ->willReturn(true);

        $result =  $service->cadastrar($postData, $fileData);

        $this->assertTrue($result['success']);
        $this->assertEquals('Imóvel cadastrado com sucesso!', $result['message']);
    }

    public function testListar()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('obterTodos')->willReturn([
            ['id' => 1, 'titulo' => 'Casa 1'],
            ['id' => 2, 'titulo' => 'Casa 2'],
        ]);

        $service = new ImovelService($mockImovel);

        $result = $service->listar();

        $this->assertCount(2, $result);
        $this->assertEquals('Casa 1', $result[0]['titulo']);
    }

    public function testObterPorId()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('obterPorId')->willReturn(['id' => 1, 'titulo' => 'Casa 1']);

        $service = new ImovelService($mockImovel);

        $result = $service->obterPorId(1);

        $this->assertEquals('Casa 1', $result['titulo']);
        $this->assertEquals(1, $result['id']);
    }

    public function testEditar()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('obterPorId')->willReturn(['id' => 1, 'imagem' => 'old_image.jpg']);
        $mockImovel->method('atualizar')->willReturn(true);

        $mockValidator = $this->createMock(Validator::class);
        $mockValidator->method('sanitize')->willReturnCallback(fn($value) => $value);
        $mockValidator->method('validatePrice')->willReturnCallback(fn($value) => (float) $value);
        $mockValidator->method('validateGaragem')->willReturnCallback(fn($value) => (int) $value);

        $mockImageUploader = $this->createMock(ImageUploader::class);
        $mockImageUploader->method('upload')->willReturn('uploads/new_image.jpg');

        $service = new ImovelService($mockImovel);

        $data = [
            'titulo' => 'Casa Atualizada',
            'descricao' => 'Casa linda',
            'preco' => 500000,
            'endereco' => 'Rua do Sol, 45',
            'garagem' => 2
        ];
        $files = [
            'imagem' => [
                'name' => 'nova_imagem.jpg',
                'tmp_name' => $this->imagePath,
                'error' => UPLOAD_ERR_OK
            ]
        ];

        $result = $service->editar(1, $data, $files);

        $this->assertTrue($result['success']);
        $this->assertEquals('Imóvel atualizado com sucesso!', $result['message']);
    }

    public function testEditarComErro()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('obterPorId')->willReturn(['id' => 1, 'imagem' => 'old_image.jpg']);
        $mockImovel->method('atualizar')->willReturn(false);

        $service = new ImovelService($mockImovel);

        $data = [
            'titulo' => 'Casa Atualizada',
            'descricao' => 'Casa linda',
            'preco' => 500000,
            'endereco' => 'Rua do Sol, 45',
            'garagem' => 2
        ];
        $files = [
            'imagem' => [
                'error' => UPLOAD_ERR_NO_FILE
            ]
        ];

        $result = $service->editar(1, $data, $files);

        $this->assertFalse($result['success']);
        $this->assertEquals('Erro ao atualizar imóvel.', $result['message']);
    }


    public function testExcluir()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('deletar')->willReturn(true);

        $service = new ImovelService($mockImovel);

        $result = $service->excluir(1);

        $this->assertTrue($result['success']);
        $this->assertEquals('Imóvel excluído com sucesso!', $result['message']);
    }

    public function testExcluirComErro()
    {
        $mockImovel = $this->createMock(Imovel::class);
        $mockImovel->method('deletar')->willReturn(false);

        $service = new ImovelService($mockImovel);

        $result = $service->excluir(1);

        $this->assertFalse($result['success']);
        $this->assertEquals('Erro ao excluir imóvel.', $result['message']);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->imagePath)) {
            unlink($this->imagePath);
        }
    }
}
