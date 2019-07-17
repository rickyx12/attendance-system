  <div id="editStudentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Student</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" id="editLastName" class="form-control">
            <input type="hidden" id="studentId">
          </div>
          <div class="form-group">
            <label>First Name</label>
            <input type="text" id="editFirstName" class="form-control">
          </div>     

          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" id="editMiddleName" class="form-control">
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
          <button type="button" id="editStudentBtn" class="btn btn-success">Proceed</button>
        </div>
      </div>

    </div>
  </div>