<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Submenus;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubmenusController extends Controller
{
    public function __construct()
    {
        $this->model = new Submenus();
        $this->mandatory = array(
            'menus_code' => 'required', 
            'submenus_name' => 'required',
            'submenus_notes' => 'required', 
		);
    }

    public function index(): Renderable
    {        
        $this->checkAuthorization(auth()->user(), ['submenus.view']);

        $listdata = $this->model
        ->where('submenus_soft_delete', 0)
        ->paginate(15);

        return view('backend.pages.submenus.index', [
            'submenus' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['submenus.view']);
        $model = $this->model
        ->leftjoin('menus', 'submenus.menus_code', '=', 'menus.menus_code')
        ->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['submenus.create']);
        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->create([
            'submenus_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'menus_code' => $request->menus_code, 
            'submenus_name' => $request->submenus_name, 
            'submenus_notes' => $request->submenus_notes, 
            'submenus_created_at' => date("Y-m-d h:i:s"),
            'submenus_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Menus has been created.'));
        return $request;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['submenus.edit']);

        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->find($id)->update([
            'menus_code' => $request->menus_code, 
            'submenus_name' => $request->submenus_name, 
            'submenus_notes' => $request->submenus_notes, 
            'submenus_updated_at' => date("Y-m-d h:i:s"),
            'submenus_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Menus has been updated.');
        return $request;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['submenus.delete']);

        $result = $this->model->find($id)->update([
            'submenus_deleted_at' => date("Y-m-d h:i:s"),
            'submenus_deleted_by' => Session::get('user_code'),
            'submenus_soft_delete' => 1,
        ]);
        session()->flash('success', 'Menus has been deleted.');
        return $result;
    }
}
