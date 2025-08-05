<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenresResource;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenresController extends Controller
{
    public function index()
    {
        $genres = Genres::paginate(10);
        return GenresResource::collection($genres);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $model = Genres::create($request->all());
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
        return new GenresResource($model);
    }
    public function show($id)
    {

        $genre = Genres::find($id);
        if (!$genre) {
            return response()->json([
                'errors' => "File not found",
            ], 404);
        }
        return new GenresResource($genre);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:2',
            'attach'=>'nullable|array',
            'detach'=>'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $model = Genres::find($id);
            if (!$model) {
                return response()->json([
                    'errors' => "File not found",
                ], 404);
            }
            $model->update(['title'=>$request->has('title') ? $request->title : $model->title]);

            if($request->has('attach')) {
                $model->films()->attach($request->attach);
            }
            if ($request->has('detach')) {
                $model->films()->detach($request->detach);
            }
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
        return new GenresResource($model);
    }

    public function destroy($id)
    {
        $model = Genres::find($id);
        if (!$model) {
            return response()->json([
                'errors' => "File not found",
            ], 404);
        }
        $model->delete();
        return response()->json(['status'=>200, 'msg'=>'Item deleted successfully']);
    }
}
