<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/options",
     *     summary="Listar opciones con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Options"},
     *     @OA\Parameter(
     *         name="question",
     *         in="query",
     *         description="Filtrar opciones por ID de pregunta",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de opciones paginadas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de opciones"),
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
     *                         @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *                         @OA\Property(property="question_id", type="integer", example=1),
     *                         @OA\Property(property="is_correct", type="boolean", example=true),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/options?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/options?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/options"),
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
        $options = Option::questionIs(request('question'))->paginate();
        return response()->json([
            'message' => 'Listado de opciones',
            'data'    => $options,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/options",
     *     summary="Crear nueva pregunta",
     *     security={{"bearerAuth":{}}},
     *     tags={"Options"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"option", "question_id", "is_correct"},
     *             @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="is_correct", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Opción creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="is_correct", type="boolean", example=true),
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
     *                      "seccion_id": {
     *                         "The seccion doesnt exist."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function store(OptionRequest $request)
    {
        $option = Option::create($request->all());
        return response()->json([
            'message' => 'Opción Creada',
            'data'    => $option,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/options/{id}",
     *     summary="Mostrar una opción por ID",
     *     tags={"options"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la opción",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="is_correct", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *         ),
     *     ),
     *     @OA\Response(response=404, description="Opción no encontrado")
     * )
     */
    public function show($id)
    {
        $option = Option::findOrFail($id);
        return response()->json([
            'message' => 'Detalles de la opción',
            'data'    => $option,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/options/{id}",
     *     summary="Actualizar una opción",
     *     tags={"Options"},
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
     *             @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="is_correct", type="boolean", example=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opción actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="option", type="string", example="esta es la respuesta"),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="is_correct", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     )
     * )
     */
    public function update(OptionRequest $request, $id)
    {
        $option = Option::findOrFail($id);
        $option->update($request->all());
        return response()->json([
            'message' => 'Opción actualizado',
            'data'    => $option,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/options/{id}",
     *     summary="Eliminar una opción",
     *     tags={"Options"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Opción eliminado")
     * )
     */
    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return response()->json([
            'message' => 'Opción eliminado'
        ], 204);
    }
}
