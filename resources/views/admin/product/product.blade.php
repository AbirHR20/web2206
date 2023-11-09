@extends('layouts.admin')
@section('content')
@can('product_add')
<div class="col-lg-12">
        @if (session('success'))
            <div class="alert alert-success m-auto">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Add New Product</h3>
                <a href="{{ route('product.list') }}" class="btn btn-primary"><i class="fa fa-list"></i> Product List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Category</label>
                                <select name="category" class="form-control" id="category">
                                    <option value="">select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Sub Category</label>
                                <select name="subcategory" class="form-control" id="subcategory">
                                    <option value="">select sub category</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('subcategory')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Brand</label>
                                <select name="brand" class="form-control">
                                    <option value="">select brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>
                            @error('product_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Product Price</label>
                                <input type="number" name="product_price" class="form-control">
                            </div>
                            @error('product_price')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Product Discount</label>
                                <input type="number" name="product_discount" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Tags</label>
                                <input required type="text" name="tags[]" class="form-control" id="input-tags">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Short Description</label>
                                <textarea type="text" name="short_desp" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Long Description</label>
                                <textarea type="text" name="long_desp" class="form-control" id="summernote"></textarea>
                            </div>
                            @error('long_desp')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Additional Info</label>
                                <textarea type="text" name="add_info" class="form-control" id="summernote2"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Preview Image</label>
                                <input type="file" name="preview" class="form-control"
                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="my-2">
                                <img src="" alt="" id="blah" width="100px">
                                @error('preview')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-2">Gallery Images</p>
                            <div class="upload__box p-0">
                                <div class="upload__btn-box">
                                    <label class="upload__btn w-100">
                                        <p>Upload images</p>
                                        <input name="gallery[]" type="file" multiple="" data-max_length="20"
                                            class="upload__inputfile">
                                    </label>
                                </div>
                                <div class="upload__img-wrap"></div>
                            </div>
                            @error('gallery')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">Add Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <h3 class="text-danger">You don't have access to view this page.</h3>    
@endcan   
@endsection
@section('footer_script')
    <script>
        $('#category').change(function() {
            var category_id = $(this).val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: 'getSubcategory',
                data: {
                    'category_id': category_id
                },
                success: function(data) {
                    $('#subcategory').html(data);
                }
            });
        })
    </script>
    <script>
        $("#input-tags").selectize({
            delimiter: ",",
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input,
                };
            },
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            $('#summernote2').summernote();
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function() {
                $(this).on('change', function(e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function(f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var html =
                                        "<div class='upload__img-box'><div style='background-image: url(" +
                                        e.target.result + ")' data-number='" + $(
                                            ".upload__img-close").length + "' data-file='" + f
                                        .name +
                                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function(e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
@endsection
