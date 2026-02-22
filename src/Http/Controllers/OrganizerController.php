<?php

namespace ArcdevPackages\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

use ArcdevPackages\Core\Helpers\Encrypt;
use ArcdevPackages\Core\Helpers\HashHelper;
use ArcdevPackages\Core\Traits\UtilsTrait;
use ArcdevPackages\Core\Models\Organizer;

class OrganizerController extends Controller
{
    use UtilsTrait;
    use ValidatesRequests;

    public function index(){
        if(!Auth::user()->super_admin){
            return Inertia::render('Unauthorized');
        }
        
        return Inertia::render('Organizers/Index');
    }

    public function organizerProfile(){
        $organizer = Organizer::find(Auth::user()->organizer_id);

        if(!empty($organizer)){
            return Inertia::render('Organizers/AddEdit', [
                'from_profile'      => true,
                'organizer_id'      => $organizer->hashid,
                'action'            => 'Edit',
            ]);
        }else{
            return Inertia::render('Unauthorized');
        }
    }
    
    public function getOrganizerList(){
        $organizersList = Organizer::select('id', 'id as value', 'business_name as label')->active()->orderBy('business_name')->get();

        foreach($organizersList as $organizer){
            $organizer->value = $organizer->hashid;
            unset($organizer->hashid);
        }

        return response()->json(Encrypt::encryptData($organizersList));
    }

    public function getAll(Request $request){
        $page = 1;
        $itemsPerPage = 20;
        $offset = 0;
        $total = 0;
        $sortBy = 'business_name';
        $sortDesc = 'ASC';
        $search = "";
        $filters = null;

        if(!empty($request->page)){
            $page = $request->page;
        }
        if(!empty($request->itemsPerPage)){
            $itemsPerPage = $request->itemsPerPage;
        }
        if(!empty($request->page) && !empty($request->itemsPerPage)){
            if($request->itemsPerPage != -1){
                $offset = ($page - 1) * $itemsPerPage;
            }
        }
        if(!empty($request->search)){
            $search = $request->search;
        }
        if(!empty($request->sortBy)){
            $sortBy = $request->sortBy;
        }
        if(!empty($request->sortDesc)){
            $sortDesc = $request->sortDesc;
        }

        if(!empty($request->filters)){
            $filters = json_decode($request->filters);
        }

        $org_ids = [];
        if(!Auth::user()->super_admin){
            $org_ids[] = Auth::user()->organizer_id;
        }

        $organizerTable = (new Organizer())->getTable();

        $columns = [
            'id',
            'business_name',
            'first_name',
            'last_name',
            'domain_name',
            'slug',
            'thumbnail_url',
            'profile_thumb_url',
            'organizer_type',
            'active',
        ];

        if (Schema::hasColumn($organizerTable, 'venue_id')) {
            $columns[] = 'venue_id';
        }

        $organizers = Organizer::select($columns)
            ->when(!empty($org_ids), function ($query) use ($org_ids) {
                return $query->whereIn('id', $org_ids);
            });

        if(isset($filters->active)){
            $organizers->where('organizers.active', $filters->active);
        }


        if(!empty($search)){
            $organizers = $organizers->where(function($query) use ($search){
                $query->where('organizers.business_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('organizers.first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('organizers.last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(first_name," ",last_name)'), 'LIKE', '%'.$search.'%')
                        ->orWhere(DB::raw('CONCAT(last_name," ",first_name)'), 'LIKE', '%'.$search.'%');
            });
        }

        $total = $organizers->count();

        if($itemsPerPage != -1){
            $organizers = $organizers->offset($offset)->limit($itemsPerPage);
        }

        if($sortBy == 'type_text'){
            $sortBy = 'organizer_type';
        }

        $organizers = $organizers->orderBy('organizers.'.$sortBy,$sortDesc)->get();

    	return response()->json([
            'status'     => 200,
            'data'       => Encrypt::encryptData($organizers),
            'total'      => $total, 
        ]);
    }

    public function show($hashid){
        $id = HashHelper::decodeId($hashid);
        $organizer = Organizer::find($id);
        
        if(!empty($organizer)){
            if(!empty($organizer->social_media_data)){
                $social_media_list = config('dropdown.social_media_list');

                $socmeds = json_decode($organizer->social_media_data);
                foreach($socmeds as $key => $socmed){
                    $socmed->type_text = isset($social_media_list[$socmed->type]) ? $social_media_list[$socmed->type] : "";
                }
                $organizer->social_media_data = json_encode($socmeds);
            }
        }

    	return response()->json(Encrypt::encryptData($organizer));
    }

    public function create(){
        return Inertia::render('Organizers/AddEdit', [
            'action' => 'Add',
        ]);
    }

    public function mapModel($organizer, $input){
        $business_name = '';
        if($input['organizer_type'] == 1){
            if(!empty($input['first_name'])){
                $business_name = $input['first_name'];
            }
            if(!empty($input['middle_name'])){
                $business_name .= ' ' . Str::upper(substr($input['middle_name'], 0, 1)) . '.';
            }
            if(!empty($input['last_name'])){
                $business_name .= ' ' . $input['last_name'];
            }
            $organizer->business_name         = $this->clearChars($business_name);
        }else{
            $organizer->business_name         = isset($input['business_name']) ? $this->clearChars($input['business_name']) : null;
        }

        $organizer->first_name                = $this->clearChars($input['first_name']);
        $organizer->last_name                 = $this->clearChars($input['last_name']);
        $organizer->middle_name               = isset($input['middle_name']) ? $this->clearChars($input['middle_name']) : null;
        $organizer->domain_name               = isset($input['domain_name'])?$input['domain_name']:null;
        $organizer->email                     = isset($input['email'])?$input['email']:null;
        $organizer->mobile_no                 = isset($input['mobile_no'])?$this->clearChars($input['mobile_no']):null;
        $organizer->mobile_no_2               = isset($input['mobile_no_2'])?$this->clearChars($input['mobile_no_2']):null;
        $organizer->business_address          = isset($input['business_address'])?$this->clearChars($input['business_address']):null;
        $organizer->social_media_data         = isset($input['social_media_data'])?$input['social_media_data']:null;
        $organizer->active                    = (isset($input['active']) && $input['active'] == 1) ? 1 : 0;
        $organizer->organizer_type            = (isset($input['organizer_type']) && $input['organizer_type'] == 1) ? 1 : 0;
        $organizer->remarks                   = isset($input['remarks'])?$this->clearChars($input['remarks']):"";
        $organizer->slug                      = isset($input['slug']) ? $this->clearChars($input['slug']) : null;

        if (Schema::hasColumn($organizer->getTable(), 'venue_id')) {
            $organizer->venue_id = isset($input['venue_id']) ? $input['venue_id'] : null;
        }
       
        return $organizer;
    }

    public function store(Request $request){
        $input = $request->all();

        $organizer = new Organizer();

        $this->validate($request, $organizer->rules, $organizer->messages);

        $organizer = $this->mapModel($organizer, $input);

        $organizer->save();

        if ($organizer && $request->hasFile('image_url')) {
            $uploadProfileRes = $organizer->uploadImageUrl($request);
        }

        if ($organizer && $request->hasFile('profile_url')) {
            $uploadProfileRes = $organizer->uploadProfileUrl($request);
        }

        return response()->json($organizer);
    }

    public function edit($id){
        return Inertia::render('Organizers/AddEdit', [
            'organizer_id'      => $id,
            'action'            => 'Edit',
        ]);
    }

    public function update(Request $request, $hashid){
        $id = HashHelper::decodeId($hashid);
        $input = $request->all();

        $organizer = Organizer::findOrFail($id);
        $organizer->rules['business_name'] = 'required_if:organizer_type,0|max:200|unique:organizers,business_name,'. $id . ',id';

        $this->validate($request, $organizer->rules, $organizer->messages);

        $organizer = $this->mapModel($organizer, $input);
        unset($organizer['hashid']);
        $organizer->update();
      
        if(!empty($request->delete_image_url)){
            $organizer->deleteImage($organizer->image_url, $organizer->thumbnail_url);
            $organizer->image_url = null;
            $organizer->thumbnail_url = null;
            $organizer->update();
        }else{
            if ($organizer && $request->hasFile('image_url')) {
                $uploadProfileRes = $organizer->uploadImageUrl($request);
            }
        }

        if(!empty($request->delete_profile_url)){
            $organizer->deleteImage($organizer->profile_url, $organizer->profile_thumb_url);
            $organizer->profile_url = null;
            $organizer->profile_thumb_url = null;
            $organizer->update();
        }else{
            if ($organizer && $request->hasFile('profile_url')) {
                $uploadProfileRes = $organizer->uploadProfileUrl($request);
            }
        }

        return response()->json($organizer);
    }

    public function destroy($hashid){
        $id = HashHelper::decodeId($hashid);
        $data['error'] = "";
        $organizer = Organizer::find($id);
        if(empty($organizer)){
            $data['error'] .= "Cannot find Organizer";
            return json_encode($data);
        }

        $products_count = 0;


        if($products_count > 0){
            $data['error'] .= "Cannot delete, This Organizer is used in games";
            return json_encode($data);
        }else{
            $organizer->deleteImage($organizer->image_url, $organizer->thumbnail_url);
            $organizer->deleteImage($organizer->profile_url, $organizer->profile_thumb_url);
            $organizer->forceDelete();
        }

        return response()->json('Delete Organizer Successful!');
    }

    public function getOrganizerLogo(){
        $currentDomain = request()->getHost();

        if($currentDomain == 'arcdevbuilder'){
            if(Auth::check()){
                $organizer = Organizer::select('image_url', 'thumbnail_url')->where('id', Auth::user()->organizer_id)->first();
            }else{
                $organizer = Organizer::select('image_url', 'thumbnail_url')->first();
            }
            
        }else{
            $organizer = Organizer::select('image_url', 'thumbnail_url')->where('domain_name', $currentDomain)->first();
        }

        if(!empty($organizer)){
            return response()->json($organizer);
        }else{
            return response()->json([
                'logo'     => 1,
            ]);
        }
    }
}