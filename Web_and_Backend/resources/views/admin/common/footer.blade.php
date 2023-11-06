<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete one track, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default confirm-delete_cancel" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok confirm-delete">Delete</a>
                </div>
            </div>
        </div>
</div>


<footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; {{$copyright_year}} <a href="{{$copyright_url}}"> {{$copyright_name}} </a>.</strong> All rights
    reserved.
</footer>
