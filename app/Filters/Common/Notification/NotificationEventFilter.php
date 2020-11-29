<?php


namespace App\Filters\Common\Notification;


use App\Filters\Common\FilterContact;
use App\Helpers\Core\Traits\InstanceCreator;
use Illuminate\Database\Eloquent\Builder;

class NotificationEventFilter extends FilterContact
{
    use InstanceCreator;

    function filter(): Builder
    {
        return $this->query->with(['templates:id,subject,type', 'settings', 'settings.audiences']);
    }

}
