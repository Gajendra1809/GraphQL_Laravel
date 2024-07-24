<?php declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;

final class UpdateUserInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            "name" => ["min:3", "max:255"],
            "email"=> ["email",Rule::unique('users', 'email')->ignore($this->arg('id'), 'id'),],
            "password" => ["min:5"]
        ];
    }

    public function messages(): array
    {
        return [
            "name.min"=> "Minimum 3 characters for name",
            "email.email" => "Proper email format is required abc@gmail.com",
            "email.unique" => "Email already exists",
        ];
    }
}
