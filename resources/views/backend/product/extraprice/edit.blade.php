@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Brand Information')}}</h5>
</div>

<div class="col-lg-8 mx-auto">
    <div class="card">
        <div class="card-body p-0">
          
            <form class="p-4" action="{{ route('Addprice.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="lang" value="{{ $lang }}">
              
                @csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                    <div class="col-sm-9"><input type="hidden" name="id" value="{{ $brand->id }}">
                         <label class="col-sm-9 col-from-label" for="name">{{ $brand->getTranslation('name', $lang) }}</label>
                    </div>
                </div>
            
               
               
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Slug')}}</label>
                    <div class="col-sm-9">
                        <label class="col-sm-9 col-from-label" for="name">{{ $brand->slug }}</label>
                    </div>
                </div>
				
            <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{translate('extra_price')}}%</label>
                    <div class="col-md-9">
                        <input type="number" step='0.01' name="extra" value="0" class="form-control" id="extra"  required>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

               