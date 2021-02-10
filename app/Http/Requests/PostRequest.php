<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //今回認証は無いのでtrue
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title' => 'required|max:50',
          'body' => 'required|max:2000',
          'thum'=>'image|mimes:jpeg,png,jpg,gif|max:1024',
        ];
    }
    
    public function messages()
    {
      return [
          "required" => "必須項目です。",
          "image" => "指定されたファイルが画像ではありません。",
          "mines" => "指定された拡張子（PNG/JPG/GIF）ではありません。",
          "max" => "１Ｍを超えています。",
      ];
    }
}
