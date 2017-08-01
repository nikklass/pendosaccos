@component('mail::message')
# Welcone to Pendo admin

Thanks for signing up. Click on the link below to set your password:
<br>
url here

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
