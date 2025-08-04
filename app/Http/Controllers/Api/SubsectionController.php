<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubsectionRequest;
use App\Models\Subsection;
use Illuminate\Http\Request;

class SubsectionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subsections",
     *     summary="Listar subsecciones con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Subsections"},
     *     @OA\Parameter(
     *         name="course",
     *         in="query",
     *         description="Filtrar subsecciones por ID de sección",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de subsecciones paginadas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de subsecciones"),
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
     *                         @OA\Property(property="title", type="string", example="sections de Laravel"),
     *                         @OA\Property(property="position", type="integer", example=0),
     *                         @OA\Property(property="section_id", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/subsections?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/subsections?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/subsections"),
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
        $subsections = Subsection::sectionIs(request('section'))->paginate();
        return response()->json([
            'message' => 'Listado de subsecciones',
            'data'    => $subsections,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/subsections",
     *     summary="Crear nueva seccion",
     *     security={{"bearerAuth":{}}},
     *     tags={"Subsections"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "position", "section_id"},
     *             @OA\Property(property="title", type="string", example="seccion de Laravel"),
     *             @OA\Property(property="position", type="integer", example=0),
     *             @OA\Property(property="section_id", type="integer", example=1),
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
     *             @OA\Property(property="section_id", type="integer", example=1),
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
     *                      "section_id": {
     *                         "The course doesnt exist."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function store(SubsectionRequest $request)
    {
        $subsection = Subsection::create($request->all());
        return response()->json([
            'message' => 'Listado de sectionss',
            'data'    => $subsection,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/subsections/{id}",
     *     summary="Mostrar una seccion por ID",
     *     tags={"subsections"},
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
     *             @OA\Property(property="section_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     ),
     *     @OA\Response(response=404, description="sections no encontrado")
     * )
     */
    public function show($id)
    {
        $subsection = Subsection::findOrFail($id);
        return response()->json([
            'message' => 'Detalles de la sección',
            'data'    => $subsection,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/subsections/{id}",
     *     summary="Actualizar una sección",
     *     tags={"subsections"},
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
     *             @OA\Property(property="section_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     )
     * )
     */
    public function update(SubsectionRequest $request, $id)
    {
        $subsection = Subsection::findOrFail($id);
        $subsection->update($request->all());
        return response()->json([
            'message' => 'Subsección actualizado',
            'data'    => $subsection,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/subsections/{id}",
     *     summary="Eliminar una sección",
     *     tags={"subsections"},
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
        $subsection = Subsection::findOrFail($id);
        $subsection->delete();
        return response()->json([
            'message' => 'Subsección eliminado'
        ], 204);
    }
}
