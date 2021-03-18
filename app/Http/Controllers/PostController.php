<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('txtsearch')) {
            return Post::orWhere('title', 'like', '%' . $request->txtBuscar . '%')->get();
        } else
            return Post::all();
    }

    //GET post/id
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    //POST post
    public function store(Request $request)
    {
        
        $this->validar($request);

        $input = $request->all();
        $input['user_id'] = 1;
        $post=Post::create($input);
        
        return response()->json($post, 201);
    }

    //PUT post/id
    public function update($id, Request $request)
    {
        //validar datos
        $this->validar($request, $id);

        $input = $request->all();

        $post = Post::find($id);
        $post->update($input);

        return response()->json([
            'res' => true,
            'message' => 'Registro modificado correctamente'
        ]);
    }

    //DELETE post/id
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete($id);
        return response()->json([
            'res' => true,
            'message' => 'Registro eliminado correctamente'
        ]);
    }
    /** JOIN de post y user 
     * User_id
    */
    public function users(){

    }
    /**Son las reglas de la request */
    private function validar($request, $id = null)
    {
        $ruleUpdate = is_null($id) ? '' : ',' . $id;

        $this->validate($request, [
            'title' => 'required|min:3|max:100',
            'content' => 'required|min:5'
        ]);
    }
    
}
