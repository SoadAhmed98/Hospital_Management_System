@component('mail::message')
# Dear {{$name}},

Your appointment has been booked on: {{$appointment}}
Thanks,<br>
{{ config('app.name') }}
@endcomponent