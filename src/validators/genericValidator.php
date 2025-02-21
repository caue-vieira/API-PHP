<?php
namespace App\Validators;

use App\Errors\EmptyFieldException;
use App\Errors\InvalidDataException;

class GenericValidator {
    public static function validateNotEmpty(string $value, string $errorMessage): void {
        if(empty($value)) {
            throw new EmptyFieldException($errorMessage);
        }
    }

    public static function validateEmail(string $email): void {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidDataException("O email precisa ser válido");
        }
    }
}