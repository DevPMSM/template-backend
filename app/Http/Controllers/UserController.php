<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->user->query()
            ->when($request->has('name'), fn ($query) => $query->orWhere('name', 'like', "%{$request['name']}%"))
            ->when($request->has('email'), fn ($query) => $query->orWhere('email', 'like', "%{$request['email']}%"))
            ->orderBy('created_at', 'desc')
            ->paginate((int) $request->per_page);

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $data['image'] = url('storage/'.$path);
        }
        $user = $this->user->create($data);
        return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        $loggedUser = auth()->user();

        if (Auth::user()->role !== 'admin' && $loggedUser['email'] !== $user['email']) {
            return response()->json(['error' => 'Acesso não autorizado'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $loggedUser = auth()->user();

        if (Auth::user()->role !== 'admin' && $loggedUser['email'] !== $user['email']) {
            return response()->json(['error' => 'Acesso não autorizado'], Response::HTTP_UNAUTHORIZED);
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('image')) {
            try {
                if($user['image']) {
                    $image_name = explode('image/', $user['image']);
                    Storage::disk('public')->delete('image/'.$image_name[1]);
                }
            } catch (\Throwable) {
            } finally {
                $path = $request->file('image')->store('image', 'public');
                $data['image'] = url('storage/'.$path);
            }
        }

        $user->update($data);

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'user' => $user], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $loggedUser = auth()->user();

        if ($loggedUser['email'] == $user['email']) {
            return response()->json(['message' => 'Usuários não podem se auto-deletar.'], Response::HTTP_FORBIDDEN);
        }

        $user->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso'], Response::HTTP_OK);
    }

    public function hardDelete(String $id): JsonResponse
    {
        $loggedUser = auth()->user();
        $user = $this->user->withTrashed()->findOrFail($id);

        if ($loggedUser['email'] == $user->email) {
            return response()->json(['message' => 'Usuários não podem se auto-deletar.'], Response::HTTP_FORBIDDEN);
        }

        $user->forceDelete();

        return response()->json([$user], Response::HTTP_OK);
    }
}
