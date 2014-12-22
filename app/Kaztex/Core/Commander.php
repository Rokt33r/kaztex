<?php namespace Kaztex\Core;

use App, Validator, Input;

trait CommanderTrait {

    public function execute($commandClass, array $overrides = []){
        $command = App::make($commandClass);

        $rules = $command->rules;
        if(empty($overrides)){
            $input = Input::all();
        }else{
            $input = $overrides;
        }

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            throw new InvalidInputException('Validation failed', $validator->errors());
        }

        $result = $command->handle($input);

        return $result;
    }
}