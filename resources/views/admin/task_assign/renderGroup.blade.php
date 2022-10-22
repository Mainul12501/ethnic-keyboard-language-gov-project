@foreach($collectors as $key=>$collect)
    <div class="row mb-3"  id="topicSelect{{$key}}">
        <div class="col-md-2 col-sm-2">
            <input type="hidden" name="user_id[]" id="user_id" value="{{$key}}">
            <label class=" col-form-label" for="user_id">{{$collect}}</label>
        </div>
        <div class="col-md-5 col-sm-5">
            <select class="form-select select2"  id="topic_id{{$key}}" data-id="topic_id" name="topic_id{{$key}}[]"multiple>

            </select>
        </div>
        <div class="col-md-5 col-sm-5">
            <select class="form-select my-select2" id="spontaneous_id{{$key}}" data-id="spontaneous_id" name="spontaneous_id{{$key}}[]" multiple>
            </select>
        </div>
    </div>
@endforeach
