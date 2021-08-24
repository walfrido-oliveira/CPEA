<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectPointMatrix;

class ProjectPointMatrixController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = ProjectPointMatrix::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => __('Ponto/Matriz Apagado com Sucesso!'),
            'alert-type' => 'success'
        ]);
    }
}
