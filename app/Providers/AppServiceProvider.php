<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\ResponseFactory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    private function responseMacros()
    {
        Response::macro('success', function ($message, array $data = null, $httpCode = 200) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $httpCode);
        });
    
        Response::macro('error', function ($message, array $data = null, $httpCode = 400) {
    
            //validation error
            if ($httpCode == 422){
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => $data
                ], $httpCode);
    
            }
            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => $data
            ] ,$httpCode);
    
        });
    }
    
    
    public function register(): void
    {
        //
    }
    
    
    public function boot(): void
    {
        $this->responseMacros();
    }
}
