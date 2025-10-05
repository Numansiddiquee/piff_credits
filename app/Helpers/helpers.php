<?php

   if (!function_exists('setting')) {
       /**
        * Get a setting value by name.
        *
        * @param string $name
        * @param mixed $default
        * @return mixed
        */
       function setting($name, $default = null)
       {
           return App\Models\Setting::get($name, $default);
       }
   }