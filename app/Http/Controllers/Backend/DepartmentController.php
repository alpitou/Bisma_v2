<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->model = new Department();
        $this->mandatory = array(
            'department_name' => 'required',
            // 'department_code' => 'nullable|unique:departments,department_code',
            'department_code' => 'nullable|string|max:225',
            'division_code' => 'required',
        );
    }

    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['department.view']);

        $listdata = $this->model
            ->where('department_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.departments.index', [
            'departments' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['department.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['department.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->first(),
                'status' => 401,
            ]);
        }

        $result = $this->model->create([
            'department_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'division_code' => $request->division_code,
            'department_name' => $request->department_name,
            'department_notes' => $request->department_notes,
            'department_created_at' => now(),
            'department_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Department has been created.'));
        return $request;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['department.edit']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->first(),
                'status' => 401,
            ]);
        }

        $result = $this->model->find($id)->update([
            'department_name' => $request->department_name,
            'division_code' => $request->division_code,
            'department_notes' => $request->department_notes,
            'department_updated_at' => now(),
            'department_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Department has been updated.'));
        return $request;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['department.delete']);

        $result = $this->model->find($id)->update([
            'department_deleted_at' => now(),
            'department_deleted_by' => Session::get('user_code'),
            'department_soft_delete' => 1,
        ]);

        session()->flash('success', __('Department has been deleted.'));
        return $result;
    }
}
