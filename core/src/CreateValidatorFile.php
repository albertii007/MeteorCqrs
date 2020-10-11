<?php

namespace MeteorCqrs\Meteor\src;

trait CreateValidatorFile
{
    private function CreateValidatorFile($validator, $parsedPath)
    {
        $validatorClass = class_basename($validator);

        $namespace = implode('\\', explode('\\', $parsedPath, -1));

        $validatorParsedPath = $this->validatorpath($validator);

        $this->writeValidatorFile($validatorParsedPath, $namespace, $validatorClass);

        dd($validatorClass . ' must be implemented!');
    }

    private function validatorpath($validator)
    {
        $validatorpath = str_replace('\\', DIRECTORY_SEPARATOR, lcfirst($validator . '.php'));

        return __DIR__ . '/../../../../../' . $validatorpath;

    }

    private function writeValidatorFile($validatorpath, $namespace, $validatorClass)
    {
        $handle = fopen($validatorpath, 'a+') or die('Cannot open file: ' . $validatorpath);

        $content = file_get_contents(__DIR__ . '/../view/Validator.php', false);
        $newContent = str_replace('//', '', $content);
        $newContent = str_replace('##namespace', 'namespace ' . $namespace . ';', $newContent);
        $newContent = str_replace('##ClassName', $validatorClass, $newContent);
        $newContent = str_replace('##dd', 'dd("' . $validatorClass . ' must be implemented!");', $newContent);

        fwrite($handle, $newContent);

        fclose($handle);
    }
}
