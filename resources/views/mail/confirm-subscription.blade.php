@php
/**
 * @var string $confirmation_url
 * @var string $decline_url
 */
@endphp

@component('mail::layout')
@slot('header')
    @component('mail::header')
    @endcomponent
@endslot

<h1>Thanks for subscribing to the Serhii Cho email list</h1>
<p style="margin-bottom:0">To complete your subscription, you need to confirm you got this email. To do so, please click the button below:</p>

@component('mail::button', ['url' => $confirmation_url])
Confirm subscription
@endcomponent

<p>If you're having trouble clicking the button, copy and paste the URL into your web browser:</p>
<a href="{{ $confirmation_url }}">{{ $confirmation_url }}</a>

@component('mail::subcopy')
<p>If you subscribed in error, click the button below and you will be instantly removed from the list:</p>

@component('mail::button', ['url' => $decline_url, 'color' => 'decline'])
    Decline subscription
@endcomponent

<p>If you're having trouble clicking the button, copy and paste the URL into your web browser:</p>
<a href="{{ $decline_url }}">{{ $decline_url }}</a>
@endcomponent

@slot('footer')
@component('mail::footer')
<p>Add color to your workdays by following this blog</p>
@endcomponent
@endslot

@endcomponent
