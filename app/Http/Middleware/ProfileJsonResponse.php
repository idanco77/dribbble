<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Arr;

class ProfileJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // check if debugbar is enanled

        if(! app()->bound('debugbar') || ! app('debugbar')->isEnabled() ) {
            return $response;
        }

        // profile the json response

        if($response instanceof JsonResponse && $request->has('_debug')){

            $response->setData(array_merge([
                    '_debug' => Arr::only(app('debugbar')->getData(), 'queries')
                ],
                $response->getData(true)
                ));
        }

        return $response;
    }
}
