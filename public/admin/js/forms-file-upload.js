"use strict";

(function () {
  const previewTemplate = `
    <div class="dz-preview dz-file-preview">
      <div class="dz-details">
        <div class="dz-thumbnail">
          <img data-dz-thumbnail>
          <span class="dz-nopreview">No preview</span>
          <div class="dz-success-mark"></div>
          <div class="dz-error-mark"></div>
          <div class="dz-error-message"><span data-dz-errormessage></span></div>
          <div class="progress">
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
          </div>
        </div>
        <div class="dz-filename" data-dz-name></div>
        <div class="dz-size" data-dz-size></div>
      </div>
    </div>`;

  const dropzoneMulti = document.querySelector("#dropzone-multi");
  if (dropzoneMulti) {
    new Dropzone(dropzoneMulti, {
      url: "<?= site_url('admin/product-details/insert-data') ?>", // backend URL
      previewTemplate: previewTemplate,
      maxFilesize: 0.02, // Max 20KB (in MB)
      acceptedFiles: "image/*",
      addRemoveLinks: true,
      parallelUploads: 5,
      uploadMultiple: true,
      paramName: "images", // Will be sent as 'images[]'
      autoProcessQueue: true,
      successmultiple: function (files, response) {
        console.log("Success:", response);
        alert("Images uploaded successfully!");
      },
      errormultiple: function (files, response) {
        console.error("Upload error:", response);
        alert("Upload failed!");
      },
    });
  }
})();
