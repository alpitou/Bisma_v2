<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Moduls;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ModulsController extends Controller
{
    public function __construct()
    {
        $this->model = new Moduls();
        $this->mandatory = array(
            'moduls_name' => 'required', 
            'moduls_icon' => 'required', 
            'moduls_notes' => 'required',
		);
    }

    public function index(): Renderable
    {        
        $this->checkAuthorization(auth()->user(), ['moduls.view']);

        $listdata = $this->model
        ->where('moduls_soft_delete', 0)
        ->paginate(15);

        return view('backend.pages.moduls.index', [
            'moduls' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['moduls.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['moduls.create']);
        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->create([
            'moduls_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'moduls_name' => $request->moduls_name, 
            'moduls_icon' => $request->moduls_icon,
            'moduls_notes' => $request->moduls_notes, 
            'moduls_created_at' => date("Y-m-d h:i:s"),
            'moduls_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('User has been created.'));
        return $request;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['moduls.edit']);

        $validator = Validator::make($request->all(), $this->mandatory); // $this->mainroute

		if ($validator->fails()) {
			$messages = [
				'data' => $validator->errors()->first(),
				'status' => 401,
			];
			return response()->json($messages);
		}

        $result = $this->model->find($id)->update([
            'moduls_name' => $request->moduls_name, 
            'moduls_icon' => $request->moduls_icon,
            'moduls_notes' => $request->moduls_notes, 
            'moduls_updated_at' => date("Y-m-d h:i:s"),
            'moduls_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Admin has been updated.');
        return $request;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['moduls.delete']);

        $result = $this->model->find($id)->update([
            'moduls_deleted_at' => date("Y-m-d h:i:s"),
            'moduls_deleted_by' => Session::get('user_code'),
            'moduls_soft_delete' => 1,
        ]);
        session()->flash('success', 'Admin has been deleted.');
        return $result;
    }

    public function combo(Request $request)
    {
        $search = !empty($_GET['search']) ? $_GET['search'] : '%';
        // return $search;

        $listdata = $this->model
            ->select('moduls_code as id', 'moduls_name as text')
            ->where('moduls_name', 'like', '%' . $search . '%')
            ->where('moduls_soft_delete', 0)
            ->get();

        return response()->json($listdata);
    }
}
