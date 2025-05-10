<?php 

namespace App\Services;

use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\BusinessSetting;

class ImagegetService {
    public static function getimagepaths() {
        $data = BusinessSetting::get();
        
        // Define allowed keys for company images
        $arrayOfCompaniesValue = [
            'company_web_logo',
            'company_mobile_logo',
            'company_footer_logo',
            'company_fav_icon',
            'loader_gif',
            'company_banner_logo',
            'boxiconimage_one',
            'boxiconimage_two',
            'boxiconimage_three',
            'boxiconimage_four'
        ];
        
        $result = [];
        
        // Filter the data to get only the necessary image paths
        foreach ($data as $item) {
            if (in_array($item->type, $arrayOfCompaniesValue)) {
                $result[$item->type] = $item->value;
            }
        }
        
        // Decode image paths if available
        return self::decodedpaths($result);
    }

    public static function decodedpaths($data) {
        $imagegetsd = [];
        
        foreach ($data as $key => $value) {
            // Decode the JSON data
            $decoded = json_decode($value, true);
            
            // Check if the decoded data contains necessary fields
            if ($decoded && isset($decoded['image_name'], $decoded['storage'])) {
                $imagegetsd[$key] = '/' . $decoded['storage'] . '/company/' . $decoded['image_name'];
            } else {
                $imagegetsd[$key] = null;
            }
        }
        
        return $imagegetsd;
    }
}
