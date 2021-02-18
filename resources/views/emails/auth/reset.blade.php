@component('mail::message')
# Introduction

{{ config('app.name') }}.


<p> Your reset password is : {{$code}} </p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
