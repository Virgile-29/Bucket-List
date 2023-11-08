<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploaderFile {

    public function __construct(private readonly SluggerInterface $slugger) {

    }

    /**
     * @param UploadedFile $file
     * @param string $directory
     * @param string $name
     * @param string|null $oldFileName
     * @return string
     */
    public function upload(UploadedFile $file, string $directory, string $name,string $oldFileName = null): string {
        $newFileName = $this->slugger->slug($name).'_'.uniqid().'.'.$file->guessExtension();
        $file->move($directory, $newFileName);
        if($oldFileName && file_exists($directory.'/'.$oldFileName)) {
            unlink($directory, $oldFileName);
        }
        return $newFileName;
    }
}