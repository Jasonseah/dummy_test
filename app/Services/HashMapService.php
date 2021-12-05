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
        $key = key($hashMapRequest);
        // First element's value
        $value = reset($hashMapRequest);

        $hashMap = HashMap::find($key);
        if ( !$hashMap) {
            $hashMap = new HashMap();
        }

        $hashMap->key = $key;
        $hashMap->value = json_encode($value);
        $hashMap->save();

        return $hashMap;
    }

}
