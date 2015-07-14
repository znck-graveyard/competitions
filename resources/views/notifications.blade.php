@foreach(flash()->get() as $notification)
    @if(array_get($notification, 'title', false))
        @include('znck::flash.modal', $notification)
    @else
        <div class="alert notification alert-{{ $notification['level'] }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            <div class="container">
                {!! $notification['message'] !!}
            </div>
        </div>
    @endif
@endforeach