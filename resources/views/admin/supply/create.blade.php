@extends('admin.layout.app')

@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Supplier</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('suppliers.manage') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('suppliers.store') }}" method="post" enctype="multipart/form-data" class="container mt-4 mb-4">
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
            <div class="row justify-content-center"> 
                <div class="col-md-8 mx-auto">
                    <div class="card mb-3">
                        <div class="card-body">								

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                                        @error('name')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control">
                                        @error('phone')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control">
                                        @error('address')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>                                                                      
                    </div>
                </div>
            </div>
            
            <div class="pb-5 pt-3 text-center"> <!-- Căn giữa nút bấm -->
                <button class="btn btn-primary">Create</button>
                <a href="{{ route('suppliers.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </section>
</form>



@endsection
