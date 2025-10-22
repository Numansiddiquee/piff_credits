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
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Create Invoices</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body p-12">
                            <!--begin::Form-->
                            <form action="{{ route('freelancer.invoice.store') }}" method="POST" id="kt_invoice_form" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Wrapper-->
                                <div class="row">
                                    <!--begin::Input group-->
                                    <div class="col-md-7 d-flex gap-3 flex-column me-4" title="Enter client name">
                                        <span class="fs-6 fw-bold text-danger">Client Name*
                                            <p class="text-muted text-sm mb-0 mt-0">You can only choose clients who have accepted your quote.</p>
                                        </span>
                                        <select id="client-select" name="client_id" aria-label="Client Name" data-control="select2" data-placeholder="Select or add a client" class="form-select form-select-sm">
                                            <option></option> <!-- Empty option for placeholder -->
                                            @foreach($clients as $client)
                                                <option value="{{ $client->client->id }}" data-name="{{ $client->client->name }}" data-email="{{ $client->client->email }}" data-type="client">
                                                    {{ $client->client->name }} - {{ $client->client->email }}
                                                </option>
                                            @endforeach
                                            <option value="new_client" data-type="new_client">+ New client</option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row">
                                    <div class="col-md-7 d-flex gap-3 flex-column me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                                        <span class="fs-6 fw-bold text-danger required">Invoice#</span>
                                        <div class="input-group mb-5">
                                            <input type="text" name="invoice_number" class="form-control form-control-sm fw-bold text-muted fs-6" aria-describedby="basic-addon2" value="{{ isset($invoiceSetting->is_auto_generate) && $invoiceSetting->is_auto_generate == 0 ? $invoiceNumber : 'INV-' }}" placehoder="..." />
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
                                            <input class="form-control form-control-sm fw-bold pe-5" placeholder="Select date" name="invoice_date" />
                                            <i class="ki-outline ki-down fs-4 position-absolute ms-4 me-3 end-0"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex gap-3 flex-column" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Specify invoice due date">
                                        <div class="fs-6 fw-bold text-nowrap">Due Date</div>
                                        <div class="position-relative d-flex align-items-center">
                                            <input class="form-control form-control-sm fw-bold pe-5" placeholder="Select date" name="invoice_due_date" />
                                            <i class="ki-outline ki-down fs-4 position-absolute end-0 me-3 ms-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="row">
                                    <div class="col-md-7 d-flex flex-column mt-5 gap-3">
                                        <div class="fs-6 fw-bold text-gray-700 text-nowrap">Subject</div>
                                        <textarea class="form-control form-control-sm fw-bold pe-5" rows="4" placeholder="Let your customer know what this invoice for" name="invoice_subject"></textarea>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                                <div class="mb-0">
                                    <div class="table-responsive mb-10">
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
                                                    <input type="text" class="form-control form-control-sm mb-2 item-name" name="name[]" placeholder="Type or click to select an item" autocomplete="off" readonly onclick="toggleDropdown(this)" />
                                                    <div class="dropdown-menu dropdown-product" style="display: none;">
                                                        @foreach($items as $item)
                                                            <div class="dropdown-item" style="min-width: 380px;" onclick="selectItem(this,'{{ $item->name }}', {{ $item->selling_price }},{{ $item->id }} ,'{{ $item->description }}')">
                                                                <b>{{ $item->name }}</b><br>
                                                                <span>Rate: ${{ $item->selling_price }}</span>
                                                            </div>
                                                        @endforeach
                                                        <div class="dropdown-divider"></div>
                                                        <div class="dropdown-item text-primary cursor-pointer" onclick="createNewItemMode(this)">+ Create New Item</div>
                                                    </div>
                                                    <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]"/>
                                                    <input type="hidden" name="is_new[]" value="0" class="item-is-new" />
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
                                                                <input type="number" id="discount" name="discount" class="form-control form-control-sm" oninput="updateTotals()" >
                                                                <select id="discount-type" name="discount_type" onchange="updateTotals()" class="form-select form-control-sm p-2" style="width: 60px;height: 30px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
                                                    <div class="dropdown-item text-primary" onclick="createNewItemMode(this)">+ Create New Item</div>
                                                </div>
                                                <input type="hidden" class="form-control form-control-sm mb-2 item-id" name="id[]"/>
                                                <input type="hidden" name="is_new[]" value="0" class="item-is-new" />
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
                                            <textarea name="terms_condition" class="form-control form-control-sm" rows="3" placeholder="Thanks for your business"></textarea>
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
                                            <i class="ki-outline ki-triangle fs-3"></i>Create Invoice
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Layout-->
            @include('freelancer.partials.invoice.invoiceSetting')
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

@section('freelancer-js')

    <script src="{{asset('metronic/assets/js/custom/apps/invoices/create_new.js')}}"></script>

    <script>
        function toggleDropdown(element) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
            const dropdown = element.nextElementSibling;
            dropdown.style.display = 'block';
        }

        function selectItem(dropdownItem, name, price, id, description) {
            const row = dropdownItem.closest('tr');
            const nameInput = row.querySelector('.item-name');
            nameInput.value = name;
            nameInput.readOnly = true;  // Lock for existing
            row.querySelector('.item-id').value = id;
            row.querySelector('.item-is-new').value = 0;
            row.querySelector('.item-description').value = description;
            row.querySelector('[name="price[]"]').value = price.toFixed(2);
            updateRowTotal(row.querySelector('[name="price[]"]'));
            dropdownItem.closest('.dropdown-menu').style.display = 'none';
        }

        function createNewItemMode(dropdownItem) {
            const row = dropdownItem.closest('tr');
            const nameInput = row.querySelector('.item-name');
            nameInput.value = '';
            nameInput.readOnly = false;
            nameInput.placeholder = 'Type new item name here';
            row.querySelector('.item-id').value = '';
            row.querySelector('.item-is-new').value = 1;
            row.querySelector('.item-description').value = '';
            row.querySelector('[name="price[]"]').value = '0.00';
            updateRowTotal(row.querySelector('[name="price[]"]'));
            dropdownItem.closest('.dropdown-menu').style.display = 'none';
            nameInput.focus();  // Auto-focus for typing
        }

        document.addEventListener('click', function(event) {
            if (!event.target.classList.contains('item-name')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.style.display = 'none');
            }
        });

        function addNewItemRow() {
            const template = document.getElementById('item-template').content.cloneNode(true);
            const row = template.querySelector('tr');
            const nameInput = row.querySelector('.item-name');
            nameInput.readOnly = false;  // New row starts editable
            nameInput.placeholder = 'Type new item name or click to select';
            row.querySelector('.item-id').value = '';
            row.querySelector('.item-is-new').value = 1;
            row.querySelector('.item-description').value = '';
            row.querySelector('[name="price[]"]').value = '0.00';
            row.querySelector('[data-kt-element="total"]').innerText = '0.00';
            document.getElementById('itemTableBody').appendChild(template);
            updateTotals();
        }

        function removeItem(button) {
            const row = button.closest('tr');
            row.remove();
            updateTotals();
        }

        function updateRowTotal(element) {
            const row = element.closest('tr');
            const quantity = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
            const price = parseFloat(row.querySelector('[name="price[]"]').value) || 0;
            const total = (quantity * price).toFixed(2);
            row.querySelector('[data-kt-element="total"]').innerText = total;
            updateTotals();
        }

        function updateTotals() {
            let subtotal = 0;
            document.querySelectorAll('[data-kt-element="total"]').forEach(totalElement => {
                subtotal += parseFloat(totalElement.innerText) || 0;
            });
            document.querySelector('[data-kt-element="sub-total"]').innerText = subtotal.toFixed(2);
            document.getElementById('subtotal').value = subtotal.toFixed(2);

            const discount = parseFloat(document.getElementById("discount").value) || 0;
            const discountType = document.getElementById("discount-type").value;
            let discountAmount = 0;
            if (discountType === "%") {
                discountAmount = (subtotal * discount) / 100;
            } else {
                discountAmount = discount;
            }
            if (discountAmount > 0) {
                document.getElementById('discount-total').innerText = '- $ ' + discountAmount.toFixed(2);
            } else {
                document.getElementById('discount-total').innerText = discountAmount.toFixed(2);
            }
            document.getElementById('discount-total-amount').value = discountAmount.toFixed(2);

            let grandTotal = subtotal - discountAmount;
            grandTotal = grandTotal < 0 ? 0 : grandTotal;
            document.querySelector('[data-kt-element="grand-total"]').innerText = grandTotal.toFixed(2);
        }

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

            const customerSelect = form.querySelector('select[name="client_id"]');
            const invoiceNumber = form.querySelector('input[name="invoice_number"]');
            const invoiceDate = form.querySelector('input[name="invoice_date"]');
            const dueDate = form.querySelector('input[name="invoice_due_date"]');

            [customerSelect, invoiceNumber, invoiceDate, dueDate].forEach(field => {
                field.classList.remove('is-invalid');
            });

            if (!customerSelect.value) {
                isValid = false;
                customerSelect.classList.add('is-invalid');
                toastr.error('Customer Name is required.');
            }

            if (!invoiceNumber.value.trim()) {
                isValid = false;
                invoiceNumber.classList.add('is-invalid');
                toastr.error('Invoice Number is required.');
            }

            if (!invoiceDate.value.trim()) {
                isValid = false;
                invoiceDate.classList.add('is-invalid');
                toastr.error('Invoice Date is required.');
            }

            if (!dueDate.value.trim()) {
                isValid = false;
                dueDate.classList.add('is-invalid');
                toastr.error('Due Date is required.');
            }

            const itemRows = form.querySelectorAll('#itemTableBody tr[data-kt-element="item"]');
            let hasValidItem = false;

            itemRows.forEach(row => {
                const itemName = row.querySelector('.item-name').value.trim();
                const price = parseFloat(row.querySelector('[name="price[]"]').value) || 0;
                const quantity = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
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

            $('#client-select').on('change', function() {
                if ($(this).val() === "new_client") {
                    $(this).val(null).trigger('change');
                    window.location.href = "{{ route('freelancer.client.create_client') }}";
                }
            });
        });

        $(document).ready(function() {
            $("#autoGenerateSettings").show();

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

    <script>
        let selectedItems = {};

        function toggleSelection(element, itemName, itemRate, itemId, ItemDescription) {
            if (selectedItems[itemName]) {
                delete selectedItems[itemName];
                element.classList.remove('selected');
            } else {
                selectedItems[itemName] = { rate: itemRate, quantity: 1 , itemId: itemId, ItemDescription: ItemDescription };
                element.classList.add('selected');
            }
            updateSelectedItemsUI();
        }

        function updateSelectedItemsUI() {
            const selectedItemsList = document.getElementById('selectedItemsList');
            selectedItemsList.innerHTML = '';
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

        function increaseQuantity(itemName) {
            selectedItems[itemName].quantity++;
            updateSelectedItemsUI();
        }

        function decreaseQuantity(itemName) {
            if (selectedItems[itemName].quantity > 1) {
                selectedItems[itemName].quantity--;
            } else {
                delete selectedItems[itemName];
                document.querySelector(`.product-list .list-group-item[data-item-name="${itemName}"]`).classList.remove('selected');
            }
            updateSelectedItemsUI();
        }

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
                        <input type="hidden" name="is_new[]" value="0" class="item-is-new" />
                        <input type="text" class="form-control form-control-sm" name="description[]"  value="${item.ItemDescription}" placeholder="Description" />
                    </td>
                    <td class="ps-0">
                        <input class="form-control form-control-sm" type="number" min="1" name="quantity[]" value="${item.quantity}" onchange="updateRowTotal(this)" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm text-end" name="price[]" value="${item.rate.toFixed(2)}" onchange="updateRowTotal(this)" />
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

            selectedItems = {};
            updateSelectedItemsUI();
            $('#bulkAddModal').modal('hide');
            updateTotals();
        }

        document.querySelector('input[name="attachments[]"]').addEventListener('change', function () {
            const fileList = this.files;
            const fileCount = fileList.length;

            if (fileCount > 3) {
                toastr.error('You can upload a maximum of 3 files.');
                this.value = '';
            }
        });
    </script>
@endsection