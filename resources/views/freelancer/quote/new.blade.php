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
                        New Quote</h1>
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
            <form action=" {{ route('freelancer.quote.save_new_quote') }}" method="POST" enctype="multipart/form-data" id="kt_quote_form">
                @csrf
                <div class="row p-1 mb-2">
                    <div class="col-md-6 fv-row">
                        <span class="fs-6 fw-bold text-danger required">Client Name</span>
                        <select id="client-select" name="client_id" aria-label="Client Name" data-control="select2" data-placeholder="Select or add a client" class="form-select form-select-sm">
                            <option></option> <!-- Empty option for placeholder -->
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" data-name="{{ $client->name }}" data-email="{{ $client->email }}" data-type="client">
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
                               id="quote_id" value="{{ isset($quoteSetting->is_auto_generate) && $quoteSetting->is_auto_generate == 0 ? $quoteNumber : 'QT-' }}"
                               name="quote_id"/>
                        <span class="input-group-text" id="basic-addon2" data-bs-toggle="modal"
                              data-bs-target="#quoteNumberSetting">
                            <i class="bi bi-gear fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2">Reference</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Reference" id="reference"
                               name="reference"/>
                    </div>
                </div>
                <div class="row p-1 mb-2">
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2 text-danger required">Quote Date</label>
                        <input type="text" class="form-control form-control-sm" required placeholder="Quote Date"
                               id="quote_date"
                               name="quote_date"/>
                    </div>
                    <div class="col-md-3">
                        <label class="fs-6 fw-semibold mb-2">Expiry Date</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Expiry Date"
                               id="expiry_date"
                               name="expiry_date"/>
                    </div>
                </div>

                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-4">
                        <label class="fs-6 fw-semibold mb-2">Subject</label>
                        <textarea class="form-control form-control-sm" name="subject"
                                  placeholder="Let Your Customers Know what this quote is for" rows="2"></textarea>
                    </div>
                </div>
                <div class="separator my-5"></div>
                <div class="row">
                    <div class="card p-0">
                        <h4 class="card-header h4 align-items-center bg-light" style="min-height:60px ">Item Table</h4>
                        <div class="card-body">
                            <div class="col-md-12">
                                <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                    <thead>
                                        <tr class="border-bottom fs-7 fw-bold text-gray-700 text-uppercase">
                                            <th class="min-w-300px w-475px pcs-itemtable-header" style="padding-left: 1.5rem !important;">Item</th>
                                            <th class="min-w-100px w-100px pcs-itemtable-header">QTY</th>
                                            <th class="min-w-150px w-150px pcs-itemtable-header">Price</th>
                                            <th class="min-w-100px w-150px text-end pcs-itemtable-header">Total</th>
                                            <th class="min-w-75px w-75px text-end pcs-itemtable-header" style="padding-right: 1.5rem !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemTableBody" style="border: 1px solid #e3dfdf9e;">
                                        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                            <td class="pe-7">
                                                <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" placeholder="Type or click to select an item" autocomplete="off" readonly />
                                                <div class="dropdown-menu dropdown-product" style="display: none;">
                                                    @foreach($items as $item)
                                                        <div class="dropdown-item" style="min-width: 380px;" data-name="{{ $item->name }}" data-price="{{ $item->selling_price }}" data-id="{{ $item->id }}" data-description="{{ $item->description }}">
                                                            <b>{{ $item->name }}</b><br>
                                                            <span>Rate: ${{ $item->selling_price }}</span>
                                                        </div>
                                                    @endforeach
                                                    <div class="dropdown-divider"></div>
                                                    <div class="dropdown-item text-primary">+ Create New Item</div>
                                                </div>
                                                <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]"/>
                                                <input type="hidden" name="is_new[]" value="0" class="item-is-new" />
                                                <input type="text" class="form-control form-control-sm item-description" name="description[]" placeholder="Description" />
                                            </td>
                                            <td class="ps-0">
                                                <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                                            </td>
                                            <td class="pt-8 text-end text-nowrap">$
                                                <span data-kt-element="total">0.00</span></td>
                                            <td class="pt-5 text-end">
                                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary">
                                                    <i class="ki-outline ki-trash fs-3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column justify-content-between" style="height:198px">
                                            <div class="row">
                                                <div class="d-flex gap-4">
                                                    <button type="button" class="btn btn-sm btn-light-primary btn-sm py-1" id="add-item-btn">
                                                        <i class="ki-outline ki-plus-square fs-3"></i>Add item
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="d-flex flex-column">
                                                    <label class="form-label fs-6 fw-bold text-gray-700">Client Notes</label>
                                                    <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Thanks for your business"></textarea>
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
                                                        <h5 data-kt-element="sub-total">0.00</h5>
                                                    </div>
                                                </div>
                                                <div class="separator border-dark-clarity my-4"></div>
                                                <div class="row">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        Discount
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <input type="number" id="discount" name="discount" class="form-control form-control-sm" >
                                                        <select id="discount-type" name="discount_type" class="form-select form-control-sm p-2" style="width: 60px;height: 30px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                            <option value="%">%</option>
                                                            <option value="fixed">$</option>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-2 d-flex flex-end">
                                                        <input type="hidden" id="discount-total-amount" name="discounted_amount" value="0">
                                                        <span id="discount-total">0.00</span>
                                                    </div>
                                                </div>
                                                <div class="separator border-dark-clarity my-4 mt-5"></div>
                                                <div class="row">
                                                    <div class="col-md-6 d-flex flex-start">
                                                        <h5>Total ($)</h5>
                                                    </div>
                                                    <div class="col-md-6 d-flex flex-end">
                                                       <span data-kt-element="grand-total" class="h4 fw-bolder">0.00</span>
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
                <!--begin::Item template-->
                <template id="item-template">
                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                        <td class="pe-7">
                            <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" placeholder="Type or click to select an item" autocomplete="off" readonly />
                            <div class="dropdown-menu dropdown-product" style="display: none;">
                                @foreach($items as $item)
                                    <div class="dropdown-item" style="min-width: 380px;" data-name="{{ $item->name }}" data-price="{{ $item->selling_price }}" data-id="{{ $item->id }}" data-description="{{ $item->description }}">
                                        <b>{{ $item->name }}</b><br>
                                        <span>Rate: ${{ $item->selling_price }}</span>
                                    </div>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-item text-primary">+ Create New Item</div>
                            </div>
                            <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]"/>
                            <input type="hidden" name="is_new[]" value="0" class="item-is-new" />
                            <input type="text" class="form-control form-control-sm item-description" name="description[]" placeholder="Description" />
                        </td>
                        <td class="ps-0">
                            <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" placeholder="1" value="1" data-kt-element="quantity" />
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-end" name="price[]" placeholder="0.00" value="0.00" data-kt-element="price" />
                        </td>
                        <td class="pt-8 text-end text-nowrap">$
                            <span data-kt-element="total">0.00</span></td>
                        <td class="pt-5 text-end">
                            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary">
                                <i class="ki-outline ki-trash fs-3"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <div class="separator my-5"></div>
                <div class="row p-1 mb-2">
                    <div class="col-md-6">
                        <label class="fs-6 fw-semibold mb-2">Terms & Conditions</label>
                        <textarea class="form-control form-control-sm" name="terms_and_conditions"
                                  placeholder="Enter the terms and conditions of your business to be displayed in your transaction"
                                  rows="3"></textarea>
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
                        <button class="btn btn-primary d-flex h-40px fs-7 fw-bold" type="button" id="save_quote">Save
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
        $(document).ready(function() {
            // Toggle dropdown
            $(document).on('click', '.item-name', function() {
                $('.dropdown-menu').hide();
                $(this).next('.dropdown-product').show();
            });

            // Select existing item
            $(document).on('click', '.dropdown-product .dropdown-item:not(.text-primary)', function() {
                const row = $(this).closest('tr');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const id = $(this).data('id');
                const description = $(this).data('description');

                row.find('.item-name').val(name).prop('readonly', true);
                row.find('.item-id').val(id);
                row.find('.item-is-new').val(0);
                row.find('.item-description').val(description);
                row.find('[name="price[]"]').val(parseFloat(price).toFixed(2));
                updateRowTotal(row.find('[name="price[]"]'));
                $(this).closest('.dropdown-menu').hide();
            });

            // Create new item mode
            $(document).on('click', '.dropdown-product .dropdown-item.text-primary', function() {
                const row = $(this).closest('tr');
                row.find('.item-name').val('').prop('readonly', false).attr('placeholder', 'Type new item name here').focus();
                row.find('.item-id').val('');
                row.find('.item-is-new').val(1);
                row.find('.item-description').val('');
                row.find('[name="price[]"]').val('0.00');
                updateRowTotal(row.find('[name="price[]"]'));
                $(this).closest('.dropdown-menu').hide();
            });

            // Close dropdown on outside click
            $(document).on('click', function(e) {
                if (!$(e.target).hasClass('item-name')) {
                    $('.dropdown-menu').hide();
                }
            });

            // Add new row
            $('#add-item-btn').on('click', function() {
                const template = $('#item-template').contents().clone();
                const row = template.find('tr');
                row.find('.item-name').prop('readonly', false).attr('placeholder', 'Type new item name or click to select');
                row.find('.item-id').val('');
                row.find('.item-is-new').val(1);
                row.find('.item-description').val('');
                row.find('[name="price[]"]').val('0.00');
                row.find('[data-kt-element="total"]').text('0.00');
                $('#itemTableBody').append(template);
                updateTotals();
            });

            // Remove item
            $(document).on('click', '#itemTableBody .btn-icon', function() {
                $(this).closest('tr').remove();
                updateTotals();
            });

            // Update row total
            $(document).on('change input', '[name="quantity[]"], [name="price[]"]', function() {
                updateRowTotal($(this));
            });

            function updateRowTotal(element) {
                const row = element.closest('tr');
                const quantity = parseFloat(row.find('[name="quantity[]"]').val()) || 0;
                const price = parseFloat(row.find('[name="price[]"]').val()) || 0;
                const total = (quantity * price).toFixed(2);
                row.find('[data-kt-element="total"]').text(total);
                updateTotals();
            }

            function updateTotals() {
                let subtotal = 0;
                $('[data-kt-element="total"]').each(function() {
                    subtotal += parseFloat($(this).text()) || 0;
                });
                $('[data-kt-element="sub-total"]').text(subtotal.toFixed(2));
                $('#subtotal').val(subtotal.toFixed(2));

                const discount = parseFloat($('#discount').val()) || 0;
                const discountType = $('#discount-type').val();
                let discountAmount = 0;
                if (discountType === "%") {
                    discountAmount = (subtotal * discount) / 100;
                } else {
                    discountAmount = discount;
                }
                if (discountAmount > 0) {
                    $('#discount-total').text('- $ ' + discountAmount.toFixed(2));
                } else {
                    $('#discount-total').text(discountAmount.toFixed(2));
                }
                $('#discount-total-amount').val(discountAmount.toFixed(2));

                let grandTotal = subtotal - discountAmount;
                grandTotal = grandTotal < 0 ? 0 : grandTotal;
                $('[data-kt-element="grand-total"]').text(grandTotal.toFixed(2));
            }

            $('#discount, #discount-type').on('input change', updateTotals);

            // Submit validation
            $('#save_quote').on('click', function () {
                const $form = $('#kt_quote_form');
                let isValid = true;
                toastr.options = {
                    "positionClass": "toastr-top-center",
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "3000"
                };

                const $clientSelect = $form.find('select[name="client_id"]');
                const $quoteId = $form.find('input[name="quote_id"]');
                const $quoteDate = $form.find('input[name="quote_date"]');

                // [$clientSelect, $quoteId, $quoteDate].removeClass('is-invalid');
                [$clientSelect, $quoteId, $quoteDate].forEach(function($el) {
                    $el.removeClass('is-invalid');
                });

                if (!$clientSelect.val()) {
                    isValid = false;
                    $clientSelect.addClass('is-invalid');
                    toastr.error('Client Name is required.');
                }

                if (!$quoteId.val().trim()) {
                    isValid = false;
                    $quoteId.addClass('is-invalid');
                    toastr.error('Quote# is required.');
                }

                if (!$quoteDate.val().trim()) {
                    isValid = false;
                    $quoteDate.addClass('is-invalid');
                    toastr.error('Quote Date is required.');
                }

                let hasValidItem = false;
                $('#itemTableBody tr[data-kt-element="item"]').each(function() {
                    const $row = $(this);
                    const itemName = $row.find('.item-name').val().trim();
                    const price = parseFloat($row.find('[name="price[]"]').val()) || 0;
                    const quantity = parseFloat($row.find('[name="quantity[]"]').val()) || 0;
                    if (itemName && price > 0 && quantity > 0) {
                        hasValidItem = true;
                    } else if (itemName || price > 0 || quantity > 0) {
                        isValid = false;
                        toastr.error('Incomplete item: Name, price, and quantity are required for each added item.');
                    }
                });

                if (!hasValidItem) {
                    isValid = false;
                    toastr.error('At least one valid item is required.');
                }

                if (isValid) {
                    toastr.success('Form is valid. Submitting...');
                    $form.submit();
                }
            });

            // Date pickers
            $("#quote_date").flatpickr();
            $("#expiry_date").flatpickr();

            // Client select2
            $('#client-select').select2({
                placeholder: "Select or Add a Client",
                allowClear: true,
                templateResult: formatCustomer,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            function formatCustomer(option) {
                if (!option.id) return option.text;

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

            $('#client-select').on('change', function () {
                if ($(this).val() === "new_client") {
                    $(this).val(null).trigger('change');
                    window.location.href = "{{ route('freelancer.client.create_client') }}";
                } 
            });

            // Quote settings toggle
            $("#autoGenerateSettings").show();
            $("input[name='QuoteNumberMode']").on('change', function() {
                if ($(this).val() === "auto") {
                    $('#textAccordingSetting').html("<p>Your quote numbers are set on auto-generate mode to save your time.</p><p>Are you sure about changing this setting?</p>");
                    $("#autoGenerateSettings").show();
                } else {
                    $('#textAccordingSetting').html("<p>You have selected manual quote numbering. Do you want us to auto-generate it for you?</p>");
                    $("#autoGenerateSettings").hide();
                }
            });

            // Save settings
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
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        toastr.error('Error saving settings. Please try again.', 'Error');
                    }
                });
            });

            // Attachments limit
            $('#documents').on('change', function () {
                if (this.files.length > 3) {
                    toastr.error('You can upload a maximum of 3 files.');
                    this.value = '';
                }
            });
        });
    </script>
@endsection