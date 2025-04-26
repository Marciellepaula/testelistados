<?php

use PHPUnit\Framework\TestCase;

require_once 'Services/ImovelService.php';
require_once 'Models/Imovel.php';
require_once 'Utils/Validator.php';
require_once 'Utils/ImageUploader.php';

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

    protected function tearDown(): void
    {
        if (file_exists($this->imagePath)) {
            unlink($this->imagePath);
        }
    }
}
