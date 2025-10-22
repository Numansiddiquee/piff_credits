<input type="text" class="d-none" value="{{ $current_quote->client_id }}" id="client_id">
<input type="text" class="d-none" value="{{ $current_quote->id }}" id="quote_id">
<input type="text" class="d-none" id="attachments_route" value="{{ url('api/freelancer/invoices/upload-file/email') }}">

    <div class="card-header-lg p-4 ">
        <div class="top-header d-flex justify-content-between align-items-center">
            <h2 class="h2 header p-4  m-0">{{ $current_quote->quote_number }}</h2>
            <div class="d-flex d-flex align-items-center gap-2 gap-lg-3">

                @if(isset($current_quote) && !in_array(strtolower($current_quote->status), ['accepted', 'converted to invoice']))
                    <a href="{{ route('freelancer.quote.edit_quote',$current_quote->id)}}" class="btn btn-light btn-sm">Edit</a>
                @endif
                <button class="btn btn-sm btn-light p-3" id="attachment_drawer_toggle">
                    <i class="bi bi-paperclip p-0"></i>
                </button>
                <button class="btn btn-sm btn-primary" id="comments_logs_drawer_toggle">
                    <i class="bi bi-chat-left-dots fs-6"></i>
                    Comments and Logs
                </button>
                <a href="#" class="btn btn-sm btn-light pe-2 d-none" data-kt-menu-trigger="click"
                   data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">More
                    <i class="ki-outline ki-down fs-5 me-0"></i></a>
                <div
                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                    data-kt-menu="true">
                    <div class="menu-item px-5">
                        <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Quote</div>
                    </div>
                    <div class="menu-item px-5">
                        <a href="javascript:void(0);" data-id="" id="updateCloneID"
                           class="menu-link px-5 text-uppercase fs-6">Clone</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="separator separator-solid my-3"></div>
    @if(isset($current_quote) && strtolower($current_quote->status) === 'converted to invoice')
        <div class="alert alert-secondary text-body d-flex align-items-center m-5" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div>
                <strong>Notice:</strong> This quote has been <strong>Converted To Invoice</strong> by {{ $current_quote->client->name ?? 'the client' }}.
                No further actions or changes can be made.<br>
            </div>
        </div>
    @endif
    <div class="separator separator-solid my-3"></div>
    <div class="card-body m-2 p-0">
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-0 p-4 bg-light">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-2 mx-3 fs-6 active" data-bs-toggle="tab"
                   href="#kt_customer_view_overview_tab"><i class="bi bi-card-heading fs-6 mr-1"></i> Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-bs-toggle="tab"
                   href="#kt_reminder_email"><i class="bi bi-envelope fs-6 mr-1"></i> Send Email</a>
            </li>
            <li class="nav-item activeLink">
                <a class="nav-link text-active-primary fs-6 mx-3 pb-2" data-kt-menu-trigger="click"
                   data-kt-menu-attach="parent"
                   data-kt-menu-placement="bottom-end"> <i class="bi bi-file-pdf fs-6 mr-1"></i> Print/PDF
                    <i class="ki-outline ki-down fs-6 me-0"></i>
                </a>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6"
                    data-kt-menu="true">
                    <div class="menu-item px-5">
                        <a href="{{ route('freelancer.quote.generatePDF', $current_quote->id) }}"
                           class="menu-link px-5 text-uppercase gap-4"><i
                                class="bi bi-file-pdf fs-3 mr-1"></i> PDF</a>
                    </div>
                    <div class="menu-item px-5">
                        <a href="#" class="menu-link px-5 text-uppercase gap-4" id="printQuote"><i
                                class="bi bi-printer fs-3 mr-1"></i> Print</a>
                    </div>
                </div>
            </li>
            <li class="nav-item activeLink">
                @if($current_quote->status == 'Accepted')
                    <a href="{{ route('freelancer.quote.convert_to_invoice',$current_quote->id) }}" class="text-gray-600 nav-link text-active-primary fs-6 mx-3 pb-2">
                        <i class="bi bi-receipt"></i>
                        Convert To Invoice
                    </a>
                @else
                    <a href="#" class="text-gray-600 nav-link text-active-primary fs-6 mx-3 pb-2 cursor-not-allowed">
                        <i class="bi bi-receipt"></i>
                        Convert To Invoice
                    </a>
                @endif
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                <div class="mw-lg-950px mx-auto w-100 py-20 rounded bordered" id="quoteContent">
                    <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                        <div class="text-sm-start">
                            @if (!empty($user->company->logo))
                                <div class="mb-3">
                                    <img src="{{ Storage::url($user->company->logo) }}" alt="Company Logo" style="max-height: 80px;">
                                </div>
                            @endif
                            <div class="text-sm-start fw-semibold fs-4 mt-1">
                                <b class="">{{ $user->name }}</b><br>
                                <span class="mt-1">{{ $user->email ?? ''}}</span><br>
                                <span class="mt-1">{{ $user->phone ?? '' }}</span><br>
                            </div>
                        </div>
                        <div class="text-sm-end pe-5 pb-7">
                            <h4 class="fw-bolder text-gray-800 fs-2qx">QUOTE</h4>
                            <div>
                                <b># {{ $current_quote->quote_number }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="pb-12">
                        <div class="d-flex flex-column gap-7 gap-md-10">
                            <div class="d-flex flex-sm-row align-items-center gap-7 gap-md-10 fw-bold">
                                <div class="flex-root d-flex flex-column gap-2">
                                    <span class="text-muted">Bill To</span>
                                    <a href="#"
                                       class="fs-5">{{ $current_quote->client->name }}</a>
                                </div>
                                <div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <tr>
                                            <td class="p-1 text-end">Quote Date :</td>
                                            <td class="p-1 text-end">{{ date('Y-m-d', strtotime($current_quote->quote_date)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 text-end">Expiry Date :</td>
                                            <td class="p-1 text-end">{{ date('Y-m-d', strtotime($current_quote->expiry_date)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 text-end">Reference# :</td>
                                            <td class="p-1 text-end">{{ $current_quote->reference }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-7 gap-md-10">
                                <div class="flex-root d-flex flex-column gap-2">
                                    <span class="text-muted">Subject</span>
                                    <b href="#" class="fs-5">{{ $current_quote->subject }}</b>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between flex-column">
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                            <th class="min-w-50px pb-2 pcs-itemtable-header text-center">#
                                            </th>
                                            <th class="min-w-175px pb-2 pcs-itemtable-header"
                                                style="padding-left: 1.5rem !important;">Item & Description
                                            </th>
                                            <th class="min-w-80px text-end pb-2 pcs-itemtable-header">Qty
                                            </th>
                                            <th class="min-w-80px text-end pb-2 pcs-itemtable-header">Rate
                                            </th>
                                            <th class="min-w-100px text-end pb-2 pcs-itemtable-header"
                                                style="padding-right: 1.5rem !important;">Amount
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                        @foreach($quote_items as $item)
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="text-center">{{ $loop->index+1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{ route('freelancer.item.show',$item->id) }}" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url({{ Storage::url('images/'.$item->item->image)}});"></span>
                                                        </a>
                                                        <div class="ms-5">
                                                            <div class="fw-bold">{{ $item->item_name }}</div>
                                                            <div class="fs-7 text-muted">{{ $item->description }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">{{ $item->quantity }}</td>
                                                <td class="text-end">{{ $item->price }}</td>
                                                <td class="text-end"
                                                    style="padding-right: 1.5rem !important;">{{ $item->total }}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="4" class="text-end">Subtotal</td>
                                            <td class="text-end" style="padding-right: 1.5rem !important;">
                                                $ {{ $current_quote->subtotal }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">Discount</td>
                                            <td class="text-end" style="padding-right: 1.5rem !important;">
                                                $ {{ $current_quote->total_discount ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fs-3 text-gray-900 fw-bold text-end">
                                                Balance Due
                                            </td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end"
                                                style="padding-right: 1.5rem !important;">
                                                $ {{ $current_quote->grand_total }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-5">
                                <label class="text-muted fs-6 fw-semibold">Notes:</label>
                                <p class="fs-7">{{ $current_quote->client_notes }}</p>
                            </div>
                            <div class="mt-5">
                                <label class="text-muted fs-6 fw-semibold">Terms & Conditions:</label>
                                <p class="fs-7">{{ $current_quote->terms_and_conditions }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kt_reminder_email" role="tabpanel">
                @include('freelancer.partials.quotes.tabs.reminderEmail')
            </div>
        </div>

    </div>

@include('freelancer.partials.quotes.comments_drawer')
@include('freelancer.partials.quotes.attachment_drawer')
