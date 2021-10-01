@extends('app')

@section('title')
Products
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h1 style="float: left;">Product List</h1>
                <a style="float: right;" href="{{ route('create_product') }}" class="btn btn-primary" type="button">Add Product</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if(count($product) > 0)
                            @php $i=1; @endphp
                            @foreach ($product as $value)
                            <tr>
                                <th scope="row">{{ $i }}</th>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->category }}</td>
                                <td>
                                    <a href="{{ route('edit_product', Crypt::encrypt($value->id)) }}" class="btn btn-outline-primary" type="button"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-outline-danger deleteProduct" data-id="{{ $value->id }}" type="button"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        @else
                        <tr>
                            <td colspan="4" style="text-align: center;">No records found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('body').on('click', '.deleteProduct', function(e){
            e.preventDefault();
            var product_id = $(this).attr('data-id');
            var cur = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    alert(product_id);
                    $.ajax({
                        "url": "{{ route('delete_product') }}",
                        "method": 'POST',
                        "dataType": "json",
                        "data": {_token: "{{ csrf_token() }}", product_id: product_id},
                        success: function(result){
                            return false;
                            Swal.fire(
                                'Deleted!',
                                'Product has been deleted.',
                                'success'
                            )
                            location.reload();
                        }
                    });
                }
            })
        })
    })
</script>
@endsection