@extends('layouts.custom')

@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-9">
                <h4>CRR COLLECTION</h4>
                
              </div>
              <div class="col-xs-3">
                <div class="pull-right">
                  @if(\Auth::user()->checkAccessByIdForCorp($corpID, 22, 'A'))
                  <a href="{{ route('branch_remittances.create', $queries) }}">Add Collection</a>
                  @endif
                </div> 
              </div>
            </div>
          </div>

          <div class="panel-body" style="margin: 30px 0px;">
            <div class="row" style="margin-bottom: 20px;">
              <form class="col-xs-3 pull-right">
                <select name="status" class="form-control" id="filter-status">
                  <option value="all">All</option>
                  <option value="checked" {{ $queries['status'] == "checked" ? "selected" : "" }}>Checked</option>
                  <option value="unchecked" {{ $queries['status'] == "unchecked" ? "selected" : "" }} >Unchecked</option>
                </select>
              </form>
            </div>
            <table class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <th >TXN No.</th>
                  <th>Date/Time</th>
                  <th>Pick-up Teller</th>
                  <th>Subtotal</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                @foreach($collections as $collection)
                  <tr class="text-center">
                    <td>{{ $collection->ID }}</td>
                    <td>{{ $collection->CreatedAt->format('Y-m-d H:ia') }}</td>
                    <td>{{ $collection->user->UserName }}</td>
                    <td>{{ $collection->Subtotal }}</td>
                    <td>
                      <input type="checkbox" name="status" class="{{ \Auth::user()->checkAccessByIdForCorp($corpID, 22, 'E') ? "col-status" : "" }}" onclick="return false;" data-id="{{ $collection->ID }}"
                        {{ $collection->Status == 1 ? "checked" : ""}}>
                    </td>
                    <td>
                      <a href="{{ route('branch_remittances.show', array_merge([$collection], $queries)) }}" style="margin-right: 10px;" 
                        class="btn btn-success btn-xs {{ \Auth::user()->checkAccessByIdForCorp($corpID, 15, 'V') ? "" : "disabled" }}"
                        title="View">
                        <i class="fa fa-eye"></i>
                      </a>

                      <a href="{{ route('branch_remittances.edit', array_merge([$collection], $queries)) }}" style="margin-right: 10px;" 
                        class="btn btn-primary btn-xs {{ \Auth::user()->checkAccessByIdForCorp($corpID, 22, 'E') ? "" : "disabled" }}"
                        title="Edit">
                        <i class="fa fa-pencil"></i>
                      </a>

                      <form action="{{ route('branch_remittances.destroy', array_merge([$collection], $queries)) }}" method="POST"
                        style="display: inline-block;">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <button style="margin-right: 10px;"  title="Delete" data-id="{{ $collection->ID }}"
                        class="btn btn-danger btn-xs {{ \Auth::user()->checkAccessByIdForCorp($corpID, 22, 'D') ? "" : "disabled" }}" >
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
                @if(!$collections->count())
                <tr>
                  <td colspan="6">Not found any collections</td>
                </tr>
                @endif
              </tbody>
            </table>

            <div class="row">
              <div class="col-md-6">
                <form class="" id="date_range" action="{{ route('branch_remittances.index', ['corpID' => $corpID]) }}" method="GET">
                  <input type="hidden" name="corpID" value="{{$corpID}}">
                  <div class="checkbox col-xs-12">
                    <label for="view_date_range" class="control-label">
                      <input type="hidden" value="0" name="view_date_range">
                      <input type="checkbox" {{$start_date || $end_date ? 'checked': ""}} id="view_date_range" value="1"
                        name="view_date_range">
                      View by Date Range
                    </label>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-5">
                        <input type="date" name="start_date" id="start_date" {{ $start_date || $end_date ? '': 'disabled="true"' }} class="form-control datepicker " value="{{$start_date}}">
                      </div>
                      <div class="col-xs-5">
                        <input type="date" name="end_date" id="end_date"  {{ $start_date || $end_date ? '': 'disabled="true"' }}  class="form-control datepicker"  value="{{$end_date}}">
                      </div>
                      <div class="col-xs-2">
                        <button id="button_ranger_date" {{ $start_date || $end_date ? '': 'disabled="true"' }} class="btn btn-primary">Show</button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <a href="/OneBusiness/home" class="btn btn-default">
                          <i class="fa fa-reply"></i> Back
                        </a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

<div id="modal-confirm-password" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" action="" role="form" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="redirect" value=""> 
        <input type="hidden" name="corpID" value="{{ $corpID }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label for="" class="col-xs-3">Your Password</label>
              <div class="col-xs-9">
                <input type="password" name="password" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Verify</button>
        </div>
      </form>
    </div>
  </div>
</div>

@section('pageJS')
<script type="text/javascript">
  $('.table').on("click", ".col-status", function(event) {
    var url = '/branch_remittances/' + $(this).attr('data-id') +  '/remittances';
    if(window.location.pathname.match(/OneBusiness/)) {
      url = '/OneBusiness' + url; 
    }
    $('#modal-confirm-password form').attr('action', url)
    $('#modal-confirm-password input[name="redirect"]').val(window.location.href);
    $('#modal-confirm-password').modal("show");
  });

  $('form').on("click", ".btn-danger", function(event){
    event.preventDefault();
    var collectionID = $(this).attr('data-id');
    var self = $(this);
    swal({
        title: "<div class='delete-title'>Confirm Delete</div>",
        text:  "<div class='delete-text'>Are you sure you want to delete Collection <strong>#" + collectionID + "?</strong></div>",
        html:  true,
        customClass: 'swal-wide',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: "Cancel",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm){
      if (isConfirm){
        self.parents('form').submit();
      }
    });
  });

  $('#filter-status').change(function(event) {
    window.location = window.location.pathname + window.location.search.replace(/status=\w*&/g, "").replace(/&status=\w*/g, "") + "&status=" + $(this).val();
  });
</script>
@endsection