@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Product Bulk Upload')}}</h5>
        </div>
        <div class="card-body">
           
            <div class="">
                <a href="/public/uploads/vendors/product_stock_sample_file.xlsx" target="_blank" ><button class="btn btn-info">Product Stock Sample</button></a>
                <a href="/public/uploads/vendors/product_price_sample_file.xlsx" target="_blank"><button class="btn btn-info">Product Price Sample</button></a>
            </div>
            <br>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><strong>Upload Product Stock List</strong></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('bulk_product_update_stock') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-9">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="upload_file" class="custom-file-input" required>
    							<span class="custom-file-name">{{ translate('Choose File')}}</span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info">Upload Stock File (.xlsx)</button>
                </div>
            </form>
        </div>
    </div>

 <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6"><strong>Upload Product Price List</strong></h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="/bulk-product-casheir_price" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-9">
                        <div class="custom-file">
    						<label class="custom-file-label">
    							<input type="file" name="upload_file" class="custom-file-input" required>
    							<span class="custom-file-name">{{ translate('Choose File')}}</span>
    						</label>
    					</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-info">Upload Price File (.xlsx)</button>
                </div>
            </form>
        </div>
    </div>

@endsection
