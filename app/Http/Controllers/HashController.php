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
use Illuminate\Validation\ValidationException;

class HashController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hashResources = HashMapResources::collection(HashMap::all());

        return custom_response(
            trans('general.retrieve.success', ['attribute' => 'hash map']),
            $hashResources
        );
    }

    /**
     * @param HashMapRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(HashMapRequest $request): JsonResponse
    {
        // hence in request is unable to check if request is empty and return a validation error
        // so we have to be ugly and make it here
        if (count($request->all()) < 1) {
            throw ValidationException::withMessages([trans('validation.custom.must_have_at_least_one_object')]);
        }

        DB::beginTransaction();
        try {
            (new HashMapService)->storeOrEdit($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $err = trans('general.create.fail', ['attribute' => 'hash map']);

            return custom_error_response($err, $e->getTrace());
        }

        return custom_response(trans('general.create.success', ['attribute' => 'hash map']));
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
            trans('general.retrieve.success', ['attribute' => 'hash map']),
            $hashMapResources
        );
    }
}
