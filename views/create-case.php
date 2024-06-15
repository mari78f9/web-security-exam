<div class="display-new-case">
        <div class="create-new-case">

            <div class="cancel-case">
                <button onclick="hideNewCrime()"> X </button>
            </div>

            <h1> New Case: </h1>

            <form id="create-case-form" onsubmit="makeCase(); return false">
                <label for="case_description">Description:</label>
                <textarea id="case_description" name="case_description" required></textarea>

                <label for="case_suspect">Suspect:</label>
                <input type="text" id="case_suspect" name="case_suspect" required>

                <label for="case_type">Type:</label>
                <input type="text" id="case_type" name="case_type" required>

                <label for="case_location">Location:</label>
                <input type="text" id="case_location" name="case_location" required>

                <button type="submit">Create Case</button>
            </form>

        </div>
    </div>