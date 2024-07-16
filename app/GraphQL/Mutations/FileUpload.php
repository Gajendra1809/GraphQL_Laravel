<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

final class FileUpload
{
    
    /**
     * Uploads a file to Cloudinary and returns the secure URL.
     *
     * @param mixed $root The root object.
     * @param array $args The arguments.
     * @return string The secure URL of the uploaded file.
     */
    public function uploadFile($root, array $args)
    {
        $image = $args['file'];
        $uploadedFileUrl = cloudinary()->upload($image->getRealPath())->getSecurePath();
        return $uploadedFileUrl;
        
    }
}
