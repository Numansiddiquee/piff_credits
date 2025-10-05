<div class="modal fade" id="invoiceSetting" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel">Configure Invoice Number Preferences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="textAccordingSetting">
                    <p>Your invoice numbers are set on auto-generate mode to save your time.</p>
                    <p>Are you sure about changing this setting?</p>
                </div>


                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="invoiceNumberMode" id="autoGenerate" value="auto" checked>
                    <label class="form-check-label" for="autoGenerate">
                        Continue auto-generating invoice numbers <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-trigger="hover" title="The edited prefix and next number will be updated in the transaction number series associated with your invoice."></i>
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="invoiceNumberMode" id="manualEntry" value="manual">
                    <label class="form-check-label" for="manualEntry">
                        Enter invoice numbers manually
                    </label>
                </div>

                <div id="autoGenerateSettings" class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="prefix" class="form-label">Prefix</label>
                            <input type="text" class="form-control" id="prefix" value="INV-">
                        </div>
                        <div class="col-6">
                            <label for="nextNumber" class="form-label">Next Number</label>
                            <input type="text" class="form-control" id="nextNumber" value="000004">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSettings">Apply Setting</button>
            </div>
        </div>
    </div>
</div>
