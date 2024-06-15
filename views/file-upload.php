<div class="display-file-upload" id="displayFileUpload">

    <div class="upload-new-file">

        <div class="cancel-upload">
            <button onclick="hideFileUpload()"> X </button>
        </div>

        <h2> Upload new file </h2>
        
        <form class="file-upload" id="file-upload" method="post" enctype="multipart/form-data">
            <input type="text" id="file_name" name="file_name" placeholder="Name the file">
            <input type="text" id="case_id" name="case_id" placeholder="Insert case-id">
            <input type="file" name="file">
            <button type="submit"> Upload </button>
        </form>

    </div>

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


