<?php namespace App\Acme\Traits;

use App\Exceptions\InvalidStatusException;
use App\Models\ListingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ListingStatusTrait {

    public function statuses()
    {
        return $this->hasMany(ListingStatus::class )->latest('id');
    }

    public function status(): ?ListingStatus
    {
        return $this->latestStatus();
    }

    /**
     * @param string|array $names
     *
     * @return null|ListingStatus
     */
    public function latestStatus(...$names): ?ListingStatus
    {
        $statuses = $this->relationLoaded('statuses') ? $this->statuses : $this->statuses();

        $names = is_array($names) ? Arr::flatten($names) : func_get_args();
        if (count($names) < 1) {
            return $statuses->first();
        }

        return $statuses->whereIn('name', $names)->first();
    }

    public function hasEverHadStatus($name): bool
    {
        $statuses = $this->relationLoaded('statuses') ? $this->statuses : $this->statuses();

        return $statuses->where('name', $name)->count() > 0;
    }

    public function setStatus(string $name, ?string $reason = null): self
    {
        if (! in_array($name, array_keys(config('app_settings.values.statuses')))) {
            throw InvalidStatusException::create($name);
        }

        return $this->forceSetStatus($name, $reason);
    }

    public function deleteStatus(...$names)
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();
        if (count($names) < 1) {
            return $this;
        }

        $this->statuses()->whereIn('name', $names)->delete();
    }

    public function scopeCurrentStatus(Builder $builder, ...$names)
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();
        $builder
            ->whereHas(
                'statuses',
                function (Builder $query) use ($names) {
                    $query
                        ->whereIn('name', $names)
                        ->whereIn(
                            'id',
                            function (QueryBuilder $query) {
                                $query
                                    ->select(DB::raw('max(id)'))
                                    ->from('listing_statuses')
                                    ->whereColumn('listing_id', 'id');
                            }
                        );
                }
            );
    }

    /**
     * @param string|array $names
     *
     * @return void
     **/
    public function scopeOtherCurrentStatus(Builder $builder, ...$names)
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();
        $builder
            ->whereHas(
                'statuses',
                function (Builder $query) use ($names) {
                    $query
                        ->whereNotIn('name', $names)
                        ->whereIn(
                            'id',
                            function (QueryBuilder $query) use ($names) {
                                $query
                                    ->select(DB::raw('max(id)'))
                                    ->from('listings_status')
                                    ->whereColumn('listing_id','id');
                            }
                        );
                }
            )
            ->orWhereDoesntHave('statuses');
    }

    public function forceSetStatus(string $name, ?string $reason = null): self
    {
        $oldStatus = $this->latestStatus();

        $newStatus = $this->statuses()->create([
            'name' => $name,
            'reason' => $reason,
            'user_id' => Auth::user()->id()
        ]);

        //event(new StatusUpdated($oldStatus, $newStatus));

        return $this;
    }

    public function getStatusAttribute(): string
    {
        return (string) $this->latestStatus();
    }
}
