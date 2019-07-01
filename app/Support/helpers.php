<?php

if (! function_exists('message')) {
    function message($id = null, $replace = [], $locale = null, $autoCapitalize = true) {
        if (is_null($id)) {
            return app('translator');
        }
        foreach ($replace as $key => $value) {
            if ($key === 'attribute') {
                $replace[$key] = app('translator')->trans('validation.attributes.'.$value, [], $locale);
            }
        }
        $message = app('translator')->trans($id, $replace, $locale);
        if ($autoCapitalize) {
            return ucfirst($message);
        }
        return $message;
    }
}

if (! function_exists('message_choice')) {
    function message_choice($id, $number, array $replace = [], $locale = null)
    {
        return app('translator')->transChoice($id, $number, $replace, $locale);
    }
}

if( ! function_exists('public_path'))
{
        /**
        * Return the path to public dir
        * @param null $path
        * @return string
        */
        function public_path($path=null)
        {
                return rtrim(app()->basePath('public/'.$path), '/');
        }
}
