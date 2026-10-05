<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Http\Requests\CountyRequest;

class CountiesController extends Controller
{
    /**
     * @api {get} /counties List counties
     * @apiName GetCounties
     * @apiGroup County
     *
     * @apiSuccess {Object[]} counties List of counties
     * @apiSuccess {Number} counties.id County ID
     * @apiSuccess {String} counties.name County name
     * @apiSuccess {String} counties.badge County badge
     * @apiSuccess {String} counties.created_at Creation timestamp
     * @apiSuccess {String} counties.updated_at Last update timestamp
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "counties": [
     *         {
     *           "id": 1,
     *           "name": "Pest",
     *           "badge": "pest-badge.png",
     *           "created_at": "2026-10-05T10:00:00.000000Z",
     *           "updated_at": "2026-10-05T10:00:00.000000Z"
     *         }
     *       ]
     *     }
     */
    public function index() {
        $counties = County::all();
        return response()->json(['counties' => $counties]);
    }

    /**
     * @api {post} /counties Create county
     * @apiName CreateCounty
     * @apiGroup County
     * @apiUse AuthRequired
     *
     * @apiBody {String{3..255}} name County name
     * @apiBody {String{10..255}} badge County badge
     *
     * @apiSuccess {Object} county The created county
     * @apiSuccess {Number} county.id County ID
     * @apiSuccess {String} county.name County name
     * @apiSuccess {String} county.badge County badge
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": { "id": 2, "name": "Fejér", "badge": "fejer-badge.png" }
     *     }
     * @apiUse ValidationError
     */
    public function store(CountyRequest $request) {
        $county = County::create($request->all());
        return response()->json(['county' => $county]);
    }

    /**
     * @api {patch} /counties/:id Update county
     * @apiName UpdateCounty
     * @apiGroup County
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id County ID
     * @apiBody {String{3..255}} [name] County name
     * @apiBody {String{10..255}} [badge] County badge
     *
     * @apiSuccess {Object} county The updated county
     * @apiSuccess {Number} county.id County ID
     * @apiSuccess {String} county.name County name
     * @apiSuccess {String} county.badge County badge
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "county": { "id": 2, "name": "Fejér megye", "badge": "fejer-badge.png" }
     *     }
     * @apiUse NotFound
     * @apiUse ValidationError
     */
    public function update(CountyRequest $request, $id) {
        $county = County::findOrFail($id);
        $county->update($request->all());
        return response()->json(['county' => $county]);
    }

    /**
     * @api {delete} /counties/:id Delete county
     * @apiName DeleteCounty
     * @apiGroup County
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id County ID
     *
     * @apiSuccess {String} message Confirmation message
     * @apiSuccess {Number} id ID of the deleted county
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "County deleted successfully",
     *       "id": "2"
     *     }
     * @apiUse NotFound
     */
    public function destroy($id) {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => "County deleted successfully",
            'id' => $id
        ]);
    }
}
