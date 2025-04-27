<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Utils/ImageUploader.php';

class ImageUploaderTest extends TestCase
{
    private $testFilePath;

    protected function setUp(): void
    {
        $this->testFilePath = tempnam(sys_get_temp_dir(), 'test_img');
        file_put_contents($this->testFilePath, 'fake image content');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function testUploadComImagemValidaRetornaCaminho()
    {
        $imageFile = [
            'name' => 'imagem.jpg',
            'tmp_name' => $this->testFilePath,
            'error' => UPLOAD_ERR_OK
        ];

        $result = ImageUploader::upload($imageFile);

        $this->assertFileExists(__DIR__ . '/../' . $result);

        unlink(__DIR__ . '/../' . $result);
    }

    public function testUploadComErroLancaExcecao()
    {
        $imageFile = [
            'name' => 'imagem.jpg',
            'tmp_name' => $this->testFilePath,
            'error' => UPLOAD_ERR_NO_FILE
        ];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Erro no envio da imagem");

        ImageUploader::upload($imageFile);
    }

    public function testUploadModoAtualizacaoMantemImagemExistente()
    {
        $imageFile = [
            'error' => UPLOAD_ERR_NO_FILE
        ];

        $existing = '/public/uploads/existente.jpg';

        $result = ImageUploader::upload($imageFile, true, $existing);

        $this->assertEquals($existing, $result);
    }

    public function testUploadInvalidoSemImagemLancaExcecao()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Erro no envio da imagem");

        ImageUploader::upload(null);
    }
}
