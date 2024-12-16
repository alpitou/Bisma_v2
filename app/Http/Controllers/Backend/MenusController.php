<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MenusController extends Controller
{
    public function __construct()
    {
        $this->model = new Menus();
        $this->mandatory = array(
            'moduls_code' => 'required', 
            'menus_name' => 'required', 
            'menus_route' => 'required',
            'menus_notes' => 'required',
		);
    }

    public function index(): Renderable
    {        
        $this->checkAuthorization(auth()->user(), ['menus.view']);

        $listdata = $this->model
        ->where('menus_soft_delete', 0)
        ->paginate(15);

        return view('backend.pages.menus.index', [
            'menus' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['menus.view']);
        $model = $this->model
        ->leftjoin('moduls', 'menus.moduls_code', '=', 'moduls.moduls_code')
        ->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['menus.create']);
        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->create([
            'menus_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'moduls_code' => $request->moduls_code, 
            'menus_name' => $request->menus_name, 
            'menus_route' => $request->menus_route, 
            'menus_notes' => $request->menus_notes, 
            'menus_created_at' => date("Y-m-d h:i:s"),
            'menus_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Menus has been created.'));
        return $request;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['menus.edit']);

        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->find($id)->update([
            'moduls_code' => $request->moduls_code, 
            'menus_name' => $request->menus_name, 
            'menus_route' => $request->menus_route, 
            'menus_notes' => $request->menus_notes, 
            'menus_updated_at' => date("Y-m-d h:i:s"),
            'menus_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Menus has been updated.');
        return $request;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['menus.delete']);

        $result = $this->model->find($id)->update([
            'menus_deleted_at' => date("Y-m-d h:i:s"),
            'menus_deleted_by' => Session::get('user_code'),
            'menus_soft_delete' => 1,
        ]);
        session()->flash('success', 'Menus has been deleted.');
        return $result;
    }

    public function combo(Request $request)
    {
        $search = !empty($_GET['search']) ? $_GET['search'] : '%';

        $listdata = $this->model
            ->select('menus_code as id', 'menus_name as text')
            ->where('menus_name', 'like', '%' . $search . '%')
            ->where('menus_soft_delete', 0)
            ->get();

        return response()->json($listdata);
    }
}
