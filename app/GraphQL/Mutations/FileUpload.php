<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

final class FileUpload
{

    public function uploadFile($root, array $args)
    {
        $image = $args['file'];
        $uploadedFileUrl = cloudinary()->upload($image->getRealPath())->getSecurePath();
        return $uploadedFileUrl;
        
    }
}
