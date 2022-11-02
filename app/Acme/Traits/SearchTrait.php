<?php namespace App\Acme\Traits;

use Elastic\ScoutDriverPlus\Support\Query;
use Illuminate\Support\Arr;

trait SearchTrait {

    /**
     * @param array $request
     * @return \Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder
     */
    public function getSearchQuery(array $request): \Elastic\ScoutDriverPlus\Builders\BoolQueryBuilder
    {

        if ($search = trim(Arr::get($request, 'q'))) {

            $must = Query::multiMatch()
                    ->fields([
                        'description',
                        'street',
                        'city',
                        'county',
                        'district'
                    ])
                    ->query($search)
                    ->fuzziness('AUTO');
        } else {
            $must = Query::matchAll();
        }

        $query = Query::bool()->must($must);


        $terms[] = 'published';

        if (Arr::get($request, 'show_rented') === 'true') {
            $terms[] = 'rented';
        }

        $query->filter(['terms' => ['status' => $terms]]);

        if ($city = Arr::get($request, 'city')) {
            $query->filter(['term' => ['city' => $city]]);
        }
        if ($county = Arr::get($request, 'county')) {
            $query->filter(['term' => ['county' => $county]]);
        }
        if ($district = Arr::get($request, 'district')) {
            $query->filter(['term' => ['district' => $district]]);
        }
        if ($userId = Arr::get($request, 'user')) {
            $query->filter(['term' => ['user_id' => $userId]]);
        }
        if (Arr::get($request, 'price_from') || Arr::get($request, 'price_to')) {
            $query->filter(['range' => ['price' => ['gte' => filter_var(Arr::get($request, 'price_from'), FILTER_SANITIZE_NUMBER_INT) ?: null, 'lte' => filter_var(Arr::get($request, 'price_to'), FILTER_SANITIZE_NUMBER_INT) ?: null]]]);
        }
        if (Arr::get($request, 'size_from') || Arr::get($request, 'size_to')) {
            $query->filter(['range' => ['size' => ['gte' => filter_var(Arr::get($request, 'size_from'), FILTER_SANITIZE_NUMBER_INT) ?: null, 'lte' => filter_var(Arr::get($request, 'size_to'), FILTER_SANITIZE_NUMBER_INT) ?: null]]]);
        }

        return $query;
    }

}
