<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;


class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->getUserChunks(5556);
        return response()->json(['message' => null, 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateUser();
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json(['message' => 'User Created', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['message' => null, 'data' => $user], 200);
    }

    public function createdCourse(Request $request, User $user, Course $course)
    {
        $note = '';
        if ($request->note) {
            $note = $request->note;
        }
        if ($user->courses()->save($course, array('note' => $note))) {
            return response()->json(['message' => 'User Course Created', 'data' => $course], 200);
        }
        return response()->json(['message' => 'Error', 'data' => null], 400);
    }

    public function validateUser()
    {
        return Validator::make(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
