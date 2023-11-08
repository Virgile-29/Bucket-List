<?php

namespace App\Entity\EntityListener;
use App\Entity\Wish;

class WishListener {
    public function __construct(private string $dir) {

    }

    public function preRemove(Wish $wish) {
        if($wish->getImage() && file_exists($this->dir.$wish->getImage())) {
            unlink($this->dir.$wish->getImage());
        }
    }

}