<div class="row">
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">Product Name <span class="text text-danger">*</span></label>
            <input type="text" name="name"
            class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ $productObj->name ? $productObj->name : old('name') }}"
            placeholder="Enter Your Product Name">
            @error('name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="slug" class="form-label">Product Slug <span class="text text-danger">*</span></label>
            <input type="text" name="slug"
            class="form-control @error('slug') is-invalid @enderror" id="slug"
            value="{{ $productObj->slug ? $productObj->slug : old('slug') }}"
            placeholder="Enter Your Product slug">
            @error('slug')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="price" class="form-label">Price <span class="text text-danger">*</span></label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ $productObj->price ? $productObj->price : old('price') }}" placeholder="Enter Your Product Price">
            @error('price')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="qty" class="form-label">Quantity</label>
            <input type="number" class="form-control @error('qty') is-invalid @enderror" min="0" name="qty" id="qty" value="{{ $productObj->qty ? $productObj->qty : old('qty') }}" placeholder="Enter Your Product Qty">	
            @error('qty')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="sku" class="form-label">SKU (Stock Keeping Unit) <span class="text text-danger">*</span></label>
            <input type="text" name="sku" id="sku" value="{{ $productObj->sku ? $productObj->sku : old('sku') }}" class="form-control @error('sku') is-invalid @enderror" placeholder="Enter Your Product SKU">	
            @error('sku')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="new_arrival" class="form-label">Latest Product</label>
            <select name="new_arrival" id="new_arrival" class="form-control @error('new_arrival') is-invalid @enderror">
                {{-- <option value="">Select</option>  --}}
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            @error('new_arrival')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>	
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="is_best_seller" class="form-label">Best Seller</label>
            <select name="is_best_seller" id="is_best_seller" class="form-control @error('is_best_seller') is-invalid @enderror">
                {{-- <option value="">Select</option> --}}
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            @error('is_best_seller')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image[]" class="form-control @error('image') is-invalid @enderror" id="image" multiple>
            @error('image')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            {{-- @if($pdct->productImages)
            <div class="col-md-8"> 
                <div class="row d-flex col-md-12">
                    <ul id="sortable" style="display: flex; list-style: none;">
                        @foreach ($pdct->productImages as $key => $item) 
                            <li class="ui-state-default" data-image-id="{{ $item->id }}">
                                <img src="{{BASE_URL.'public/uploads/ProductImage/'.$item->image}}" alt="Image {{ $item->id }}" height="80px" width="80px">
                                <i id="{{$key}}" onclick="delete_img({{$item->id}})" class="bi bi-x" aria-hidden="true"></i>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif --}}
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="bar_code" class="form-label">Product Bar Code</label>
            <input type="number" class="form-control @error('bar_code') is-invalid @enderror" name="bar_code" id="bar_code" value="{{ $productObj->bar_code ? $productObj->bar_code : old('bar_code') }}" placeholder="Enter Your Product Bar Code">
            @error('bar_code')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-9 mb-3">
        <div class="form-group">
            <label for="desc" class="form-label">Product Description</label>
            <textarea name="desc" id="editor" cols="100" rows="100" class="ckeditor">{{ $productObj->desc ? $productObj->desc : old('desc') }}</textarea>
            @error('desc')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-group">
            <a href="{{ route('products.index') }}" class="btn btn-danger mt-2">Cancel</a>
            <button class="btn btn-primary mr-1 mt-2">
                <i class="ri-user-add-fill me-1"></i> Submit
            </button>
        </div>
    </div>
</div>
