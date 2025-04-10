<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\MembershipTier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Utils\CategoryManager;

class ThemeSettingsController extends Controller
{
    public function webtheme()
    {
        $customer_tiers = MembershipTier::orderBy('membership_order', 'asc')->where('membership_type', 'customer')->where('membership_active', 1)->get();
        $seller_tiers = MembershipTier::orderBy('membership_order', 'asc')->where('membership_type', 'seller')->where('membership_active', 1)->get();

        // Get the total number of customer and seller tiers
        $total_customer_tiers = $customer_tiers->count();
        $total_seller_tiers = $seller_tiers->count();

        // Attempt to fetch the database field
        $getDBfield = BusinessSetting::where('type', 'memsetting')->first();

        // Decode the value if the field exists, otherwise use an empty array
        $memdata = $getDBfield ? json_decode($getDBfield['value'], true) : [];

        // Attempt to fetch the database field
        $getDBfield = BusinessSetting::where('type', 'memsettingseller')->first();

        // Decode the value if the field exists, otherwise use an empty array
        $memdataseller = $getDBfield ? json_decode($getDBfield['value'], true) : [];

        // Render the view with the memdata variable
        return view('admin-views.business-settings.website-theme', compact('memdata', 'total_customer_tiers', 'total_seller_tiers', 'memdataseller'));
    }

    public function websettingmem(Request $request)
    {
        // Validate request input
        $validatedData = $request->validate([
            'totalTiers' => 'required|integer|min:1',
            'type' => 'array|required',
            'type.*' => 'string|nullable',
            'desc' => 'array|required', // Added validation for desc array
            'desc.*' => 'string|nullable', // Each description can be a string or null
        ]);

        // Get total tiers
        $totalTiers = (int) $validatedData['totalTiers'];

        // Initialize data array
        $data = [
            'totalTiers' => $totalTiers,
            'type' => $validatedData['type'] ?? [],
            'desc' => $validatedData['desc'] ?? [], // Add descriptions to the data
        ];

        // Dynamically fetch all features
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^feature\d+$/', $key) && is_array($value)) {
                $data[$key] = $value;
            }
        }

        // Ensure array lengths are consistent
        $dataCount = count($data['type']);
        foreach ($data as $key => $value) {
            if (is_array($value) && count($value) > $dataCount) {
                $data[$key] = array_slice($value, 0, $dataCount);
            }
        }

        // Encode as JSON
        $encodedData = json_encode($data, JSON_PRETTY_PRINT);

        // Fetch or create BusinessSetting record
        BusinessSetting::updateOrCreate(
            ['type' => 'memsetting'],
            ['value' => $encodedData]
        );

        toastr()->success('Membership Setting Updated Successfully');
        return redirect()->back()->with('success', 'Membership Setting Updated Successfully');
    }


    public function websettingmemseller(Request $request)
    {
        // Validate request input
        $validatedData = $request->validate([
            'totalTiers' => 'required|integer|min:1',
            'type' => 'array|required',
            'type.*' => 'string|nullable',
            'desc' => 'array|required', // Added validation for desc array
            'desc.*' => 'string|nullable', // Each description can be a string or null
        ]);

        // Get total tiers
        $totalTiers = (int) $validatedData['totalTiers'];

        // Initialize data array
        $data = [
            'totalTiers' => $totalTiers,
            'type' => $validatedData['type'] ?? [],
            'desc' => $validatedData['desc'] ?? [], // Add descriptions to the data
        ];

        // Dynamically fetch all features
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^feature\d+$/', $key) && is_array($value)) {
                $data[$key] = $value;
            }
        }

        // Ensure array lengths are consistent
        $dataCount = count($data['type']);
        foreach ($data as $key => $value) {
            if (is_array($value) && count($value) > $dataCount) {
                $data[$key] = array_slice($value, 0, $dataCount);
            }
        }

        // Encode as JSON
        $encodedData = json_encode($data, JSON_PRETTY_PRINT);

        // Fetch or create BusinessSetting record
        BusinessSetting::updateOrCreate(
            ['type' => 'memsettingseller'],
            ['value' => $encodedData]
        );

        toastr()->success('Membership Setting Updated Successfully');
        return redirect()->back()->with('success', 'Membership Setting Updated Successfully');
    }


    public function backsettings()
    {
        $getDBfield = BusinessSetting::where('type', 'bgimages')->first();
        $bgimages = $getDBfield ? json_decode($getDBfield['value'], true) : [];
        return view('admin-views.business-settings.theme-pages.back-settings', compact('bgimages'));
    }

    public function backsettingform(Request $request)
    {
        $request->validate([
            'image1' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image2' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image3' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image4' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image5' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image6' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image7' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image8' => 'nullable|mimes:jpg,png,jpeg|max:10425',
        ]);

        $storage = config('filesystems.disks.default') ?? 'public';

        $i = 1;
        $updatearray = [];

        // Retrieve the existing background images from the database
        $existingImages = BusinessSetting::where('type', 'bgimages')->first();
        $existingImagesData = $existingImages ? json_decode($existingImages->value, true) : [];

        while ($i <= 8) {
            $imageKey = 'image' . $i;

            // Check if the image is marked for deletion
            if ($request->input('delete_image' . $i)) {
                if (isset($existingImagesData[$i - 1])) {
                    $imagePath = $existingImagesData[$i - 1]['img_path'];

                    // Delete the file from storage
                    if (Storage::disk($storage)->exists($imagePath)) {
                        Storage::disk($storage)->delete($imagePath);
                    }
                }
            } elseif ($request->hasFile($imageKey)) {
                $image = $request->file($imageKey);
                $imagePath = 'bgimages/' . $image->getClientOriginalName();

                // Check if the image already exists in storage
                if (!Storage::disk($storage)->exists($imagePath)) {
                    $imagePath = $image->storeAs('bgimages', $image->getClientOriginalName(), $storage);
                }

                $updatearray[] = [
                    'img_name' => $imageKey,
                    'img_path' => $imagePath,
                ];
            } else {
                // Keep the existing image if it hasn't been deleted
                if (isset($existingImagesData[$i - 1])) {
                    $updatearray[] = $existingImagesData[$i - 1];
                }
            }

            $i++;
        }

        // Encode the updated array into JSON
        $encodedData = json_encode($updatearray);

        // Update the database with the new values
        if ($existingImages) {
            $existingImages->update([
                'value' => $encodedData,
            ]);
        } else {
            BusinessSetting::create([
                'type' => 'bgimages',
                'value' => $encodedData,
            ]);
        }

        toastr()->success('Background Images Updated');
        return redirect()->back()->with('success', 'Background Images Updated Successfully');
    }

    public function bannertheme()
    {
        // Get the first business setting for banners
        $getDBfield = BusinessSetting::where('type', 'bannersetting')->first();

        // Get the banner trade setting (with default handling if not found)
        $bannertradesetting = BusinessSetting::where('type', 'bannertradesetting')->first();

        // Decode the banner trade setting value with a fallback to an empty array if it's null
        $decodedbanner = $bannertradesetting ? json_decode($bannertradesetting['value'], true) : [];

        // If the business setting is found, decode it, otherwise set an empty array
        if ($getDBfield) {
            $data = json_decode($getDBfield['value'], true);
        } else {
            $data = [];
        }

        $firstbox = BusinessSetting::where('type', 'firstbox')->first();
        $secondbox = BusinessSetting::where('type', 'secondbox')->first();
        $thirdbox = BusinessSetting::where('type', 'thirdbox')->first();
        $fourthbox = BusinessSetting::where('type', 'fourthbox')->first();
        $fifthbox = BusinessSetting::where('type', 'fifthbox')->first();

        $firstbox = $firstbox ? json_decode($firstbox['value'], true) : [];;
        $secondbox = $secondbox ? json_decode($secondbox['value'], true) : [];;
        $thirdbox = $thirdbox ? json_decode($thirdbox['value'], true) : [];;
        $fourthbox = $fourthbox ? json_decode($fourthbox['value'], true) : [];;
        $fifthbox = $fifthbox ? json_decode($fifthbox['value'], true) : [];;

        // Return the view with the decoded data
        return view('admin-views.business-settings.theme-pages.banner-setting', compact('data', 'decodedbanner', 'firstbox', 'secondbox', 'thirdbox', 'fourthbox', 'fifthbox'));
    }

    public function bannersetting(Request $request)
    {
        return $this->handleBannerSetting($request, 'bannersetting');
    }

    public function bannertradesetting(Request $request)
    {
        return $this->handleBannerSetting($request, 'bannertradesetting');
    }

    private function handleBannerSetting(Request $request, $settingType)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            // Dynamically collect banner inputs into an array
            $banners = [];
            for ($i = 1; $i <= 3; $i++) {
                if (
                    $request->has("image_$i") ||
                    $request->filled("title_$i") ||
                    $request->filled("content_$i") ||
                    $request->filled("url_$i") ||
                    $request->filled("color_$i")
                ) {
                    $banners[] = [
                        'image' => $request->file("image_$i") ?? null,
                        'title' => $request->input("title_$i"),
                        'content' => $request->input("content_$i"),
                        'url' => $request->input("url_$i"),
                        'color' => $request->input("color_$i") ?? '#000000',
                    ];
                }
            }

            if (empty($banners)) {
                toastr()->error("At least one banner is required.");
                return redirect()->back()->with('error', "At least one banner is required.");
            }

            // Validation
            foreach ($banners as $index => $banner) {
                if (!empty($banner['url']) && !Str::contains($banner['url'], $baseUrl)) {
                    toastr()->error("Banner " . ($index + 1) . ": Incorrect URL");
                    return redirect()->back()->with('error', "Banner " . ($index + 1) . ": Incorrect URL");
                }
            }

            $existingData = BusinessSetting::where('type', $settingType)->first();
            $storedBanners = $existingData ? json_decode($existingData->value, true) : [];

            $updatedBanners = [];

            foreach ($banners as $index => $banner) {
                $imagePath = $storedBanners[$index]['image'] ?? null;

                if (!empty($banner['image']) && $banner['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $banner['image']->store('featured', $storage);

                    if (!empty($storedBanners[$index]['image']) && Storage::exists($storedBanners[$index]['image'])) {
                        Storage::delete($storedBanners[$index]['image']);
                    }
                }

                $updatedBanners[] = [
                    'image' => $imagePath,
                    'title' => $banner['title'] ?? null,
                    'content' => $banner['content'] ?? null,
                    'url' => $banner['url'] ?? null,
                    'color' => $banner['color'] ?? '#000000',
                ];
            }

            BusinessSetting::updateOrCreate(
                ['type' => $settingType],
                ['value' => json_encode($updatedBanners)]
            );

            toastr()->success(ucwords(str_replace('_', ' ', $settingType)) . ' updated successfully');
            return redirect()->back()->with('success', ucwords(str_replace('_', ' ', $settingType)) . ' updated successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function firstbox(Request $request)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            $request->validate([
                'image' => 'nullable|mimes:jpg,png,jpeg|max:10425',
                'title' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|url',
            ]);

            $getDBfield = BusinessSetting::where('type', 'firstbox')->first();

            $imagePath = null;

            $checkUrl = Str::contains($request->url, $baseUrl);
            if ($checkUrl == false) {
                toastr()->error('Incorrect URL');
                return redirect()->back()->with('error', 'Incorrect URL');
            }

            if ($getDBfield) {
                $existingData = json_decode($getDBfield->value, true);

                $oldImagePath = $existingData['image'] ?? null;

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);

                    if ($oldImagePath && Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                } else {
                    $imagePath = $oldImagePath;
                }
            } else {
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);
                }
            }

            $data = [
                'image' => $imagePath,
                'title' => $request->title,
                'content' => $request->content,
                'url' => $request->url,
            ];

            $encodedData = json_encode($data);

            if ($getDBfield) {
                $getDBfield->update([
                    'value' => $encodedData,
                ]);
            } else {
                BusinessSetting::create([
                    'type' => 'firstbox',
                    'value' => $encodedData,
                ]);
            }

            toastr()->success('Settings Updated Successfully');
            return redirect()->back()->with('success', 'Settings Updated Successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function secondbox(Request $request)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            $request->validate([
                'image' => 'nullable|mimes:jpg,png,jpeg|max:10425',
                'title' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|url',
            ]);

            $getDBfield = BusinessSetting::where('type', 'secondbox')->first();

            $imagePath = null;

            $checkUrl = Str::contains($request->url, $baseUrl);
            if ($checkUrl == false) {
                toastr()->error('Incorrect URL');
                return redirect()->back()->with('error', 'Incorrect URL');
            }

            if ($getDBfield) {
                $existingData = json_decode($getDBfield->value, true);

                $oldImagePath = $existingData['image'] ?? null;

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);

                    if ($oldImagePath && Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                } else {
                    $imagePath = $oldImagePath;
                }
            } else {
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);
                }
            }

            $data = [
                'image' => $imagePath,
                'title' => $request->title,
                'content' => $request->content,
                'url' => $request->url,
            ];

            $encodedData = json_encode($data);

            if ($getDBfield) {
                $getDBfield->update([
                    'value' => $encodedData,
                ]);
            } else {
                BusinessSetting::create([
                    'type' => 'secondbox',
                    'value' => $encodedData,
                ]);
            }

            toastr()->success('Settings Updated Successfully');
            return redirect()->back()->with('success', 'Settings Updated Successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function thirdbox(Request $request)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            $request->validate([
                'image' => 'nullable|mimes:jpg,png,jpeg|max:10425',
                'title' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|url',
            ]);

            $getDBfield = BusinessSetting::where('type', 'thirdbox')->first();

            $imagePath = null;

            $checkUrl = Str::contains($request->url, $baseUrl);
            if ($checkUrl == false) {
                toastr()->error('Incorrect URL');
                return redirect()->back()->with('error', 'Incorrect URL');
            }

            if ($getDBfield) {
                $existingData = json_decode($getDBfield->value, true);

                $oldImagePath = $existingData['image'] ?? null;

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);

                    if ($oldImagePath && Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                } else {
                    $imagePath = $oldImagePath;
                }
            } else {
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);
                }
            }

            $data = [
                'image' => $imagePath,
                'title' => $request->title,
                'content' => $request->content,
                'url' => $request->url,
            ];

            $encodedData = json_encode($data);

            if ($getDBfield) {
                $getDBfield->update([
                    'value' => $encodedData,
                ]);
            } else {
                BusinessSetting::create([
                    'type' => 'thirdbox',
                    'value' => $encodedData,
                ]);
            }

            toastr()->success('Settings Updated Successfully');
            return redirect()->back()->with('success', 'Settings Updated Successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function fourthbox(Request $request)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            $request->validate([
                'image' => 'nullable|mimes:jpg,png,jpeg|max:10425',
                'title' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|url',
            ]);

            $getDBfield = BusinessSetting::where('type', 'fourthbox')->first();

            $imagePath = null;

            $checkUrl = Str::contains($request->url, $baseUrl);
            if ($checkUrl == false) {
                toastr()->error('Incorrect URL');
                return redirect()->back()->with('error', 'Incorrect URL');
            }

            if ($getDBfield) {
                $existingData = json_decode($getDBfield->value, true);

                $oldImagePath = $existingData['image'] ?? null;

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);

                    if ($oldImagePath && Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                } else {
                    $imagePath = $oldImagePath;
                }
            } else {
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);
                }
            }

            $data = [
                'image' => $imagePath,
                'title' => $request->title,
                'content' => $request->content,
                'url' => $request->url,
            ];

            $encodedData = json_encode($data);

            if ($getDBfield) {
                $getDBfield->update([
                    'value' => $encodedData,
                ]);
            } else {
                BusinessSetting::create([
                    'type' => 'fourthbox',
                    'value' => $encodedData,
                ]);
            }

            toastr()->success('Settings Updated Successfully');
            return redirect()->back()->with('success', 'Settings Updated Successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function fifthbox(Request $request)
    {
        try {
            $storage = config('filesystems.disks.default') ?? 'public';
            $baseUrl = url('/');

            $request->validate([
                'image' => 'nullable|mimes:jpg,png,jpeg|max:10425',
                'title' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|url',
            ]);

            $getDBfield = BusinessSetting::where('type', 'fifthbox')->first();

            $imagePath = null;

            $checkUrl = Str::contains($request->url, $baseUrl);
            if ($checkUrl == false) {
                toastr()->error('Incorrect URL');
                return redirect()->back()->with('error', 'Incorrect URL');
            }

            if ($getDBfield) {
                $existingData = json_decode($getDBfield->value, true);

                $oldImagePath = $existingData['image'] ?? null;

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);

                    if ($oldImagePath && Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                } else {
                    $imagePath = $oldImagePath;
                }
            } else {
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('featured', $storage);
                }
            }

            $data = [
                'image' => $imagePath,
                'title' => $request->title,
                'content' => $request->content,
                'url' => $request->url,
            ];

            $encodedData = json_encode($data);

            if ($getDBfield) {
                $getDBfield->update([
                    'value' => $encodedData,
                ]);
            } else {
                BusinessSetting::create([
                    'type' => 'fifthbox',
                    'value' => $encodedData,
                ]);
            }

            toastr()->success('Settings Updated Successfully');
            return redirect()->back()->with('success', 'Settings Updated Successfully');
        } catch (\Exception $e) {
            toastr()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // public function vendorlogin()
    // {
    //     // Fetch Vendor Setting
    //     $vendorSetting = BusinessSetting::where('type','vendorlogin')->first();
    //     $data = $businessSetting ? json_decode()
    // }

    public function stocksaleset()
    {
        // Fetch Business Setting
        $businessSetting = BusinessSetting::where('type', 'stocksale')->first();
        $data = $businessSetting ? json_decode($businessSetting->value, true) : [];

        $buyerbanner = BusinessSetting::where('type', 'stocksalebanner')->first();
        $bannerimage = $buyerbanner ? json_decode($buyerbanner->value, true) : [];

        // Return Admin View packed with Data
        return view('admin-views.business-settings.theme-pages.stocksale', compact('data', 'bannerimage'));
    }

    public function stocksale(Request $request)
    {
        // Validate the input
        $request->validate([
            'color' => 'required|string',
            'ad1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad1_title' => 'nullable|string',
            'ad1_url' => 'nullable|url',
            'ad2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad2_title' => 'nullable|string',
            'ad2_url' => 'nullable|url',
        ]);

        // Fetch or create the business setting
        $setting = BusinessSetting::firstOrNew(['type' => 'stocksale']);

        // Decode the current value or initialize an empty array
        $currentValue = $setting->value ? json_decode($setting->value, true) : [];

        // Handle file uploads for banners
        if ($request->hasFile('ad1_image')) {
            $ad1ImagePath = $request->file('ad1_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad1_image'] = $ad1ImagePath;
        }

        if ($request->hasFile('ad2_image')) {
            $ad2ImagePath = $request->file('ad2_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad2_image'] = $ad2ImagePath;
        }

        // Update the settings data
        $currentValue['color'] = $request->input('color');
        $currentValue['ad1_title'] = $request->input('ad1_title', '');
        $currentValue['ad1_url'] = $request->input('ad1_url', '');
        $currentValue['ad2_title'] = $request->input('ad2_title', '');
        $currentValue['ad2_url'] = $request->input('ad2_url', '');

        // Save the updated settings
        $setting->value = json_encode($currentValue);
        $setting->save();

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function stocksalebanner(Request $request)
    {
        // Validate the input
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
        ]);

        // Fetch or create the buyer banner setting
        $setting = BusinessSetting::firstOrNew(['type' => 'stocksalebanner']);

        // Decode the current value or initialize an empty array
        $currentValue = $setting->value ? json_decode($setting->value, true) : [];

        // Handle file uploads for banners
        if ($request->hasFile('banner_image1')) {
            // Store the uploaded banner image and get the file path
            $ad1ImagePath = $request->file('banner_image1')->store('uploads/ad_banners', 'public');

            // Save the image path in the currentValue array
            $currentValue['banner_image1'] = $ad1ImagePath;
        }

        if ($request->hasFile('banner_image2')) {
            // Store the uploaded banner image and get the file path
            $ad2ImagePath = $request->file('banner_image2')->store('uploads/ad_banners', 'public');

            // Save the image path in the currentValue array
            $currentValue['banner_image2'] = $ad2ImagePath;
        }

        // Save the updated settings to the database
        $setting->value = json_encode($currentValue);
        $setting->save();

        // Success message
        toastr()->success('Banner Settings Updated Successfully');
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function trendingproductsset()
    {
        $data = BusinessSetting::where('type', 'trendingproducts')->first();
    
        $registerSetting = BusinessSetting::where('type', 'register_banner')->first();
        $quotationSetting = BusinessSetting::where('type', 'quotation')->first();
        $marketplaceSetting = BusinessSetting::where('type', 'marketplace')->first();
    
        $registerbanner = $registerSetting ? json_decode($registerSetting->value, true) : [];
        $quotation = $quotationSetting ? json_decode($quotationSetting->value, true) : [];
        $marketplace = $marketplaceSetting ? json_decode($marketplaceSetting->value, true) : [];
    
        return view('admin-views.business-settings.theme-pages.trendingproducts', compact('data', 'registerbanner', 'quotation', 'marketplace'));
    }

    public function trendingproducts(Request $request)
    {
        $this->saveOrUpdateSetting('trendingproducts', [
            'limit' => $request->input('limit'),
        ]);

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function topsupplierset()
    {
        $data = BusinessSetting::where('type', 'topsupplier')->first();
        return view('admin-views.business-settings.theme-pages.topsupplier', compact('data'));
    }

    public function topsupplier(Request $request)
    {
        $this->saveOrUpdateSetting('topsupplier', [
            'limit' => $request->input('limit'),
        ]);

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function buyerset()
    {
        // Fetch Business Setting
        $businessSetting = BusinessSetting::where('type', 'buyer')->first();
        $data = $businessSetting ? json_decode($businessSetting->value, true) : [];

        $buyerbanner = BusinessSetting::where('type', 'banners_buyers')->first();
        $bannerimages = $buyerbanner ? json_decode($buyerbanner->value, true) : [];

        // Return Admin View packed with Data
        return view('admin-views.business-settings.theme-pages.buyer', compact('data', 'bannerimages'));
    }

    public function buyer(Request $request)
    {
        // Validate the input
        $request->validate([
            'limit' => 'required|integer',
            'color' => 'required|string',
            'ad1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad1_title' => 'nullable|string',
            'ad1_url' => 'nullable|url',
            'ad2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad2_title' => 'nullable|string',
            'ad2_url' => 'nullable|url',
        ]);

        // Fetch or create the business setting
        $setting = BusinessSetting::firstOrNew(['type' => 'buyer']);

        // Decode the current value or initialize an empty array
        $currentValue = $setting->value ? json_decode($setting->value, true) : [];

        // Handle file uploads for banners
        if ($request->hasFile('ad1_image')) {
            $ad1ImagePath = $request->file('ad1_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad1_image'] = $ad1ImagePath;
        }

        if ($request->hasFile('ad2_image')) {
            $ad2ImagePath = $request->file('ad2_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad2_image'] = $ad2ImagePath;
        }

        // Update the settings data
        $currentValue['limit'] = $request->input('limit');
        $currentValue['color'] = $request->input('color');
        $currentValue['ad1_title'] = $request->input('ad1_title', '');
        $currentValue['ad1_url'] = $request->input('ad1_url', '');
        $currentValue['ad2_title'] = $request->input('ad2_title', '');
        $currentValue['ad2_url'] = $request->input('ad2_url', '');

        // Save the updated settings
        $setting->value = json_encode($currentValue);
        $setting->save();

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function buyerbanner(Request $request)
    {
        $request->validate([
            'image1' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image2' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image3' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image4' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image5' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image6' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image7' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image8' => 'nullable|mimes:jpg,png,jpeg|max:10425',
        ]);

        $storage = config('filesystems.disks.default') ?? 'public';

        $i = 1;
        $updatearray = [];

        // Retrieve the existing background images from the database
        $existingImages = BusinessSetting::where('type', 'banners_buyers')->first();
        $existingImagesData = $existingImages ? json_decode($existingImages->value, true) : [];

        while ($i <= 8) {
            $imageKey = 'image' . $i;

            // Check if the image is marked for deletion
            if ($request->input('delete_image' . $i)) {
                if (isset($existingImagesData[$i - 1])) {
                    $imagePath = $existingImagesData[$i - 1]['img_path'];

                    // Delete the file from storage
                    if (Storage::disk($storage)->exists($imagePath)) {
                        Storage::disk($storage)->delete($imagePath);
                    }
                }
            } elseif ($request->hasFile($imageKey)) {
                $image = $request->file($imageKey);
                $imagePath = 'banners_buyers/' . $image->getClientOriginalName();

                // Check if the image already exists in storage
                if (!Storage::disk($storage)->exists($imagePath)) {
                    $imagePath = $image->storeAs('banners_buyers', $image->getClientOriginalName(), $storage);
                }

                $updatearray[] = [
                    'img_name' => $imageKey,
                    'img_path' => $imagePath,
                ];
            } else {
                // Keep the existing image if it hasn't been deleted
                if (isset($existingImagesData[$i - 1])) {
                    $updatearray[] = $existingImagesData[$i - 1];
                }
            }

            $i++;
        }

        // Encode the updated array into JSON
        $encodedData = json_encode($updatearray);

        // Update the database with the new values
        if ($existingImages) {
            $existingImages->update([
                'value' => $encodedData,
            ]);
        } else {
            BusinessSetting::create([
                'type' => 'banners_buyers',
                'value' => $encodedData,
            ]);
        }

        toastr()->success('Background Images Updated');
        return redirect()->back()->with('success', 'Background Images Updated Successfully');
    }

    public function sellerbanner(Request $request)
    {
        $request->validate([
            'image1' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image2' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image3' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image4' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image5' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image6' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image7' => 'nullable|mimes:jpg,png,jpeg|max:10425',
            'image8' => 'nullable|mimes:jpg,png,jpeg|max:10425',
        ]);

        $storage = config('filesystems.disks.default') ?? 'public';

        $i = 1;
        $updatearray = [];

        // Retrieve the existing background images from the database
        $existingImages = BusinessSetting::where('type', 'sellers_buyers')->first();
        $existingImagesData = $existingImages ? json_decode($existingImages->value, true) : [];

        while ($i <= 8) {
            $imageKey = 'image' . $i;

            // Check if the image is marked for deletion
            if ($request->input('delete_image' . $i)) {
                if (isset($existingImagesData[$i - 1])) {
                    $imagePath = $existingImagesData[$i - 1]['img_path'];

                    // Delete the file from storage
                    if (Storage::disk($storage)->exists($imagePath)) {
                        Storage::disk($storage)->delete($imagePath);
                    }
                }
            } elseif ($request->hasFile($imageKey)) {
                $image = $request->file($imageKey);
                $imagePath = 'sellers_buyers/' . $image->getClientOriginalName();

                // Check if the image already exists in storage
                if (!Storage::disk($storage)->exists($imagePath)) {
                    $imagePath = $image->storeAs('sellers_buyers', $image->getClientOriginalName(), $storage);
                }

                $updatearray[] = [
                    'img_name' => $imageKey,
                    'img_path' => $imagePath,
                ];
            } else {
                // Keep the existing image if it hasn't been deleted
                if (isset($existingImagesData[$i - 1])) {
                    $updatearray[] = $existingImagesData[$i - 1];
                }
            }

            $i++;
        }

        // Encode the updated array into JSON
        $encodedData = json_encode($updatearray);

        // Update the database with the new values
        if ($existingImages) {
            $existingImages->update([
                'value' => $encodedData,
            ]);
        } else {
            BusinessSetting::create([
                'type' => 'sellers_buyers',
                'value' => $encodedData,
            ]);
        }

        toastr()->success('Background Images Updated');
        return redirect()->back()->with('success', 'Background Images Updated Successfully');
    }

    public function sellerset()
    {
        // Fetch Business Setting
        $businessSetting = BusinessSetting::where('type', 'seller')->first();

        // If No Data then assign null array else decode data array
        $data = $businessSetting ? json_decode($businessSetting->value, true) : [];

        $sellerbanner = BusinessSetting::where('type', 'sellers_buyers')->first();
        $bannerimages = $sellerbanner ? json_decode($sellerbanner->value, true) : [];

        return view('admin-views.business-settings.theme-pages.seller', compact('data', 'bannerimages'));
    }

    public function seller(Request $request)
    {
        // Validate the input
        $request->validate([
            'limit' => 'required|integer',
            'color' => 'required|string',
            'ad1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad1_title' => 'nullable|string',
            'ad1_url' => 'nullable|url',
            'ad2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad2_title' => 'nullable|string',
            'ad2_url' => 'nullable|url',
        ]);

        // Fetch or create the business setting
        $setting = BusinessSetting::firstOrNew(['type' => 'seller']);

        // Decode the current value or initialize an empty array
        $currentValue = $setting->value ? json_decode($setting->value, true) : [];

        // Handle file uploads for banners
        if ($request->hasFile('ad1_image')) {
            $ad1ImagePath = $request->file('ad1_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad1_image'] = $ad1ImagePath;
        }

        if ($request->hasFile('ad2_image')) {
            $ad2ImagePath = $request->file('ad2_image')->store('uploads/ad_banners', 'public');
            $currentValue['ad2_image'] = $ad2ImagePath;
        }

        // Update the settings data
        $currentValue['limit'] = $request->input('limit');
        $currentValue['color'] = $request->input('color');
        $currentValue['ad1_title'] = $request->input('ad1_title', '');
        $currentValue['ad1_url'] = $request->input('ad1_url', '');
        $currentValue['ad2_title'] = $request->input('ad2_title', '');
        $currentValue['ad2_url'] = $request->input('ad2_url', '');

        // Save the updated settings
        $setting->value = json_encode($currentValue);
        $setting->save();

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function tradeshowset()
    {
        $data = BusinessSetting::where('type', 'tradeshow')->first();
        $tradeshowlimit = BusinessSetting::where('type', 'tradeshowbannerlimit')->first();
        $carouselData = BusinessSetting::where('type', 'tradeshowrotatingbox')->first();
        $carouselarray = $carouselData ? json_decode($carouselData->value, true) : [];
        $imagesData = BusinessSetting::where('type','tradeshowhomepage')->first();
        $imagesArray = $imagesData ? json_decode($imagesData->value,true) : [];
        $bannerData = BusinessSetting::where('type', 'tradeshowbannerrotatingbox')->first();
        $bannerarray = $bannerData ? json_decode($bannerData->value, true) : [];
        return view('admin-views.business-settings.theme-pages.tradeshow', compact('data', 'tradeshowlimit', 'carouselarray','imagesArray','bannerarray'));
    }

    public function tradeshow(Request $request)
    {
        $this->saveOrUpdateSetting('tradeshow', [
            'limit' => $request->input('limit'),
        ]);

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function tradeshowlimit(Request $request)
    {
        $this->saveOrUpdateSetting('tradeshowbannerlimit', [
            'tradeshowbannerlimit' => $request->input('bannerlimit')
        ]);

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function tradeshowbannerrotatingbox(Request $request)
    {
        // Fetch current settings from the database
        $setting = BusinessSetting::where('type', 'tradeshowbannerrotatingbox')->first();

        $currentSettings = [];
        
        if ($setting && $setting->value) {
            $decoded = json_decode($setting->value, true);
            if (is_array($decoded)) {
                $currentSettings = $decoded;
            }
        }
        
        // Use current values if no new file is uploaded
        $c1 = $request->hasFile('banner1') ? $request->file('banner1')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowbannerrotatingbox']['banner1']) ? $currentSettings['tradeshowbannerrotatingbox']['banner1'] : null);
        $c2 = $request->hasFile('banner2') ? $request->file('banner2')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowbannerrotatingbox']['banner2']) ? $currentSettings['tradeshowbannerrotatingbox']['banner2'] : null);
        $c3 = $request->hasFile('banner3') ? $request->file('banner3')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowbannerrotatingbox']['banner3']) ? $currentSettings['tradeshowbannerrotatingbox']['banner3'] : null);
        $c4 = $request->hasFile('banner4') ? $request->file('banner4')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowbannerrotatingbox']['banner4']) ? $currentSettings['tradeshowbannerrotatingbox']['banner4'] : null);

        // Prepare the new data to be saved
        $data = [
            'banner1' => $c1,
            'banner2' => $c2,
            'banner3' => $c3,
            'banner4' => $c4,
        ];

        // Save or update the setting
        $this->saveOrUpdateSetting('tradeshowbannerrotatingbox', [
            'tradeshowbannerrotatingbox' => $data
        ]);

        toastr()->success('Settings Updated Successfully');
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function tradeshowrotatingbox(Request $request)
    {
        // Fetch current settings from the database
        $currentSettings = json_decode(BusinessSetting::where('type', 'tradeshowrotatingbox')->first()->value, true);

        // Use current values if no new file is uploaded
        $c1 = $request->hasFile('carousel1') ? $request->file('carousel1')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowrotatingbox']['carousel1']) ? $currentSettings['tradeshowrotatingbox']['carousel1'] : null);
        $c2 = $request->hasFile('carousel2') ? $request->file('carousel2')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowrotatingbox']['carousel2']) ? $currentSettings['tradeshowrotatingbox']['carousel2'] : null);
        $c3 = $request->hasFile('carousel3') ? $request->file('carousel3')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowrotatingbox']['carousel3']) ? $currentSettings['tradeshowrotatingbox']['carousel3'] : null);
        $c4 = $request->hasFile('carousel4') ? $request->file('carousel4')->store('tradeshow', 'public') : (isset($currentSettings['tradeshowrotatingbox']['carousel4']) ? $currentSettings['tradeshowrotatingbox']['carousel4'] : null);

        // Prepare the new data to be saved
        $data = [
            'carousel1' => $c1,
            'carousel2' => $c2,
            'carousel3' => $c3,
            'carousel4' => $c4,
        ];

        // Save or update the setting
        $this->saveOrUpdateSetting('tradeshowrotatingbox', [
            'tradeshowrotatingbox' => $data
        ]);

        toastr()->success('Settings Updated Successfully');
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    private function saveOrUpdateSetting($type, array $data)
    {
        $setting = BusinessSetting::firstOrCreate(['type' => $type]);
        $setting->value = json_encode($data);
        $setting->save();
    }

    public function vendorsetting()
    {
        $data = BusinessSetting::where('type', 'vendorsetting')->first();
        $vendorsetting = $data ? json_decode($data->value, true) : [];
        return view('admin-views.business-settings.theme-pages.vendorsettings', compact('vendorsetting'));
    }

    public function vendorsettingform(Request $request)
    {
        // Validate the input
        $request->validate([
            'ad1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
            'ad2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10425',
        ]);

        // Fetch or create the business setting
        $setting = BusinessSetting::firstOrNew(['type' => 'vendorsetting']);

        // Decode the current value or initialize an empty array
        $currentValue = $setting->value ? json_decode($setting->value, true) : [];

        // Handle file uploads for banners
        if ($request->hasFile('ad1_image')) {
            $ad1ImagePath = $request->file('ad1_image')->store('uploads/themevendor', 'public');
            $currentValue['ad1_image'] = $ad1ImagePath;
        }

        if ($request->hasFile('ad2_image')) {
            $ad2ImagePath = $request->file('ad2_image')->store('uploads/themevendor', 'public');
            $currentValue['ad2_image'] = $ad2ImagePath;
        }

        // Save the updated settings
        $setting->value = json_encode($currentValue);
        $setting->save();

        toastr()->success('Settings Updated Successfully');

        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function homepagesetting()
    {
        $data = BusinessSetting::where('type', 'genresection1')->first();
        $homepagesetting = $data ? json_decode($data->value, true) : [];
        $categories = CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting();
        return view('admin-views.business-settings.theme-pages.homepage-setting', compact('homepagesetting','categories'));
    }

    public function saveGenreSectionSettings(Request $request)
{
    $request->validate([
        'genres' => 'array',
        'genres.*.background_image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:10425',
        'genres.*.category_title' => 'nullable|string|max:255',
        'genres.*.button_text' => 'nullable|string|max:50',
        'genres.*.products' => 'nullable|array|max:8', // Max 8 products per genre
        'genres.*.products.*.name' => 'nullable|string|max:100',
        'genres.*.products.*.image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:10425',
    ]);

    $storage = config('filesystems.disks.default') ?? 'public';
    $genresData = [];

    foreach ($request->input('genres', []) as $index => $genre) {
        // Get existing genre data
        $existingGenreData = $this->getExistingGenreData($genre);

        // Handle background image (upload new or retain existing)
        $backgroundImagePath = $this->storeOrReplaceFile($request, "genres.{$index}.background_image", 'uploads/homepage', $storage, $existingGenreData['background_image'] ?? null);

        // Process products
        $products = [];
        foreach ($genre['products'] ?? [] as $productIndex => $product) {
            $existingProductData = $existingGenreData['products'][$productIndex] ?? null;

            // Handle product image (upload new or retain existing)
            $productImagePath = $this->storeOrReplaceFile($request, "genres.{$index}.products.{$productIndex}.image", 'uploads/homepage', $storage, $existingProductData['image'] ?? null);

            $products[] = [
                'name' => $product['name'],
                'image' => $productImagePath,
            ];
        }

        $genresData[] = [
            'background_image' => $backgroundImagePath,
            'category_title' => $genre['category_title'],
            'button_text' => $genre['button_text'],
            'products' => $products,
        ];
    }

    // Save or update genre settings
    $this->saveOrUpdateGenreSettings($genresData);

    return redirect()->back()->with('success', 'Genre settings updated successfully!');
}

private function storeOrReplaceFile(Request $request, $fileKey, $folder, $storage, $existingFile = null)
{
    if ($request->hasFile($fileKey)) {
        $file = $request->file($fileKey);
        $filePath = $file->store($folder, $storage);

        // Delete old file if it exists
        if ($existingFile && Storage::disk($storage)->exists($existingFile)) {
            Storage::disk($storage)->delete($existingFile);
        }

        return $filePath;
    }

    // Keep existing file if no new one is uploaded
    return $existingFile;
}

    private function getExistingGenreData($genre)
    {
        // Decode the current settings from the database (if they exist)
        $setting = BusinessSetting::where('type', 'genresection1')->first();
        $existingData = $setting ? json_decode($setting->value, true) : [];
        
        // Find the genre data from existing settings (if available)
        return collect($existingData)->firstWhere('category_title', $genre['category_title']);
    }

    private function handleImageUpload(Request $request, $imageKey, $folder, $storage, $genre, $existingGenreData = null)
    {
        $imagePath = null;
        
        // Check if the background image exists in the request
        if ($request->hasFile($imageKey)) {
            $image = $request->file($imageKey);
            $imagePath = $folder . '/' . $image->getClientOriginalName();

            // Store the uploaded image
            $imagePath = $image->storeAs($folder, $image->getClientOriginalName(), $storage);
        }
        
        // If no new image and 'keep_existing_image' flag is set, retain the existing image
        if (!$request->hasFile($imageKey) && $request->input("keep_{$imageKey}") && isset($existingGenreData['background_image'])) {
            $imagePath = $existingGenreData['background_image'];
        }

        return $imagePath ?? ($existingGenreData['background_image'] ?? '');
    }

    private function saveOrUpdateGenreSettings($genresData)
    {
        $encodedData = json_encode($genresData);
        
        // Update or create the genre section settings
        $setting = BusinessSetting::firstOrNew(['type' => 'genresection1']);
        $setting->value = $encodedData;
        $setting->save();
    }

    public function registerbannerform(Request $request)
    {
        $request->validate([
            'banner' => 'required|image|mimes:jpg,jpeg,png,gif,webp',
        ]);
    
        // Store the banner image in 'banners' inside public storage
        $bannerPath = $request->file('banner')->store('uploads/banners', 'public');
    
        // Prepare data to store in the database
        $data = [
            'banner' => $bannerPath,
        ];
    
        // Use updateOrCreate to either update or create the entry
        BusinessSetting::updateOrCreate(
            ['type' => 'register_banner'],
            ['value' => json_encode($data)]
        );
    
        return redirect()->back()->with('success', 'Banner uploaded successfully');
    }
    
    public function quotationbanner(Request $request)
    {
        // Validate the request
        $request->validate([
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'quotation_header' => 'nullable|string',
            'header_color' => 'nullable|string',
            'quotation_Subtext' => 'nullable|string',
            'subtext_color' => 'nullable|string',
            'banner_prev' => 'nullable|string',
        ]);
    
        // Determine the banner path
        if ($request->has('banner_prev') && $request->banner_prev && !$request->hasFile('banner')) {
            $bannerPath = $request->banner_prev; // Use previous banner if no new one is uploaded
        } elseif ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('uploads/banners', 'public'); // Store the new banner
        } else {
            $bannerPath = null; // No banner provided
        }
    
        // Prepare data to store in the database
        $data = [
            'header' => $request->quotation_header,
            'header_color' => $request->header_color,
            'subtext' => $request->quotation_Subtext,
            'subtext_color' => $request->subtext_color,
            'banner' => $bannerPath,
        ];
    
        // Use updateOrCreate to either update or create the entry
        BusinessSetting::updateOrCreate(
            ['type' => 'quotation'],
            ['value' => json_encode($data)]
        );
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Quotation banner uploaded successfully');
    }
        
    public function marketplacebanner(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpg,jpeg,png,gif,webp',
            'header_text' => 'string|max:255',
            'text_field_1' => 'nullable|string|max:255',
            'text_field_2' => 'nullable|string|max:255',
            'text_field_3' => 'nullable|string|max:255',
        ]);
    
        // Store the background image in 'backgrounds' inside public storage
        $backgroundImagePath = $request->file('background_image')->store('uploads/backgrounds', 'public');
    
        // Prepare data to store in the database
        $data = [
            'background_image' => $backgroundImagePath,
            'header_text' => $request->input('header_text'),
            'text_field_1' => $request->input('text_field_1'),
            'text_field_2' => $request->input('text_field_2'),
            'text_field_3' => $request->input('text_field_3'),
        ];
    
        // Use updateOrCreate to either update or create the entry
        BusinessSetting::updateOrCreate(
            ['type' => 'marketplace'],
            ['value' => json_encode($data)]
        );
    
        return redirect()->back()->with('success', 'Marketplace settings updated successfully');
    }

    public function homepagesecsetting()
    {
        $setting = BusinessSetting::where('type', 'homepage_second_settings')->first();
        $existingData = $setting ? json_decode($setting->value, true) : [];
        $settinge = BusinessSetting::where('type', 'quotation_enabled')->first();
        $existingDatae = $settinge ? json_decode($settinge->value, true) : [];
        return view('admin-views.business-settings.theme-pages.homepage-sec',compact('existingData','existingDatae'));
    }
    
    public function updateHomepageSecondSettings(Request $request)
    {       
        $request->validate([
            'image_1' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'image_2' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'image_3' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'heading_1' => 'nullable|string|max:255',
            'heading_2' => 'nullable|string|max:255',
            'heading_3' => 'nullable|string|max:255',
            'link_1' => 'nullable|string|max:255',
            'link_2' => 'nullable|string|max:255',
            'link_3' => 'nullable|string|max:255',
            'sub_text_1' => 'nullable|string|max:255',
            'sub_text_2' => 'nullable|string|max:255',
            'sub_text_3' => 'nullable|string|max:255',
            'sub_text_color_1' => 'nullable|string|max:7',
            'sub_text_color_2' => 'nullable|string|max:7',
            'sub_text_color_3' => 'nullable|string|max:7',
            'bauble_text_color_1' => 'nullable|string|max:7',
            'bauble_text_color_2' => 'nullable|string|max:7',
            'bauble_text_color_3' => 'nullable|string|max:7',
        ]);

        $data = [];

        // Loop through each section (1 to 3)
        for ($i = 1; $i <= 3; $i++) {
            // Check if an image has been uploaded, otherwise keep the existing one
            if ($request->hasFile("image_$i")) {
                $data["image_$i"] = $request->file("image_$i")->store('uploads/homepage', 'public');
            } else {
                // If no new image uploaded, keep the old value from the existing data (if it exists)
                $data["image_$i"] = $request->input("existing_image_$i", null);
            }

            // Handle other fields
            $data["heading_$i"] = $request->input("heading_$i");
            $data["sub_text_$i"] = $request->input("sub_text_$i");
            $data["sub_text_color_$i"] = $request->input("sub_text_color_$i");
            $data["bauble_text_color_$i"] = $request->input("bauble_text_color_$i");
            $data["link_$i"] = $request->input("link_$i");

            // Loop through baubles (1 to 4)
            for ($j = 1; $j <= 4; $j++) {
                // Check if a bauble icon has been uploaded
                if ($request->hasFile("bauble_icon_{$i}_{$j}")) {
                    $data["bauble_icon_{$i}_{$j}"] = $request->file("bauble_icon_{$i}_{$j}")->store('uploads/homepage/baubles', 'public');
                } else {
                    // If no new bauble icon uploaded, keep the old value (if it exists)
                    $data["bauble_icon_{$i}_{$j}"] = $request->input("existing_bauble_icon_{$i}_{$j}", null);
                }

                // Handle bauble text and links
                $data["bauble_text_{$i}_{$j}"] = $request->input("bauble_text_{$i}_{$j}");
                $data["bauble_link_{$i}_{$j}"] = $request->input("bauble_link_{$i}_{$j}");
            }
        }

        // Update or create the business setting
        BusinessSetting::updateOrCreate(
            ['type' => 'homepage_second_settings'],
            ['value' => json_encode($data)]
        );

        return redirect()->back()->with('success', 'Homepage second settings updated successfully');
    }

    public function updateTradeshowHomepage(Request $request)
    {
        // Fetch current settings from the database
        $currentSettings = json_decode(BusinessSetting::where('type', 'tradeshowhomepage')->first()->value ?? '{}', true);

        // Use current values if no new file is uploaded
        $c1 = $request->hasFile('carousel1') ? $request->file('carousel1')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['carousel1'] ?? null);
        $c2 = $request->hasFile('carousel2') ? $request->file('carousel2')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['carousel2'] ?? null);
        $c3 = $request->hasFile('carousel3') ? $request->file('carousel3')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['carousel3'] ?? null);
        $c4 = $request->hasFile('carousel4') ? $request->file('carousel4')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['carousel4'] ?? null);
        $c5 = $request->hasFile('carousel5') ? $request->file('carousel5')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['carousel5'] ?? null);
        $c6 = $request->hasFile('newimage5') ? $request->file('newimage5')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['newimage5'] ?? null);
        $c7 = $request->hasFile('newimage4') ? $request->file('newimage4')->store('tradeshow', 'public') : ($currentSettings['tradeshowhomepage']['newimage4'] ?? null);

        $title1 = $request->input('title1');
        $textcolor1 = $request->filled('textcolor1') ? $request->input('textcolor1') : ($currentSettings['tradeshowhomepage']['textcolor1'] ?? 'black');

        $title2 = $request->input('title2');
        $textcolor2 = $request->filled('textcolor2') ? $request->input('textcolor2') : ($currentSettings['tradeshowhomepage']['textcolor2'] ?? 'black');

        $title3 = $request->input('title3');
        $textcolor3 = $request->filled('textcolor3') ? $request->input('textcolor3') : ($currentSettings['tradeshowhomepage']['textcolor3'] ?? 'black');

        $title4 = $request->input('title4');
        $textcolor4 = $request->filled('textcolor4') ? $request->input('textcolor4') : ($currentSettings['tradeshowhomepage']['textcolor4'] ?? 'black');

        $title5 = $request->input('title5');
        $textcolor5 = $request->filled('textcolor5') ? $request->input('textcolor5') : ($currentSettings['tradeshowhomepage']['textcolor5'] ?? 'black');

        // Prepare the new data to be saved
        $data = [
            'carousel1' => $c1,
            'title1' => $title1,
            'textcolor1' => $textcolor1,
            'carousel2' => $c2,
            'title2' => $title2,
            'textcolor2' => $textcolor2,
            'carousel3' => $c3,
            'title3' => $title3,
            'textcolor3' => $textcolor3,
            'carousel4' => $c4,
            'title4' => $title4,
            'textcolor4' => $textcolor4,
            'carousel5' => $c5,
            'title5' => $title5,
            'textcolor5' => $textcolor5,
            'newimage4' => $c7,
            'newimage5' => $c6,
        ];

        // Save or update the setting
        $this->saveOrUpdateSetting('tradeshowhomepage', [
            'tradeshowhomepage' => $data
        ]);

        toastr()->success('Settings Updated Successfully');
        return redirect()->back()->with('success', 'Settings Updated Successfully');
    }

    public function updateQuotation(Request $request)
    {
        try {
            // Retrieve the toggle value from the request
            $quotationEnabled = $request->has('quotation_enabled') ? 1 : 0;

            // Save the quotation toggle setting
            $this->saveOrUpdateSetting('quotation_enabled', ['enabled' => $quotationEnabled]);

            return redirect()->back()->with('success', __('Quotation settings updated successfully.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('An error occurred while updating settings: ') . $e->getMessage());
        }
    }
}
