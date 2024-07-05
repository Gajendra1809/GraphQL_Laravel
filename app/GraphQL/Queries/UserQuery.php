<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;

final class UserQuery
{
    public function users(){

        return User::all();

    }

    public function user($root, array $args){

        return User::find($args['id']);
    
    }
}
