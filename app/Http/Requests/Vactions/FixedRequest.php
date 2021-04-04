<?php

namespace App\Http\Requests\Vactions;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FixedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole(Role::DIRECTOR);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fixed' => ['required', 'boolean']
        ];
    }
}
