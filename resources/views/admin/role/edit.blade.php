@extends('layouts.app')
@section('content')
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ $title }}</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $data->id) }}" class="row g-3 needs-validation custom-input" novalidate="">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label" for="role">Role Name</label>
                    <input class="form-control" id="role" type="text" placeholder="Role Name" name="role" value="{{ $data->name }}" required="" disabled>
                    <div class="invalid-feedback">Please enter your valid </div>
                    <div class="valid-feedback">Looks's Good!</div>
                </div>

                <div class="col-12">
                    <div class="card-wrapper border rounded-3 checkbox-checked">
                      <h6 class="sub-title">Permission </h6>
                      <label class="d-block" for="all"></label>
                      <input class="checkbox_animated" id="all" type="checkbox" value="all">All
                      @foreach ($permissions as $permission)
                        <label class="d-block" for="{{ $permission->name }}"></label>
                        <input class="checkbox_animated" id="{{ $permission->name }}" name="permissions[]" type="checkbox" value="{{ $permission->name }}" @if(inArrayCheck($arr_permission, $permission->name)) checked="" @endif>{{ $permission->name }}
                      @endforeach
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
  <!-- Container-fluid Ends-->

<div style="height: 10px"></div>
@endsection

@push ('after-scripts')
    <script>
        document.getElementById('all').addEventListener('change', function() {
            let allChecked = this.checked;
            let checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = allChecked;
            });
        });

        let individualCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
          individualCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                let allChecked = document.getElementById('all');
                if (!this.checked) {
                    allChecked.checked = false;
                } else {
                    let allSelected = true;
                    individualCheckboxes.forEach(function(cb) {
                        if (!cb.checked) {
                            allSelected = false;
                        }
                    });
                    allChecked.checked = allSelected;
                }
            });
        });
    </script>
@endpush
