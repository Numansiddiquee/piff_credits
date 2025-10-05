<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card-body py-20" id="invoiceContent">
        <div class="mw-lg-950px mx-auto w-100">
            <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                <div class="text-sm-start">
                    @if (!empty($user->company->logo))
                        <div class="mb-3">
                            <img src="{{ Storage::url($user->company->logo) }}" alt="Company Logo" style="max-height: 80px;">
                        </div>
                    @endif
                    <div class="text-sm-start fw-semibold fs-4 mt-1">
                        <b class="">{{ $user->name }}</b><br>   
                        <span class="mt-1">{{ $user->email }}</span><br>
                    </div>
                </div>
                <div class="text-sm-end pe-5 pb-7">
                    <h4 class="fw-bolder text-gray-800 fs-2qx">INVOICE</h4>
                    <div>
                        <b># {{ $invoice->invoice_number ?? ''}}</b>
                    </div>
                    <div class="flex-root d-flex flex-column">
                        <span class="mt-3">Balance Due</span>
                        <b>${{ number_format($invoice->due_amount == null ? $invoice->total : $invoice->due_amount,2) }}</b>
                    </div>
                </div>

            </div>
            <div class="pb-12">
                <div class="d-flex flex-column gap-7 gap-md-10">
                    <div class="d-flex flex-sm-row align-items-center gap-7 gap-md-10 fw-bold">
                        <div class="flex-root d-flex flex-column">
                            <span class="text-muted">Bill To</span>
                            <a href="#" class="fs-5">{{ $invoice->client->name ?? ''}}</a>
                        </div>
                        <div>
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <tr>
                                    <td class="p-1 text-end">Invoice date :</td>
                                    <td class="p-1 text-end">{{ $invoice->created_at->format('d M, Y') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td class="p-1 text-end">Due date :</td>
                                    <td class="p-1 text-end">{{ $invoice->due_date->format('d M, Y')  ?? ''}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between flex-column">
                        <div class="table-responsive border-bottom mb-9">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <thead>
                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                    <th class="min-w-175px pb-2 pcs-itemtable-header" style="padding-left: 1.5rem !important;">ITEM</th>
                                    <th class="min-w-80px text-end pb-2 pcs-itemtable-header">QTY</th>
                                    <th class="min-w-80px text-end pb-2 pcs-itemtable-header">Price</th>
                                    <th class="min-w-100px text-end pb-2 pcs-itemtable-header" style="padding-right: 1.5rem !important;">Total</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($invoice->items as $item)
                                    <tr style="border-bottom: 1px solid;">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('admin.item.show',$item->id) }}" class="symbol symbol-50px">
                                                    <span class="symbol-label" style="background-image:url({{ Storage::url('images/'.$item->item->image)}});"></span>
                                                </a>
                                                <div class="ms-5">
                                                    <div class="fw-bold">{{ $item->item_name }}</div>
                                                    <div class="fs-7 text-muted">{{ $item->description }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">{{ $item->quantity }} {{ $item->item->unit ?? '' }}</td>
                                        <td class="text-end">{{ $item->price }}</td>
                                        <td class="text-end">{{ $item->total }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" class="text-end">Subtotal</td>
                                    <td class="text-end">${{$invoice->subtotal}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Discount</td>
                                    <td class="text-end">${{$invoice->discounted_amount}}</td>
                                </tr>
                                @if($invoice->status == 'Paid')
                                    <tr>
                                        <td colspan="3" class="text-end">Balance Due</td>
                                        <td class="text-end">${{ number_format($invoice->due_amount,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="fs-3 text-success fw-bold text-end">Paid Amount</td>
                                        <td class="text-success fs-3 fw-bolder text-end">${{ number_format($invoice->total,2) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" class="fs-3 text-gray-900 fw-bold text-end">Balance Due</td>
                                        <td class="text-gray-900 fs-3 fw-bolder text-end">${{ number_format($invoice->due_amount == null ? $invoice->total : $invoice->due_amount,2) }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
