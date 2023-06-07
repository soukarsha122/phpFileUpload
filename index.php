<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>File Upload Example</title>
</head>

<body>
    <h1>File Upload Example</h1>
    <form id="fileUploadForm">
        <label for="file">Choose files to upload (max 5, max 10KB each):</label>
        <input type="file" name="files[]" id="file" multiple>
        <br>
        <input type="submit" value="Upload">
    </form>
    <div id="status"></div>
    <script>
        const fileUploadForm = document.querySelector('#fileUploadForm');
        const statusDiv = document.querySelector('#status');

        fileUploadForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(fileUploadForm);

            const files = formData.getAll('files[]');
            if (files.length > 5) {
                statusDiv.textContent = 'Too many files selected (max 5).';
                return;
            }

            for (const file of files) {
                if (file.size > 10240) {
                    statusDiv.textContent = `File '${file.name}' is too large (max 10KB).`;
                    return;
                }
            }

            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    statusDiv.textContent = "File Uploaded Successfully";
                })
                .catch(error => {
                    console.error(error);
                    statusDiv.textContent = 'An error occurred while uploading the files.';
                });
        });
    </script>
</body>

</html>
