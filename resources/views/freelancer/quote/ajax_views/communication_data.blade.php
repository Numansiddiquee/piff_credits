<label for="">Email Communications</label>
{{--        <div class="form-control form-control-sm m-5">--}}
{{--            <label for="contact_{{$contact->id}}">--}}
{{--            <input class="form-check-input" type="checkbox" value="{{$contact->id}}" id="contact_{{$contact->id}}" name="email_communication">--}}
{{--                <span class="ms-2">{{$contact->first_name .' '. $contact->last_name .' <'.$contact->email.'>'}}</span>--}}
{{--            </label>--}}
{{--        </div>--}}


<div class="d-flex">
    <select class="form-select form-select-sm" name="email_communications[]" id="email_communication" multiple>
        @if(count($contacts) > 0)
            @foreach($contacts as $contact)
                <option
                    value="{{ $contact->id }}">{{ $contact->first_name .' '.$contact->last_name .' <'.$contact->email.'>' }}</option>
            @endforeach
        @endif
    </select>
</div>
<script>
    $('#email_communication').select2();
</script>
