<style media="all" type="text/css">

    .pcs-template {
        font-family: 'Sans-serif';
        font-size: 9pt;
        color: #333333;
        background: #ffffff;
    }

    .pcs-header-content {
        font-size: 9pt;
        color: #333333;
        background-color: #ffffff;
    }

    .pcs-template-body {
        padding: 0 0.400000in 0 0.550000in;
    }

    .pcs-template-footer {
        height: 0.700000in;
        font-size: 6pt;
        color: #aaaaaa;
        padding: 0 0.400000in 0 0.550000in;
        background-color: #ffffff;
    }

    .pcs-footer-content {
        word-wrap: break-word;
        color: #aaaaaa;
        border-top: 1px solid #adadad;
    }

    .pcs-label {
        display: flex;
        flex-direction: column;
        color: #333333;
    }

    .pcs-entity-title {
        font-size: 28pt;
        color: #000000;
    }

    .pcs-orgname {
        font-size: 10pt;
        color: #333333;
    }

    .pcs-customer-name {
        font-size: 9pt;
        color: #333333;
    }

    .pcs-eori-number {
        color: #333;
        margin: 0;
        padding-top: 10px;
    }

    .pcs-itemtable-header {
        font-size: 9pt;
        color: #ffffff;
        background-color: #3c3d3a;
    }

    .pcs-itemtable-breakword {
        word-wrap: break-word;
    }

    .pcs-taxtable-header {
        font-size: 9pt;
        color: #ffffff;
        background-color: #3c3d3a;
    }

    .breakrow-inside {
        page-break-inside: avoid;
    }

    .breakrow-after {
        page-break-after: auto;
    }

    .pcs-item-row {
        font-size: 9pt;
        border-bottom: 1px solid #adadad;
        background-color: #ffffff;
        color: #000000;
    }

    .pcs-img-fit-aspectratio {
        object-fit: contain;
        object-position: top;
    }

    .pcs-item-sku, .pcs-item-hsn, .pcs-item-coupon, .pcs-item-serialnumber, .pcs-item-unitcode {
        margin-top: 2px;
        font-size: 10px;
        color: #444444;
    }

    .pcs-item-desc {
        color: #727272;
        font-size: 9pt;
    }

    .pcs-balance {
        background-color: #f5f4f3;
        font-size: 9pt;
        color: #000000;
    }

    .pcs-savings {
        font-size: 0pt;
        color: ;
        background-color: ;
    }

    .pcs-totals {
        font-size: 9pt;
        color: #000000;
        background-color: #ffffff;
    }

    .pcs-notes {
        font-size: 8pt;
    }

    .pcs-terms {
        font-size: 8pt;
    }

    .pcs-header-first {
        background-color: #ffffff;
        font-size: 9pt;
        color: #333333;
        height: auto;
    }

    .pcs-status {
        color: ;
        font-size: 15pt;
        border: 3px solid;
        padding: 3px 8px;
    }

    .billto-section {
        padding-top: 0mm;
        padding-left: 0mm;
    }

    .shipto-section {
        padding-top: 0mm;
        padding-left: 0mm;
    }

    @page :first {
        @top-center {
            content: element(header);
        }
        margin-top: 0.700000in;
    }

    .pcs-template-header {
        padding: 0 0.400000in 0 0.550000in;
        height: 0.700000in;
    }

    .pcs-template-fill-emptydiv {
        display: table-cell;
        content: " ";
        width: 100%;
    }


    /* Additional styles for RTL compat */

    /* Helper Classes */

    .inline {
        display: inline-block;
    }

    .v-top {
        vertical-align: top;
    }

    .text-align-right {
        text-align: right;
    }

    .rtl .text-align-right {
        text-align: left;
    }

    .text-align-left {
        text-align: left;
    }

    .rtl .text-align-left {
        text-align: right;
    }

    .float-section-right {
        float: right;
    }

    .rtl .float-section-right {
        float: left;
    }

    .float-section-left {
        float: left;
    }

    .rtl .float-section-left {
        float: right;
    }

    /* Helper Classes End */

    .item-details-inline {
        display: inline-block;
        margin: 0 10px;
        vertical-align: top;
        max-width: 70%;
    }

    .total-in-words-container {
        width: 100%;
        margin-top: 10px;
    }

    .total-in-words-label {
        vertical-align: top;
        padding: 0 10px;
    }

    .total-in-words-value {
        width: 170px;
    }

    .total-section-label {
        padding: 5px 10px 5px 0;
        vertical-align: middle;
    }

    .total-section-value {
        width: 120px;
        vertical-align: middle;
        padding: 10px 10px 10px 5px;
    }

    .rtl .total-section-value {
        padding: 10px 5px 10px 10px;
    }

    .tax-summary-description {
        color: #727272;
        font-size: 8pt;
    }

    .bharatqr-bg {
        background-color: #f4f3f8;
    }

    /* Overrides/Patches for RTL compat */
    .rtl th {
        text-align: inherit; /* Specifically setting th as inherit for supporting RTL */
    }

    /* Overrides/Patches End */


    /* Subject field styles */
    .subject-block {
        margin-top: 20px;
    }

    .subject-block-value {
        word-wrap: break-word;
        white-space: pre-wrap;
        line-height: 14pt;
        margin-top: 5px;
    }

    /* Subject field styles End*/

    .pcs-sub-label {
        color: #666;
        font-size: 10px;
    }

    .pcs-hsnsummary-compact {
        padding: 0;
        margin-top: 3px;
    }

    .pcs-hsnsummary-label-compact {
        margin-bottom: 3px;
        font-weight: 600;
        padding-left: 3px;
        font-size: 9pt;
    }

    .pcs-hsnsummary-header-compact {
        text-align: right;
        padding: 5px 7px 2px 7px;
        word-wrap: break-word;
        width: 17%;
        height: 32px;
        border-right: 1px solid #9E9E9E;
        font-size: 8pt;
        font-weight: 600;
    }

    .pcs-hsnsummary-body-compact, .pcs-hsnsummary-total-compact {
        text-align: right;
        word-wrap: break-word;
        font-size: 7pt;
        padding: 4px 10px;
    }

    .pcs-hsnsummary-total-compact {
        border-top: 1px solid #adadad;
    }

    .pcs-ukvat-summary {
        margin-top: 50px;
        clear: both;
        width: 100%;
    }

    .pcs-ukvat-summary-header {
        padding: 5px 10px 5px 5px;
    }

    .pcs-ukvat-summary-header:first-child {
        padding-left: 10px;
    }

    .pcs-ukvat-summary-label {
        font-size: 10pt;
    }

    .pcs-ukvat-summary-table {
        margin-top: 10px;
        width: 100%;
        table-layout: fixed;
    }

    .pcs-ukvat-summary-body, .pcs-ukvat-summary-total {
        padding: 10px 10px 5px 10px;
    }

    .pcs-ukvat-summary-body:first-child {
        padding-bottom: 10px;
        padding-right: 0;
    }

    .pcs-payment-block {
        margin-top: 20px;
    }

    .pcs-payment-block-inner {
        margin-top: 10px;
    }

    .pcs-entity-label-section {
        padding: 5px 10px 5px 0px;
        font-size: 10pt;
    }

    .pcs-colon {
        width: 3%;
    }

    .retention-block-label {
        padding: 5px 10px 5px 0;
    }

    .retention-block-value {
        padding: 10px 10px 10px 5px;
    }

    .pcs-d-inline {
        display: inline;
    }

    .bank-details-section {
        margin-top: 10px;
        width: 100%;
        word-wrap: break-word;
    }


    .pcs-w-100 {
        width: 100%;
    }

    .pcs-h-10px {
        height: 10px;
    }

    .pcs-w-120px {
        width: 120px;
    }

    .pcs-w-110px {
        width: 110px;
    }

    .pcs-w-50 {
        width: 50%;
    }


    .pcs-d-table-cell {
        display: table-cell;
    }


    .pcs-talign-center {
        text-align: center;
    }

    .pcs-wordwrap-bw {
        word-wrap: break-word;
    }

    .pcs-whitespace-pw {
        white-space: pre-wrap;
    }

    .pcs-fw-600 {
        font-weight: 600;
    }

    .pcs-text-uppercase {
        text-transform: uppercase;
    }

    .pcs-text-underline {
        text-decoration: underline;
    }

    .pcs-text-red {
        color: red;
    }

    .pcs-dark-grey {
        color: #666;
    }

    .pcs-fs-10 {
        font-size: 10px;
    }


    .pcs-table-fixed {
        table-layout: fixed;
    }


    .pcs-valign-middle {
        vertical-align: middle;
    }


    .pcs-clearfix {
        clear: both;
    }

    .pcs-pb-0 {
        padding-bottom: 0px;
    }

    .pcs-pb-5 {
        padding-bottom: 5px;
    }

    .pcs-pb-2 {
        padding-bottom: 2px;
    }

    .pcs-pt-20 {
        padding-top: 20px;
    }

    .pcs-pt-5 {
        padding-top: 5px;
    }

    .pcs-pt-10 {
        padding-top: 10px;
    }

    .pcs-pt-3 {
        padding-top: 3px;
    }

    .pcs-pt-0 {
        padding-top: 0px;
    }

    .pcs-px-10 {
        padding-right: 10px;
        padding-left: 10px;
    }

    .pcs-py-0 {
        padding-top: 0px;
        padding-bottom: 0px;
    }

    .pcs-mt-5 {
        margin-top: 5px;
    }

    .lineitem-column {
        padding: 10px 10px 5px 10px;
        word-wrap: break-word;
        vertical-align: top;
    }

    .lineitem-content-right {
        padding: 10px 10px 10px 5px;
    }

    .rtl .lineitem-content-right {
        padding: 10px 5px 10px 10px;
    }

    .total-number-section {
        width: 45%;
        padding: 0 10px 3px 3px;
        font-size: 9pt;
        float: left;
    }

    .rtl .total-number-section {
        float: right;
    }

    .total-section {
        float: right;
        width: 50%;
    }

    .rtl .total-section {
        float: left;
    }

</style>

<div class="card-body">
    <div class="quote-template d-flex justify-content-center">
        <div id="ember1778" style="width: 80%;border:1px solid #f9f9f9;"
             class="shadow rounded ember-view ">

            <div class="pcs-template">
                <div class="pcs-template-header pcs-header-content" id="header">


                    <div class="pcs-template-fill-emptydiv"></div>

                </div>

                <div class="pcs-template-body">
                    <table style="width:100%;table-layout: fixed;">
                        <tbody>
                        <tr>
                            <td style="vertical-align: top; width:50%;">
                                <div>
                                </div>
                                <span
                                        class="pcs-orgname"><b> {{ $current_quote->customer->company_name }}</b></span><br>
                                <span class="pcs-label">
                                                            <span>{{ $customer_address->state }}</span>
                                                            <span>{{ $customer_address->country }}</span>
                                                            <span>{{ $current_quote->customer->email }}</span>
                                                        </span>
                            </td>
                            <td class="text-align-right v-top" style="width:50%;">
                                <span class="pcs-entity-title">QUOTE</span><br>
                                <span id="tmp_entity_number" style="font-size: 10pt;"
                                      class="pcs-label"><b># {{ $current_quote->quote_id }}</b></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="width:100%;margin-top:30px;table-layout:fixed;">
                        <tbody>
                        <tr>
                            <td style="width:60%;vertical-align:bottom;word-wrap: break-word;">
                                <div><label style="font-size: 10pt;"
                                            id="tmp_billing_address_label" class="pcs-label">Bill
                                        To</label>

                                    <span id="tmp_billing_address">
                                                                <strong>
                                                                    <span class="pcs-customer-name">
                                                                        <a href="#">{{ $current_quote->customer->display_name }}
                                                                        </a>
                                                                    </span>
                                                                </strong>
                                                            </span>
                                </div>
                            </td>
                            <td align="right" style="vertical-align:bottom;width: 40%;">
                                <table
                                        style="float:right;table-layout: fixed;word-wrap: break-word;width: 100%;"
                                        border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td style="padding:5px 10px 5px 0px;font-size:10pt;"
                                            class="text-align-right">
                                            <span class="pcs-label">Quote Date :</span>
                                        </td>
                                        <td class="text-align-right">
                                                                    <span
                                                                            id="tmp_entity_date">{{ date('Y-m-d',strtotime($current_quote->quote_date)) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 10px 5px 0px;font-size: 10pt;"
                                            class="text-align-right">
                                            <span class="pcs-label">Expiry Date :</span>
                                        </td>
                                        <td class="text-align-right">
                                                                    <span
                                                                            id="tmp_due_date">{{ date('Y-m-d',strtotime($current_quote->expiry_date)) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 10px 5px 0px;font-size: 10pt;"
                                            class="text-align-right">
                                            <span class="pcs-label">Reference# :</span>
                                        </td>
                                        <td class="text-align-right">
                                                                    <span
                                                                            id="tmp_ref_number">{{ $current_quote->reference }}</span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div id="subject_field" class="subject-block">
                        <div id="tmp_subject_label" class="pcs-label subject-block-label">
                            Subject :
                        </div>
                        <div class="subject-block-value">{{ $current_quote->subject }}</div>
                    </div>


                    <table style="width:100%;margin-top:20px;table-layout:fixed;"
                           class="pcs-itemtable" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr style="height:32px;">
                            <td style="padding: 5px 0px 5px 5px;width: 5%;text-align: center;"
                                id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                                #
                            </td>
                            <td style="padding: 5px 10px 5px 20px;width: ;text-align: left;"
                                id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                                Item &amp; Description
                            </td>
                            <td style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"
                                id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                                Qty
                            </td>
                            <td style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"
                                id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                                Rate
                            </td>
                            <td style="padding: 5px 10px 5px 5px;width: 15%;text-align: right;"
                                id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                                Amount
                            </td>

                        </tr>
                        </thead>
                        <tbody class="itemBody">
                        @foreach($quote_items as $item)
                            <tr class="breakrow-inside breakrow-after">
                                <td valign="top"
                                    style="padding: 10px 0 10px 5px;text-align: center;word-wrap: break-word;"
                                    class="pcs-item-row">
                                    {{ $loop->index+1 }}
                                </td>
                                <td style="padding: 10px 0px 10px 20px;"
                                    class="pcs-item-row lineitem-column">
                                    <div>
                                        <div>
                                                                    <span style="word-wrap: break-word;"
                                                                          id="tmp_item_name">{{ $item->item ? $item->item->name : "" }}</span><br>

                                            <span
                                                    style="white-space: pre-wrap;word-wrap: break-word;"
                                                    class="pcs-item-desc"
                                                    id="tmp_item_description">{{$item->item_description}}</span>
                                        </div>
                                    </div>
                                </td>


                                <td valign="top"
                                    class="pcs-item-row lineitem-column text-align-right">
                                    <span id="tmp_item_qty">{{$item->item_qty}}</span>
                                    {{--                                                        <div class="pcs-item-desc">cm</div>--}}
                                </td>

                                <td valign="top"
                                    class="pcs-item-row lineitem-column text-align-right">
                                    <span id="tmp_item_rate">{{$item->item_rate }}</span>
                                </td>
                                <td valign="top"
                                    class="pcs-item-row lineitem-column lineitem-content-right text-align-right">
                                    <span id="tmp_item_amount">{{ $item->item_amount }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="width: 100%;margin-top: 1px;">
                        <div class="total-number-section">
                            <div class="pcs-pt-5">
                                <div style="white-space: pre-wrap;"></div>
                            </div>
                        </div>
                        <div class="total-section">
                            <table class="pcs-totals" cellspacing="0" border="0" width="100%">
                                <tbody>
                                <tr>
                                    <td class="total-section-label text-align-right">Sub Total
                                    </td>
                                    <td id="tmp_subtotal"
                                        class="total-section-value text-align-right">10.00
                                    </td>
                                </tr>


                                <tr style="height:40px;" class="pcs-balance">
                                    <td class="total-section-label text-align-right">
                                        <b>Total</b></td>
                                    <td id="tmp_total"
                                        class="total-section-value text-align-right">
                                        <b>$10.00</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div style="clear: both;"></div>
                    </div>


                    <div style="clear:both;margin-top:50px;width:100%;">
                        <label style="font-size: 10pt;" id="tmp_notes_label" class="pcs-label">Notes</label
                        <p style="margin-top:7px;white-space: pre-wrap;word-wrap: break-word;"
                           class="pcs-notes">{{ $current_quote->customer_notes }}</p>
                    </div>


                    <div style="clear:both;margin-top:30px;width:100%;">
                        <label style="font-size: 10pt;" id="tmp_terms_label" class="pcs-label">Terms
                            &amp; Conditions</label>
                        <p style="margin-top:7px;white-space: pre-wrap;word-wrap: break-word;"
                           class="pcs-terms">{{ $current_quote->terms_and_conditions }}</p>
                    </div>
                    <div style="page-break-inside: avoid;">
                    </div>


                </div>
                <div class="pcs-template-footer">
                    <div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>