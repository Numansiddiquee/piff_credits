@extends('layouts.custom.freelancer')
@section('freelancer-css')
@endsection

@section('freelancer-content')

    <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Update Item
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <form action="{{ route('freelancer.item.update') }}" method="POST" enctype="multipart/form-data"
                  id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row">
                @csrf
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Item Type</label>
                                <div class="form-check form-check-custom form-check-solid ms-3 mt-3">
                                    <div class="first-option">
                                        <input class="form-check-input h-20px w-20px" name="item_type" type="radio"
                                               value="goods"
                                               id="goods"  {{ $item->type == "goods" ? 'checked' : ''}} required/>
                                                <label class="form-check-label" for="goods">
                                                    Goods
                                                </label>
                                    </div>
                                    <div class="second-option ps-4">
                                        <input class="form-check-input h-20px w-20px " name="item_type" type="radio"
                                               value="services"
                                               id="services" {{ $item->type == "services" ? 'checked' : ''}} required/>
                                                <label class="form-check-label" for="services">
                                                    Services
                                                </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <div class="mb-10 fv-row">
                                <label class="required form-label text-danger">Item Name</label>
                                <input type="text" name="name" class="form-control form-control-sm mb-2"
                                       placeholder="Item name" value="{{ $item->name }}"/>
                                <div class="text-muted fs-7">A item name is required and recommended to be unique.</div>
                            </div>
                            <div>
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control min-h-200px mb-2">{{ $item->description }}</textarea>
                                <div class="text-muted fs-7">Set a description to the item</div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Other Options</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-10">
                                <label class="required form-label text-danger">Selling Price</label>
                                <input type="number" class="form-control form-control-sm mb-2" name="price" value="{{ $item->selling_price }}" placeholder="Enter price"/>
                            </div>
                            <div class="mb-10">
                                <label class="form-label">Unit</label>
                                <select id="unit" name="unit" aria-label="Select a Unit" data-control="select2"
                                        data-placeholder="Select Unit" class="form-select form-select-sm">
                                    <option value=""></option>
                                    <option value="cm" {{ $item->unit == "cm" ? 'selected' : '' }}>cm</option>
                                    <option value="box" {{ $item->unit == "box" ? 'selected' : '' }}>box</option>
                                    <option value="dz" {{ $item->unit == "dz" ? 'selected' : '' }}>dz</option>
                                    <option value="g" {{ $item->unit == "g" ? 'selected' : '' }}>g</option>
                                    <option value="in" {{ $item->unit == "in" ? 'selected' : '' }}>in</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('freelancer.items') }}" class="btn btn-light me-5">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 ms-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Image</h2>
                            </div>
                        </div>
                        <div class="card-body text-center pt-0">
                            <style>.image-input-placeholder {
                                    background-image: url({{ Storage::url('images/'.$item->image) }});
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url({{ Storage::url('images/'.$item->image) }});
                                }</style>
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                 data-kt-image-input="true">
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Add Item Image">
                                    <i class="ki-outline ki-pencil fs-7"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                </label>
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                                <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="ki-outline ki-cross fs-2"></i>
                                </span>
                            </div>
                            <div class="text-muted fs-7">Set the item image. Only *.png, *.jpg and *.jpeg image files
                                are accepted
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('freelancer-js')

    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-category.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('input[name="item_type"]').on('change', function () {
                $('#unit').prop('disabled', $('#services').is(':checked')).val('').trigger('change');
            }).trigger('change');
        });
    </script>
@endsection
