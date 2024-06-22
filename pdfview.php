<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>File Upload and Preview</title>
  <style>
    .preview {
      max-width: 100%;
      max-height: 600px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h2>Upload and Preview File</h2>
  <form id="uploadForm" enctype="multipart/form-data">
    <input type="file" id="fileInput" name="fileInput" onchange="previewFile(event)">
    <br>
    <div id="previewContainer"></div>
    <br>
    <button type="submit">Upload File</button>
  </form>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
  <script>
    function previewFile(event) {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = function(event) {
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = ''; // Clear previous previews

        if (file.type === 'application/pdf') {
          // Render PDF using PDF.js
          const pdfViewer = document.createElement('canvas');
          pdfViewer.className = 'preview';
          previewContainer.appendChild(pdfViewer);

          // Asynchronous download PDF
          const pdfData = new Uint8Array(event.target.result);
          pdfjsLib.getDocument({ data: pdfData }).promise.then(pdf => {
            // Fetch the first page
            pdf.getPage(1).then(page => {
              const scale = 1.5;
              const viewport = page.getViewport({ scale });

              // Prepare canvas using PDF page dimensions
              const canvas = pdfViewer;
              const context = canvas.getContext('2d');
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              // Render PDF page into canvas context
              const renderContext = {
                canvasContext: context,
                viewport: viewport
              };
              page.render(renderContext);
            });
          }).catch(error => {
            console.error('Error occurred while loading the PDF:', error);
          });
        } else {
          // Display other file types
          const fileDetails = document.createElement('p');
          fileDetails.textContent = `${file.name} (${file.type}) - ${file.size} bytes`;
          previewContainer.appendChild(fileDetails);
        }
      };

      if (file) {
        reader.readAsArrayBuffer(file);
      }
    }
  </script>
</body>
</html>
