<?php

namespace App\Models\Core\Setting;

use App\Models\Core\BaseModel;
use App\Models\Core\Setting\Traits\NotificationEventRelationship;
use App\Models\Core\Setting\Traits\NotificationEventRules;
use App\Models\Core\Traits\Translate\TranslatedNameTrait;
use Illuminate\Database\Eloquent\Builder;

class NotificationEvent extends BaseModel
{
    protected $appends = ['translated_name'];

    use NotificationEventRelationship, NotificationEventRules;

    public function getTranslatedNameAttribute()
    {
        $explode = explode('_', $this->name);
        return trans('default.notification_event_name', [
            'name' => trans('default.'.$explode[0]),
            'action' => trans('default.notification_'.(isset($explode[1]) ? $explode[1] : '')),
        ]);
    }

}
