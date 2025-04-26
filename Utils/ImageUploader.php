<?php

class ImageUploader
{
    public static function upload($imageFile, $isUpdate = false, $existingImage = null)
    {
        if (isset($imageFile) && $imageFile['error'] === UPLOAD_ERR_OK) {
            $tmpName = $imageFile['tmp_name'];
            $originalName = basename($imageFile['name']);
            $path = 'uploads/' . uniqid() . '-' . $originalName;

            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }


            $moved = php_sapi_name() === 'cli'
                ? rename($tmpName, $path)
                : move_uploaded_file($tmpName, $path);

            if ($moved) {

                return $path;
            } else {
                throw new Exception(" Erro ao mover o arquivo de imagem.");
            }
        }

        if ($isUpdate && $existingImage) {
            return $existingImage;
        }

        throw new Exception(" Erro no envio da imagem.");
    }
}
