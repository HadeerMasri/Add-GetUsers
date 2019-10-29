<?php

namespace App\Http\Controllers;

use App\Data;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function create(){
        return view('show');
    }
    public function storeItem(Request $request) {
//        dd($request);
        $data = new Data ();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->save ();
        return $data;
    }
    public function readItems(Request $request) {
//        $data = Data::all();
//        return response()->json(['data'=> $data]);
            if ( $request->input('client') ) {
                return Data::select('id', 'name', 'email', 'mobile')->get();
            }
            $columns = ['name', 'email', 'mobile'];

            $length = $request->input('length');
            $column = $request->input('column'); //Index
            $dir = $request->input('dir');
            $searchValue = $request->input('search');

            $query = Data::select('id', 'name', 'email', 'mobile')->orderBy($columns[$column], $dir);

            if ($searchValue) {
                $query->where(function($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('mobile', 'like', '%' . $searchValue . '%');
                });
            }

            $users = $query->paginate($length);
            return ['data' => $users, 'draw' => $request->input('draw')];
        }

    public function show(){
        return view('show');
    }
    public function deleteItem(Request $request) {
        $data = Data::find ( $request->id )->delete ();
    }
}
