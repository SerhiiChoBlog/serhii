@php
use App\Models\Subscription

/**
 * @var string $confirmation_url
 * @var string $decline_url
 * @var Subscription $subscription
 */
@endphp

@component('mail::layout')
@slot('header')
    @component('mail::header')
    @endcomponent
@endslot

<h1>Thanks for subscribing to the Serhii Cho email list</h1>

@if ($subscription->tags->isEmpty())
<p>You've requested a subscription to all the new articles.</p>
@else

<p>You've requested a subscription to <strong>{{ $subscription->tags->count() }} {{ str('tag')->plural($subscription->tags->count()) }}</strong> which you can see down below:</p>

<ul style="display: flex; flex-wrap: wrap; padding: 0;">
@foreach ($subscription->tags as $tag)
<li style="display: flex; align-items: center; gap: 10px; margin-bottom: 7px; flex: 0 0 50%;">
<img src="{{ asset("img/tags/{$tag->name}.webp") }}" width="20" height="20" style="border-radius: 3px;" />
<span>{{ $tag->title }}</span>
</li>
@endforeach
</ul>

@endif

<p style="margin-bottom: 0;">To complete your subscription, you need to confirm you got this email. To do so, please click the button below:</p>

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
<p>Add color to your workdays</p>
@endcomponent
@endslot

@endcomponent
