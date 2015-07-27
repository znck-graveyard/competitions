@extends('comparator.abstract')

@section('one.content')
    <div class="content content-text" style="display: block; overflow: auto">
        <article>
            {!! $one->abstract !!}
        </article>
    </div>
@endsection
@section('other.content')
    <div class="content content-text" style="display: block; overflow: auto">
        <article>
            {!! $other->abstract !!}
        </article>
    </div>
@endsection