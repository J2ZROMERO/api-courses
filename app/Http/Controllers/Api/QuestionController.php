<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/questions",
     *     summary="Listar preguntas con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="element",
     *         in="query",
     *         description="Filtrar preguntas por ID de elemento",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de preguntas paginadas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de preguntas"),
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
     *                         @OA\Property(property="Question", type="string", example="Cuál es la respuesta a?"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/questions?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/questions?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/questions"),
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
        $questions = Question::elementIs(request('element'))->paginate();
        return response()->json([
            'message' => 'Listado de preguntas',
            'data'    => $questions,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/questions",
     *     summary="Crear nueva pregunta",
     *     security={{"bearerAuth":{}}},
     *     tags={"Questions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"question", "element_id"},
     *             @OA\Property(property="question", type="string", example="Cuál es la respuesta a?"),
     *             @OA\Property(property="element_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pregunta creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="question", type="string", example="Cuál es la respuesta a?"),
     *             @OA\Property(property="element_id", type="integer", example=1),
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
    public function store(QuestionRequest $request)
    {
        $question = Question::create($request->all());
        return response()->json([
            'message' => 'Pregunta Creada',
            'data'    => $question,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/questions/{id}",
     *     summary="Mostrar una pregunta por ID",
     *     tags={"Questions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la elemento",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="question", type="string", example="Cuál es la respuesta a?"),
     *             @OA\Property(property="element_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *         ),
     *     ),
     *     @OA\Response(response=404, description="Curso no encontrado")
     * )
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return response()->json([
            'message' => 'Detalles de la pregunta',
            'data'    => $question,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/questions/{id}",
     *     summary="Actualizar una pregunta",
     *     tags={"Questions"},
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
     *             @OA\Property(property="question", type="string", example="Cuál es la respuesta a?"),
     *             @OA\Property(property="element_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Seccion actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="question", type="string", example="Cuál es la respuesta a?"),
     *             @OA\Property(property="element_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     )
     * )
     */
    public function update(QuestionRequest $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());
        return response()->json([
            'message' => 'Pregunta actualizado',
            'data'    => $question,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/questions/{id}",
     *     summary="Eliminar una pregunta",
     *     tags={"Questions"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Pregunta eliminado")
     * )
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json([
            'message' => 'Pregunta eliminado'
        ], 204);
    }
}
