<?php 

namespace App\Services;

use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\BusinessSetting;

class ImagegetService{
    public static function getimagepaths(){
        $data = BusinessSetting::get();
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
        foreach($data as $item){
            if(in_array($item->type,$arrayOfCompaniesValue)){
                $result[$item->type] = $item->value;
            }
        }
        return $result;
    }
    public static function decodedpaths($data){    
        $imagegetsd = [];
        foreach($data as $key => $value){
            $decoded = json_decode($value,true);
            if($decoded && isset($decoded['image_name'],$decoded['storage'])){
                $imagegetsd[$key] = '/' . $decoded['storage'] . '/company/' . $decoded ['image_name'];
            } else {
                $imagegetsd[$key] = null;
            }
        }
        return $imagegetsd;
    } 
}