<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::orderBy("id")->get();
        return GameResource::collection($games);
    }


 
    public function store(StoreGameRequest $request)
    {
        $newGame = Game::create($request->validated());

        if($request->hasFile('img_url')){
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ]
            ]);

            $upload = $cloudinary->uploadApi()->upload(
            $request->file('img_url')->getRealPath()
           
        );

        $newGame['img_url'] = $upload['secure_url'];
        $newGame->save();
        }

        return new GameResource($newGame);
    }


    public function show(Game $game)
    {
        return new GameResource($game);
    }


    public function update(UpdateGameRequest $request, $id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Não encontrado'], 404);
        }

        $game->fill($request->safe()->except('img_url'));

            if($request->hasFile('img_url')){
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key' => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET'),
                    ]
                ]);

                $upload = $cloudinary->uploadApi()->upload(
                    $request->file('img_url')->getRealPath()
                );

                $game->img_url = $upload['secure_url'];
            }
            $game->save();


            return response()->json($game);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return response(null, 204);
    }
}
