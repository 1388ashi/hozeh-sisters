<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Validation\UnauthorizedException;
use Nette\Schema\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()){
            if($e instanceof ModelNotFoundException){
                return response()->error('مورد خواسته شده یافت نشد' , ['message'=>$e->getMessage()],404);
            }
            if ($e instanceof ValidationException){
                return response()->error('validation errors:', $e->errors(), 422);
            }
            if ($e instanceof ThrottleRequestsException){
                return response()->error('درخواستهای شما بیشتر از حد مجاز است',[$e->getMessage()],421);
            }
            if ($e instanceof UnauthorizedException){
                return response()->error('شما مجوز لازم را ندارید',[$e->getMessage()],401);
            }
            if ($e instanceof PermissionDoesNotExist){
                return response()->error('مجوز پیدا نشد',[$e->getmessage()],403);
            }
        }
        return parent::render($request, $e);
    }
}
