<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ElementRequest;
use App\Http\Requests\ProgressRequest;
use App\Models\Element;
use App\Models\ElementProgress;
use Illuminate\Http\Request;
use Laravel\Prompts\Progress;

class ElementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/elements",
     *     summary="Listar elementos con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Elements"},
     *     @OA\Parameter(
     *         name="section",
     *         in="query",
     *         description="Filtrar elementos por ID de sección",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de elementos paginadas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de elementos"),
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
     *                         @OA\Property(property="url", type="string", example="https://github.com"),
     *                         @OA\Property(property="position", type="integer", example=0),
     *                         @OA\Property(property="seccion_id", type="integer", example=1),
     *                         @OA\Property(property="type", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/elements?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/elements?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/elements"),
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
        $elements = Element::sectionIs(request('section'))->paginate();
        return response()->json([
            'message' => 'Listado de elementos',
            'data'    => $elements,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/elements",
     *     summary="Crear nuevo elemento",
     *     security={{"bearerAuth":{}}},
     *     tags={"Elements"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "position", "section_id","type"},
     *             @OA\Property(property="title", type="string", example="elemento de Laravel"),
     *             @OA\Property(property="url", type="string", example="https://github.com"),
     *             @OA\Property(property="position", type="integer", example=0),
     *             @OA\Property(property="section_id", type="integer", example=1),
     *             @OA\Property(property="type", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Seccion creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Seccion de Laravel"),
     *             @OA\Property(property="url", type="string", example="https://github.com"),
     *             @OA\Property(property="type", type="integer", example=1),
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
     *                      "seccion_id": {
     *                         "The seccion doesnt exist."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function store(ElementRequest $request)
    {
        $element = Element::create($request->all());
        return response()->json([
            'message' => 'Elemento Creado',
            'data'    => $element,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/elements/{id}",
     *     summary="Mostrar una seccion por ID",
     *     tags={"Elements"},
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
     *              @OA\Property(property="url", type="string", example="https://github.com"),
     *             @OA\Property(property="type", type="integer", example=1),
     *             @OA\Property(property="position", type="string", example=0),
     *             @OA\Property(property="section_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     ),
     *     @OA\Response(response=404, description="Curso no encontrado")
     * )
     */
    public function show($id)
    {
        $element = Element::findOrFail($id);
        return response()->json([
            'message' => 'Detalles del elemento',
            'data'    => $element,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/elements/{id}",
     *     summary="Actualizar una sección",
     *     tags={"Elements"},
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
     *             @OA\Property(property="title", type="string", example="Elemento actualizado"),
     *             @OA\Property(property="position", type="integer", example=0),
     *             @OA\Property(property="url", type="string", example="https://github.com"),
     *             @OA\Property(property="type", type="integer", example=1),
     *             @OA\Property(property="section_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Seccion actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Seccion de Laravel"),
     *              @OA\Property(property="url", type="string", example="https://github.com"),
     *             @OA\Property(property="type", type="integer", example=1),
     *             @OA\Property(property="position", type="string", example=0),
     *             @OA\Property(property="section_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *         ),
     *     )
     * )
     */
    public function update(ElementRequest $request, $id)
    {
        $element = Element::findOrFail($id);
        $element->update($request->all());
        return response()->json([
            'message' => 'Elemento actualizado',
            'data'    => $element,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/elements/{id}",
     *     summary="Eliminar un elemento",
     *     tags={"Elements"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Elemento eliminado")
     * )
     */
    public function destroy($id)
    {
        $element = Element::findOrFail($id);
        $element->delete();
        return response()->json([
            'message' => 'Elemento eliminado'
        ], 204);
    }

    /**
     * @OA\Post(
     *     path="/api/elements/progress",
     *     summary="Marcar como visto",
     *     security={{"bearerAuth":{}}},
     *     tags={"Elements"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "element_id"},
     *             @OA\Property(property="element_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Se ha registrado en un curso"
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
     *                     "description": {
     *                         "The description must be at least 10 characters."
     *                     },
     *                      "created_by": {
     *                         "The user doesnt exist."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function progress(ProgressRequest $request)
    {
        ElementProgress::create($request->all());
        return response()->json([
            'message' => 'Se ha guardado el progreso'
        ], 201);
    }
}
