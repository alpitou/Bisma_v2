
@extends('backend.layouts.master')

@section('title')
Sub Menu - Admin Panel
@endsection

@section('admin-content')
<div class="content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 rt-mb-25">
                    <div class="breadcrumbs ">
                        <div class="breadcrumb-title"> Account Setting</div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href='/admin'>Home</a></li>
                                <li class="breadcrumb-item"><a href='/admin'>Setting</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Sub Menu</li>
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
                                        <table class="table align-middle table-basic ">
                                            <thead style="text-align: center">
                                                <tr>
                                                    <th scope="col">NO</th>
                                                    <th scope="col">NAME</th>
                                                    <th scope="col">NOTE</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($submenus as $submenu)
                                                    <tr>
                                                        <td scope="row">{{ $loop->index+1 }}</td>
                                                        <td>{{ $submenu->submenus_name }}</td>
                                                        <td>{{ $submenu->submenus_notes }}</td>
                                                        <td>
                                                            <ul class="action-btn">
                                                                <li>
                                                                    <button onclick="delete_data('{{ $submenu->submenus_id }}')">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M12.5 3.5L3.5 12.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M12.5 12.5L3.5 3.5" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                        </svg>
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button title="Edit" onclick="showedit('{{ $submenu->submenus_id }}')">
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
                                <input type="hidden" id="submenus_id">
                                <div class="fromGroup mb-3">
                                    <label>Menu</Select></label>
                                    <input class="form-control" type="text" id="menus_code" placeholder="Code Menu" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Nama</label>
                                    <input class="form-control" type="text" id="submenus_name" placeholder="Nama Sub Menu" />
                                </div>
                                <div class="fromGroup mb-3">
                                    <label>Note</label>
                                    <textarea class="form-control" name="submenus_notes" id="submenus_notes" placeholder="Catatan"></textarea>
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-primary pill mt-3" onclick="save()">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-secondary2 pill btn-icon" onclick="reload()">
                                        <span class="button-content-wrapper">
                                            <span class="button-text">
                                                New Data
                                            </span>
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
        // setTimeout(function () {
            window.open("/admin/submenus", "_self");
        // }, 500);
    }

    function save() {
        id = document.getElementById('submenus_id').value;
        if (id == '') {
            saveInput();
        } else {
            updateInput(id);
        }
    }

    function saveInput() {
        var postdata = new FormData();
        // Tambahkan token CSRF
        postdata.append('_token', document.getElementsByName('_token')[0].defaultValue);
        postdata.append('menus_code', document.getElementById('menus_code').value); 
        postdata.append('submenus_name', document.getElementById('submenus_name').value); 
        postdata.append('submenus_notes', document.getElementById('submenus_notes').value); 

        $.ajax({
            type: "POST",
            url: "/admin/submenus",
            data: (postdata),
            processData: false, // Jangan ubah data
            contentType: false, // Atur tipe konten secara otomatis
            dataType: "json",
            async: false,
            success: function (data) {
                // console.log('hasil => ',data);
                
                if (data.status == 401) {
                    alert('Form Wajib Harus diisi');
                    return;
                } else if (data.status == 501) {
                    alert(data.message);
                    return;
                } else {
                    alert('Berhasil Disimpan');
                    setTimeout(function () {
                        window.open("/admin/submenus", "_self");
                    }, 500);
                }
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });

    }

    function showedit(id){
        $.ajax({
            type: "GET",
            url: "/admin/submenus/"+id,
            dataType: "json",
            async: false,
            success: function (data) {
                // console.log('hasil => ',data);
                document.getElementById('submenus_id').value = data.submenus_id; 
                document.getElementById('menus_code').value = data.menus_code; 
                document.getElementById('submenus_name').value = data.submenus_name; 
                document.getElementById('submenus_notes').value = data.submenus_notes;
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });
    }

    function updateInput(id) {
        var postdata = new FormData();
        // Tambahkan token CSRF
        postdata.append('_token', document.getElementsByName('_token')[0].defaultValue);
        postdata.append('menus_code', document.getElementById('menus_code').value); 
        postdata.append('submenus_name', document.getElementById('submenus_name').value); 
        postdata.append('submenus_notes', document.getElementById('submenus_notes').value); 
        // console.log('Data FormData: ', Array.from(postdata.entries()));
        

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "POST",
            url: "/admin/submenus/"+id,
            data: (postdata),
            processData: false, // Jangan ubah data
            contentType: false, // Atur tipe konten secara otomatis
            dataType: "json",
            async: false,
            success: function (data) {
                // console.log('hasil => ',data);
                
                if (data.status == 401) {
                    alert('Form Wajib Harus diisi');
                    return;
                } else if (data.status == 501) {
                    alert(data.message);
                    return;
                } else {
                    alert('Berhasil Diupdate');
                    setTimeout(function () {
                        window.open("/admin/submenus", "_self");
                    }, 500);
                }
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });

    }

    function delete_data(id){
        var postdata = {};
        postdata._token = document.getElementsByName('_token')[0].defaultValue;
        
        $.ajax({
            type: "DELETE",
            url: "/admin/submenus/"+id,
            data: (postdata),
            dataType: "json",
            async: false,
            success: function (data) {
                if (data.status == 401) {
                    alert('Form Wajib Harus diisi');
                    return;
                } else if (data.status == 501) {
                    alert(data.message);
                    return;
                } else {
                    alert('Data Berhasil Dihapus');
                    setTimeout(function () {
                        window.open("/admin/submenus", "_self");
                    }, 500);
                }
            },
            error: function (dataerror) {
                console.log(dataerror);
            }
        });
    }

</script>
@endsection
