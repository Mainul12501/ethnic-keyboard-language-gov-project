<div class="modal fade" id="spontaneousEditForm" tabindex="-1" aria-labelledby="spontaneousEditFormTitle" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{url('admin/update-spontaneous')}}" method="post">
            @csrf
            @method("PUT")
            <input type="hidden" id="spontaneousID" name="spontaneousID">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('messages.আপডেট স্বতঃস্ফূর্ত')}}</h5>
                    <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="field_wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="word">{{__('messages.কীওয়ার্ড')}}</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="word" name="word" type="text" placeholder="কীওয়ার্ড বাংলায়" required>
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
