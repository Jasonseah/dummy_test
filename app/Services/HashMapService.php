<?php

namespace App\Services;

use App\Models\HashMap;

class HashMapService
{
    /**
     * @param $hashMapRequest
     * @return HashMap
     */
    public function storeOrEdit($hashMapRequest): HashMap
    {
        $hashMap = HashMap::find(key($hashMapRequest));
        if ( !$hashMap) {
            $hashMap = new HashMap();
        }

        $value = $hashMapRequest->{key($hashMapRequest)};

        $hashMap->key = key($hashMapRequest);
        $hashMap->value = is_string($value) ? $value : json_encode($value);
        $hashMap->save();

        return $hashMap;
    }

}
