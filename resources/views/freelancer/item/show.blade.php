@extends('layouts.custom.freelancer')
@section('freelancer-css')
    <style>
        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .activeDiv{
            background: aliceblue;
        }
    </style>
@endsection

@section('freelancer-content')

    <div id="loader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
        <img src="{{ asset('assets/loader/loaderr.gif') }}" alt="Loading..." style="width: 100px; height: 100px;">
        <p class="fs-6 fw-bold" style="margin-top: 10px; color: #555;">Please wait...</p>
    </div>

    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Item Details</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Action menu-->
                    <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">More
                        <i class="ki-outline ki-down fs-2 me-0"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                        <div class="menu-item px-5">
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Items</div>
                        </div>
                        <!-- <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">Mark as inactive</a>
                        </div>
                        <div class="separator my-3"></div> -->
                        <div class="menu-item px-5">
                            <a href="{{ route('freelancer.item.edit',$item->id) }}" class="menu-link px-5 text-uppercase">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body pt-3 pl-2 pr-2">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-350px ps-12" placeholder="Search Items" />
                            </div>

                            <div class="separator separator-dashed my-3"></div>
                            @foreach($items as $item)
                                <div class="d-flex justify-content-between rounded py-3 px-3 mb-3 item-div {{ $item->id == $id ? 'activeDiv' : '' }}" id="item-{{ $item->id }}"  onclick="loadItem('{{ $item->id }}')" style="box-shadow: 0px 7px 15px rgba(0, 0, 0, 0.1);cursor: pointer">
                                    <div class="d-flex flex-column fs-4 fw-bold text-gray-700">
                                        <b class="fw-bold">{{$item->name}}</b>
                                        <span class="text-muted fs-8 mt-1">Created At: {{$item->created_at->format('d M,Y')}}</span>
                                    </div>
                                    <div class="fw-bold">${{number_format($item->selling_price,2)}}</div>
                                </div>
                            @endforeach
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>

                <div class="flex-lg-row-fluid ms-lg-15" id="itemDetail">
                    @include('freelancer.item.render')
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@section('freelancer-js')
    <script src="{{ asset('assets/js/custom/apps/customers/list/list.js') }}"></script>
    <script>
        function loadItem(id){
            $('#loader').show();

            $.ajax({
                url  : "{{ route('freelancer.item.render') }}",
                type : 'POST',
                data :
                    {
                        id : id,
                        _token : "{{ csrf_token() }}"
                    },
                success:function(result){
                    $('#itemDetail').html(result.html);

                    $('.item-div').removeClass('activeDiv');
                    $(`#item-${id}`).addClass('activeDiv');

                    const currentUrl = window.location.href;
                    const newUrl = currentUrl.replace(/\/\d+$/, `/${id}`);
                    history.pushState({ id: id }, '', newUrl);

                },error: function () {
                    alert('Failed to load item. Please try again.');
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
    </script>
@endsection
