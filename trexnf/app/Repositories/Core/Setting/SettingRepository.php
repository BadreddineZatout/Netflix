<?php


namespace App\Repositories\Core\Setting;


use App\Models\Core\Setting\Setting;
use App\Repositories\Core\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SettingRepository extends BaseRepository
{
    /**
     * SettingRepository constructor.
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    public function getFormattedSettings($context = 'app', $settingable_type = null, $settingable_id = null)
    {
        return $this->formatSettings(
            $this->basicQuery($context, $settingable_type, $settingable_id)
                ->get(['id','name', 'value'])
        );
    }

    public function findAppSettingWithName(string $name, string $context = 'app')
    {
        return $this->basicQuery($context, null, null)
            ->where('name', $name)
            ->first();
    }

    public function createSettingInstance(string $name, string $context, $settingable_type = null, $settingable_id = null)
    {
        return $this->basicQuery($context, $settingable_type, $settingable_id)
            ->where('name', $name)
            ->firstOrNew();
    }

    public function formatSettings(Collection $settings, $decrypt = false)
    {
        return $settings->reduce(function ($final, $setting) use ($decrypt) {
            $final[$setting->name] = $decrypt ? decrypt($setting->value) : $setting->value;
            return $final;
        }, []);
    }

    public function getDeliverySettingLists($context = null, $settingable_type = null, $settingable_id = null)
    {
        return $this->formatSettings(
            $this->basicQuery($context, $settingable_type, $settingable_id)
                ->get(['id', 'name', 'value']),
            true
        );

    }


    public function basicQuery($context = null, $settingable_type = null, $settingable_id = null)
    {
        return $this->model::query()->when($context, function (Builder $builder) use ($context) {
            $builder->whereIn('context',is_array($context) ? $context : [$context]);
        })->where('settingable_type', $settingable_type)
            ->where('settingable_id', $settingable_id);
    }


    public function settings($context)
    {
        $context = is_array($context) ? $context : func_get_args();
        return $this->model::query()
            ->whereIn('context', $context)
            ->get();
    }

    public function getDefaultMailKey($key = 'default_mail', $settingable_type = null, $settingable_id= null)
    {
        return $this->model::query()
            ->select(['id', 'name', 'value', 'context'])
            ->where('name', $key)
            ->where('settingable_type', $settingable_type)
            ->where('settingable_id', $settingable_id)
            ->first();
    }

}
