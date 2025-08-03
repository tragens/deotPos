<?php

use App\Libraries\MyCoredata;

if (!function_exists('has_permission')) {
    function has_permission(string $permissionName): bool
    {
        // Create an instance of your CustomHelper library
        $perm = new MyCoredata();

        // Call the permissions method
        return $perm->permissions($permissionName);
    }
}
