<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmResource;
use App\Http\Resources\GenresResource;
use App\Models\Films;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class FilmsController extends Controller
{
    public function index()
    {
        $films = Films::paginate(10);
        return FilmResource::collection($films);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|min:2',
            'file' => ['nullable', File::image()],
            'is_published' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $model = Films::create($request->except('file'));
            if ($request->hasFile('file')) {
                $folder = "images/films/{$model->id}/";
                $filename = uniqid(time(), true) . '.' . $request->file('file')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs($folder, $request->file('file'), $filename);

                $model->update([
                    'poster' => $folder . $filename
                ]);
            }
        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ],400);
        }
        return new FilmResource($model);
    }
    public function show($id)
    {

        $genre = Films::find($id);
        if (!$genre) {
            return response()->json([
                'errors' => "File not found",
            ], 404);
        }
        return new FilmResource($genre);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|min:2',
            'file' => ['nullable', File::image()],
            'is_published' => 'nullable|boolean',
            'attach'=>'nullable|array',
            'detach'=>'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $model = Films::find($id);
            if (!$model) {
                return response()->json([
                    'errors' => "File not found",
                ], 404);
            }

            $model->update([
                'title'=> $request->has('title') ? $request->title : $model->title,
                'is_published' => $request->has('is_published') ? $request->is_published : $model->is_published
            ]);
            if($request->has('file')) {
                $folder = "images/films/{$model->id}/";
                if (Storage::disk('public')->exists($folder)) {
                    Storage::disk('public')->deleteDirectory($folder);
                }
                $filename = uniqid(time(), true) . '.' . $request->file('file')->getClientOriginalExtension();
                Storage::disk('public')->putFileAs($folder, $request->file('file'), $filename);

                $model->update([
                    'poster' => $folder . $filename
                ]);
            }
            if($request->has('attach')) {
                $model->genres()->attach($request->attach);
            }
            if ($request->has('detach')) {
                $model->genres()->detach($request->detach);
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
        $folder = "images/films/{$model->id}/";
        if (Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->deleteDirectory($folder);
        }
        $model->delete();
        return response()->json(['status'=>200, 'msg'=>'Item deleted successfully']);
    }
}
