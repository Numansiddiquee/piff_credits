<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
    <li class="nav-item">
        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_customer_view_overview_tab">Overview</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_customer_view_overview_events_and_logs_tab">Transections</a>
    </li>
    <li class="nav-item d-none">
        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_customer_view_overview_statements">History</a>
    </li>
    <li class="nav-item ms-auto">

    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
        <div class="card pt-4 mb-6 mb-xl-9">
            <div class="card-body pt-0 pb-5">
                <div  class="form d-flex flex-column justify-content-between flex-lg-row">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5">
                            <tbody class="fs-6 fw-semibold text-gray-600">
                            <tr>
                                <td>Item Name</td>
                                <td>{{ $item->name }}</td>
                            </tr>
                            <tr>
                                <td>Item Type</td>
                                <td>{{ $item->type }}</td>
                            </tr>
                            <tr>
                                <td>Unit</td>
                                <td>{{ $item->unit ?? '-'}}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                            <tr>
                                <td>Created Date</td>
                                <td>{{ $item->created_at->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>{{ number_format($item->rate,2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="">
                        <label class="fs-6 fw-semibold mb-3">
                            <span>Image</span>
                            <span class="ms-1" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg.">
                                <i class="ki-outline ki-information fs-7"></i>
                            </span>
                        </label>
                        <div class="mt-1">
                            <div class="image-input image-input-outline image-input-placeholder image-input-empty" data-kt-image-input="true">
                                <div class="image-input-wrapper w-100px h-100px" style="background-image: url({{ Storage::url('images/'.$item->image) }})"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="kt_customer_view_overview_events_and_logs_tab" role="tabpanel">
        <div class="card pt-4 mb-6 mb-xl-9">
            <div class="card-body py-0">
                <div class="card-header border-0 pt-6 d-none">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Item" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                <div class="px-7 py-5">
                                    <div class="fs-4 text-gray-900 fw-bold">Filter Options</div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-10">
                                        <label class="form-label fs-5 fw-semibold mb-3">Payment Type:</label>
                                        <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-customer-table-filter="payment_type">
                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="payment_type" value="all" checked="checked" />
                                                <span class="form-check-label text-gray-600">All</span>
                                            </label>
                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                                <span class="form-check-label text-gray-600">Visa</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">DATE</th>
                            <th class="min-w-125px">Invoice#</th>
                            <th class="min-w-125px">Client Name</th>
                            <th class="min-w-125px">Quantity Sold</th>
                            <th class="min-w-125px">Price</th>
                            <th class="min-w-125px">Total</th>
                            <th class="text-end min-w-70px">Status</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse($item->invoice as $inv)
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">{{ \Carbon\Carbon::parse($inv->created_at)->format('d M, Y') }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $inv->invoice->invoice_number }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-gray-600 text-hover-primary mb-1">{{ $inv->invoice->client->name ?? 'N/A' }}</a>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 text-hover-primary mb-1">{{ $inv->quantity }}</span>
                                    </td>
                                    <td data-filter="mastercard">
                                        <span class="text-gray-600 text-hover-primary mb-1">${{ $inv->price }}</span>
                                    </td>
                                    <td>
                                        <span class="text-gray-600 text-hover-primary mb-1">${{ $inv->total }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-blue-600 text-hover-primary mb-1">Sent</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No records found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="kt_customer_view_overview_statements" role="tabpanel">
        <div class="card mb-6 mb-xl-9">
            <div class="card-body py-0">
                <table class="table align-middle table-row-dashed gy-5">
                    <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th>Date</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <tbody class="fs-6 fw-semibold text-gray-600">
                    <tr>
                        <td>14 Nov, 2024 AT 10:24 AM</td>
                        <td>Added by, <b>Test</b></td>
                    </tr>
                    <tr>
                        <td>16 Nov, 2024 AT 8:50 PM</td>
                        <td>updated by, <b>Test</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
