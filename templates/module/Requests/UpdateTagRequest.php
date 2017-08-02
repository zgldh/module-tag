<?php

namespace WoXuanWang\Tag\Requests;

use Illuminate\Foundation\Http\FormRequest;
use WoXuanWang\Tag\Models\Tag;
use zgldh\Scaffold\Traits\HasWithParameter;

class UpdateTagRequest extends FormRequest
{
    use HasWithParameter;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Tag::$rules;
    }
}
