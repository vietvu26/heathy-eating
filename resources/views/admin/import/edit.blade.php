@extends('admin.layout.app')

@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit import</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('imports.manage') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('imports.update', $supply->id) }}" method="post" enctype="multipart/form-data" class="container mt-4 mb-4">
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
                                        <label for="supplier_id">Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $supplier->id == $supply->supplier_id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $supply->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $supply->quantity) }}" class="form-control" min="1">
                                        @error('quantity')
                                            <div class="error-validate mt-3">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="unit_price">Unit Price</label>
                                        <input type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', $supply->unit_price) }}" class="form-control" placeholder="Unit Price">	
                                        @error('unit_price')
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
                            <h2 class="h4 mb-3">Total Price</h2>
                            <div class="mb-3">
                                <input type="text" name="total_price" id="total_price" value="{{ old('total_price', $supply->total_price) }}" class="form-control" placeholder="Total Price" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('imports.create') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </section>
</form>

<script>
    // Tính tổng giá trị
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unit_price');
        const totalPriceInput = document.getElementById('total_price');

        function calculateTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const totalPrice = quantity * unitPrice;
            totalPriceInput.value = totalPrice.toFixed(2); // Cập nhật tổng giá trị
        }

        // Lắng nghe sự kiện thay đổi
        quantityInput.addEventListener('input', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);
    });
</script>
@endsection
