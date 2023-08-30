<?php

namespace Source\Support;

/**
 * RequestFiles Source\Support
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Support
 */
class RequestFiles
{
    /** @var array Armazena a variavel global $_FILES */
    protected $files;

    /**
     * RequestFiles constructor
     */
    public function __construct()
    {
        $this->files = $_FILES;
    }

    public function uploadFile(string $path, string $key)
    {
        $fileName = basename($this->files[$key]["name"]);
        $realPath = $path . "/" . $fileName;
        $type = exif_imagetype($this->files[$key]["tmp_name"]);

        if ($type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

            $maxSize = 5 * 1024 * 1024; // Tamanho máximo de 5 MB

            if ($this->files[$key]["size"] > $maxSize) {
                throw new \Exception("Largura e altura da imagem inválida");
            }

            if (!move_uploaded_file($this->files[$key]["tmp_name"], $realPath)) {
                throw new \Exception("Erro desconhecido ao subir o arquivo.");
            }
        } else {
            throw new \Exception("Tipo de imagem inválida");
        }
    }

    public function getFile($key)
    {
        if (isset($this->files[$key])) {
            return $this->files[$key];
        } else {
            throw new \Exception('Arquivo ' . $key . ' não encontrado');
        }
    }

    public function getAllFiles()
    {
        return $this->files;
    }
}
