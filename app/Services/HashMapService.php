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

        $hashMap->key = key($hashMapRequest);
        $hashMap->value = json_encode($hashMapRequest->{key($hashMapRequest)});
        $hashMap->save();

        return $hashMap;
    }

}
