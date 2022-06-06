<?php 

declare(strict_types=1);

namespace App\Http\Handlers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use BadMethodCallException;

class Handler extends BaseController {
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function callAction($method, $parameters)
    {
        if ($method === '__invoke') {
            return call_user_func_array([$this, $method], $parameters);
        }

        throw new BadMethodCallException('Only __invoke method can be called on handler.');
    }
}
