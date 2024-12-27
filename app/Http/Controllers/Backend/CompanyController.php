<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->model = new Company();
        $this->mandatory = [
            'companies_code' => 'nullable|string|max:225',
            'companies_name' => 'required|string|max:225',
            'companies_notes' => 'nullable|string',
        ];
    }
    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['companies.view']);
        $search = $request->search ?? '';
    
        $listdata = $this->model
            ->where('companies_name', 'like', '%' . $search . '%')
            ->where('companies_soft_delete', 0)
            ->paginate(15);
    
        if ($request->ajax()) {
            return response()->json([
                'companies' => $listdata,
            ]);
        }
    
        return view('backend.pages.companies.index', [
            'companies' => $listdata,
            'search' => $search,
        ]);
    }
    

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['companies.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['companies.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'companies_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'companies_name' => $request->companies_name,
            'companies_notes' => $request->companies_notes,
            'companies_created_at' => date("Y-m-d h:i:s"),
            'companies_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Company has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['companies.edit']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->find($id)->update([
            'companies_name' => $request->companies_name,
            'companies_notes' => $request->companies_notes,
            'companies_updated_at' => date("Y-m-d h:i:s"),
            'companies_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', 'Company has been updated.');
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['companies.delete']);

        $result = $this->model->find($id)->update([
            'companies_deleted_at' => date("Y-m-d h:i:s"),
            'companies_deleted_by' => Session::get('user_code'),
            'companies_soft_delete' => 1,
        ]);
        session()->flash('success', 'Company has been deleted.');
        return $result;
    }

    public function combo(Request $request)
    {
        $search = !empty($_GET['search']) ? $_GET['search'] : '%';

        $listdata = $this->model
            ->select('companies_code as id', 'companies_name as text')
            ->where('companies_name', 'like', '%' . $search . '%')
            ->where('companies_soft_delete', 0)
            ->get();

        return response()->json($listdata);
    }
}
