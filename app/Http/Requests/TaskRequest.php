<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->getMethod() == 'POST')
        {
            return $this->createRules();
        } elseif ($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH')
        {
            return $this->updateRules();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function createRules()
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required'],
            'due_at' => ['required' , 'date'],
            'parent_id' => ['sometimes', 'nullable', 'exists:tasks,id']
        ];
    }

    public function updateRules()
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'min:3', 'max:255'],
            'description' => ['sometimes', 'required'],
            'due_at' => ['sometimes', 'required' , 'date'],
            'parent_id' => ['sometimes', 'nullable', 'exists:tasks,id']
        ];
    }
}
