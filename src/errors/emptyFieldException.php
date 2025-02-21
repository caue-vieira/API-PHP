<?php
namespace App\Errors;

use Exception;
use Throwable;

class EmptyFieldException extends Exception {
    public function __construct(string $message = "", int $code = 400, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}