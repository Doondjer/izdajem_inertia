<?php namespace App\Acme\Traits;

use App\Models\Listing;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;


trait AggregateTrait {

    protected $aggs = [
        'type' => 'types',
        'city' => false,
        'county' => false,
        'district' => false,
        'furnish_type' => 'furnish_types',
        'nb_room' => 'structure',
    ];

    protected $field = 'search:aggregation';

    protected function aggregate()
    {
        return Cache::rememberForever($this->field, function (){
            $aggregations['statuses'] = config('app_settings.values.statuses');
            foreach ($this->aggs as $agg => $config) {
                $aggregations[$agg] = ['buckets' => Listing::active()
                    ->select($agg)
                    ->groupBy($agg)
                    ->pluck($agg)
                    ->map(function ($value) use($agg, $config){
                        return ['key' => $config ?
                            Arr::get(config("app_settings.values.$config"),is_float($value) ? number_format($value,1) : $value)
                            : $value, 'doc_count' => 0
                        ];
                    })
                ];
            }

            return $aggregations;
        });
    }

    protected function reAggregate()
    {
        Cache::forget($this->field);
        $this->aggregate();
    }
}
