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
        if (isset($request->ArrQuery->Desc)) {
            if (isset($request->ArrQuery->param)) {
                $param = explode('.', $request->ArrQuery->param);
                if (count($param) > 1) {
                    $Model->orderByRaw(strtolower($param[0]) . ', ' . $param[1] . ' asc');
                }else{
                    $Model->orderBy(strtolower($request->ArrQuery->param), 'asc');
                }
            }else{
                $Model->orderBy('order_id', 'desc');
            }
        }
        if (isset($request->ArrQuery->orderDesc)) {
            if (isset($request->ArrQuery->param)) {
                $param = explode('.', $request->ArrQuery->param);
                if (count($param) > 1) {
                    $Model->orderByRaw(strtolower($param[0]) . ', ' . $param[1] . ' asc');
                }else{
                    $Model->orderBy(strtolower($request->ArrQuery->param), 'asc');
                }
            }else{
                $Model->orderBy('id', 'desc');
            }
        }
        if (isset($request->ArrQuery->orderAsc)) {
            if (isset($request->ArrQuery->param)) {
                $param = explode('.', $request->ArrQuery->param);
                if (count($param) > 1) {
                    $Model->orderByRaw(strtolower($param[0]) . ', ' . $param[1] . ' asc');
                }else{
                    $Model->orderBy(strtolower($request->ArrQuery->param), 'asc');
                }
            }else{
                $Model->orderBy('id', 'asc');
            }
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
