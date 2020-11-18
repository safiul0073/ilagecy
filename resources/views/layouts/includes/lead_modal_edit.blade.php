<div class="modal" id="modalLeadEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Edit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Name</label>
                        <input class="form-control name" id="editFields" />
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Phone</label>
                        <input class="form-control phone" id="editFields" />
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Email</label>
                        <input class="form-control email" id="editFields" />
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Address</label>
                        <textarea class="form-control address" id="editFields"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Caller Status</label>
                        <select name="caller_status" id="editFields" class="form-control callerstatus">
                            @foreach (App\Models\Lead::statuses as $status)
                                <option value="{{ $status }}"> {{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveEditButton">Save</button>
            </div>
        </div>
    </div>
</div>
