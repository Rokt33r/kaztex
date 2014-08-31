<?php

namespace KazTex\Validators;


class SignUpFormValidator extends FormValidator{
    protected $rules = [
        'email'=>'email|required',
        'password'=>'required',
        'repassword'=>'required',
        'name'=>'required'
        ];

    public function validate(array $formData) {
        $this->validation = $this->validator->make($formData, $this->getValidationRules());

        if ($this->validation->fails()) {
            throw new FormValidationException('Validation failed', $this->getValidationErrors());
        }
        if ($formData['password'] !== $formData['repassword']){
            $messageBag = new \Illuminate\Support\MessageBag;
            $messageBag->add('repassword', 'Password(Double Chk) isn\'t equal to Password');
            throw new FormValidationException('Validation failed', $messageBag);
        }
        return true;
    }
}
