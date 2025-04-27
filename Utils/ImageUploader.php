<?php

class ImageUploader
{
    public static function upload($imageFile, $isUpdate = false, $existingImage = null)
    {
        if (isset($imageFile) && $imageFile['error'] === UPLOAD_ERR_OK) {
            $tmpName = $imageFile['tmp_name'];
            $originalName = basename($imageFile['name']);
            $fileName = uniqid() . '-' . $originalName;
            $relativePath = '/public/uploads/' . $fileName;
            $absolutePath = __DIR__ . '/../' . $relativePath;

            if (!is_dir(__DIR__ . '/../public/uploads')) {
                mkdir(__DIR__ . '/../public/uploads', 0777, true);
            }

            $moved = php_sapi_name() === 'cli'
                ? rename($tmpName, $absolutePath)
                : move_uploaded_file($tmpName, $absolutePath);

            if ($moved) {
                return $relativePath;
            } else {
                throw new Exception("Erro ao mover o arquivo de imagem.");
            }
        }

        if ($isUpdate && $existingImage) {
            return $existingImage;
        }

        throw new Exception("Erro no envio da imagem.");
    }
}
