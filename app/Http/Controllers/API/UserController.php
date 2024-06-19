<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    /**
     * Retrieves a list of all users from the database.
     *
     * @return \Illuminate\Http\JsonResponse containing the user list or an error message if retrieval fails.
     */
    public function index()
    {
        $users = User::all();
        return $this->sendResponse($users, "User list", 200);
    }

    /**
     * Retrieves details of a specific user by ID.
     *
     * @param int $id The unique identifier of the user to retrieve.
     *
     * @return \Illuminate\Http\JsonResponse containing the user details or an error message if retrieval fails.
     *
     * @throws \Throwable If an unexpected error occurs during user retrieval.
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
        } catch (\Throwable $th) {
            return $this->sendError("Invalid ID format. Please provide a numeric ID.", [], 422);
        }

        if (!$user) {
            return $this->sendError("No user found", [], 404);
        }

        return $this->sendResponse($user, "User Detail.", 200);
    }

    /**
     * Creates a new user in the database.
     *
     * @param UserRequest $request A validated request object containing user data.
     *
     * @return \Illuminate\Http\JsonResponse containing the created user or an error message if creation fails.
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->sendResponse($user, "User created successfully.", 201);
    }


    /**
     * Updates an existing user in the database.
     *
     * @param UserRequest $request A validated request object containing updated user data.
     *
     * @param int $id The unique identifier of the user to update.
     *
     * @return \Illuminate\Http\JsonResponse containing the updated user or an error message if update fails.
     *
     * @throws \Throwable If an unexpected error occurs during user retrieval or update.
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::find($id);
        } catch (\Throwable $th) {
            return $this->sendError("Invalid ID format. Please provide a numeric ID.", [], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->sendError("No user found", [], 404);
        }

        $user->name = $request->name;
        $user->email = $request->name;
        $user->password = Hash::make($request->password);

        $user->save();
        return $this->sendResponse($user, "User updated successfully.", 200);
    }

    /**
     * Deletes a user from the database.
     *
     * @param int $id The unique identifier of the user to delete.
     *
     * @return \Illuminate\Http\JsonResponse containing a success message or an error message if deletion fails.
     *
     * @throws \Throwable If an unexpected error occurs during user retrieval or deletion.
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
        } catch (\Throwable $th) {
            return $this->sendError("Invalid ID format. Please provide a numeric ID.", [], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->sendError("No user found", [], 404);
        }

        $user->delete();
        return $this->sendResponse($user, "User deleted successfully.", 200);
    }
}
