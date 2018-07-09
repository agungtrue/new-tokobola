<?php

namespace App\Traits;
use Closure;

trait Browse
{
    public function Browse($request, $Model, $function = null)
    {
        if (isset($request->ArrQuery->take)) {
            $request->ArrQuery->take = (int) $request->ArrQuery->take;
        }
        if (isset($request->ArrQuery->skip)) {
            $request->ArrQuery->skip = (int) $request->ArrQuery->skip;
        }

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

        $Array['total'] = (int) $ModelForCount->count();
        if ((isset($request->ArrQuery->set)) && $request->ArrQuery->set === 'first') {
            $Array['show'] = (int) isset($data[0]) ? 1 : 0;
            $Array['records'] = isset($data[0]) ? $data[0] : (object)[];
        } else {
            $Array['show'] = (int) $data->count();
            $Array['records'] = $data;
        }
        return $Array;
    }
}
