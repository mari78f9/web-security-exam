<div class="display-tip">

    <div class="display-add-tip">

        <div class="cancel-tip">
            <button onclick="hideTip()"> X </button>
        </div>

        <h2>Add tip by Case ID</h2>

        <form class="tip-upload" id="add-tip-form" onsubmit="addTip(); return false;">
            <input type="text" id="case_id_tip" name="case_id" placeholder="Insert case-id" required>
            <textarea id="case_tip" name="case_tip" placeholder="Write your tip here..." required></textarea>
            <button type="submit">Add Tip</button>
        </form>

    </div>

</div>