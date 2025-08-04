<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\SignInToCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/courses",
     *     summary="Listar cursos con paginación",
     *     security={{"bearerAuth":{}}},
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="user",
     *         in="query",
     *         description="Filtrar cursos por ID de usuario",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listado de cursos paginados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Listado de cursos"),
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
     *                         @OA\Property(property="description", type="string", example="Aprende Laravel desde cero"),
     *                         @OA\Property(property="created_by", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-19T15:55:10.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/courses?page=1"),
     *                 @OA\Property(property="from", type="integer", nullable=true, example=null),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/courses?page=1"),
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
     *                 @OA\Property(property="path", type="string", example="http://localhost:8000/api/courses"),
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
        $courses = Course::userIs(request('user'))->paginate();
        return response()->json([
            'message' => 'Listado de cursos',
            'data'    => $courses,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     summary="Crear nuevo curso",
     *     security={{"bearerAuth":{}}},
     *     tags={"Courses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "created_by"},
     *             @OA\Property(property="title", type="string", example="Curso de Laravel"),
     *             @OA\Property(property="description", type="string", example="Aprende Laravel desde cero"),
     *             @OA\Property(property="created_by", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Curso creado exitosamente"
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
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->all());
        return response()->json([
            'message' => 'Listado de cursos',
            'data'    => $course,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/courses/{id}",
     *     summary="Obtener detalles del curso con secciones y elementos",
     *     tags={"Courses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del curso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del curso con secciones y elementos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Detalles del curso"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="title", type="string", example="Introduccion"),
     *                 @OA\Property(property="description", type="string", example="Texto largo de descripción..."),
     *                 @OA\Property(property="created_by", type="integer", example=3),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                 
     *                 @OA\Property(
     *                     property="sections",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="course_id", type="integer", example=10),
     *                         @OA\Property(property="title", type="string", example="Curso 1 Seccion 1"),
     *                         @OA\Property(property="position", type="integer", example=0),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                         
     *                         @OA\Property(
     *                             property="elements",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=2),
     *                                 @OA\Property(property="section_id", type="integer", example=2),
     *                                 @OA\Property(property="title", type="string", example="Elemento A1"),
     *                                 @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=PGQxIILBb7M"),
     *                                 @OA\Property(property="position", type="integer", example=0),
     *                                 @OA\Property(property="type", type="integer", example=1),
     *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                                 @OA\Property(property="status_progress", type="boolean", example=false),
     *                                 @OA\Property(property="unlock", type="boolean", example=false)
     *                             ),
     *                              @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=3),
     *                                 @OA\Property(property="section_id", type="integer", example=2),
     *                                 @OA\Property(property="title", type="string", example="Elemento A2"),
     *                                 @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=PGQxIILBb7M"),
     *                                 @OA\Property(property="position", type="integer", example=0),
     *                                 @OA\Property(property="type", type="integer", example=1),
     *                                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-20T16:20:58.000000Z"),
     *                                 @OA\Property(property="status_progress", type="boolean", example=false),
     *                                 @OA\Property(property="unlock", type="boolean", example=false)
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $course = Course::with([
            'sections' => fn($q) => $q->orderBy('position'),
            'sections.subsections' => fn($q) => $q->orderBy('position'),
            'sections.subsections.elements' => fn($q) => $q->orderBy('position'),
            'sections.subsections.elements.questions.options'
        ])->findOrFail($id);
        return response()->json([
            'message' => 'Detalles del curso',
            'data'    => $course,
        ], 200);
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
        return response()->json([
            'message' => 'Curso actualizado',
            'data'    => $course,
        ], 200);
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
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json([
            'message' => 'Curso eliminado'
        ], 204);
    }

    /**
     * @OA\Post(
     *     path="/api/sign-to-course",
     *     summary="Registrarse a Curso",
     *     security={{"bearerAuth":{}}},
     *     tags={"Courses"},
     *     @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(
     *               required={"user_id", "course_ids"},
     *               @OA\Property(
     *                   property="course_ids",
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
    public function signInToCourse(SignInToCourseRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->signInCourses()->sync($request->course_ids);
        return response()->json([
            'message' => 'Se ha registrado en curso'
        ], 201);
    }
}
