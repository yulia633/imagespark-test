<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json(['message' => null, 'data' => $courses], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateCourse();
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $course = Course::create($validator->validate());
        return response()->json(['message' => 'Course Created', 'data' => $course], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return response()->json(['message' => null, 'data' => $course], 200);
    }


    public function validateCourse()
    {
        return Validator::make(request()->all(), [
            'course_name' => 'required|string|max:25',
            'course_detail' => 'required|string|max:255',
        ]);
    }
}
