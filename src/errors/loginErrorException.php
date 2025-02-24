<?php
namespace App\Errors;

use Exception;
use Throwable;

class LoginErrorException extends Exception {
    public function __construct(string $message, int $code = 401, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}