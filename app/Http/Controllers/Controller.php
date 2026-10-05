<?php

namespace App\Http\Controllers;
/**
 * @apiDefine AuthRequired Authentication required
 * Send the token returned by the login endpoint.
 *
 * @apiHeader {String} Authorization Bearer token, e.g. `Bearer 1|abc123...`
 * @apiError (401) Unauthenticated Missing or invalid token.
 * @apiErrorExample {json} 401 Unauthenticated:
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "message": "Unauthenticated."
 *     }
 */

/**
 * @apiDefine ValidationError
 * @apiError (422) ValidationError One or more fields failed validation.
 * @apiErrorExample {json} 422 Validation error:
 *     HTTP/1.1 422 Unprocessable Entity
 *     {
 *       "message": "The name field is required.",
 *       "errors": {
 *         "name": ["The name field is required."]
 *       }
 *     }
 */

/**
 * @apiDefine NotFound
 * @apiError (404) NotFound The requested record does not exist.
 * @apiErrorExample {json} 404 Not found:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "message": "No query results for model [App\\Models\\City] 99"
 *     }
 */
abstract class Controller
{
    //
}
