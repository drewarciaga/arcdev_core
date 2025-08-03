<?php

namespace ArcdevPackages\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use ArcdevPackages\Core\Traits\HashidTrait;
use ArcdevPackages\Core\Enums\OrganizerType;

class Organizer extends MyBaseModel
{
    public $timestamps = false;
    use HashidTrait;
    use SoftDeletes;

    protected $hidden = [
        'id'
    ];

    protected $appends = [
        'full_name', 'type_text'
    ];

    protected $casts = [
        'social_media_data' => 'array',
        'organizer_type' => OrganizerType::class,
    ];

    protected $fillable = [
        'business_name',
        'first_name',
        'last_name',
        'middle_name',
        'domain_name',
        'email',
        'mobile_no',
        'mobile_no_2',
        'business_address',
        'image_url',
        'thumbnail_url',
        'profile_url',
        'profile_thumb_url',
        'social_media_data',
        'remarks',
        'organizer_type',
        'active',
        'slug',
    ];

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    
    public $rules = [
        'business_name'      => 'required_if:organizer_type,0|max:200|unique:organizers',
        'first_name'         => 'required|max:200',
        'last_name'          => 'required|max:200',
        'middle_name'        => 'max:200',
        'remarks'            => 'max:2000',
        'image_url'          => 'image|mimes:jpeg,bmp,png,webp|max:2000',
        'email'              => 'required|email',
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'required_without'          => 'The :attribute field is required.',
        'required'                  => 'The :attribute field is required.',
        'numeric'                   => 'The :attribute field is invalid.',
        'image_url.image'           => 'The :attribute should be an image.',
        'image_url.uploaded'        => 'The :attribute cannot exceed 2MB.',
        'business_name.required_if' => 'The :attribute is required if organizer type is business',
    ];

    public function uploadImageUrl($request){
        $status = "success";
        $folder = 'organizers/'.$this->hashid;
        $image_url = null;
        $thumbnail_url = null;
     
        //delete existing image first
        $this->deleteImage($this->image_url, $this->thumbnail_url);

        $url = $this->uploadImage($request, 'image_url', $folder, 800, 'organizer_profile');
        if(!empty($url)){
            if($url == 'error'){
                $status = "error";
            }else{
                $this->image_url = $url;

                if(!empty($this->image_url)){
                    $thumbUrl = $this->createThumbnail($request, 'image_url', $folder, 500, 'organizer_profile');
                    if($thumbUrl == 'error'){
                        $status = "error";
                    }else{
                        $this->thumbnail_url = $thumbUrl;
                    }
                }
            }
            $this->update();
        }

        return $status;
    }

    public function uploadProfileUrl($request){
        $status = "success";
        $folder = 'organizers/'.$this->hashid;
     
        //delete existing image first
        $this->deleteImage($this->profile_url, $this->profile_thumb_url);

        $url = $this->uploadImage($request, 'profile_url', $folder, 800, 'organizer_profile');
        if(!empty($url)){
            if($url == 'error'){
                $status = "error";
            }else{
                $this->profile_url = $url;

                if(!empty($this->profile_url)){
                    $thumbUrl = $this->createThumbnail($request, 'profile_url', $folder, 500, 'organizer_profile');
                    if($thumbUrl == 'error'){
                        $status = "error";
                    }else{
                        $this->profile_thumb_url = $thumbUrl;
                    }
                }
            }
            $this->update();
        }

        return $status;
    }

    public function scopeActive($query){
        $query->where('active', 1);
    }

    public function getFullNameAttribute(){
        $fullName = '';
        if(!empty($this->first_name)){
            $fullName = $this->first_name;
        }
        if(!empty($this->middle_name)){
            $fullName .= ' ' . Str::upper(substr($this->middle_name, 0, 1)) . '.';
        }
        if(!empty($this->last_name)){
            $fullName .= ' ' . $this->last_name;
        }

        return $fullName;
    }

    public function getTypeTextAttribute(){
        return !is_null($this->organizer_type) ? $this->organizer_type->label() : "";
    }
}