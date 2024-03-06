<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ProduitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'qte' => ['required', 'numeric'],
            'nom' => ['required', 'alpha'],
            // - ajout pour vérifier clé étrangère existe
            'user_id'   => ['required','exists:App\Models\User,id'],
        ];
    }
    /**
     * Cette fonction est appelée automatiquement si la validation échoue.
     *
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'    => 0,
            'message'   => $validator->errors()
        ]));
    }
}
