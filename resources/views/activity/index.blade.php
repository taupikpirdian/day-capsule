@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
      <div class="row">
        <div class="col-xl-3 box-col-6">
          <div class="md-sidebar">
            <a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)">filter</a>
            <div class="md-sidebar-aside job-left-aside custom-scrollbar">
              <div class="email-left-aside">
                <div class="card theme-scrollbar">
                  <div class="card-body">
                    <div class="email-app-sidebar left-bookmark">
                      <ul class="nav main-menu" role="tablist">
                        <li class="nav-item">
                          <button class="badge-light-primary btn-block btn-mail w-100" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="me-2" data-feather="plus"></i> Add Activity </button>
                        </li>
                        <li>
                          <span class="main-title"> Tags
                          </span>
                        </li>
                        @foreach ($data_tags as $dtag)
                        <li>
                          <a id="{{$dtag->title}}" data-bs-toggle="pill" href="#{{$dtag->title}}" role="tab" aria-controls="{{$dtag->title}}" aria-selected="false">
                            <span class="title">{{$dtag->title}}</span>
                          </a>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-9 col-md-12 box-col-12">
          <div class="email-right-aside bookmark-tabcontent">
            <div class="card email-body radius-left">
              <div class="ps-0">
                <div class="tab-content">
                  <div class="tab-pane fade active show" id="pills-created" role="tabpanel" aria-labelledby="pills-created-tab">
                    <div class="card mb-0">
                      <div class="card-header d-flex">
                        <h4 class="mb-0">{{ $title }}</h4>
                      </div>
                      <div class="card-body pb-0">
                        <div class="col-sm-12">
                          <div class="details-bookmark text-center">
                            <div class="row" id="bookmarkData">
                              <div class="table-responsive theme-scrollbar">
                                <table class="display" id="table_yajra">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Title</th>
                                      <th>Date</th>
                                      <th>Time</th>
                                      <th>Time Spent (m)</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody></tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Bookmark Modal-->
                    <div class="modal fade modal-bookmark" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form method="POST" action="{{ route('activity.store') }}" class="row g-3 needs-validation custom-input" novalidate="">
                              @csrf
                              <div class="row g-2">
                                <div class="mt-0 col-md-12">
                                  <label for="bm-weburl">Time spent</label>
                                  <input class="form-control" type="text" name="time_spent" autocomplete="off" required>
                                </div>
                                <div class="col-md-12">
                                  <label>Use the format: 6h 45m</label>
                                  <ul style="margin-left: 15px; margin-bottom: 15px; list-style-type: circle">
                                    <li>h: hours</li>
                                    <li>m: minutes</li>
                                  </ul>
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                  <label for="bm-weburl">Date Started</label>
                                  <div class="row">
                                    <div class="col-xxl-6 box-col-6">
                                        <div class="input-group flatpicker-calender">
                                        <input class="form-control" name="date" type="date" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 box-col-6">
                                        <div class="input-group flatpicker-calender">
                                        <input class="form-control" name="time" type="time" value="{{ date('H:i') }}">
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                  <label for="bm-title">Title</label>
                                  <div id="bloodhound">
                                    <input class="form-control typeahead" type="text" name="title" required="" placeholder="Please enter title">
                                  </div>
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                  <label>Description</label>
                                  <textarea class="form-control" name="desc" autocomplete="off"></textarea>
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                  <label for="bm-title">Tag</label>
                                  <select class="form-control select2-tags" multiple="multiple" name="tag[]">
                                    @foreach ($data_tags as $dtag)
                                    <option>{{ $dtag->title }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <button class="btn btn-secondary" type="submit">Save</button>
                              <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@push ('after-styles')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push ('after-scripts')
    <script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typehead-activity.js') }}"></script>
    
    <script>
        $(".select2-tags").select2({
            tags: true
        });
        var table = $('#table_yajra').DataTable({
            "scrollX": true,
            processing: true,
            serverSide: true,
            autoWidth: true,
            orderCellsTop: true,
            fixedHeader: true,
            sDom: 'lrtip',
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            pageLength: 5,
            ajax: {
                "url": "activity/datatable",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"},
            },
            columns: [
              {
                  data: 'DT_RowIndex',
                  orderable: false
              },
              {
                  data: 'title'
              },
              {
                  data: 'date'
              },
              {
                  data: 'time'
              },
              {
                  data: 'time_spent'
              },
              {
                  data: 'action'
              },
            ],
            order: [
                [2, 'desc']
            ],
            'columnDefs': [
              {
                  "targets": 0,
                  "bSortable": false
              },
            ]
        });

        function destroy(uuid) {
            var url = "{{ route('activity.destroy', ':uuid') }}".replace(':uuid', uuid);
            callDataWithAjax(url, 'POST', {
                _method: "DELETE"
            }).then((data) => {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                ).then(() => {
                    location.reload();
                });
            }).catch((xhr) => {
                alert('Error: ' + xhr.responseText);
            })
        }
    </script>
@endpush
