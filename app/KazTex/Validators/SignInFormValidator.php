<?php

namespace KazTex\Validators;


class SignInFormValidator extends FormValidator{
    protected $rules = [
        'email'=>'email|required',
        'password'=>'required'
        ];

    public function validate(array $formData) {
        $this->validation = $this->validator->make($formData, $this->getValidationRules());

        if ($this->validation->fails()) {
            throw new FormValidationException('Validation failed', $this->getValidationErrors());
        }
        if(!\Auth::attempt(['email'=>$formData['email'], 'password'=>$formData['password']])){
            $messageBag = new \Illuminate\Support\MessageBag;
            $messageBag->add('password', 'E-mail and Password do not match.');
            throw new FormValidationException('Validation failed', $messageBag);
        }
        return true;
    }
}
