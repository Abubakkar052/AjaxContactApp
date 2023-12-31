<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\network;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {    $request = $this;
         if(($request['id']))
        {
           if (network::where('id', $request['id'])->exists())
           {
           return true;
           }
           else
           { 
           return false;
           }
        }
        else 
        {
         return true;
        }     
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' =>'required|min:4|max:8',
            'code' => 'required|min:4|max:4',   
        ];
    }
    
     
     

}