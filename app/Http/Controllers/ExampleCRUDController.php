<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExampleCRUDRequest;
use App\Models\ExampleCRUD;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExampleCRUDController extends Controller
{

    private $exampleCRUD;

    public function __construct(ExampleCRUD $exampleCRUD) {
        $this->exampleCRUD = $exampleCRUD;
    }

    /**
    * Display a listing of the resource.
    */
    public function index(Request $request): JsonResponse
    {
        $exampleCRUD = $this->exampleCRUD->query()
        ->when($request->has('name'), fn ($query) => $query->orWhere('name', 'like', "%{$request['name']}%"))
        ->when($request->has('email'), fn ($query) => $query->orWhere('email', 'like', "%{$request['email']}%"))
        ->orderBy('created_at', 'desc')
        ->paginate((int) $request->per_page);

        return response()->json($exampleCRUD, Response::HTTP_OK);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(ExampleCRUDRequest $request): JsonResponse
    {
        $data = $request->validated();
        $exampleCRUD = $this->exampleCRUD->create($data);

        return response()->json($exampleCRUD, Response::HTTP_CREATED);
    }

    /**
    * Display the specified resource.
    */
    public function show(ExampleCRUD $exampleCRUD): JsonResponse
    {
        $exampleCRUD = $this->exampleCRUD->findOrFail($exampleCRUD->id)->with('updatedBy')->get();
        return response()->json($exampleCRUD, Response::HTTP_OK);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(ExampleCRUDRequest $request, ExampleCRUD $exampleCRUD): JsonResponse
    {
        $data = $request->validated();
        $exampleCRUD = $this->exampleCRUD->findOrFail($exampleCRUD->id);
        $exampleCRUD->update($data);

        return response()->json($exampleCRUD, Response::HTTP_OK);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(ExampleCRUD $exampleCRUD): JsonResponse
    {
        $exampleCRUD->delete();
        return response()->json(['message' => 'Registro deletado com sucesso'], Response::HTTP_OK);
    }

    public function hardDelete(String $id): JsonResponse
    {
        $this->exampleCRUD
        ->withTrashed()
        ->findOrFail($id)
        ->forceDelete();

        return response()->json(['message' => 'Registro excluído com sucesso'],Response::HTTP_OK);
    }

}
