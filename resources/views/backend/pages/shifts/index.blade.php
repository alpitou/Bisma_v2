@extends('backend.layouts.master')

@section('title')
Shifts - Admin Panel
@endsection

@section('admin-content')
<div class="content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 rt-mb-25">
                    <div class="breadcrumbs">
                        <div class="breadcrumb-title"> Account Setting</div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href='/admin'>Home</a></li>
                                <li class="breadcrumb-item"><a href='/admin'>Setting</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Shifts</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-md-8">
                    <section class="tables">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-wrapper">
                                    <div class="table-content table-responsive">
                                        <table class="table align-middle table-basic">
                                            <thead style="text-align: center">
                                                <tr>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">NAME</th>
                                                    <th scope="col">Shift CODE</th>
                                                    <th scope="col">START TIME (Before Break)</th>
                                                    <th scope="col">END TIME (Before Break)</th>
                                                    <th scope="col">START TIME (Break)</th>
                                                    <th scope="col">END TIME (Break)</th>
                                                    <th scope="col">START TIME (After Break)</th>
                                                    <th scope="col">END TIME (After Break)</th>
                                                    <th scope="col">Company CODE</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($shifts as $shift)
                                                    <tr>
                                                        <td scope="row">{{ $loop->index+1 }}</td>
                                                        <td>{{ $shift->shift_name }}</td>
                                                        <td>{{ $shift->shift_code }}</td>
                                                        <td>{{ $shift->shift_start_time_before_break }}</td>
                                                        <td>{{ $shift->shift_end_time_before_break }}</td>
                                                        <td>{{ $shift->shift_start_time_break }}</td>
                                                        <td>{{ $shift->shift_end_time_break }}</td>
                                                        <td>{{ $shift->shift_start_time_after_break }}</td>
                                                        <td>{{ $shift->shift_end_time_after_break }}</td>
                                                        <td>{{ $shift->companies_code }}</td>
                                                        <td>
                                                            <ul class="action-btn">
                                                                <li>
                                                                    <button onclick="delete_data('{{ $shift->shift_id }}')">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M12.5 3.5L3.5 12.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M12.5 12.5L3.5 3.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                        </svg>
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button title="Edit" onclick="showedit('{{ $shift->shift_id }}')">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M12.1464 1.85355C12.3417 1.65829 12.6583 1.65829 12.8536 1.85355L14.1464 3.14645C14.3417 3.34171 14.3417 3.65829 14.1464 3.85355L5.35355 12.6464L2.5 13.5L3.35355 10.6464L12.1464 1.85355Z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M11.5 2.5L13.5 4.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                        </svg>
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xxl-4 col-xl-4 col-md-4">
                    <div class="card">
                        <div class="card-header">Form Input</div>
                        <div class="card-body">
                            <form>
                                <input type="hidden" id="shift_id">
                                <div class="fromGroup mb-3">
                                    <label>Shift Name</label>
                                    <input class="form-control" type="text" id="shift_name" placeholder="Shift Name" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Start Time (Before Break)</label>
                                    <input class="form-control" type="time" id="shift_start_time_before_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>End Time (Before Break)</label>
                                    <input class="form-control" type="time" id="shift_end_time_before_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Start Time (Break)</label>
                                    <input class="form-control" type="time" id="shift_start_time_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>End Time (Break)</label>
                                    <input class="form-control" type="time" id="shift_end_time_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Start Time (After Break)</label>
                                    <input class="form-control" type="time" id="shift_start_time_after_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>End Time (After Break)</label>
                                    <input class="form-control" type="time" id="shift_end_time_after_break" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Company Code</label>
                                    <input class="form-control" type="text" id="companies_code" placeholder="Company Code" />
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-primary pill mt-3" onclick="save()">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-secondary2 pill btn-icon" onclick="reload()">
                                        <span class="button-content-wrapper">
                                            <span class="button-text">New Data</span>
                                            <span class="button-icon">
                                                <i class="ph-arrow-left"></i>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function reload(){
        window.open("/admin/shifts", "_self");
    }

    function save() {
        let id = document.getElementById('shift_id').value;
        if (id === '') {
            saveInput();
        } else {
            updateInput(id);
        }
    }

    function saveInput() {
        let postdata = new FormData();
        postdata.append('_token', document.getElementsByName('_token')[0].defaultValue);
        postdata.append('shift_name', document.getElementById('shift_name').value);
        postdata.append('shift_start_time_before_break', document.getElementById('shift_start_time_before_break').value);
        postdata.append('shift_end_time_before_break', document.getElementById('shift_end_time_before_break').value);
        postdata.append('shift_start_time_break', document.getElementById('shift_start_time_break').value);
        postdata.append('shift_end_time_break', document.getElementById('shift_end_time_break').value);
        postdata.append('shift_start_time_after_break', document.getElementById('shift_start_time_after_break').value);
        postdata.append('shift_end_time_after_break', document.getElementById('shift_end_time_after_break').value);
        postdata.append('companies_code', document.getElementById('companies_code').value);

        $.ajax({
            type: "POST",
            url: "/admin/shifts",
            data: postdata,
            processData: false,
            contentType: false,
            dataType: "json",
            async: false,
            success: function (data) {
                if (data.status === 401) {
                    alert('All fields are required');
                    return;
                } else if (data.status === 501) {
                    alert(data.message);
                    return;
                } else {
                    alert('Successfully saved');
                    setTimeout(function () {
                        window.open("/admin/shifts", "_self");
                    }, 500);
                }
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });
    }

    function showedit(id) {
        $.ajax({
            type: "GET",
            url: "/admin/shifts/" + id,
            dataType: "json",
            async: false,
            success: function (data) {
                document.getElementById('shift_id').value = data.id;
                document.getElementById('shift_name').value = data.shift_name;
                document.getElementById('shift_start_time_before_break').value = data.shift_start_time_before_break;
                document.getElementById('shift_end_time_before_break').value = data.shift_end_time_before_break;
                document.getElementById('shift_start_time_break').value = data.shift_start_time_break;
                document.getElementById('shift_end_time_break').value = data.shift_end_time_break;
                document.getElementById('shift_start_time_after_break').value = data.shift_start_time_after_break;
                document.getElementById('shift_end_time_after_break').value = data.shift_end_time_after_break;
                document.getElementById('companies_code').value = data.companies_code;
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });
    }

    function updateInput(id) {
        let postdata = new FormData();
        postdata.append('_token', document.getElementsByName('_token')[0].defaultValue);
        postdata.append('shift_name', document.getElementById('shift_name').value);
        postdata.append('shift_start_time_before_break', document.getElementById('shift_start_time_before_break').value);
        postdata.append('shift_end_time_before_break', document.getElementById('shift_end_time_before_break').value);
        postdata.append('shift_start_time_break', document.getElementById('shift_start_time_break').value);
        postdata.append('shift_end_time_break', document.getElementById('shift_end_time_break').value);
        postdata.append('shift_start_time_after_break', document.getElementById('shift_start_time_after_break').value);
        postdata.append('shift_end_time_after_break', document.getElementById('shift_end_time_after_break').value);
        postdata.append('companies_code', document.getElementById('companies_code').value);

        $.ajax({
            type: "PUT",
            url: "/admin/shifts/" + id,
            data: postdata,
            processData: false,
            contentType: false,
            dataType: "json",
            async: false,
            success: function (data) {
                if (data.status === 401) {
                    alert('All fields are required');
                    return;
                } else {
                    alert('Successfully updated');
                    setTimeout(function () {
                        window.open("/admin/shifts", "_self");
                    }, 500);
                }
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });
    }

    function delete_data(id) {
        if (confirm("Are you sure you want to delete this data?")) {
            let postdata = new FormData();
            postdata.append('_token', document.getElementsByName('_token')[0].defaultValue);

            $.ajax({
                type: "DELETE",
                url: "/admin/shifts/" + id,
                data: postdata,
                processData: false,
                contentType: false,
                dataType: "json",
                async: false,
                success: function (data) {
                    if (data.status === 401) {
                        alert('Failed to delete');
                        return;
                    } else {
                        alert('Successfully deleted');
                        setTimeout(function () {
                            window.open("/admin/shifts", "_self");
                        }, 500);
                    }
                },
                error: function (dataerror) {
                    console.log(dataerror);
                }
            });
        }
    }
</script>
@endsection
