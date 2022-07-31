<?php

namespace App\Contracts;

interface ImageHandleInterface
{
    public function upload($image,Array $image_data);
    public function destroy(Array $image_data);
    public function fetch(Array $image_data);
}