@extends('admin.layout.app')

@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('categories.manage') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data" class="container mt-4 mb-4">
    @csrf
   
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								    
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name">Title</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control">
                                        @error('name')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Description">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>                                                                      
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div class="mb-3">
                                <label for="image">Upload Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                @error('image')
                                    <div class="error-validate mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" class="img-thumbnail" width="100">
                            @endif
                        </div>                                                                      
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								    
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" value="{{ old('price', $category->price) }}" class="form-control" placeholder="Price">	
                                        @error('price')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" name="quantity" id="quantity" value="{{ old('quantity', $category->quantity) }}" class="form-control" placeholder="Quantity">	
                                        @error('quantity')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>                                      	
                            </div>
                        </div>                                                                      
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if(old('status', $category->status) == '1') selected @endif>Active</option>
                                    <option value="0" @if(old('status', $category->status) == '0') selected @endif>Block</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product type</h2>
                            <div class="mb-3">
                                <label for="type">Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="combo" @if(old('type', $category->type) == 'combo') selected @endif>Gói ăn giảm cân</option>
                                    <option value="cereal" @if(old('type', $category->type) == 'cereal') selected @endif>Ngũ cốc</option>
                                    <option value="cookies" @if(old('type', $category->type) == 'cookies') selected @endif>Bánh giảm cân</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="calories">Calories in product</label>
                                <input type="text" name="calories" id="calories" value="{{ old('calories', $category->calories) }}" class="form-control">
                                @error('calories')
                                    <div class="error-validate mt-3">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Edit</button>
                <a href="{{ route('categories.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </section>
</form>

<script>
    // JavaScript code for dynamic fields (if needed)
</script>
@endsection
