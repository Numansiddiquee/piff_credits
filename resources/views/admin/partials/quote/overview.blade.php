<div class="card rounded bordered shadow-sm m-auto mt-5 mw-950px w-100 py-10 px-10">
<div class="card-body m-2 p-0 " id="quoteContent">
    <div class="mw-lg-950px mx-auto w-100 py-20 rounded bordered">
        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
            <div class="text-sm-start">
                <div class="text-sm-start fw-semibold fs-4 mt-1">
                    <b class="">{{ $current_quote->freelancer->name }}</b><br>
                    <span class="mt-1">{{ $current_quote->freelancer->email }}</span><br>
                    <span class="mt-1">{{ $current_quote->freelancer->phone }}</span><br>
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
                        <a href="#" class="fs-5">
                            {{ $current_quote->client->name ?? ''}}
                        </a>
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
                                        <div class="ms-5">
                                            <div
                                                    class="fw-bold">{{ $item->item ? $item->item->name : "" }}</div>
                                            <div
                                                    class="fs-7 text-muted">{{ $item->description }}</div>
                                        </div>
                                    </td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">$ {{ $item->price }}</td>
                                    <td class="text-end"
                                        style="padding-right: 1.5rem !important;">$ {{ $item->total }}</td>
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
</div>
@include('client.partials.quote.comments_drawer')
