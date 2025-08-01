<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ArcdevPackages\Core\Traits\UtilsTrait;
use ArcdevPackages\Core\Models\WelcomePageSettings;
use ArcdevPackages\Core\Models\Organizer;
use App\Models\User;

class WelcomePageController extends Controller
{
    use UtilsTrait;
    use ValidatesRequests;

    private function checkIfAdmin($user){
        return (!empty($user->super_admin) || $user->hasRole('super_admin') || $user->hasRole('admin')) ? true : false;
    }

    private function getWelcomePageSettingsDetail($organizer_id, $param){
        if (!empty($organizer_id) && !empty($param)) {
            return json_decode(optional(
                WelcomePageSettings::where('organizer_id', $organizer_id)->first()
            )->$param);
        }else{
            return null;
        }
        
    }

    public function welcomeSettings(){
        if(Auth::user() == null){
            Auth::logout();
            return redirect('/login');
        }

        $user = User::find(Auth::user()->id);

        if($user && $this->checkIfAdmin($user)){
            return Inertia::render('WelcomeSettings');
        }else{
            return Inertia::render('Unauthorized');
        } 
    }

    public function getMainBanner(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['main_banner'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'main_banner');
        }

    	return response()->json($data);
    }

    public function saveMainBanner(Request $request){
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }

        $old_data = json_decode($welcome_page_settings->main_banner, true);
        $old_data['hide_logo']              = !empty($request->hide_logo) ? 1 : 0;
        $old_data['banner_text']            = !empty($request->banner_text) ? $this->clearChars($request->banner_text) : null;
        $old_data['header']                 = !empty($request->header) ? $this->clearChars($request->header) : null;
        $old_data['footer_text']            = !empty($request->footer_text) ? $this->clearChars($request->footer_text) : null;
        $old_data['main_text']              = !empty($request->main_text) ? $this->clearChars($request->main_text) : null;
        $old_data['sub_text']               = !empty($request->sub_text) ? $this->clearChars($request->sub_text) : null;
        $old_data['header_menu_text']       = !empty($request->header_menu_text) ? $this->clearChars($request->header_menu_text) : null;
        
        if(empty($welcome_page_settings->main_banner) ){
            $welcome_page_settings->main_banner = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $main_banner = !empty($welcome_page_settings->main_banner) ? json_decode($welcome_page_settings->main_banner) : null;
         
        if(!empty($request->delete_banner_url)){
            if(!empty($main_banner->banner_url)){
                $welcome_page_settings->deleteImageLink($main_banner->banner_url, $main_banner->banner_thumb_url);
                $old_data['banner_url']       = null;
                $old_data['banner_thumb_url'] = null;
            }
        }else{
            if(!empty($main_banner)){
                if($request->hasFile('banner_url')){
                    if(!empty($main_banner->banner_url)){
                        $welcome_page_settings->deleteImageLink($main_banner->banner_url, $main_banner->banner_thumb_url);
                        $old_data['banner_url']       = null;
                        $old_data['banner_thumb_url'] = null;
                    }
                    
                    $uploadProfileRes = $welcome_page_settings->uploadMainBanner($request);
                    $old_data['banner_url']       = $uploadProfileRes['banner_url'];
                    $old_data['banner_thumb_url'] = $uploadProfileRes['banner_thumb_url'];
                }
            }
        }

        if(!empty($request->delete_header_logo_url)){
            if(!empty($main_banner->header_logo_url)){
                $welcome_page_settings->deleteImageLink($main_banner->header_logo_url);
                $old_data['header_logo_url']       = null;
            }
        }else{
            if(!empty($main_banner)){
                if($request->hasFile('header_logo_url')){
                    if(!empty($main_banner->header_logo_url)){
                        $welcome_page_settings->deleteImageLink($main_banner->header_logo_url);
                        $old_data['header_logo_url']       = null;
                    }
                    
                    $uploadProfileRes = $welcome_page_settings->uploadHeaderLogo($request);
                    $old_data['header_logo_url']       = $uploadProfileRes['header_logo_url'];
                }
            }
        }
        
        if(!empty($request->delete_overlay_url)){
            if(!empty($main_banner->overlay_url)){
                $welcome_page_settings->deleteImageLink($main_banner->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($main_banner)){
                if($request->hasFile('overlay_url')){
                    if(!empty($main_banner->overlay_url)){
                        $welcome_page_settings->deleteImageLink($main_banner->overlay_url, null);
                    }
                    
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data = json_decode($welcome_page_settings->main_banner, true);
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->main_banner = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getOverview(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['overview'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'overview');
        }

    	return response()->json($data);
    }

    public function saveOverview(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }

        $old_data = json_decode($welcome_page_settings->overview, true);
        $old_data['top_sub_text']          = isset($input['top_sub_text'])?$this->clearChars($input['top_sub_text']):null;
        $old_data['main_text']             = isset($input['main_text'])?$this->clearChars($input['main_text']):null;
        $old_data['sub_text']              = isset($input['sub_text'])?$this->clearChars($input['sub_text']):null;
        $old_data['buttons']               = isset($input['buttons'])?json_decode($input['buttons']):[];

        if(empty($welcome_page_settings->overview) ){
            $welcome_page_settings->overview = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $overview = !empty($welcome_page_settings->overview) ? json_decode($welcome_page_settings->overview) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($overview->overlay_url)){
                $welcome_page_settings->deleteImageLink($overview->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($overview)){
                if($request->hasFile('overlay_url')){
                    if(!empty($overview->overlay_url)){
                        $welcome_page_settings->deleteImageLink($overview->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        if(!empty($input['slides']) ){
            $slides = json_decode($input['slides']);

            foreach($slides as $key => $slide){
                if(!empty($input['slide'.$key]) && $request->hasFile('slide'.$key)){
                    if(!empty($old_data['slides']) && !empty($old_data['slides'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['slides'][$key]['bg'], null);
                        $old_data['slides']['bg'] = null;
                    }

                    $slide->bg = $welcome_page_settings->updateSlideImage($request, 'slide'.$key, 'overview');
                    
                }else if(!empty($input['existing_slide'.$key])){
                    $slide->bg = $input['existing_slide'.$key];
                }

                if(!empty($slide->delete_bg)){
                    $welcome_page_settings->deleteImageLink($slide->bg, null);
                    $slide->bg = null;
                }
            }

            $old_data['slides'] = $slides;
        }else{
            $old_data['slides']  = [];
        }

        $welcome_page_settings->overview = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getMainCategories(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['main_categories'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'main_categories');
        }

    	return response()->json($data);
    }

    public function saveMainCategories(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->main_categories, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";

        if(!empty($input['links']) ){
            $links = json_decode($input['links']);

            foreach($links as $key => $link){   
                if(!empty($input['link'.$key]) && $request->hasFile('link'.$key)){

                    if($request->file('link'.$key) != null && $request->file('link'.$key)->getSize() > 5242880){
                        throw ValidationException::withMessages(['links' => 'The image cannot exceed 5MB']);
                    }

                    if(!empty($old_data['links']) && !empty($old_data['links'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['links'][$key]['bg'], null);
                        $old_data['links']['bg'] = null;
                    }

                    $link->bg = $welcome_page_settings->updateLinkImage($request, 'link'.$key);
                    
                }else if(!empty($input['existing_link'.$key])){
                    $link->bg = $input['existing_link'.$key];
                }
       
                if(!empty($link->delete_bg) && !empty($link->bg)){
                    if(!empty($old_data['links']) && !empty($link->bg)){
                        $welcome_page_settings->deleteImageLink($link->bg, null);
                        $link->bg = null;
                    }
                }
            }

            $old_data['links'] = $links;
        }else{
            $old_data['links']  = [];
        }
     
        $welcome_page_settings->main_categories = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getCarouselSliders(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['carousel_sliders'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'carousel');
        }

    	return response()->json($data);
    }

    public function saveCarouselSliders(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                                = json_decode($welcome_page_settings->carousel, true);
        $old_data['header']                      = !empty($input['header']) ? $input['header'] : "";
        $old_data['main_text']                   = !empty($input['main_text']) ? $input['main_text'] : "";

        if(!empty($input['slides']) ){
            $slides = json_decode($input['slides']);

            foreach($slides as $key => $slide){
                if(!empty($input['slide'.$key]) && $request->hasFile('slide'.$key)){
                    if(!empty($old_data['slides']) && !empty($old_data['slides'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['slides'][$key]['bg'], null);
                        $old_data['slides']['bg'] = null;
                    }

                    $slide->bg = $welcome_page_settings->updateSlideImage($request, 'slide'.$key);
                    
                }else if(!empty($input['existing_slide'.$key])){
                    $slide->bg = $input['existing_slide'.$key];
                }

                if(!empty($slide->delete_bg)){
                    $welcome_page_settings->deleteImageLink($slide->bg, null);
                    $slide->bg = null;
                }
            }

            $old_data['slides'] = $slides;
        }else{
            $old_data['slides']  = [];
        }
     
        $welcome_page_settings->carousel = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getAboutUs(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['about_us'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'about_us');
        }

    	return response()->json($data);
    }

    public function saveAboutUs(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }

        $old_data = json_decode($welcome_page_settings->about_us, true);

        $old_data['top_sub_text']          = isset($input['top_sub_text'])?$this->clearChars($input['top_sub_text']):null;
        $old_data['main_text']             = isset($input['main_text'])?$input['main_text']:null;
        $old_data['sub_text']              = isset($input['sub_text'])?$this->clearChars($input['sub_text']):null;
        $old_data['header']                = isset($input['header'])?$this->clearChars($input['header']):null;
        $old_data['team_leader_name']      = isset($input['team_leader_name'])?$this->clearChars($input['team_leader_name']):null;
        $old_data['team_leader_position']  = isset($input['team_leader_position'])?$this->clearChars($input['team_leader_position']):null;
     
        if(!empty($input['team_leader_profile_url']) && $request->hasFile('team_leader_profile_url')){
            if($request->file('team_leader_profile_url') != null && $request->file('team_leader_profile_url')->getSize() > 5242880){
                throw ValidationException::withMessages(['team_leader_profile_url' => 'The image cannot exceed 5MB']);
            }

            if(!empty($old_data['team_leader_profile_url']) && !empty($old_data['team_leader_profile_url'])){
                $welcome_page_settings->deleteImageLink($old_data['team_leader_profile_url'], null);
                $old_data['team_leader_profile_url'] = null;
            }

            $old_data['team_leader_profile_url'] = $welcome_page_settings->updateAboutUsImage($request, 'team_leader_profile_url');
        }

        if(!empty($request->delete_leader_profile_image) && !empty($old_data['team_leader_profile_url'])){
            $welcome_page_settings->deleteImageLink($old_data['team_leader_profile_url'], null);
            $old_data['team_leader_profile_url'] = null;
        }
       
        if(!empty($input['team_members']) ){
            $team_members = json_decode($input['team_members']);

            foreach($team_members as $key => $team_member){   
                if(!empty($input['team_member'.$key]) && $request->hasFile('team_member'.$key)){

                    if($request->file('team_member'.$key) != null && $request->file('team_member'.$key)->getSize() > 5242880){
                        throw ValidationException::withMessages(['team_members' => 'The image cannot exceed 5MB']);
                    }

                    if(!empty($old_data['team_members']) && !empty($old_data['team_members'][$key]['profile_url'])){
                        $welcome_page_settings->deleteImageLink($old_data['team_members'][$key]['profile_url'], null);
                        $old_data['team_members']['profile_url'] = null;
                    }

                    $team_member->profile_url = $welcome_page_settings->updateAboutUsImage($request, 'team_member'.$key);
                    
                }else if(!empty($input['existing_profile'.$key])){
                    $team_member->profile_url = $input['existing_profile'.$key];
                }
       
                if(!empty($team_member->delete_profile_image) && !empty($team_member->profile_url)){
                    if(!empty($old_data['team_members']) && !empty($team_member->profile_url)){
                        $welcome_page_settings->deleteImageLink($team_member->profile_url, null);
                        $team_member->profile_url = null;
                    }
                }
            }
            $old_data['team_members'] = $team_members;
        }else{
            $old_data['team_members']  = [];
        }

        if(empty($welcome_page_settings->about_us) ){
            $welcome_page_settings->about_us = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $about_us = !empty($welcome_page_settings->about_us) ? json_decode($welcome_page_settings->about_us) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($about_us->overlay_url)){
                $welcome_page_settings->deleteImageLink($about_us->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($about_us)){
                if($request->hasFile('overlay_url')){
                    if(!empty($about_us->overlay_url)){
                        $welcome_page_settings->deleteImageLink($about_us->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->about_us = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getGallerySwipers(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['gallery_swipers'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'swiper_gallery');
        }

    	return response()->json($data);
    }

    public function saveGallerySwipers(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->swiper_gallery, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";
     
        if(!empty($input['slides']) ){
            $slides = json_decode($input['slides']);

            foreach($slides as $key => $slide){
                if(!empty($input['slide'.$key]) && $request->hasFile('slide'.$key)){
                    if(!empty($old_data['slides']) && !empty($old_data['slides'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['slides'][$key]['bg'], null);
                        $old_data['slides']['bg'] = null;
                    }

                    $slide->bg = $welcome_page_settings->updateSwiperImage($request, 'slide'.$key);
                    
                }else if(!empty($input['existing_slide'.$key])){
                    $slide->bg = $input['existing_slide'.$key];
                }

                if( !empty($input['slides'][$key]) && !empty($input['slides'][$key]['delete_bg']) ){
                    $welcome_page_settings->deleteImageLink($input['slides'][$key]['bg'], null);
                    $old_data['slides']['bg'] = null;
                }
            }

            $old_data['slides'] = $slides;
        }else{
            $old_data['slides']  = [];
        }
     
        if(empty($welcome_page_settings->swiper_gallery) ){
            $welcome_page_settings->swiper_gallery = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $swiper_gallery = !empty($welcome_page_settings->swiper_gallery) ? json_decode($welcome_page_settings->swiper_gallery) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($swiper_gallery->overlay_url)){
                $welcome_page_settings->deleteImageLink($swiper_gallery->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($swiper_gallery)){
                if($request->hasFile('overlay_url')){
                    if(!empty($swiper_gallery->overlay_url)){
                        $welcome_page_settings->deleteImageLink($swiper_gallery->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->swiper_gallery = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getFeatures(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['features'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'features');
        }

    	return response()->json($data);
    }

    public function saveFeatures(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->features, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";

        if(!empty($input['links']) ){
            $links = json_decode($input['links']);

            foreach($links as $key => $link){   
                if(!empty($input['link'.$key]) && $request->hasFile('link'.$key)){

                    if($request->file('link'.$key) != null && $request->file('link'.$key)->getSize() > 5242880){
                        throw ValidationException::withMessages(['links' => 'The image cannot exceed 5MB']);
                    }

                    if(!empty($old_data['links']) && !empty($old_data['links'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['links'][$key]['bg'], null);
                        $old_data['links']['bg'] = null;
                    }

                    $link->bg = $welcome_page_settings->updateLinkImage($request, 'link'.$key, 'features');
                    
                }else if(!empty($input['existing_link'.$key])){
                    $link->bg = $input['existing_link'.$key];
                }
       
                if(!empty($link->delete_bg) && !empty($link->bg)){
                    if(!empty($old_data['links']) && !empty($link->bg)){
                        $welcome_page_settings->deleteImageLink($link->bg, null);
                        $link->bg = null;
                    }
                }
            }

            $old_data['links'] = $links;
        }else{
            $old_data['links']  = [];
        }
     
        if(empty($welcome_page_settings->features) ){
            $welcome_page_settings->features = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $features = !empty($welcome_page_settings->features) ? json_decode($welcome_page_settings->features) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($features->overlay_url)){
                $welcome_page_settings->deleteImageLink($features->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($features)){
                if($request->hasFile('overlay_url')){
                    if(!empty($features->overlay_url)){
                        $welcome_page_settings->deleteImageLink($features->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->features = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getBrands(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['brands'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'brands');
        }

    	return response()->json($data);
    }

    public function saveBrands(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->brands, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";

        if(!empty($input['links']) ){
            $links = json_decode($input['links']);

            foreach($links as $key => $link){   
                if(!empty($input['link'.$key]) && $request->hasFile('link'.$key)){

                    if($request->file('link'.$key) != null && $request->file('link'.$key)->getSize() > 5242880){
                        throw ValidationException::withMessages(['links' => 'The image cannot exceed 5MB']);
                    }

                    if(!empty($old_data['links']) && !empty($old_data['links'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['links'][$key]['bg'], null);
                        $old_data['links']['bg'] = null;
                    }

                    $link->bg = $welcome_page_settings->updateLinkImage($request, 'link'.$key, 'brands');
                    
                }else if(!empty($input['existing_link'.$key])){
                    $link->bg = $input['existing_link'.$key];
                }
       
                if(!empty($link->delete_bg) && !empty($link->bg)){
                    if(!empty($old_data['links']) && !empty($link->bg)){
                        $welcome_page_settings->deleteImageLink($link->bg, null);
                        $link->bg = null;
                    }
                }
            }

            $old_data['links'] = $links;
        }else{
            $old_data['links']  = [];
        }
     
        if(empty($welcome_page_settings->brands) ){
            $welcome_page_settings->brands = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $brands = !empty($welcome_page_settings->brands) ? json_decode($welcome_page_settings->brands) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($brands->overlay_url)){
                $welcome_page_settings->deleteImageLink($brands->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($brands)){
                if($request->hasFile('overlay_url')){
                    if(!empty($brands->overlay_url)){
                        $welcome_page_settings->deleteImageLink($brands->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->brands = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getFooters(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['footers'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'footers');
        }

    	return response()->json($data);
    }

    public function saveFooters(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->footers, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";

        if(!empty($input['links']) ){
            $links = json_decode($input['links']);

            foreach($links as $key => $link){   
                if(!empty($input['link'.$key]) && $request->hasFile('link'.$key)){

                    if($request->file('link'.$key) != null && $request->file('link'.$key)->getSize() > 5242880){
                        throw ValidationException::withMessages(['links' => 'The image cannot exceed 5MB']);
                    }

                    if(!empty($old_data['links']) && !empty($old_data['links'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['links'][$key]['bg'], null);
                        $old_data['links']['bg'] = null;
                    }

                    $link->bg = $welcome_page_settings->updateLinkImage($request, 'link'.$key, 'footers');
                    
                }else if(!empty($input['existing_link'.$key])){
                    $link->bg = $input['existing_link'.$key];
                }
       
                if(!empty($link->delete_bg) && !empty($link->bg)){
                    if(!empty($old_data['links']) && !empty($link->bg)){
                        $welcome_page_settings->deleteImageLink($link->bg, null);
                        $link->bg = null;
                    }
                }
            }

            $old_data['links'] = $links;
        }else{
            $old_data['links']  = [];
        }
     
        if(empty($welcome_page_settings->footers) ){
            $welcome_page_settings->footers = json_encode($old_data);
            $welcome_page_settings->update();
        }

        $footers = !empty($welcome_page_settings->footers) ? json_decode($welcome_page_settings->footers) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($footers->overlay_url)){
                $welcome_page_settings->deleteImageLink($footers->overlay_url, null);
                $old_data['overlay_url'] = null;
            }
        }else{
            if(!empty($footers)){
                if($request->hasFile('overlay_url')){
                    if(!empty($footers->overlay_url)){
                        $welcome_page_settings->deleteImageLink($footers->overlay_url, null);
                        $old_data['overlay_url'] = null;
                    }
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data['overlay_url']       = $uploadProfileRes;
                }
            }
        }

        $welcome_page_settings->footers = json_encode($old_data);
        $welcome_page_settings->update();
    }

    public function getGallery(){
        $user = User::find(Auth::user()->id);
        $data = [];
        if($user && $this->checkIfAdmin($user)){
            $data['gallery'] = $this->getWelcomePageSettingsDetail($user->organizer_id, 'gallery');
        }

    	return response()->json($data);
    }

    public function saveGallery(Request $request){
        $input = $request->all();
        $user = User::find(Auth::user()->id);
        $welcome_page_settings = WelcomePageSettings::find($user->id);

        if(empty($welcome_page_settings)){
            $welcome_page_settings = new WelcomePageSettings();
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
            $welcome_page_settings->organizer_id = Auth::user()->organizer_id;

            $welcome_page_settings->save();
        }else{
            $this->validate($request, $welcome_page_settings->rules, $welcome_page_settings->messages);
        }
        
        $old_data                               = json_decode($welcome_page_settings->gallery, true);
        $old_data['title']                      = !empty($input['title']) ? $input['title'] : "";
        $old_data['subtitle']                   = !empty($input['subtitle']) ? $input['subtitle'] : "";
     
        if(!empty($input['slides']) ){
            $slides = json_decode($input['slides']);

            foreach($slides as $key => $slide){
                if(!empty($input['slide'.$key]) && $request->hasFile('slide'.$key)){
                    if(!empty($old_data['slides']) && !empty($old_data['slides'][$key]['bg'])){
                        $welcome_page_settings->deleteImageLink($old_data['slides'][$key]['bg'], null);
                        $old_data['slides']['bg'] = null;
                    }

                    $slide->bg = $welcome_page_settings->updateSwiperImage($request, 'slide'.$key);
                    
                }else if(!empty($input['existing_slide'.$key])){
                    $slide->bg = $input['existing_slide'.$key];
                }

                if( !empty($input['slides'][$key]) && !empty($input['slides'][$key]['delete_bg']) ){
                    $welcome_page_settings->deleteImageLink($input['slides'][$key]['bg'], null);
                    $old_data['slides']['bg'] = null;
                }
            }

            $old_data['slides'] = $slides;
        }else{
            $old_data['slides']  = [];
        }
     
        $welcome_page_settings->gallery = json_encode($old_data);
        $welcome_page_settings->update();

        $gallery = !empty($welcome_page_settings->gallery) ? json_decode($welcome_page_settings->gallery) : null;

        if(!empty($input['delete_overlay_url']) && $input['delete_overlay_url'] != 'false'){
            if(!empty($gallery->overlay_url)){
                $welcome_page_settings->deleteImageLink($gallery->overlay_url, null);
                $old_data['overlay_url'] = null;
                $welcome_page_settings->gallery = json_encode($old_data);
                $welcome_page_settings->update();
            }
        }else{
            if(!empty($gallery)){
                if($request->hasFile('overlay_url')){
                    if(!empty($gallery->overlay_url)){
                        $welcome_page_settings->deleteImageLink($gallery->overlay_url, null);
                    }
                    
                    $uploadProfileRes = $welcome_page_settings->updateOverlayImage($request, 'overlay_url');
                    $old_data = json_decode($welcome_page_settings->gallery, true);

                    $old_data['overlay_url']       = $uploadProfileRes;
        
                    $welcome_page_settings->gallery = json_encode($old_data);
                    $welcome_page_settings->update();
                }
            }
        }
    }
}