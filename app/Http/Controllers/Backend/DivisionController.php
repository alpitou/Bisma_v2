<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    public function __construct()
    {
        $this->model = new Division();
        $this->mandatory = [
            'division_code' => 'nullable|string|max:225',
            'companies_code' => 'required|string|max:225',
            'division_name' => 'required|string|max:225',
            'division_notes' => 'nullable|string',
        ];
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['divisions.view']);

        $listdata = $this->model
            ->where('division_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.divisions.index', [
            'divisions' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['divisions.view']);

        $model = $this->model->find($id);

        if (!$model) {
            return response()->json([
                'data' => 'Division not found.',
                'status' => 404,
            ]);
        }

        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['divisions.create']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'division_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'companies_code' => $request->companies_code,
            'division_name' => $request->division_name,
            'division_notes' => $request->division_notes,
            'division_created_at' => date("Y-m-d H:i:s"),
            'division_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Division has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['divisions.edit']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $model = $this->model->find($id);

        if (!$model) {
            return response()->json([
                'data' => 'Division not found.',
                'status' => 404,
            ]);
        }

        $result = $model->update([
            'companies_code' => $request->companies_code,
            'division_name' => $request->division_name,
            'division_notes' => $request->division_notes,
            'division_updated_at' => date("Y-m-d H:i:s"),
            'division_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Division has been updated.'));
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['divisions.delete']);

        $model = $this->model->find($id);

        if (!$model) {
            return response()->json([
                'data' => 'Division not found.',
                'status' => 404,
            ]);
        }

        $result = $model->update([
            'division_deleted_at' => date("Y-m-d H:i:s"),
            'division_deleted_by' => Session::get('user_code'),
            'division_soft_delete' => 1,
        ]);

        session()->flash('success', __('Division has been deleted.'));
        return $result;
    }
}
