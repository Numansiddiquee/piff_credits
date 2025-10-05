<div class="modal fade" id="expectedPaymentDate" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Expected Payment Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3" id="textAccordingSetting">
                    <b class="fw-bold">Payment is expected on </b>
                    <span class="fw-bold">26 Nov 2024.</span>
                </div>

                <div class="mb-3 mt-3">
                    <div class="form-group">
                        <input type="date" name="invoice_date" id="invoiceDate" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="reason" class="form-label required">Reason</label>
                        <textarea type="text" class="form-control" id="reason" placeholder="Enter Reason..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="expectedDateConsent" data-invoice-id="{{ $invoice->id }}">Save</button>
            </div>
        </div>
    </div>
</div>
