<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update user request",
 *      description="Update user request body data",
 * )
 */
class UserUpdateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="first_name"
     * )
     *
     * @var string
     */
    public $first_name;

    /**
     * @OA\Property(
     *      title="last_name"
     * )
     *
     * @var string
     */
    public $last_name;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('edit', 'users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'nullable',
            'role_id' => 'nullable',
        ];
    }
}
