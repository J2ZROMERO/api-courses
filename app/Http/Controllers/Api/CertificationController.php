<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CertificationRequest;
use App\Http\Requests\SignInToCertificationRequest;
use App\Models\Certification;
use App\Models\User;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/certifications",
     *     summary="Listar certificaciones con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Certifications"},
     *     @OA\Parameter(
     *         name="user",
     *         in="query",
     *         description="Filtrar certificaciones por ID de usuario",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de certificaciones paginados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de certificaciones"),
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
     *                         @OA\Property(property="title", type="string", example="certificación de Laravel"),
     *                         @OA\Property(property="description", type="string", example="Aprende Laravel desde cero"),
     *                         @OA\Property(property="created_by", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/certifications?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/certifications?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/certifications"),
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
        $certifications = Certification::userIs(request('user'))->paginate();
        return response()->json([
            'message' => 'Listado de certificaciones',
            'data'    => $certifications,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/certifications",
     *     summary="Crear nuevo certificación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Certifications"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "created_by"},
     *             @OA\Property(property="title", type="string", example="certificación de Laravel"),
     *             @OA\Property(property="description", type="string", example="Aprende Laravel desde cero"),
     *             @OA\Property(property="created_by", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="certificación creado exitosamente"
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
    public function store(CertificationRequest $request)
    {
        $certification = Certification::create($request->all());
        return response()->json([
            'message' => 'Certificación guardada',
            'data'    => $certification,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/certifications/{id}",
     *     summary="Obtener detalles de una certificación con sus cursos",
     *     description="Devuelve una certificación junto con sus cursos, secciones, elementos, preguntas y opciones.",
     *     operationId="getCertificationDetails",
     *     tags={"Certifications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la certificación",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la certificación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Detalles del certificación"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Certificación Full Stack"),
     *                 @OA\Property(property="description", type="string", example="Incluye cursos de backend y frontend"),
     *                 @OA\Property(
     *                     property="courses",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=10),
     *                         @OA\Property(property="title", type="string", example="Curso Laravel"),
     *                         @OA\Property(
     *                             property="sections",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=100),
     *                                 @OA\Property(property="title", type="string", example="Introducción"),
     *                                 @OA\Property(
     *                                     property="elements",
     *                                     type="array",
     *                                     @OA\Items(
     *                                         type="object",
     *                                         @OA\Property(property="id", type="integer", example=1000),
     *                                         @OA\Property(property="title", type="string", example="Video 1"),
     *                                         @OA\Property(
     *                                             property="questions",
     *                                             type="array",
     *                                             @OA\Items(
     *                                                 type="object",
     *                                                 @OA\Property(property="id", type="integer", example=2000),
     *                                                 @OA\Property(property="text", type="string", example="¿Qué es Laravel?"),
     *                                                 @OA\Property(
     *                                                     property="options",
     *                                                     type="array",
     *                                                     @OA\Items(
     *                                                         type="object",
     *                                                         @OA\Property(property="id", type="integer", example=3000),
     *                                                         @OA\Property(property="text", type="string", example="Framework de PHP")
     *                                                     )
     *                                                 )
     *                                             )
     *                                         )
     *                                     )
     *                                 )
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Certificación no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "message": "No query results for model [App\\Models\\Certification] 999"
     *             }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $certification = Certification::with([
            'courses.sections' => fn($q) => $q->orderBy('position'),
            'courses.sections.subsections' => fn($q) => $q->orderBy('position'),
            'courses.sections.subsections.elements' => fn($q) => $q->orderBy('position'),
            'courses.sections.subsections.elements.questions.options'
        ])->findOrFail($id);
        return response()->json([
            'message' => 'Detalles del certificación',
            'data'    => $certification,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/certifications/{id}",
     *     summary="Actualizar un certificación",
     *     tags={"Certifications"},
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
     *             @OA\Property(property="title", type="string", example="certificación actualizado"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="certificación actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Course")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $certification = Certification::findOrFail($id);
        $certification->update($request->all());
        return response()->json([
            'message' => 'certificación actualizado',
            'data'    => $certification,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/certifications/{id}",
     *     summary="Eliminar un certificación",
     *     tags={"Certifications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="certificación eliminado")
     * )
     */
    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();
        return response()->json([
            'message' => 'certificación eliminado'
        ], 204);
    }

    
    /**
     * @OA\Post(
     *     path="/api/certifications/{certification}/assign-courses",
     *     summary="Asignar cursos a una certificación",
     *     description="Asocia uno o más cursos existentes a una certificación.",
     *     tags={"Certifications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="certification",
     *         in="path",
     *         required=true,
     *         description="ID de la certificación",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_ids"},
     *             @OA\Property(
     *                 property="course_ids",
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={1, 2, 3}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cursos asignados correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Cursos asignados correctamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "message": "The given data was invalid.",
     *                 "errors": {
     *                     "course_ids": {
     *                         "The course_ids field is required."
     *                     },
     *                     "course_ids.0": {
     *                         "The selected course_ids.0 is invalid."
     *                     }
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Certificación no encontrada"
     *     )
     * )
     */
    public function assignCourses(Request $request, $id)
    {
        $validated = $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $certification = Certification::findOrFail($id);
        $certification->courses()->sync($validated['course_ids']);
        return response()->json([
            'message' => 'Cursos asignados correctamente.'
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/sign-to-certification",
     *     summary="Registrarse a Certificación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Certifications"},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"user_id", "certification_ids"},
     *               @OA\Property(
     *                   property="certification_ids",
     *                   type="array",
     *                   @OA\Items(type="integer"),       
     *                   example={1, 2}                  
     *               ),
     *               @OA\Property(
     *                   property="user_id",
     *                   type="integer",
     *                  example=1
     *               )
     *           )
     *       ),
     *     @OA\Response(
     *         response=201,
     *         description="Se ha registrado en una certificación"
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
    public function signInToCertification(SignInToCertificationRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->certifications()->sync($request->certification_ids);
        return response()->json([
            'message' => 'Se ha registrado en certificaciones'
        ], 201);
    }

}
