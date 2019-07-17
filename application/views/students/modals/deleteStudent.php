  <div id="deleteStudentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Student</h4>
        </div>
        <div class="modal-body">

          Delete <span id="deleteStudentName"></span> ?         
          <input type="hidden" id="studentId">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger closeModalBtn" data-dismiss="modal">Close</button>
          <button type="button" id="deleteStudentBtn" class="btn btn-success">Proceed</button>
        </div>
      </div>

    </div>
  </div>