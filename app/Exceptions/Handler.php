<?php
namespace App\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
class Handler extends ExceptionHandler {
    public function render($request, $exception) {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(null, 404);
        }
        return parent::render($request, $exception);
    }
    protected $dontReport = [
            //
    ];
    protected $dontFlash  = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    public function register() {
        $this->reportable(function (Throwable $e) {
            
        });
    }
}