<div class="display-file-upload" id="displayFileUpload">
    <h2>File Upload</h2>
    
    <form id="file-upload" method="post" enctype="multipart/form-data">
        <label for="file_name">File Name:</label>
        <input type="text" id="file_name" name="file_name">
        <label for="case_id">Case ID:</label>
        <input type="text" id="case_id" name="case_id">
        <input type="file" name="file">
        <input type="submit" value="Upload">
    </form>
</div>

<script>
    document.getElementById('file-upload').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way
        var formData = new FormData(this);

        fetch('../api/api-upload-files.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.info);
            if (data.info === 'File uploaded successfully.') {
                location.reload(); // Reload the page to show updated content after upload
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while uploading the file.');
        });
    });
</script>


