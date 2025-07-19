<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Cursos Demo",
 *     version="1.0.0",
 *     description="Documentación de la API con Swagger y Laravel",
 *     @OA\Contact(
 *         email="soporte@tudominio.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor API"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
