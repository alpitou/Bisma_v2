<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->model = new Province();
        $this->mandatory = [
            'provinces_code' => 'nullable|string|max:225',
            'provinces_name' => 'required|string|max:225',
            'provinces_notes' => 'nullable|string',
            'provinces_status' => 'nullable|string|max:225',
        ];
    }

    public function index()
    {
        // $this->checkAuthorization(auth()->user(), ['provinces.view']);

        $listdata = $this->model
            ->where('provinces_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.provinces.index', [
            'provinces' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['provinces.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        // $this->checkAuthorization(auth()->user(), ['provinces.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'provinces_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'provinces_name' => $request->provinces_name,
            'provinces_notes' => $request->provinces_notes,
            'provinces_status' => $request->provinces_status,
            'provinces_created_at' => now(),
            'provinces_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Province has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['provinces.edit']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->find($id)->update([
            'provinces_name' => $request->provinces_name,
            'provinces_notes' => $request->provinces_notes,
            'provinces_status' => $request->provinces_status,
            'provinces_updated_at' => now(),
            'provinces_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Province has been updated.');
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['provinces.delete']);

        $result = $this->model->find($id)->update([
            'provinces_deleted_at' => now(),
            'provinces_deleted_by' => Session::get('user_code'),
            'provinces_soft_delete' => 1,
        ]);
        session()->flash('success', 'Province has been deleted.');
        return $result;
    }
}
