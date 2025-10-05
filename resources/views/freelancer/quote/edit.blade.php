@extends('admin.layout.main')

@section('css')
    <style>
        /* Styling each customer option */
        .select2-customer-option {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
        }

        .select2-customer-option:hover {
            background-color: #f9f9f9;
        }

        /* Customer initials circle */
        .select2-customer-initials {
            width: 32px;
            height: 32px;
            background-color: #c4c4c4;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Customer details */
        .select2-customer-details {
            display: flex;
            flex-direction: column;
        }

        .select2-customer-name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .select2-customer-email {
            font-size: 12px;
            color: #777;
        }

        /* Styling the "+ New Customer" option */
        .select2-new-customer {
            text-align: left
            font-weight: bold;
            color: #007bff;
            padding: 0 10px;
            cursor: pointer;
        }

        .select2-new-customer:hover {
            background-color: #f9f9f9;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')

    <div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2 mb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Edit Quote</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <div class="card mb-5 mb-xl-8">
        <div class="card-body py-3">
            <form action="{{route("admin.quote.update_quote") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" class="d-none" value="{{$quote->id}}" name="id">
                <div class="row p-1 mb-2">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-4 required text-danger">Select Customer</label>
                        <select class="form-select form-select-sm" name="customer_id" required
                                aria-label="Customer Name"
                                data-control="select2" id="customer-select"
                                data-placeholder="Select an option">
                            <option value="" selected disabled>Select a Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" @if($quote->customer_id == $customer->id) selected
                                        @endif data-name="{{ $customer->first_name }}"
                                        data-email="{{ $customer->email }}" data-type="customer">
                                    {{ $customer->first_name }} - {{ $customer->email }}
                                </option>
                                {{--                                <option--}}
                                {{--                                    value="{{ $customer->id }}">{{ $customer->display_name != null ? $customer->display_name : $customer->first_name .' '.$customer->last_name}}</option>--}}
                            @endforeach
                            <option value="new_customer" data-type="new_customer">+ New Customer</option>
                            {{--                            <option value="new_customer" >--}}
                            {{--                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">--}}
                            {{--                                    <i class="ki-outline ki-trash fs-2"></i>--}}
                            {{--                                </a>--}}
                            {{--                                <span style="background-color: red">New Customer</span></option>--}}
                        </select>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2 text-danger required">Quote#</label>
                        <div class="input-group mb-5">
                        <input type="text" class="form-control form-control-sm" required placeholder="Quote"
                               id="quote_id" value="{{ $quote->quote_id }}"
                               name="quote_id"/>
                        <span class="input-group-text" id="basic-addon2"  data-bs-toggle="modal" data-bs-target="#quoteNumberSetting">
                            <i class="bi bi-gear fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2">Reference</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Reference" id="reference"
                               value="{{ $quote->reference }}"
                               name="reference"/>
                    </div>
                </div>
                <div class="row p-1 mb-2">
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2 text-danger required">Quote Date</label>
                        <input type="text" class="form-control form-control-sm" required placeholder="Quote Date"
                               value="{{ date('Y-m-d',strtotime($quote->quote_date)) }}"
                               id="quote_date"
                               name="quote_date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2">Expiry Date</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Expiry Date"
                               value="{{ date('Y-m-d',strtotime($quote->expiry_date)) }}"
                               id="expiry_date"
                               name="expiry_date"/>
                    </div>
                </div>
                <div class="separator my-5"></div>

                <div class="row p-1 mb-2">
                    <div class="col-md-3 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Sales Person</label>
                        <select class="form-select form-select-sm" name="sales_person" data-control="select2"
                                data-placeholder="Select an option">
                            <option value="" selected disabled>Select a Sales Person</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                        @if($quote->sales_person == $customer->id) selected @endif> {{ $customer->display_name != null ? $customer->display_name : $customer->first_name .' '.$customer->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 fv-row" id="select_projects">
                        <label class="fs-6 fw-semibold mb-2">Select Project</label>
                        <select class="form-select form-select-sm" name="project" data-control="select2">
                            <option value="" selected disabled>Select a Project</option>
                            @foreach($projects as $project)
                                <option
                                    value="{{ $project->id }}"
                                    @if($quote->project_id == $project->id) selected @endif>{{ $project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2">Subject</label>
                        <textarea class="form-control form-control-sm" name="subject"
                                  placeholder="Let Your Customers Know what this quote is for"
                                  rows=2">{{$quote->subject}}</textarea>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row">
                    <div class="card p-0">
                        <h4 class="card-header h4 align-items-center bg-light" style="min-height:60px ">Item Table</h4>
                        <div class="card-body">
                            <div class="col-md-12" id="items_repeater">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td style="min-width: 300px;">Item</td>
                                        <td style="width: 120px;">QTY</td>
                                        <td style="width: 120px;">Rate</td>
                                        <td style="width: 200px;text-align: right">Amount</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody data-repeater-list="items_repeater">
                                    @foreach($quoteItems as $quoteItem)

                                        <tr data-repeater-item>
                                            <td>
                                                <div class="item-details">
                                                    <input type="text" value="{{ $quoteItem->id }}" name="quote_item_id" class="d-none">
                                                    <select name="item_id" class="form-select form-select-sm item_id"
                                                            data-kt-repeater="select2"
                                                            data-placeholder="Select an option"
                                                            data-control="select2">
                                                        <option value="" selected disabled>Select an Item</option>
                                                        @foreach($items as $item)
                                                            <option value="{{ $item->id }}"
                                                                    @if($quoteItem->item_id == $item->id) selected @endif>{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <textarea
                                                        class=" mt-3 form-control form-control-solid form-control-sm"
                                                        name="item_desc"
                                                        placeholder="Description">{{$quoteItem->item_description}}</textarea>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="">
                                                    <input class="form-control form-control-sm item_qty" type="number"
                                                           name="item_qty"
                                                           value="{{ $quoteItem->item_qty }}"/>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="">
                                                    <input class="form-control form-control-sm item_rate" type="number"
                                                           value="{{$quoteItem->item_rate}}"
                                                           name="item_rate">
                                                </div>
                                            </td>
                                            <td style="text-align: right">
                                                <div class="">
                                                    <span class="d-inline">$</span>
                                                    <h4 class="h4 d-inline item_total">{{$quoteItem->item_amount}}</h4>
                                                    <input class="form-control form-control-sm item_total_field d-none" value="{{$quoteItem->item_amount}}"
                                                           type="number" name="item_total">
                                                    {{--                                                <input class="form-control form-control-sm" type="number">--}}
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;" data-repeater-delete
                                                   class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete_row">
                                                    <i class="ki-outline ki-trash fs-2"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr data-repeater-item>
                                        <td>
                                            <div class="item-details">
                                                <select name="item_id" class="form-select form-select-sm item_id"
                                                        data-kt-repeater="select2"
                                                        data-placeholder="Select an option"
                                                        data-control="select2">
                                                    <option value="" selected disabled>Select an Item</option>
                                                    @foreach($items as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <textarea class=" mt-3 form-control form-control-solid form-control-sm"
                                                          name="item_desc"
                                                          placeholder="Description"></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <input class="form-control form-control-sm item_qty" type="number"
                                                       name="item_qty"
                                                       value="1"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <input class="form-control form-control-sm item_rate" type="number"
                                                       name="item_rate">
                                            </div>
                                        </td>
                                        <td style="text-align: right">
                                            <div class="">
                                                <span class="d-inline">$</span>
                                                <h4 class="h4 d-inline item_total">0</h4>
                                                <input class="form-control form-control-sm item_total_field d-none"
                                                       type="number" name="item_total">
                                                {{--                                                <input class="form-control form-control-sm" type="number">--}}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:;" data-repeater-delete
                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete_row">
                                                <i class="ki-outline ki-trash fs-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-6 d-flex flex-column justify-content-between">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="javascript:;" class="btn btn-sm btn-primary"
                                                   data-repeater-create type="button">
                                                    <i class="ki-duotone ki-plus fs-3"></i>
                                                    Add New Row</a>
                                                <button class="btn btn-sm btn-primary" type="button">Add Bulk Items
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="fs-6 fw-semibold mb-2">Customer Notes</label>
                                                <textarea class="form-control form-control-sm" rows="3"
                                                          name="customer_notes"
                                                          placeholder="Looking Forward for your business">{{$quote->customer_notes}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row ">
                                                    <div class="col-md-6 d-flex flex-start">
                                                        <h5>Subtotal</h5>
                                                    </div>
                                                    <div class="col-md-6 d-flex flex-end">
                                                        <input type="text" id="subtotal" name="sub_total"
                                                               class="form-control form-control-sm d-none">
                                                        <h5 id="subtotal_text"></h5>
                                                    </div>
                                                </div>
                                                <div class="separator border-dark-clarity my-4"></div>
                                                <div class="row">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        Discount
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <input type="number" id="discount_value" name="discount_value" value="{{ $quote->discount_value }}"
                                                               class="form-control form-control-sm">
                                                        <select id="discount_type" name="discount_type"
                                                                class="form-select form-control-sm p-2"
                                                                style="width: 60px;height: 30px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                            <option value="percentage" @if($quote->discount_type == "percentage") selected @endif>%</option>
                                                            <option value="number" @if($quote->discount_type == "number") selected @endif>$</option>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-2 d-flex flex-end">
                                                        <input type="text" id="total_discount" name="total_discount"
                                                               value=""
                                                               class="form-control form-control-sm d-none">
                                                        <p id="discount_text"></p>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        Shipping Charges
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <input type="number" id="shipping_charges" value="{{ $quote->shipping_charges }}"
                                                               name="shipping_charges"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-2 d-flex flex-end">
                                                        <p id="shipping_text"></p>
                                                    </div>
                                                </div>
                                                <div class="row my-2">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <input type="text" id="adjustment_field" value="{{$quote->adjustment_field}}"
                                                               name="adjustment_field"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <input type="number" id="adjustment_value"
                                                               name="adjustment_value" value="{{ $quote->adjustment_value }}"
                                                               class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-2 d-flex flex-end">
                                                        <p id="adjustment_text"></p>
                                                    </div>
                                                </div>
                                                <div class="separator border-dark-clarity my-4 mt-5"></div>
                                                <div class="row">
                                                    <div class="col-md-6 d-flex flex-start">
                                                        <h5>Total ($)</h5>
                                                    </div>
                                                    <div class="col-md-6 d-flex flex-end">
                                                        <input type="text" id="grandTotal" name="grand_total"
                                                               class="form-control form-control-sm d-none">
                                                        <h4 id="grand_total_text" class="h4 fw-bolder"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-6">
                        <label class="fs-6 fw-semibold mb-2">Terms & Conditions</label>
                        <textarea class="form-control form-control-sm" name="terms_and_conditions"
                                  placeholder="Enter the terms and conditions of your business to be displayed in your transaction"
                                  rows="3">{{$quote->terms_and_conditions}}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="fs-6 fw-semibold mb-2">Attach Files to Quote</label>
                        <input type="file" class="form-control form-control-sm" name="documents" id="documents">
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2" id="email_communication_row">
                </div>
                <div class="row m-4 justify-content-end">
                    <div class="col-md-4 d-flex flex-end">
                        <button class="btn btn-primary d-flex h-40px fs-7 fw-bold" type="submit" id="update_quote">Update
                            Quote
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('admin.partials.quotes.quoteNumberSetting')

@endsection

@section('js')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script>
        $(document).ready(function () {

            $("#quote_date").flatpickr();
            $("#expiry_date").flatpickr();

            $('#customer-select').select2({
                placeholder: "Select or Add a Customer",
                allowClear: true,
                templateResult: formatCustomer,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            function formatCustomer(option) {
                // alert('asdf');
                if (!option.id) return option.text; // Placeholder case

                const type = $(option.element).data('type');

                if (type === "new_customer") {
                    return '<div class="select2-new-customer">+ New Customer</div>';
                }

                const name = $(option.element).data('name');
                const email = $(option.element).data('email');

                return `
                            <div class="select2-customer-option">
                                <div class="select2-customer-initials">${name.charAt(0)}</div>
                                <div class="select2-customer-details">
                                    <div class="select2-customer-name">${name}</div>
                                    <div class="select2-customer-email">${email}</div>
                                </div>
                            </div>
                        `;
            }

            $('#customer-select').on('change', function () {
                if ($(this).val() === "new_customer") {
                    $(this).val(null).trigger('change'); // Reset the select
                    window.location.href = "{{ route('admin.customer.new_customer')}}";
                } else {
                    let customer_id = $(this).val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token
                        },
                        url: '{{ route("admin.quote.getCustomerProjectsAndContacts") }}', // Replace with your route
                        method: 'POST',
                        data: {
                            'customer_id': customer_id
                        }, // Serialize form data
                        success: function (response) {
                            console.log("customer data", response)
                            $('#select_projects').html();
                            $('#select_projects').html(response.projects);
                            $('#email_communication_row').html(response.contacts);
                            // price_field.val(response.selling_price);
                            // rowTotal(row);
                        },
                        error: function (xhr, status, error) {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });
        });

        $('#items_repeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();

                // Re-init select2
                $(this).find('[data-kt-repeater="select2"]').select2();

                // Re-init flatpickr
                $(this).find('[data-kt-repeater="datepicker"]').flatpickr();

                // Re-init tagify
                new Tagify(this.querySelector('[data-kt-repeater="tagify"]'));
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },

            ready: function () {
                // Init select2
                $('[data-kt-repeater="select2"]').select2();

                // Init flatpickr
                $('[data-kt-repeater="datepicker"]').flatpickr();

                // Init Tagify
                new Tagify(document.querySelector('[data-kt-repeater="tagify"]'));
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            updateTotals();
            $(document).on('change', '.item_id', function () {
                var item_id = $(this).val();
                const row = $(this).closest('tr');
                var price_field = row.find('.item_rate');
                var qty_field = row.find('.item_qty');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token
                    },
                    url: '{{ route("admin.item.getItemData") }}', // Replace with your route
                    method: 'POST',
                    data: {
                        'item_id': item_id
                    }, // Serialize form data
                    success: function (response) {
                        price_field.val(response.selling_price);
                        rowTotal(row);
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });

            $(document).on('keyup', '.item_qty', function () {
                const row = $(this).closest('tr');
                rowTotal(row)
            });
            $(document).on('keyup', '.item_rate', function () {
                const row = $(this).closest('tr');
                rowTotal(row);
            });
            $(document).on('keyup', '#shipping_charges', function () {
                updateTotals();
            });
            $(document).on('keyup', '#discount_value', function () {
                updateTotals();
            });
            $(document).on('change', '#discount_type', function () {
                updateTotals();
            });
            $(document).on('keyup', '#adjustment_value', function () {
                updateTotals();
            });
            $(document).on('click', '.delete_row', function () {
                setTimeout(function () {
                    updateTotals();
                }, 500);
            });

            function rowTotal(row) {
                let price_field = row.find('.item_rate').val();
                let qty_field = row.find('.item_qty').val();
                let row_total = (price_field * qty_field).toFixed(2);
                row.find('.item_total').html();
                row.find('.item_total').html(row_total);
                row.find('.item_total_field').val(row_total);
                updateTotals();
            }

            function updateTotals() {
                let subtotal = 0;

                // Calculate the subtotal by summing up individual totals
                let totals = document.querySelectorAll('.item_total');
                totals.forEach(totalElement => {
                    subtotal += parseFloat(totalElement.innerText) || 0;
                });
                let discount = parseFloat($("#discount_value").val()) || 0;
                let discountType = $("#discount_type").val();


                // Calculate discount amount
                let discountAmount = 0;
                if (discountType === "percentage") {
                    discountAmount = (subtotal * discount) / 100;
                } else {
                    discountAmount = discount;
                }


                // Get shipping charges
                const shipping = parseFloat($("#shipping_charges").val()) || 0;


                // Calculate grand total
                let grandTotal = subtotal - discountAmount + shipping;
                // Get Adjustment value
                const adjustment = parseFloat($("#adjustment_value").val()) || 0;

                if (adjustment > 0) {
                    $('#adjustment_text').html("+ " + adjustment.toFixed(2))
                    grandTotal = grandTotal + adjustment;
                } else if (adjustment < 0) {
                    $('#adjustment_text').html("- " + (-adjustment.toFixed(2)))
                    grandTotal = grandTotal - (-adjustment.toFixed(2));
                } else {
                    $('#adjustment_text').html(adjustment.toFixed(2))
                }
                grandTotal = grandTotal < 0 ? 0 : grandTotal; // Ensure no negative total


                $('#total_discount').val(discountAmount);
                if (discountAmount > 0) {
                    $('#discount_text').html('- ' + discountAmount.toFixed(2));
                } else if (discountAmount < 0) {
                    $('#discount_text').text('+ ' + -discountAmount.toFixed(2));
                } else {
                    $('#discount_text').text(discountAmount.toFixed(2));
                }
                if (shipping > 0) {
                    $('#shipping_text').html("+ " + shipping.toFixed(2));
                } else {
                    $('#shipping_text').html(shipping.toFixed(2));
                }
                $('#subtotal_text').html(subtotal.toFixed(2));
                $('#subtotal').val(subtotal.toFixed(2));
                $('#grand_total_text').html(grandTotal.toFixed(2));
                $('#grandTotal').val(grandTotal.toFixed(2));


                console.log("discountType", discountType);
                console.log("discount", discount);
                console.log("subtotal", subtotal);
            }
        })


        $(document).ready(function() {
            // Initially, show the auto-generate settings
            $("#autoGenerateSettings").show();

            // Toggle the visibility of the input fields when a radio button is clicked
            $("input[name='QuoteNumberMode']").on('change', function() {
                if ($(this).val() === "auto") {
                    $('#textAccordingSetting').html("<p>Your invoice numbers are set on auto-generate mode to save your time.</p><p>Are you sure about changing this setting?</p>");
                    $("#autoGenerateSettings").show();
                } else {
                    $('#textAccordingSetting').html("<p>You have selected manual invoice numbering. Do you want us to auto-generate it for you?</p>");
                    $("#autoGenerateSettings").hide();
                }
            });
        });

        $(document).ready(function() {
            $('#saveSettings').click(function() {

                var isAutoGenerate = $("input[name='QuoteNumberMode']:checked").val() === 'auto';
                var prefix = $('#prefix').val();
                var nextNumber = $('#nextNumber').val();

                $.ajax({
                    url: '{{ route("admin.quote.quote_number_settings") }}',
                    method: 'POST',
                    data: {
                        quoteNumberMode: isAutoGenerate,
                        prefix: prefix,
                        next_number: nextNumber,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.success, 'Success');
                        // Optionally, reload the page after a delay
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        toastr.error('Error saving settings. Please try again.', 'Error');
                    }
                });
            });
        });
    </script>

@endsection
