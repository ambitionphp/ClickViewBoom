@component('mail::message')
# You received a secret text

Someone has sent you a secret text. This text will delete itself immediately when you view it.

@component('mail::button', ['url' => $url])
View secret text
@endcomponent

Thanks,<br>
{{ config('app.name') }}

<small>If you never want to receive an email from us again, click here to blacklist your email address.</small>
@endcomponent
