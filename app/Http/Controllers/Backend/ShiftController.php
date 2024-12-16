<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->model = new Shift();
        $this->mandatory = [
            'shift_code' => 'nullable|string|max:225',
            'companies_code' => 'required|string|max:225',
            'shift_name' => 'required|string|max:225',
            'shift_start_time_before_break' => 'required|date_format:H:i',
            'shift_end_time_before_break' => 'required|date_format:H:i',
            'shift_start_time_break' => 'nullable|date_format:H:i',
            'shift_end_time_break' => 'nullable|date_format:H:i',
            'shift_start_time_after_break' => 'required|date_format:H:i',
            'shift_end_time_after_break' => 'required|date_format:H:i',
            'shift_notes' => 'nullable|string',
        ];
    }

    public function index()
    {
        $this->checkAuthorization(auth()->user(), ['shifts.view']);

        $listdata = $this->model
            ->where('shift_soft_delete', 0)
            ->paginate(15);

        return view('backend.pages.shifts.index', [
            'shifts' => $listdata,
        ]);
    }

    public function show($id)
    {
        $this->checkAuthorization(auth()->user(), ['shifts.view']);
        $model = $this->model->find($id);
        return $model;
    }

    public function store(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['shifts.create']);
        $validator = Validator::make($request->all(), $this->mandatory);

        if ($validator->fails()) {
            $messages = [
                'data' => $validator->errors()->first(),
                'status' => 401,
            ];
            return response()->json($messages);
        }

        $result = $this->model->create([
            'shift_code' => str_pad((string)mt_rand(0, 9999), 4, '0', STR_PAD_LEFT),
            'companies_code' => $request->companies_code,
            'shift_name' => $request->shift_name,
            'shift_start_time_before_break' => $request->shift_start_time_before_break,
            'shift_end_time_before_break' => $request->shift_end_time_before_break,
            'shift_start_time_break' => $request->shift_start_time_break,
            'shift_end_time_break' => $request->shift_end_time_break,
            'shift_start_time_after_break' => $request->shift_start_time_after_break,
            'shift_end_time_after_break' => $request->shift_end_time_after_break,
            'shift_notes' => $request->shift_notes,
            'shift_created_at' => now(),
            'shift_created_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Shift has been created.'));
        return $result;
    }

    public function update(Request $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['shifts.edit']);

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
            'shift_name' => $request->shift_name,
            'shift_start_time_before_break' => $request->shift_start_time_before_break,
            'shift_end_time_before_break' => $request->shift_end_time_before_break,
            'shift_start_time_break' => $request->shift_start_time_break,
            'shift_end_time_break' => $request->shift_end_time_break,
            'shift_start_time_after_break' => $request->shift_start_time_after_break,
            'shift_end_time_after_break' => $request->shift_end_time_after_break,
            'shift_notes' => $request->shift_notes,
            'shift_updated_at' => now(),
            'shift_updated_by' => Session::get('user_code'),
        ]);

        session()->flash('success', __('Shift has been updated.'));
        return $result;
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['shifts.delete']);

        $result = $this->model->find($id)->update([
            'shift_deleted_at' => now(),
            'shift_deleted_by' => Session::get('user_code'),
            'shift_soft_delete' => 1,
        ]);
        session()->flash('success', __('Shift has been deleted.'));
        return $result;
    }
}
