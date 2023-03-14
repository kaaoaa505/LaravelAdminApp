<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Admin App ApplicationAPI",
 *    version="1.0.0",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @QA\Info(
     *			version="1.0.0",
     *			title="Admin Documentation",
     *			description="Admin OpenApi description"
     * 		@QA\Contact(
     *				email="kaaoaa505@gmail.com"
     *			),
     * )
     *
     * @QA\Server(
     * 	url=L5_SWAGGER_CONST_HOST,
     *		description="Admin API Server"
     * )
     */
}
