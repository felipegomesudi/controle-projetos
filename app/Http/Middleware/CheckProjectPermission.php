<?php

namespace ControleProjetos\Http\Middleware;

use Closure;
use ControleProjetos\Services\ProjectServices;

class CheckProjectPermission
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

//        $projectId = $request->route('id');
        $projectId = $request->route('id') ? $request->route('id') : $request->route('project');

        if($this->service->checkProjectPermissions($projectId) == false){
            return ['error'=>'You not have permission to access project'];
        }

        return $next($request);
    }
}
