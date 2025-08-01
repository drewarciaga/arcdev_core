<?php

namespace ArcdevPackages\Core\Models;

use Illuminate\Support\Str;
use ArcdevPackages\Core\Enums\SubscriptionType;

class OrganizerSetting extends MyBaseModel
{
    public $timestamps = false;

    protected $appends = [
        'subscription_type_text'
    ];

    protected $casts = [
        'modules'               => 'array',
        'subscription_type'     => SubscriptionType::class,
        'subscription_start'    => 'date:M-d-y',
        'subscription_end'      => 'date:M-d-y',
    ];
    protected $fillable = [
        'organizer_id',
        'subscription_start',
        'subscription_end',
        'subscription_length',
        'subscription_type',
        'subscription_amount',
        'remarks',
        'modules',
    ];

    public $rules = [
        
    ];

    public $messages = [
        'required' => 'The :attribute field is required.',
    ];

    public function getSubscriptionTypeTextAttribute(){
        return !is_null($this->subscription_type) ? $this->subscription_type->label() : "";
    }
}