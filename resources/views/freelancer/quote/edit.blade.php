@extends('layouts.custom.freelancer')
@section('freelancer-css')
    <style>
        #productDropdown {
            position: relative;
            background-color: white;
            border: 1px solid #ddd;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #productDropdown .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
        }

        #productDropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        #productDropdown .dropdown-divider {
            border-top: 1px solid #ddd;
            margin: 5px 0;
        }

        /* General styling for the select2 dropdown */
        .select2-container--bootstrap5 .select2-results__options {
            padding: 0;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Styling each client option */
        .select2-client-option {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
        }

        .select2-client-option:hover {
            background-color: #f3f4f6;
        }

        /* Customer initials circle */
        .select2-client-initials {
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
        .select2-client-details {
            display: flex;
            flex-direction: column;
        }

        .select2-client-name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .select2-client-email {
            font-size: 12px;
            color: #777;
        }

        /* Styling the "+ New Customer" option */
        .select2-new-client {
            text-align: center;
            font-weight: bold;
            color: #007bff;
            padding: 10px;
            cursor: pointer;
        }

        .select2-new-client:hover {
            background-color: #f3f4f6;
            text-decoration: underline;
        }

        .product-list input {
            width: 100%;
        }

        /* Highlight selected item in the product list */
        .product-list .list-group-item.selected {
            background-color: #f1f1f4d6;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
        }

        .quantity-controls button {
            margin: 0 5px;
        }

        .pcs-itemtable-header {
            padding-bottom: 1.25rem !important;
            color: #ffffff !important;
            background-color: #3c3d3a !important;
        }

        table td:last-child {
            padding-right: 1.5rem !important;
        }
        table th:last-child {
            padding-right: 1.5rem !important;
        }

        .pe-7, .ps-0 {
            padding-left: 20px !important;
        }
    </style>
@endsection

@section('freelancer-content')

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
            <form action="{{route('freelancer.quote.update_quote') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" class="d-none" value="{{$quote->id}}" name="quote_id">
                <div class="row p-1 mb-2">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-4 required text-danger">Select client</label>
                        <select class="form-select form-select-sm" name="client_id" required
                                aria-label="client Name"
                                data-control="select2" id="client-select"
                                data-placeholder="Select an option">
                            <option value="" selected disabled>Select a client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @if($quote->client_id == $client->id) selected
                                        @endif data-name="{{ $client->name }}"
                                        data-email="{{ $client->email }}" data-type="client">
                                    {{ $client->name }} - {{ $client->email }}
                                </option>
                            @endforeach
                            <option value="new_client" data-type="new_client">+ New client</option>
                        </select>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2 text-danger required">Quote#</label>
                        <div class="input-group mb-5">
                        <input type="text" class="form-control form-control-sm" required placeholder="Quote"
                               id="quote_number" value="{{ $quote->quote_number }}"
                               name="quote_number"/>
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
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2">Subject</label>
                        <textarea class="form-control form-control-sm" name="subject"
                                  placeholder="Let Your Customers Know what this quote is for"
                                  rows="2">{{$quote->subject}}</textarea>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="mb-0">
                    <div class="table-responsive mb-10">
                        <!--begin::Table-->
                        <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                <th class="min-w-300px w-475px pcs-itemtable-header"  style="padding-left: 1.5rem !important;">Item</th>
                                <th class="min-w-100px w-100px pcs-itemtable-header">QTY</th>
                                <th class="min-w-150px w-150px pcs-itemtable-header">Price</th>
                                <th class="min-w-100px w-150px pcs-itemtable-header text-end">Total</th>
                                <th class="min-w-75px w-75px pcs-itemtable-header text-end"  style="padding-right: 1.5rem !important;">Action</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody id="itemTableBody" style="border: 1px solid #e3dfdf9e;">
                                @foreach($quoteItems as $item)
                                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                        <td class="pe-7">
                                            <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" value="{{ $item->item_name }}" placeholder="Type or click to select an item" autocomplete="off" readonly onclick="toggleDropdown(this)" />
                                            <div class="dropdown-menu dropdown-product" style="display: none;">
                                                @foreach($items as $ite)
                                                    <div class="dropdown-item" style="min-width: 380px;" onclick="selectItem(this,'{{ $ite->name }}', {{ $ite->selling_price }},{{ $ite->id }} ,'{{ $ite->description }}')">
                                                        <b>{{ $ite->name }}</b><br>
                                                        <span>Rate: ${{ $ite->selling_price }}</span>
                                                    </div>
                                                @endforeach
                                                <div class="dropdown-divider"></div>
                                                <div class="dropdown-item text-primary" onclick="addNewItem()">+ Add New Item</div>
                                            </div>
                                            <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]" value="{{ $item->item_id }}"/>
                                            <input type="text" class="form-control form-control-sm item-description" name="description[]" value="{{ $item->description }}" placeholder="Description" />
                                        </td>
                                        <td class="ps-0">
                                            <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" value="{{ $item->quantity }}" placeholder="1" value="1" data-kt-element="quantity" onchange="updateRowTotal(this)" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm text-end" name="price[]" placeholder="0.00" value="{{ $item->price }}" data-kt-element="price" onchange="updateRowTotal(this)" />
                                        </td>
                                        <td class="pt-8 text-end text-nowrap">$
                                            <span data-kt-element="total">{{ $item->total }}</span></td>
                                        <td class="pt-5 text-end">
                                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="removeItem(this)">
                                                <i class="ki-outline ki-trash fs-3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex flex-column justify-content-between" style="height:198px">
                                    <div class="row">
                                        <div class="d-flex gap-4">
                                            <button type="button" class="btn btn-sm btn-light-primary btn-sm py-1" onclick="addNewItemRow()">
                                                <i class="ki-outline ki-plus-square fs-3"></i>Add item
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex flex-column">
                                            <label class="form-label fs-6 fw-bold text-gray-700">Customer Notes</label>
                                            <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Thanks for your business">{{ $quote->client_notes }}</textarea>
                                        </div>
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
                                                <input type="text" id="subtotal" name="sub_total" class="form-control form-control-sm d-none">
                                                <h5 data-kt-element="sub-total">$ {{$quote->subtotal}}</h5>
                                            </div>
                                        </div>
                                        <div class="separator border-dark-clarity my-4"></div>
                                        <div class="row">
                                            <div class="col-md-4 d-flex align-items-center">
                                                Discount
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <input type="number" id="discount" name="discount_value" value="{{$quote->discount_value}}"  class="form-control form-control-sm" oninput="updateTotals()" >
                                                <select id="discount-type" name="discount_type" onchange="updateTotals()" class="form-select form-control-sm p-2" style="width: 60px;height: 30px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <option value="%" {{ '%' == $quote->discount_type ? 'selected' : '' }}>%</option>
                                                    <option value="fixed"{{ 'fixed' == $quote->discount_type ? 'selected' : '' }}>$</option>
                                                </select>

                                            </div>
                                            <div class="col-md-2 d-flex flex-end">
                                                <input type="hidden" id="discount-total-amount" name="total_discount" value="{{$quote->total_discount}}">
                                                <span id="discount-total">$ {{$quote->total_discount}}</span>
                                            </div>
                                        </div>
                                        <div class="separator border-dark-clarity my-4 mt-5"></div>
                                        <div class="row">
                                            <div class="col-md-6 d-flex flex-start">
                                                <h5>Total ($)</h5>
                                            </div>
                                            <div class="col-md-6 d-flex flex-end">
                                                <span data-kt-element="grand-total" class="h4 fw-bolder">$ {{$quote->grand_total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Table-->
                    <!--begin::Item template-->
                    <template id="item-template">
                        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                            <td class="pe-7">
                                <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" placeholder="Type or click to select an item" autocomplete="off" readonly onclick="toggleDropdown(this)" />
                                <div class="dropdown-menu dropdown-product" style="display: none;">
                                    @foreach($items as $item)
                                        <div class="dropdown-item" style="min-width: 380px;" onclick="selectItem(this, '{{ $item->name }}', {{ $item->selling_price }},{{ $item->id }} ,'{{ $item->description }}')">
                                            <b>{{ $item->name }}</b><br>
                                            <span>Rate: ${{ $item->selling_price }}</span>
                                        </div>
                                    @endforeach
                                    <div class="dropdown-divider"></div>
                                    <div class="dropdown-item text-primary" onclick="addNewItem()">+ Add New Item</div>
                                </div>
                                <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]"/>
                                <input type="text" class="form-control form-control-sm item-description" name="description[]" placeholder="Description" />
                            </td>
                            <td class="ps-0">
                                <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" onchange="updateRowTotal(this)" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" onchange="updateRowTotal(this)" />
                            </td>
                            <td class="pt-8 text-end text-nowrap">$
                                <span data-kt-element="total">0.00</span></td>
                            <td class="pt-5 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="removeItem(this)">
                                    <i class="ki-outline ki-trash fs-3"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
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
                        <input type="file" class="form-control form-control-sm" name="attachments[]" id="documents" multiple>
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
    @include('freelancer.partials.quotes.quoteNumberSetting')

@endsection

@section('freelancer-js')
    <script src="{{asset('metronic/assets/js/custom/apps/invoices/create_new.js')}}"></script>
    <script>

        function toggleDropdown(element) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
            const dropdown = element.nextElementSibling;
            dropdown.style.display = 'block';
        }

        function selectItem(dropdownItem, name, price,id,description) {
            const row = dropdownItem.closest('tr');
            row.querySelector('.item-name').value = name;
            row.querySelector('.item-id').value = id;
            row.querySelector('.item-description').value = description;
            row.querySelector('[name="price[]"]').value = price.toFixed(2);
            updateRowTotal(row.querySelector('[name="price[]"]'));
            dropdownItem.closest('.dropdown-menu').style.display = 'none';
        }

        document.addEventListener('click', function(event) {
            if (!event.target.classList.contains('item-name')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
            }
        });

        function addNewItemRow() {
            const template = document.getElementById('item-template').content.cloneNode(true);
            document.getElementById('itemTableBody').appendChild(template);
        }

        function removeItem(button) {
            const row = button.closest('tr');
            row.remove();
            updateTotals();
        }

        function updateRowTotal(priceInput) {
            const row = priceInput.closest('tr');
            const quantity = row.querySelector('[name="quantity[]"]').value;
            const price = row.querySelector('[name="price[]"]').value;
            const total = (quantity * price).toFixed(2);
            row.querySelector('[data-kt-element="total"]').innerText = total;

            updateTotals();
        }

        function updateTotals() {
            let subtotal = 0;

            // Calculate the subtotal by summing up individual totals
            const totals = document.querySelectorAll('[data-kt-element="total"]');
            totals.forEach(totalElement => {
                subtotal += parseFloat(totalElement.innerText) || 0;
            });

            // Update the displayed subtotal
            document.querySelector('[data-kt-element="sub-total"]').innerText = subtotal.toFixed(2);

            // Get discount and type
            const discount = parseFloat(document.getElementById("discount").value) || 0;
            const discountType = document.getElementById("discount-type").value;

            // Calculate discount amount
            let discountAmount = 0;
            if (discountType === "%") {
                discountAmount = (subtotal * discount) / 100;
            } else {
                discountAmount = discount;
            }
            if(discountAmount > 0){
                $('#discount-total').text('- $ '+discountAmount);
            }else{
                $('#discount-total').text(discountAmount);
            }

            $('#discount-total-amount').val(discountAmount);

            // Get shipping charges
            // const shipping = parseFloat(document.getElementById("shipping").value) || 0;
            // $('#shipping-total').text(shipping);
            // Calculate grand total
            let grandTotal = subtotal - discountAmount;
            grandTotal = grandTotal < 0 ? 0 : grandTotal; // Ensure no negative total

            // Update the displayed grand total
            document.querySelector('[data-kt-element="grand-total"]').innerText = grandTotal.toFixed(2);
        }

        // Call updateTotals whenever any relevant field changes
        document.getElementById("discount").addEventListener("input", updateTotals);
        document.getElementById("discount-type").addEventListener("change", updateTotals);

    </script>
    <script>
        $(document).ready(function () {

            $("#quote_date").flatpickr();
            $("#expiry_date").flatpickr();

            $(document).ready(function() {
                $('#client-select').select2({
                    placeholder: "Select or add a client",
                    allowClear: true,
                    templateResult: formatCustomer,
                    escapeMarkup: function (markup) { return markup; }
                });

                function formatCustomer(option) {
                    if (!option.id) return option.text; // Placeholder case

                    const type = $(option.element).data('type');

                    if (type === "new_client") {
                        return '<div class="select2-new-client">+ New Client</div>';
                    }

                    const name = $(option.element).data('name');
                    const email = $(option.element).data('email');

                    return `
                                <div class="select2-client-option">
                                    <div class="select2-client-initials">${name.charAt(0)}</div>
                                    <div class="select2-client-details">
                                        <div class="select2-client-name">${name}</div>
                                        <div class="select2-client-email">${email}</div>
                                    </div>
                                </div>
                            `;
                }

                $('#client-select').on('change', function() {
                    if ($(this).val() === "new_client") {
                        $(this).val(null).trigger('change'); // Reset the select
                        window.location.href = "{{ route('freelancer.client.create_client') }}";
                    }
                });
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
                    url: '{{ route("freelancer.quote.quote_number_settings") }}',
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
