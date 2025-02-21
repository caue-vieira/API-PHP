<?php
namespace App\Validators;

use App\Errors\EmptyFieldException;
use App\Errors\InvalidDataException;
use App\Models\Usuario;

class Validator {
    public static function validateUser(Usuario $usuario): void {
        GenericValidator::validateNotEmpty($usuario->getNome(), "O nome é obrigatório");
        GenericValidator::validateNotEmpty($usuario->getEmail(), "O email é obrigatório");
        GenericValidator::validateNotEmpty($usuario->getTrilha(), "A trilha é obrigatória");
        GenericValidator::validateEmail($usuario->getEmail());
    }
}