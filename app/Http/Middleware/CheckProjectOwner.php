<?php

namespace ControleProjetos\Http\Middleware;

use Closure;
use ControleProjetos\Services\ProjectServices;

class CheckProjectOwner
{

    private $service;

    public function __construct(ProjectServices $service)
    {
        $this->service = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $projectId = $request->route('id') ? $request->route('id') : $request->route('project');

        if($this->service->checkProjectOwner($projectId) == false){
            return ['error'=>'Access Forbidden'];
        }

        return $next($request);
    }
}
