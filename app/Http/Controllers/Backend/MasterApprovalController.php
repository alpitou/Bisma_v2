<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MasterApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MasterApprovalController extends Controller
{
    public function __construct()
    {
        $this->model = new MasterApproval();
        $this->mandatory = [
            'master_approvals_code' => 'nullable|string|max:225',
            'master_approvals_name' => 'required|string|max:225',
            'department_code' => 'required|string|max:225',
            'division_code' => 'required|string|max:225',
            'level_code' => 'required|string|max:225',
            'master_approvals_notes' => 'nullable|string',
        ];
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['master_approvals.view']);

        $listdata = $this->model
            ->where('master_approvals_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.master_approvals.index', [
            'master_approvals' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['master_approvals.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        // $this->checkAuthorization(auth()->user(), ['master_approvals.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'master_approvals_code' =>  str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'master_approvals_name' => $request->master_approvals_name,
            'department_code' => $request->department_code,
            'division_code' => $request->division_code,
            'level_code' => $request->level_code,
            'master_approvals_notes' => $request->master_approvals_notes,
            'master_approvals_created_at' => now(),
            'master_approvals_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Master Approval has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['master_approvals.edit']);

        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->find($id)->update([
            'master_approvals_code' => $request->master_approvals_code,
            'master_approvals_name' => $request->master_approvals_name,
            'department_code' => $request->department_code,
            'division_code' => $request->division_code,
            'level_code' => $request->level_code,
            'master_approvals_notes' => $request->master_approvals_notes,
            'master_approvals_updated_at' => now(),
            'master_approvals_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Master Approval has been updated.'));
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['master_approvals.delete']);

        $result = $this->model->find($id)->update([
            'master_approvals_deleted_at' => now(),
            'master_approvals_deleted_by' => Session::get('user_code'),
            'master_approvals_soft_delete' => 1,
        ]);
        session()->flash('success', __('Master Approval has been deleted.'));
        return $result;
    }
}
