<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *     schema="Course",
 *     type="object",
 *     title="Course",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="name", type="string")
 * )
 */
class CourseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/courses",
     *     summary="Listar todos los cursos",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cursos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Course")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     summary="Crear un nuevo curso",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description"},
     *             @OA\Property(property="title", type="string", example="Curso de Laravel"),
     *             @OA\Property(property="description", type="string", example="Aprende Laravel desde cero")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Curso creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Course")
     *     )
     * )
     */
    public function store(Request $request)
    {
        return Course::create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/courses/{id}",
     *     summary="Mostrar un curso por ID",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del curso",
     *         @OA\JsonContent(ref="#/components/schemas/Course")
     *     ),
     *     @OA\Response(response=404, description="Curso no encontrado")
     * )
     */
    public function show($id)
    {
        return Course::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/courses/{id}",
     *     summary="Actualizar un curso",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Curso actualizado"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Course")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return $course;
    }

    /**
     * @OA\Delete(
     *     path="/api/courses/{id}",
     *     summary="Eliminar un curso",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Curso eliminado")
     * )
     */
    public function destroy($id)
    {
        Course::destroy($id);
        return response()->noContent();
    }
}
