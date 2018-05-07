<?php

namespace App\Traits;
use Closure;

trait Browse
{
    public function Browse($request, $Model, $function = null)
    {
        $Array = [
            'query' => $request->ArrQuery
        ];
        $ModelForCount = clone $Model;
        if (!$request->ArrQuery->takeAll) {
          $Model->take($request->ArrQuery->take)->skip($request->ArrQuery->skip);
        }
        if (config('app.debug')) {
            $ModelForSQL = clone $Model;
            $Array['debug'] = [
                'sql' => $ModelForSQL->toSql()
            ];
        }
        $data = $Model->get();

        if ($function instanceof Closure) {
            $data = call_user_func_array($function, [ $data ]);
        }

        $Array['total'] = $ModelForCount->count();
        if ((isset($request->ArrQuery->set)) && $request->ArrQuery->set === 'first') {
            $Array['show'] = isset($data[0]) ? 1 : 0;
            $Array['records'] = isset($data[0]) ? $data[0] : (object)[];
        } else {
            $Array['show'] = $data->count();
            $Array['records'] = $data;
        }
        return $Array;
    }
}
