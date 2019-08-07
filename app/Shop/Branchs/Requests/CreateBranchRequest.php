<?php

namespace App\Shop\Branchs\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateBranchRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:brands']
        ];
    }
}
