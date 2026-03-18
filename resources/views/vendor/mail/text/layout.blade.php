<!-- {!! strip_tags($header ?? '') !!} -->
@include('mail.header')

{!! strip_tags($slot) !!}
@isset($subcopy)

{!! strip_tags($subcopy) !!}
@endisset

<!-- {!! strip_tags($footer ?? '') !!} -->
@include('mail.footer')
