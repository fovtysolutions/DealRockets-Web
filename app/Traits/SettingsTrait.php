<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

trait SettingsTrait
{
    use StorageTrait;
    public function setEnvironmentValue($envKey, $envValue): mixed
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (is_bool(env($envKey))) {
            $oldValue = var_export(env($envKey), true);
        } else {
            $oldValue = env($envKey);
        }

        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }

    public function getSettings($object, $type)
    {
        $config = null;
        foreach ($object as $setting) {
            if ($setting['type'] == $type) {
                $config = $this->storageDataProcessing($type, $setting);
            }
        }
        return $config;
    }
    private function storageDataProcessing($name, $value)
    {
        $arrayOfCompaniesValue = [
            'company_web_logo',
            'company_mobile_logo',
            'company_footer_logo',
            'company_fav_icon',
            'loader_gif',
            'company_banner_logo',
            'company_banner_logo1',
            'company_banner_logo2',
            'company_banner_logo3',
            'company_banner_logo4',
            'company_banner_logo5',
            'company_banner_logo6',
            'company_banner_logo7',
            'company_banner_logo8',
            'company_banner_logo9',
            'boxiconimage_one',
            'boxiconimage_two',
            'boxiconimage_three',
            'boxiconimage_four'
        ];
        if (in_array($name, $arrayOfCompaniesValue)) {
            $imageData = json_decode($value->value, true) ?? ['image_name' => $value['value'], 'storage' => 'public'];
            $value['value'] = $this->storageLink('company', $imageData['image_name'], $imageData['storage']);
        }
        return $value;
    }
}
