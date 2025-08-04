<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sections",
     *     summary="Listar secciones con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Sections"},
     *     @OA\Parameter(
     *         name="course",
     *         in="query",
     *         description="Filtrar secciones por ID de curso",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de secciones paginadas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de secciones"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Curso de Laravel"),
     *                         @OA\Property(property="position", type="integer", example=0),
     *                         @OA\Property(property="course_id", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/sections?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/sections?page=1"),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", nullable=true, example=null),
     *                         @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                         @OA\Property(property="active", type="boolean", example=false)
     *                     )
     *                 ),
     *                 @OA\Property(property="next_page_url", type="string", nullable=true, example=null),
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/sections"),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *                 @OA\Property(property="to", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="total", type="integer", example=0)
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $sections = Section::courseIs(request('course'))->paginate();
        return response()->json([
            'message' => 'Listado de secciones',
            'data'    => $sections,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/sections",
     *     summary="Crear nueva seccion",
     *     security={{"bearerAuth":{}}},
     *     tags={"Sections"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "position", "course_id"},
     *             @OA\Property(property="title", type="string", example="seccion de Laravel"),
     *             @OA\Property(property="position", type="integer", example=0),
     *             @OA\Property(property="course_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Seccion creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Seccion de Laravel"),
     *             @OA\Property(property="position", type="string", example=0),
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "message": "The given data was invalid.",
     *                 "errors": {
     *                     "title": {
     *                         "The title field is required."
     *                     },
     *                     "position": {
     *                         "The position column must be an integer."
     *                     },
     *                      "course_id": {
     *                         "The course doesnt exist."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function store(SectionRequest $request)
    {
        $section = Section::create($request->all());
        return response()->json([
            'message' => 'Listado de cursos',
            'data'    => $section,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/sections/{id}",
     *     summary="Mostrar una seccion por ID",
     *     tags={"Sections"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la sección",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Seccion de Laravel"),
     *             @OA\Property(property="position", type="string", example=0),
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     ),
     *     @OA\Response(response=404, description="Curso no encontrado")
     * )
     */
    public function show($id)
    {
        $section = Section::with([
            'subsections' => fn($q) => $q->orderBy('position'),
            'subsections.elements' => fn($q) => $q->orderBy('position'),
            'subsections.elements.questions.options'
        ])->findOrFail($id);
        return response()->json([
            'message' => 'Detalles de la sección',
            'data'    => $section,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/sections/{id}",
     *     summary="Actualizar una sección",
     *     tags={"Sections"},
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
     *             @OA\Property(property="title", type="string", example="Seccion actualizado"),
     *             @OA\Property(property="position", type="integer", example=0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Seccion actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Seccion de Laravel"),
     *             @OA\Property(property="position", type="string", example=0),
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     )
     * )
     */
    public function update(SectionRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->all());
        return response()->json([
            'message' => 'Sección actualizado',
            'data'    => $section,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/sections/{id}",
     *     summary="Eliminar una sección",
     *     tags={"Sections"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Sección eliminado")
     * )
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json([
            'message' => 'Sección eliminado'
        ], 204);
    }
}
