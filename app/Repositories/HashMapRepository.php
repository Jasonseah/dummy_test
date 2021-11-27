<?php

namespace App\Repositories;

use App\Models\HashMap;
use Carbon\Carbon;

class HashMapRepository
{
    /**
     * @param $key
     * @param $filters
     * @return mixed
     */
    public function find($key, $filters): mixed
    {
        $base = HashMap::where("key", $key);

        // for now usable is [timestamp]
        foreach ($filters as $key => $filter) {
            $function = "$key";
            if (method_exists($this, $function)) {
                $base = $this->$function($base, $filter);
            }
        }

        return $base->first();
    }

    /**
     * @param $base
     * @param $timestamp
     * @return mixed
     */
    private function timestamp($base, $timestamp)
    {
        return $base->where('created_at', Carbon::createFromTimestamp($timestamp));
    }

}
