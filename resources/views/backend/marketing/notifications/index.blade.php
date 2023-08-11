@extends('backend.layouts.app')

@section('content')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Notifications')}}</h5>
        </div>

        <div class="card-body">
            <form class="form-horizontal" action="{{ route('notification.send') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="name">{{translate('Emails')}} ({{translate('Users')}})</label>
                    <div class="col-sm-10">
                        <select class="form-control aiz-selectpicker" name="user_tokens[]" multiple data-selected-text-format="count" data-actions-box="true">
                            @foreach($users as $user)
                                <option value="{{$user->push_token}}">{{$user->email}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="subject">{{translate('Notification Title')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="subject" id="subject" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-from-label" for="name">{{translate('Notification Body')}}</label>
                    <div class="col-sm-10">
                        <textarea rows="8" class="form-control aiz-text-editor" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]], ["insert", ["link", "picture"]],["view", ["undo","redo"]]]' name="content" required></textarea>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Send')}}</button>
                </div>
              </form>
          </div>
    </div>
</div>

@endsection
