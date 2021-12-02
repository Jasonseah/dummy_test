<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\HashMap;
use Illuminate\Http\Request;
use App\Services\HashMapService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\HashMapRequest;
use App\Http\Resources\HashMapResources;
use App\Repositories\HashMapRepository;

class HashController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hashResources = HashMapResources::collection(HashMap::all());

        return custom_response(
            $hashResources,
            trans('general.retrieve.success', ['attribute' => 'hash map'])
        );
    }

    /**
     * @param HashMapRequest $request
     * @return JsonResponse
     */
    public function create(HashMapRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            (new HashMapService)->storeOrEdit(
                json_decode($request->input('data'))
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $err = trans('general.create.fail', ['attribute' => 'hash map']);

            return custom_error_response($e->getTrace(), $err);
        }


        return custom_response([], trans('general.create.success', ['attribute' => 'hash map']));
    }

    /**
     * @param $key
     * @param Request $request
     * @return JsonResponse
     */
    public function show($key, Request $request): JsonResponse
    {
        $allFilters = $request->only(['timestamp']);
        $queryResults = (new HashMapRepository)->find($key, $allFilters);

        $hashMapResources = $queryResults ? new HashMapResources($queryResults) : (object) [];

        return custom_response(
            $hashMapResources,
            trans('general.retrieve.success', ['attribute' => 'hash map'])
        );
    }
}
