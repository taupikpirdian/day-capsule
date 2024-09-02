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
            <div class="table-responsive theme-scrollbar">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($datas as $role)
                  <tr>
                    <td>{{ $role->name }}</td>
                    <td class="w-action"> 
                      <ul class="action"> 
                        <li class="edit"> <a href="{{route('roles.edit', $role->id)}}"><i class="fa fa-pencil-square-o"></i></a></li>
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
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
  <!-- Container-fluid Ends-->

<div style="height: 10px"></div>
@endsection

@push ('after-scripts')
    <script>
      // ----------Shifts Overview-----//
    </script>
@endpush
