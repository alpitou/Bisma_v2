<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Homebase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomebaseController extends Controller
{
    public function __construct()
    {
        $this->model = new Homebase();
        $this->mandatory = [
            'homebase_code' => 'nullable|string|max:225',
            'companies_code' => 'required|string|max:225',
            'homebase_name' => 'required|string|max:225',
            'homebase_notes' => 'nullable|string',
        ];
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['homebases.view']);

        $listdata = $this->model
            ->where('homebase_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.homebases.index', [
            'homebases' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['homebases.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['homebases.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'homebase_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'companies_code' => $request->companies_code,
            'homebase_name' => $request->homebase_name,
            'homebase_notes' => $request->homebase_notes,
            'homebase_created_at' => date("Y-m-d h:i:s"),
            'homebase_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Homebase has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['homebases.edit']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->find($id)->update([
            'companies_code' => $request->companies_code,
            'homebase_name' => $request->homebase_name,
            'homebase_notes' => $request->homebase_notes,
            'homebase_updated_at' => date("Y-m-d h:i:s"),
            'homebase_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Homebase has been updated.');
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['homebases.delete']);

        $result = $this->model->find($id)->update([
            'homebase_deleted_at' => date("Y-m-d h:i:s"),
            'homebase_deleted_by' => Session::get('user_code'),
            'homebase_soft_delete' => 1,
        ]);
        session()->flash('success', 'Homebase has been deleted.');
        return $result;
    }
}
