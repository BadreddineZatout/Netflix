<?php


namespace App\Repositories\Core\Status;


use App\Exceptions\GeneralException;
use App\Models\Core\Status;
use App\Repositories\Core\BaseRepository;
use Illuminate\Support\Collection;

class StatusRepository extends BaseRepository
{
    public function __construct(Status $status)
    {
        $this->model = $status;
    }

    /**
     * @param string $type
     * @return mixed | Collection
     * @throws \Exception
     */
    public function statuses($type = '')
    {
        return cache()->rememberForever('status-'.$type, function () use ($type) {
            return $this->model::query()
                ->where('type', $type)
                ->get();
        });
    }

    public function __call($name, $arguments)
    {
        $status = preg_split('/(^[^A-Z]+|[A-Z][^A-Z]+)/', $name,-1, PREG_SPLIT_NO_EMPTY |
            PREG_SPLIT_DELIM_CAPTURE );

        [$type] = $status;

        if ( ($count = count($status)) > 1) {
            $q = 'status';
            for ($i = 1; $i <= $count - 1; $i++) $q .=  '_' . strtolower($status[$i]);
            return $this->getStatusId($type, $q);
        }

        $statuses = $this->statuses($type);
        if ($arguments) {
            return $statuses->whereIn('name', $arguments)
                ->pluck('name', 'id')
                ->toArray();
        }
        return $statuses;

    }

    public function getStatusId($type, $name)
    {
        $row = $this->statuses($type)
            ->firstWhere('name', $name);

        return $row ? $row->id : new GeneralException('Status Not Found');
    }
}
