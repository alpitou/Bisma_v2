<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function __construct()
    {
        $this->model = new City();
        $this->mandatory = [
            'cities_name' => 'required',
            'cities_code' => 'nullable|string|max:225',
            'provinces_code' => 'required',
        ];
    }

    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['cities.view']);

        $listdata = $this->model
            ->where('cities_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.cities.index', [
            'cities' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['cities.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['cities.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->first(),
                'status' => 401,
            ]);
        }

        $result = $this->model->create([
            'cities_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'provinces_code' => $request->provinces_code,
            'cities_name' => $request->cities_name,
            'cities_notes' => $request->cities_notes,
            'cities_status' => $request->cities_status,
            'cities_created_at' => now(),
            'cities_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('cities has been created.'));
        return $request;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['cities.edit']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->first(),
                'status' => 401,
            ]);
        }

        $result = $this->model->find($id)->update([
            'cities_name' => $request->cities_name,
            'provinces_code' => $request->provinces_code,
            'cities_notes' => $request->cities_notes,
            'cities_status' => $request->cities_status,
            'cities_updated_at' => now(),
            'cities_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('cities has been updated.'));
        return $request;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['cities.delete']);

        $result = $this->model->find($id)->update([
            'cities_deleted_at' => now(),
            'cities_deleted_by' => Session::get('user_code'),
            'cities_soft_delete' => 1,
        ]);

        session()->flash('success', __('cities has been deleted.'));
        return $result;
    }
}
