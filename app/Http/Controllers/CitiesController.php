<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\CityRequest;

class CitiesController extends Controller
{
    /**
     * @api {get} /cities List cities
     * @apiName GetCities
     * @apiGroup City
     *
     * @apiSuccess {Object[]} cities List of cities
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {String} cities.name City name
     * @apiSuccess {Number} cities.zip_code ZIP code
     * @apiSuccess {Number} cities.county_id ID of the county the city belongs to
     * @apiSuccess {Number} cities.population Population
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         {
     *           "id": 1,
     *           "name": "Budapest",
     *           "zip_code": 1011,
     *           "county_id": 1,
     *           "population": 1700000
     *         }
     *       ]
     *     }
     */
    public function index() {
        $cities = City::all();
        return response()->json(['cities' => $cities]);
    }

    /**
     * @api {post} /cities Create city
     * @apiName CreateCity
     * @apiGroup City
     * @apiUse AuthRequired
     *
     * @apiBody {String{3..255}} name City name
     * @apiBody {Number} zip_code ZIP code
     * @apiBody {Number} county_id ID of an existing county
     * @apiBody {Number} population Population
     *
     * @apiSuccess {Object} city The created city
     * @apiSuccess {Number} city.id City ID
     * @apiSuccess {String} city.name City name
     * @apiSuccess {Number} city.zip_code ZIP code
     * @apiSuccess {Number} city.county_id County ID
     * @apiSuccess {Number} city.population Population
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 5,
     *         "name": "Szeged",
     *         "zip_code": 6720,
     *         "county_id": 3,
     *         "population": 160000
     *       }
     *     }
     * @apiUse ValidationError
     */
    public function store(CityRequest $request) {
        $city = City::create($request->all());
        return response()->json(['city' => $city]);
    }

    /**
     * @api {patch} /cities/:id Update city
     * @apiName UpdateCity
     * @apiGroup City
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id City ID
     * @apiBody {String{3..255}} [name] City name
     * @apiBody {Number} [zip_code] ZIP code
     * @apiBody {Number} [county_id] ID of an existing county
     * @apiBody {Number} [population] Population
     *
     * @apiSuccess {Object} city The updated city
     * @apiSuccess {Number} city.id City ID
     * @apiSuccess {String} city.name City name
     * @apiSuccess {Number} city.zip_code ZIP code
     * @apiSuccess {Number} city.county_id County ID
     * @apiSuccess {Number} city.population Population
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "city": {
     *         "id": 5,
     *         "name": "Szeged",
     *         "zip_code": 6720,
     *         "county_id": 3,
     *         "population": 165000
     *       }
     *     }
     * @apiUse NotFound
     * @apiUse ValidationError
     */
    public function update(CityRequest $request, $id) {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json(['city' => $city]);
    }

    /**
     * @api {delete} /cities/:id Delete city
     * @apiName DeleteCity
     * @apiGroup City
     * @apiUse AuthRequired
     *
     * @apiParam {Number} id City ID
     *
     * @apiSuccess {String} message Confirmation message
     * @apiSuccess {Number} id ID of the deleted city
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "City deleted successfully",
     *       "id": "5"
     *     }
     * @apiUse NotFound
     */
    public function destroy($id) {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => "City deleted successfully",
            'id' => $id
        ]);
    }

    /**
     * @api {get} /counties/:id/cities List cities of a county
     * @apiName GetCitiesByCounty
     * @apiGroup City
     *
     * @apiParam {Number} id County ID
     *
     * @apiSuccess {Object[]} cities Cities belonging to the county (empty array if there are none)
     * @apiSuccess {Number} cities.id City ID
     * @apiSuccess {String} cities.name City name
     * @apiSuccess {Number} cities.zip_code ZIP code
     * @apiSuccess {Number} cities.county_id County ID
     * @apiSuccess {Number} cities.population Population
     *
     * @apiSuccessExample {json} Success:
     *     HTTP/1.1 200 OK
     *     {
     *       "cities": [
     *         { "id": 1, "name": "Budapest", "zip_code": 1011, "county_id": 1, "population": 1700000 }
     *       ]
     *     }
     */
    public function getCitiesByCountyId($id) {
        $cities = City::where('county_id', $id)->get();
        return response()->json(['cities' => $cities]);
    }
}
