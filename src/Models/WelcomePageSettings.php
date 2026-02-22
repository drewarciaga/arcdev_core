<?php


namespace ArcdevPackages\Core\Models;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use ArcdevPackages\Core\Models\MyBaseModel;
use Illuminate\Support\Facades\Auth;


class WelcomePageSettings extends MyBaseModel
{
    public $timestamps = false;
    /*protected $fillable = [
        'user_id',
        'main_banner',
        'overview',
        'carousel',
        'features',
        'services',
        'about_us',
        'topics',
        'swiper_gallery',
        'gallery',
        'brands',
        'footers',
        'virtual_tours',
    ];*/

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'description'        => 'max:2000',
        'banner_url'         => 'image|mimes:jpeg,bmp,png,webp|max:7000',
        'overlay_url'        => 'image|mimes:jpeg,bmp,png,webp|max:7000'
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'required_without'    => 'The :attribute field is required.',
        'required'            => 'The :attribute field is required.',
        'numeric'             => 'The :attribute field is invalid.',
        'banner_url.image'    => 'The :attribute should be an image.',
        'banner_url.uploaded' => 'The :attribute cannot exceed 5MB.',
    ];

    public function uploadMainBanner($request){
        $status = "success";
        $folder = 'welcome_page/main_banner';

        $company_config = config(config('app_client.config_file'), []);

        //delete existing image first
        $banner_height = !empty($company_config['banner_height']) ? $company_config['banner_height'] : 1900;

        $url = $this->uploadImage($request, 'banner_url', $folder, $banner_height, 'main_banner_img');
        if(!empty($url)){
            if($url == 'error'){
                $status = "error";
            }else{
                $image_url     = $url;
                $thumbnail_url = '';

                if(!empty($image_url)){
                    $thumbUrl = $this->createThumbnail($request, 'banner_url', $folder, 150, 'main_banner_img');
                    if($thumbUrl == 'error'){
                        $status = "error";
                    }else{
                        $thumbnail_url = $thumbUrl;
                    }
                }
            }

            $old_data = json_decode($this->main_banner, true);

            $old_data['banner_url']       = $image_url;
            $old_data['banner_thumb_url'] = $thumbnail_url;

        }

        return $old_data;
    }

    public function uploadHeaderLogo($request){
        $status = "success";
        $folder = 'welcome_page/main_banner';

        $url = $this->uploadImage($request, 'header_logo_url', $folder, 1900, 'header_logo_img');
        if(!empty($url)){
            if($url == 'error'){
                $status = "error";
            }else{
                $image_url     = $url;
            }

            $old_data = json_decode($this->main_banner, true);
            $old_data['header_logo_url']       = $image_url;
        }

        return $old_data;
    }

    public function deleteImageLink($image_path, $thumb_path = null){
        $local_storage = "local";

        if(!empty($image_path)){
            $image_path = str_replace("\\","/",$image_path);
 
            if(Storage::disk($local_storage)->exists($image_path)){
                Storage::disk($local_storage)->delete($image_path);
            }

            if(Storage::disk('local5')->exists($image_path)){
                Storage::disk('local5')->delete($image_path);
            } 
        }

        if(!empty($thumb_path)){
            $thumb_path = str_replace("\\","/",$thumb_path);
 
            if(Storage::disk($local_storage)->exists($thumb_path)){
                Storage::disk($local_storage)->delete($thumb_path);
            }

            if(Storage::disk('local5')->exists($thumb_path)){
                Storage::disk('local5')->delete($thumb_path);
            } 
        }

        $old_data = json_decode($this->main_banner, true);

        //$old_data['banner_url']       = null;
        //$old_data['banner_thumb_url'] = null;

        $this->main_banner = json_encode($old_data);
        $this->update();
    }

    public function updateLinkImage($request, $type, $folder_name = null, $customSize = 800){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/main_categories';

        if(!empty($folder_name)){
            $folder = 'welcome_page/' . $folder_name;
        }
        
        $name   = $type;
        $size   = $customSize;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . '-' . $this->id . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
            $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');

            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
            
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }

    public function updateSlideImage($request, $type){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/carousel';
        $name   = $type;
        $size   = 1200;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
            $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');
    
            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }

    public function updateSwiperImage($request, $type){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/swiper';
        $name   = $type;
        $size   = 1200;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
            $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');
    
            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }

    public function updateOverlayImage($request, $type){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/overlay_images';
        $name   = $type;
        $size   = 1200;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
            $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');
    
            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }

    public function updateAboutUsImage($request, $type){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/about_us';
        $name   = $type;
        $size   = 900;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
            $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');
    
            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }

    private function storeImage($file_path, $local_storage, $file, $size){
        if (Storage::disk('local5')->exists($file_path)) {
            Storage::delete($file_path);
        }

        /* if( system_settings('s3_storage') ){
            $local_storage = "s3";
        }else{
            $local_storage = "local";
        }*/
        
        Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
        $url   = Storage::disk($local_storage)->url($file_path);
    
        $image = $manager->read(Storage::disk($local_storage)->get($file_path));
        $image->scale(height: $size);

        $image = $image->toWebp();

        Storage::disk($local_storage)->put($file_path, $image, 'public');

        if( $local_storage == "local" ){
            $url = str_replace("/storage", "/organizer_content", $url);
        }

        return $url;
    }

    public function updateMenuImage($request, $type){
        $manager = new ImageManager(new Driver());
        $status = "success";
        $folder = 'welcome_page/menu';
        $name   = $type;
       // $size   = 1200;

        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
            $filename  = Str::slug($name) . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/' . $filename;
    
            if (Storage::disk('local5')->exists($file_path)) {
                Storage::delete($file_path);
            }

           /* if( system_settings('s3_storage') ){
                $local_storage = "s3";
            }else{
                $local_storage = "local";
            }*/
            
            Storage::disk($local_storage)->put($file_path, file_get_contents($file), 'public');
            $url   = Storage::disk($local_storage)->url($file_path);
      
            $image = $manager->read(Storage::disk($local_storage)->get($file_path));
          //  $image->scale(height: $size);

            $image = $image->toWebp();

            Storage::disk($local_storage)->put($file_path, $image, 'public');
    
            if( $local_storage == "local" ){
                $url = str_replace("/storage", "/user_content", $url);
            }
        }catch(\Exception $e){
            return "error";
        }
        
        return $url;
    }
}