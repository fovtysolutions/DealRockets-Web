<?php

namespace App\Utils;

use App\Models\Country;

class RolesAccess{
    /**
     * Check if the user has access to a specific module and permission.
     *
     * @param string $mod_name The name of the module.
     * @param string $continent The continent associated with the module.
     * @param string $permission The permission to check (e.g., 'read', 'create', 'edit', 'delete').
     * @return bool True if the user has access, false otherwise.
     */
    public static function checkEmployeeAccess($mod_name, $continent, $permission)
    {
        $user_role = auth('admin')->user()->role;

        $module_access = $user_role->module_access;
        $mod_access_decoded = json_decode($module_access, true);

        if (auth('admin')->user()->admin_role_id == 1) {
            return true;
        }

        if($continent == 'any'){
            foreach ($mod_access_decoded as $continent_key => $mod_data) {
                if (isset($mod_data[$mod_name])) {
                    $permissions = $mod_data[$mod_name];

                    if (isset($permissions[$permission]) && $permissions[$permission] === 'yes') {
                        return true;
                    }
                }
            }
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

    public static function AccessibleCountries($mod_name){
        $user_role = auth('admin')->user()->role;
        $module_access = $user_role->module_access;
        $mod_access_decoded = json_decode($module_access, true);

        if (auth('admin')->user()->admin_role_id == 1) {
            return ['all']; // Admin has access to all countries
        }

        $accessible_countries = [];

        // Handle Global Case
        if (isset($mod_access_decoded['Global']) && is_array($mod_access_decoded['Global'])) {
            foreach ($mod_access_decoded['Global'] as $continent => $modules) {
                if (isset($modules[$mod_name])) {
                    foreach ($modules[$mod_name] as $permission => $access) {
                        if (isset($access) && $permission === 'read' && $access === 'yes') {
                            $accessible_countries[] = self::getCountriesFromRegion('Global');
                            break; // No need to check further permissions for this continent
                        }
                    }
                }
            }
        }

        // Handle Normal Continents Case
        if (isset($mod_access_decoded) && is_array($mod_access_decoded)) {
            foreach ($mod_access_decoded as $continent => $modules) {
                if (isset($modules[$mod_name])) {
                    foreach ($modules[$mod_name] as $permission => $access) {
                        if (isset($access) && $permission === 'read' && $access === 'yes') {
                            $accessible_countries = array_merge($accessible_countries,self::getCountriesFromRegion($continent));
                            break; // No need to check further permissions for this continent
                        }
                    }
                }
            }
        }
        return $accessible_countries;
    }

    public static function getCountriesFromRegion($continent){
        if ($continent == 'Global'){
            $countries = Country::pluck('id')->toArray();
            return $countries;
        } else {
            $countries = Country::where('region',$continent)->pluck('id')->toArray();
            return $countries;
        }
    }
}