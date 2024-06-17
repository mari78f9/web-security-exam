<div class="display-new-case">
    <div class="create-new-case">

        <div class="cancel-case">
            <button onclick="hideNewCrime()"> X </button>
        </div>

        <h1> Create New Case </h1>
        
        <form id="create-case-form" class="new-case-description" onsubmit="makeCase(); return false">
            
            <input type="text" id="case_type" name="case_type" placeholder="Type of crime committed" required>
            
            <textarea id="case_description" class="case-description" name="case_description" placeholder="Write a description of the case" required></textarea>    
            
            <input type="text" id="case_suspect" name="case_suspect" placeholder="Name a suspect" required>

            <input type="text" id="case_location" name="case_location" placeholder="Location of the crime scene" required>

            <button type="submit">Create Case</button>
        
        </form>

    </div>

</div>




            <!-- <button onclick="hideNewCrime()"> X </button>
        </div>

        <h1> Create New Case </h1>

        <form" class="new-case-description" id="create-case-form" onsubmit="makeCase(); return false">
        
            <input type="text" id="case_type" name="case_type" placeholder="Type of crime committed" required>
            
            <textarea class="case-description" id="case_description" name="case_description" placeholder="Write a description of the case" required></textarea>

            <input type="text" id="case_suspect" name="case_suspect" placeholder="Name a suspect" required>

            <input type="text" id="case_location" name="case_location" placeholder="Location of the crime scene" required>

            <button type="submit"> Create Case </button>
        </form>

    </div>
    
</div> -->