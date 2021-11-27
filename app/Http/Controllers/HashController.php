<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\HashMap;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\HashMapService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\HashMapRequest;
use App\Http\Resources\HashMapResources;
use App\Repositories\HashMapRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HashController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return HashMapResources::collection(HashMap::all());
    }

    /**
     * @param HashMapRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function create(HashMapRequest $request): Response|Application|ResponseFactory
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

            return response($err, 400);
        }


        return response(trans('general.create.success', ['attribute' => 'hash map']));
    }

    /**
     * @param $key
     * @param Request $request
     * @return HashMapResources
     */
    public function show($key, Request $request)
    {
        $allFilters = $request->only(['timestamp']);
        $queryResults = (new HashMapRepository)->find($key, $allFilters);

        if ( !$queryResults) {
            return response()->json([
                'data' => []
            ]);
        }

        return new HashMapResources($queryResults);
    }
}
