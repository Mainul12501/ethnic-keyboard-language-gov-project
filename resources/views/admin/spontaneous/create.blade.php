<div class="modal fade" id="spontaneousForm" tabindex="-1" aria-labelledby="spontaneousFormTitle" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('admin.spontaneouses.store')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('messages.নতুন স্বতঃস্ফূর্ত')}}</h5>
                    <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="field_wrapper">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="mb-3 row">
                                            <label class="col-sm-3 col-form-label" for="word">{{__('messages.কীওয়ার্ড')}}</label>
                                            <div class="col-sm-9">
                                                <input class="form-control @error('word') is-invalid @enderror" id="word" name="word[]" type="text" value="{{old('word')}}" placeholder="{{__('messages.বাংলা')}}" required>
                                            </div>
                                            @error('word')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle add_button">
                                            <svg class="icon text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                            </svg>
                                        </a>
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
