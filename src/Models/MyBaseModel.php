<?php

namespace ArcdevPackages\Core\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MyBaseModel extends \Illuminate\Database\Eloquent\Model
{
    public function uploadImage($request, $type, $folder, $size, $name){
        $manager = new ImageManager(new Driver());
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

    public function createThumbnail($request, $type, $folder, $size, $name){
        $manager = new ImageManager(new Driver());
        $url = null;

        try{
            $local_storage = "local";
            $file      = $request->file($type);
            $randomDigit = rand(100,999);
    
            $filename  = Str::slug($name) . '-' . $this->id . date('jnGi') . $randomDigit . '.' . 'webp';
            $file_path = 'app_img' . '/' . $folder . '/thumbnails' . '/' .$filename;
    
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

    public function deleteImage($image_path = null, $thumnail_path = null){
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
        
        if(!empty($thumnail_path)){
            $thumnail_path = str_replace("\\","/",$thumnail_path);
            if(Storage::disk($local_storage)->exists('/'.$thumnail_path)){
                Storage::disk($local_storage)->delete($thumnail_path);
            }

            if(Storage::disk('local5')->exists('/'.$thumnail_path)){
                Storage::disk('local5')->delete($thumnail_path);
            }
        }
    }
}