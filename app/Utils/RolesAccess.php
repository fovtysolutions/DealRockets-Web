<?php

namespace App\Utils;

class RolesAccess{
    public static function checkEmployeeAccess($mod_name, $continent, $permission)
    {
        $user_role = auth('admin')->user()->role;

        $module_access = $user_role->module_access;
        $mod_access_decoded = json_decode($module_access, true);

        if (auth('admin')->user()->admin_role_id == 1) {
            return true;
        }

        if (isset($mod_access_decoded) && is_array($mod_access_decoded)) {
            if (isset($mod_access_decoded[$continent])) {
                $mod_data = $mod_access_decoded[$continent];

                if (isset($mod_data[$mod_name])) {
                    $permissions = $mod_data[$mod_name];

                    if (isset($permissions[$permission]) && $permissions[$permission] === 'yes') {
                        return true;
                    }
                }
            }
        }

        return false; // Access denied
    }
}