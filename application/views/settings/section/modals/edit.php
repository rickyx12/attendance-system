  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Section</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Section</label>
            <input type="text" id="editSection" class="form-control">
            <input type="hidden" id="sectionId">
          </div>
          <div class="form-group">
            <label>Grade Level</label>
            <select id="editGradeLevel" class="form-control">
              <option></option>
              <?php foreach($sections as $section): ?>
                <option value="<?= $section->id ?>"><?= $section->grade_level ?></option>
              <?php endforeach; ?>
            </select>
          </div>           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
          <button type="button" id="editModalBtn" class="btn btn-success">Proceed</button>
        </div>
      </div>

    </div>
  </div>