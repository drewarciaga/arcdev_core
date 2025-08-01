<?php

namespace ArcdevPackages\Core\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenuGrid extends Model
{
    public $timestamps = false;
    
    protected $table = 'admin_menu_grids';
    /*protected $fillable = [
        'layouts',
        'user_id'
    ];*/

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}