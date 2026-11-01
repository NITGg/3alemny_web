<?php
require_once('../config.php');
global $DB, $CFG, $USER;

echo '
<button class="learn-more add_new_student" data-toggle="modal" data-target="#AddStudentModal">
<span class="circle" aria-hidden="true">
<span class="icon plus"></span>
</span>
<span class="button-text">ADD STUDENT</span>
</button>
';
  echo '
<div class="modal fade" id="AddStudentModal" tabindex="-1" role="dialog" aria-labelledby="AddStudentModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" id="add_student_modal_dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">ADD STUDENT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <form action="./addNewStudent.php" method="post">
          <input type="hidden" class="form-control" id="ParentId" name="id" value="' . $USER->id . '">
          <div class="form-group">
            <label for="Email" class="col-form-label text-dark">Student Email:</label>
            <input type="email" class="form-control" id="Email" name="email">
          </div>
          <div class="form-group">
            <label for="Phone" class="col-form-label text-dark">Student Phone:</label>
            <input type="tel" class="form-control" id="Phone" name="phone">
          </div>
          <button type="submit" class="btn btn-primary">ADD</button>
        </form>
      </div>

    </div>
  </div>
</div>
';