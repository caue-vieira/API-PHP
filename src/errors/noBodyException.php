<?php
namespace App\Errors;

use Exception;
use Throwable;

class NoBodyException extends Exception {
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}