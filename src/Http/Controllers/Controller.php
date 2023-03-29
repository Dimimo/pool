<?php

namespace Dimimo\Pool\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Session;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, GetCycles;

    /**
     * The current cycle (f.ex. 2023/03)
     */
    public ?string $cycle;

    /**
     * A public bool to determine if somebody has editor access, can be accessed in the view
     */
    public bool $hasAccess = false;

    /**
     * The user id's that have editor access
     * Names represent Dimitri, Richard and James
     */
    protected array $userIds = [1, 9, 1053];

    /**
     * CycleController constructor.
     */
    public function __construct()
    {
        $this->middleware('PoolCycle');
        $this->middleware(function (Request $request, $next) {
            if (Auth::check()) {
                $id = Auth::id();
                if (in_array($id, $this->userIds)) {
                    $this->hasAccess = true;
                }
            }
            $this->cycle = Session::get('cycle');
            View::share('cycle', $this->cycle);
            View::share('cycles', $this->getCycles());
            View::share('hasAccess', $this->hasAccess);

            return $next($request);
        });
    }
}
