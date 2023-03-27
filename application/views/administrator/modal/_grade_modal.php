<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="gradeModalLabel">Report of Grades</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>STUDENT ID</th>
                            <th>SCHEDID</th>
                            <th>FACULTY</th>
                            <th>CATALOGUE</th>
                            <th>GRADES (1st)</th> 
                            <th>GRADES (2nd)</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="gradeList">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="saveGrade('insert')">SAVE</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>