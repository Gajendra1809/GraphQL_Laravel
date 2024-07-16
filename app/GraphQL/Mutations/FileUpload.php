<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

final class FileUpload
{

    public function uploadFile($root, array $args)
    {
        $image = $args['file'];
        return $image->store('images', 'public');
    }
}
