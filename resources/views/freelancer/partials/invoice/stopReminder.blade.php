<div class="modal fade" id="stopReminder" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel">Stop Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="textAccordingSetting">
                    <b class="fw-bold">
                        <i class="flaticon-warning"></i>
                        Warning! All reminders for this invoice will be stopped if you click on OK. Proceed if that is alright.
                    </b>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="stopReminderConsent" data-invoice-id="{{ $invoice->id }}">Ok</button>
            </div>
        </div>
    </div>
</div>
