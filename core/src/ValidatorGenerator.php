<?php

namespace MeteorCqrs\Meteor\src;

use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

trait ValidatorGenerator
{
    use ClassNameRule, CreateValidatorFile, ProvidesConvenienceMethods;

    private function Validator($classpath, $data = null)
    {

        $parsedPath = (string) get_class($classpath);

        $validator = $this->ClassName($parsedPath);

        if (class_exists($validator)) {

            $class = new $validator;

            return $this->validate($data,$class->Validations(),$class->Messages());

        } else {

            if (app()->environment('local')) {
                return $this->CreateValidatorFile($validator, $parsedPath);
            } else {
                return "You can create files only on Local";
            }

        }
    }
}
