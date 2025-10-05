document.addEventListener("DOMContentLoaded", function () {
    // Initialize Dropzone for the first form
    const dropzoneForm1 = document.querySelector('#kt_inbox_reply_attachments[data-kt-inbox-form="dropzone"]');
    const previewsContainer1 = dropzoneForm1.querySelector(".dropzone-items");
    const uploadButton1 = document.querySelector('#kt_inbox_reply_attachments_select[data-kt-inbox-form="dropzone_upload"]');
    const attachments_route = document.querySelector('#attachments_route').value;
    
    if (dropzoneForm1 && uploadButton1) {
        const dropzone1 = new Dropzone(dropzoneForm1, {
            url: attachments_route, // Replace with your backend endpoint
            maxFilesize: 1, // Max file size in MB
            parallelUploads: 20,
            previewTemplate: `
                <div class="dropzone-item">
                    <div class="dropzone-file">
                        <div class="dropzone-filename" title="">
                            <span data-dz-name></span>
                            <strong>(<span data-dz-size></span>)</strong>
                        </div>
                        <div class="dropzone-error" data-dz-errormessage></div>
                    </div>
                    <div class="dropzone-progress">
                        <div class="progress bg-gray-300">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="dropzone-toolbar">
                        <span class="dropzone-delete" data-dz-remove>
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                    </div>
                </div>`,
            previewsContainer: previewsContainer1,
            clickable: uploadButton1, // Link clickable button
        });

        dropzone1.on("success", function (file, response) {
            // Handle the success and add the file URL to the hidden input
            let hiddenInput = dropzoneForm1.querySelector('input[name="attachments[]"]');

            // If the hidden input does not exist, create it
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'attachments[]'; // Name same as Dropzone configuration
                dropzoneForm1.appendChild(hiddenInput);
            }

            // Append the file URL to the hidden input's value
            const fileUrls = hiddenInput.value ? hiddenInput.value.split(',') : [];
            fileUrls.push(response.temp_link); // Add the current file's temp URL
            hiddenInput.value = fileUrls.join(','); // Join all URLs into a single string
        });

        // Handle file removal
        dropzone1.on("removedfile", function (file) {
            let hiddenInput = dropzoneForm1.querySelector('input[name="attachments[]"]');
            if (hiddenInput) {
                const fileUrls = hiddenInput.value ? hiddenInput.value.split(',') : [];
                const fileIndex = fileUrls.indexOf(file.name);
                if (fileIndex !== -1) {
                    fileUrls.splice(fileIndex, 1); // Remove the file URL from the array
                    hiddenInput.value = fileUrls.join(','); // Update the hidden input value
                }
            }
        });
    }

    // Initialize Dropzone for the second form
    const dropzoneForm2 = document.querySelector('#kt_inbox_reply_attachments_reminder[data-kt-inbox-form="dropzone"]');
    const previewsContainer2 = dropzoneForm2.querySelector(".dropzone-items-reminder");
    const uploadButton2 = document.querySelector('#kt_inbox_reply_attachments_select_reminder[data-kt-inbox-form="dropzone_upload_reminder"]');

    if (dropzoneForm2 && uploadButton2) {
        const dropzone2 = new Dropzone(dropzoneForm2, {
            url: attachments_route, // Replace with your backend endpoint
            maxFilesize: 1,
            parallelUploads: 20,
            previewTemplate: `
                <div class="dropzone-item">
                    <div class="dropzone-file">
                        <div class="dropzone-filename" title="">
                            <span data-dz-name></span>
                            <strong>(<span data-dz-size></span>)</strong>
                        </div>
                        <div class="dropzone-error" data-dz-errormessage></div>
                    </div>
                    <div class="dropzone-progress">
                        <div class="progress bg-gray-300">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="dropzone-toolbar">
                        <span class="dropzone-delete" data-dz-remove>
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                    </div>
                </div>`,
            previewsContainer: previewsContainer2,
            clickable: uploadButton2, // Link clickable button
        });

        dropzone2.on("success", function (file, response) {
            // Handle the success and add the file URL to the hidden input
            let hiddenInput = dropzoneForm2.querySelector('input[name="attachments[]"]');

            // If the hidden input does not exist, create it
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'attachments[]'; // Name same as Dropzone configuration
                dropzoneForm2.appendChild(hiddenInput);
            }

            // Append the file URL to the hidden input's value
            const fileUrls = hiddenInput.value ? hiddenInput.value.split(',') : [];
            fileUrls.push(response.temp_link); // Add the current file's temp URL
            hiddenInput.value = fileUrls.join(','); // Join all URLs into a single string
        });

        // Handle file removal
        dropzone2.on("removedfile", function (file) {
            let hiddenInput = dropzoneForm2.querySelector('input[name="attachments[]"]');
            if (hiddenInput) {
                const fileUrls = hiddenInput.value ? hiddenInput.value.split(',') : [];
                const fileIndex = fileUrls.indexOf(file.name);
                if (fileIndex !== -1) {
                    fileUrls.splice(fileIndex, 1); // Remove the file URL from the array
                    hiddenInput.value = fileUrls.join(','); // Update the hidden input value
                }
            }
        });
    }
});
