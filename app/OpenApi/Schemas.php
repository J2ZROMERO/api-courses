<?php

namespace App\OpenApi;

/**
 * @OA\Schema(
 *     schema="Course",
 *     type="object",
 *     title="Course",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Curso de Laravel"),
 *     @OA\Property(property="description", type="string", example="Aprende Laravel desde cero"),
 *     @OA\Property(property="created_by", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
 * )
 */

class Schemas {}