@component('mail::message')
# Thanks for your contribution!

Awesome people like you are what makes the Internet great!

Here is a breakdown of your contribution:

@component('mail::table')
| Breakdown        | Amount   |
|:---------------- | --------:|
| Domain lifetime  | ${{ number_format(($contribution->domain / 100), 2) }}  |
| Hosting lifetime | ${{ number_format($contribution->hosting / 100, 2) }}  |
| Coffee           | ${{ number_format($contribution->coffee / 100, 2) }}  |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
