<div class="modal fade" id="trimEditForm" tabindex="-1" aria-labelledby="trimEditFormTitle" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('admin.trim.send.revert')}}" method="post">
            @csrf
            @method("PUT")
            <input type="hidden" id="ID" name="id">
            <input type="hidden" id="trimID" name="trimID">
            <input type="hidden" id="audio_type" name="audio_type">
            <input type="hidden" id="collector_id" name="collector_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('messages.সংশোধন মেসেজ')}}</h5>
                    <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="field_wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="comment">{{__('messages.মেসেজ')}}</label>
                                            <div class="col-sm-9">
                                                <textarea name="comment" class="form-control" id="comment" cols="30" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm text-white" type="button" data-coreui-dismiss="modal">{{__('messages.বন্ধ করুন')}}</button>
                    <button class="btn btn-success btn-sm text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
