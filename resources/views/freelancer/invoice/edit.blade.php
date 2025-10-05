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

    <div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Edit Invoices</h1>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column flex-lg-row">
                <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                    <div class="card">
                        <div class="card-body p-12">
                            <form action="{{ route('freelancer.invoice.update') }}" method="POST" id="kt_invoice_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="invoice_id" value="{{ $id }}">
                                    <div class="col-md-7 d-flex gap-5 flex-column me-4" title="Enter client name">
                                        <span class="fs-6 fw-bold text-danger">Client Name*</span>
                                        <select id="client-select" name="client_id" aria-label="Client Name" data-control="select2" data-placeholder="Select or add a client" class="form-select form-select-sm">
                                            <option></option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ $client->id == $invoice->client_id ? 'selected' : '' }} data-name="{{ $client->name }}" data-email="{{ $client->email }}" data-type="client">
                                                    {{ $client->name }} - {{ $client->email }}
                                                </option>
                                            @endforeach
                                            <option value="new_client" data-type="new_client">+ New Client</option> <!-- New Client option -->
                                        </select>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row">
                                    <div class="col-md-7 d-flex gap-3 flex-column me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                        <span class="fs-6 fw-bold text-danger required">Invoice#</span>
                                        <div class="input-group mb-5">
                                            <input type="text" name="invoice_number" class="form-control form-control-sm fw-bold text-muted fs-6" aria-describedby="basic-addon2" value="{{ $invoice->invoice_number }}" placeholder="..." />
                                            <span class="input-group-text" id="basic-addon2"  data-bs-toggle="modal" data-bs-target="#invoiceSetting">
                                                <i class="bi bi-gear fs-4"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 d-flex flex-column gap-3" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice date">
                                        <div class="fs-6 fw-bold text-nowrap text-danger  required">Invoice Date</div>
                                        <div class="position-relative d-flex align-items-center">
                                            <input class="form-control form-control-sm fw-bold pe-5" placeholder="Select date" name="invoice_date" value="{{ $invoice->invoice_date->format('d, M Y') }}"/>
                                            <i class="ki-outline ki-down fs-4 position-absolute ms-4 me-3 end-0"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 d-flex gap-3 flex-column" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice due date">
                                        <div class="fs-6 fw-bold text-nowrap">Due Date</div>
                                        <div class="position-relative d-flex align-items-center">
                                            <input class="form-control form-control-sm fw-bold pe-5" placeholder="Select date" name="invoice_due_date" value="{{ $invoice->due_date->format('d, M Y') }}"/>
                                            <i class="ki-outline ki-down fs-4 position-absolute end-0 me-3 ms-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row">
                                    <div class="col-md-7 d-flex flex-column mt-5 gap-3">
                                        <div class="fs-6 fw-bold text-gray-700 text-nowrap">Subject</div>
                                        <textarea class="form-control form-control-sm fw-bold pe-5" rows="4" placeholder="Let your customer know what this invoice for" name="invoice_subject">{{ $invoice->subject }}</textarea>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-10"></div>
                                <!--end::Separator-->
                                <!--begin::Wrapper-->
                                <div class="mb-0">
                                    <!--begin::Table wrapper-->
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
                                                @foreach($invoice->items as $item)
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
                                            <div class="col-md-5">
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
                                                            <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Thanks for your business">{{ $invoice->notes }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <div class="row ">
                                                            <div class="col-md-6 d-flex flex-start">
                                                                <h5>Subtotal</h5>
                                                            </div>
                                                            <div class="col-md-6 d-flex flex-end">
                                                                <input type="text" id="subtotal" name="sub_total" class="form-control form-control-sm d-none">
                                                                <h5 data-kt-element="sub-total">{{$invoice->subtotal}}</h5>
                                                            </div>
                                                        </div>
                                                        <div class="separator border-dark-clarity my-4"></div>
                                                        <div class="row">
                                                            <div class="col-md-4 d-flex align-items-center">
                                                                Discount
                                                            </div>
                                                            <div class="col-md-6 d-flex">
                                                                <input type="number" id="discount" name="discount" value="{{$invoice->discount}}"  class="form-control form-control-sm" oninput="updateTotals()" >
                                                                <select id="discount-type" name="discount_type" onchange="updateTotals()" class="form-select form-control-sm p-2" style="width: 60px;height: 30px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                                    <option value="%" {{ '%' == $invoice->discount_type ? 'selected' : '' }}>%</option>
                                                                    <option value="fixed"{{ 'fixed' == $invoice->discount_type ? 'selected' : '' }}>$</option>
                                                                </select>

                                                            </div>
                                                            <div class="col-md-2 d-flex flex-end">
                                                                <input type="hidden" id="discount-total-amount" name="discounted_amount" value="{{$invoice->discounted_amount}}">
                                                                <span id="discount-total">{{$invoice->discounted_amount}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="separator border-dark-clarity my-4 mt-5"></div>
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex flex-start">
                                                                <h5>Total ($)</h5>
                                                            </div>
                                                            <div class="col-md-6 d-flex flex-end">
                                                                <span data-kt-element="grand-total" class="h4 fw-bolder">{{$invoice->total}}</span>
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
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fs-6 fw-bold text-gray-700">Terms & Conditions</label>
                                            <textarea name="terms_condition" class="form-control form-control-sm" rows="3" placeholder="Thanks for your business">{{ $invoice->terms_condition }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fs-6 fw-bold text-gray-700">Attachments</label>
                                            <input type="file" name="attachments[]" class="form-control form-control-sm mb-2" multiple>
                                            <span class="text-muted text-sm">You can upload a maximum of 3 files, 10MB each</span>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>

                                    <div class="d-flex flex-end mt-5">
                                        <button type="button" class="btn btn-primary w-25" id="kt_invoice_submit_button">
                                            <i class="ki-outline ki-triangle fs-3"></i>Update Invoice
                                        </button>
                                    </div>
                                </div>
                                <!--end::Wrapper-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <!--end::Layout-->
            @include('freelancer.partials.invoice.invoiceSetting')

        </div>
    </div>
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
        document.querySelector('#kt_invoice_submit_button').addEventListener('click', function () {
            const form = document.querySelector('#kt_invoice_form');
            let isValid = true;
            toastr.options = {
                "positionClass": "toastr-top-center",
                "closeButton": true,
                "progressBar": true,
                "timeOut": "3000"
            };

            // Validation rules for required fields
            const customerSelect = form.querySelector('select[name="client_id"]');
            const invoiceNumber = form.querySelector('input[name="invoice_number"]');
            const invoiceDate = form.querySelector('input[name="invoice_date"]');
            const dueDate = form.querySelector('input[name="invoice_due_date"]');

            // Reset border colors (optional)
            [customerSelect, invoiceNumber, invoiceDate, dueDate].forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Check if customer is selected
            if (!customerSelect.value) {
                isValid = false;
                customerSelect.classList.add('is-invalid');
                toastr.error('Customer Name is required.');
            }

            // Check if invoice number is filled
            if (!invoiceNumber.value.trim()) {
                isValid = false;
                invoiceNumber.classList.add('is-invalid');
                toastr.error('Invoice Number is required.');
            }

            // Check if invoice date is filled
            if (!invoiceDate.value.trim()) {
                isValid = false;
                invoiceDate.classList.add('is-invalid');
                toastr.error('Invoice Date is required.');
            }

            // Check if due date is filled
            if (!dueDate.value.trim()) {
                isValid = false;
                dueDate.classList.add('is-invalid');
                toastr.error('Due Date is required.');
            }

            const itemRows = form.querySelectorAll('#itemTableBody tr[data-kt-element="item"]'); // Adjust selector as needed
            let hasValidItem = false;

            itemRows.forEach(row => {
                const itemName = row.querySelector('.item-name');
                if (itemName && itemName.value.trim() !== '') {
                    hasValidItem = true;
                }
            });

            if (!hasValidItem) {
                isValid = false;
                toastr.error('At least one valid item is required.');
            }

            // If all validations pass, submit the form
            if (isValid) {
                toastr.success('Form is valid. Submitting...');
                form.submit();
            }
        });
    </script>

    <script>
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
                    window.location.href = "{{ route('freelancer.invoice.create_client') }}";
                }
            });
        });

        $(document).ready(function() {
            // Initially, show the auto-generate settings
            $("#autoGenerateSettings").show();

            // Toggle the visibility of the input fields when a radio button is clicked
            $("input[name='invoiceNumberMode']").on('change', function() {
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

                var isAutoGenerate = $("input[name='invoiceNumberMode']:checked").val() === 'auto';
                var prefix = $('#prefix').val();
                var nextNumber = $('#nextNumber').val();

                $.ajax({
                    url: '{{ route("freelancer.invoice.invoice_number_settings") }}',
                    method: 'POST',
                    data: {
                        invoiceNumberMode: isAutoGenerate,
                        prefix: prefix,
                        next_number: nextNumber,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.success, 'Success');
                        // Optionally, reload the page after a delay
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function(error) {
                        toastr.error('Error saving settings. Please try again.', 'Error');
                    }
                });
            });
        });

    </script>

    //Bulk Items modal
    <script>

        let selectedItems = {};

        function toggleSelection(element, itemName, itemRate, itemId, ItemDescription) {
            if (selectedItems[itemName]) {
                // Item already selected, unselect it
                delete selectedItems[itemName];
                element.classList.remove('selected');
            } else {
                // Select the item
                selectedItems[itemName] = { rate: itemRate, quantity: 1 , itemId: itemId,ItemDescription:ItemDescription };
                element.classList.add('selected');
            }
            updateSelectedItemsUI();
        }

        function updateSelectedItemsUI() {
            const selectedItemsList = document.getElementById('selectedItemsList');
            selectedItemsList.innerHTML = ''; // Clear previous selected items

            // Update the count of selected items
            document.getElementById('selectedCount').textContent = `(${Object.keys(selectedItems).length})`;

            Object.keys(selectedItems).forEach(itemName => {
                const item = selectedItems[itemName];

                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                listItem.innerHTML = `
            <span>${itemName}</span>
            <div class="quantity-controls">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="decreaseQuantity('${itemName}')">-</button>
                <span>${item.quantity}</span>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="increaseQuantity('${itemName}')">+</button>
            </div>
        `;

                selectedItemsList.appendChild(listItem);
            });
        }

        // Functions to increase or decrease quantity
        function increaseQuantity(itemName) {
            selectedItems[itemName].quantity++;
            updateSelectedItemsUI();
        }

        function decreaseQuantity(itemName) {
            if (selectedItems[itemName].quantity > 1) {
                selectedItems[itemName].quantity--;
            } else {
                // Remove item if quantity goes to zero
                delete selectedItems[itemName];
                document.querySelector(`.product-list .list-group-item[data-item-name="${itemName}"]`).classList.remove('selected');
            }
            updateSelectedItemsUI();
        }

        // Confirm selected items and add to main item list
        function confirmSelectedItems() {
            const itemTableBody = document.getElementById('itemTableBody');

            Object.keys(selectedItems).forEach(itemName => {
                const item = selectedItems[itemName];

                const row = document.createElement('tr');
                row.classList.add('border-bottom', 'border-bottom-dashed');

                row.innerHTML = `
                                    <td class="pe-7">
                                        <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" value="${itemName}" readonly />
                                        <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]" value="${item.itemId}" />
                                        <input type="text" class="form-control form-control-sm" name="description[]"  value="${item.ItemDescription}" placeholder="Description" />
                                    </td>
                                    <td class="ps-0">
                                        <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" value="${item.quantity}" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm text-end" name="price[]" value="${item.rate.toFixed(2)}" readonly />
                                    </td>
                                    <td class="pt-8 text-end text-nowrap">$<span data-kt-element="total">${(item.rate * item.quantity).toFixed(2)}</span></td>
                                    <td class="pt-5 text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" onclick="removeItem(this)">
                                            <i class="ki-outline ki-trash fs-3"></i>
                                        </button>
                                    </td>
                                `;

                itemTableBody.appendChild(row);
            });

            // Reset selected items and close modal
            selectedItems = {};
            updateSelectedItemsUI();
            $('#bulkAddModal').modal('hide');
        }

        document.querySelector('input[name="attachments[]"]').addEventListener('change', function () {
            const fileList = this.files;
            const fileCount = fileList.length;

            if (fileCount > 3) {
                toastr.error('You can upload a maximum of 3 files.');
                this.value = ''; // Reset input
            }
        });
    </script>
@endsection
