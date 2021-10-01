@extends('app')

@section('title')
Edit - Products
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h1>Edit Product</h1>
            </div>
            <div class="card-body">
                <form id="store_product" method="post" action="{{ route('update_product') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product_data->id }}" />
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="{{ $product_data->product_name }}" placeholder="Product Name" />
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 category_list">
                        <label>Categories</label>

                        <div class="col-md-12 pl-0">
                            {!! $data !!}
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest', '#store_product'); !!}
<script>
    $(document).ready(function(){
        $('.category_item').click(function(){
            var className = 'subcategory_list_'+$(this).val();
            if($(this).is(':checked')){
                $(this).parent().parent().find('.'+className).show();
            }else{
                var id =$(this).parent().parent().attr('data-id');
                hideChildrens(id)
            }
        })

        function hideChildrens(id){
            $('.subcategory_list_'+id).each(function(){
                $(this).hide();
                $(this).find('.category_item').each(function(){
                    if($(this).is(':checked')){
                        $(this).prop('checked',false);
                    }
                })
                var id = $(this).attr('data-id');
                hideChildrens(id);
            })
        }
    })
</script>
@endsection