@extends('emails.template_two')
@section('emails.main')
<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;margin-top:1em">

	@if($type == 'default_update')
	<div style="margin:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;padding:0;margin-top:1em">
		{{ trans('messages.email.hope_messgae_friends',['site_name'=>$site_name,'updated_date'=>$updated_date], null, $locale) }}.
	</div>
	<div style="margin:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;padding:0;margin-top:1em">
		{{ trans('messages.email.change_your_account',[], null, $locale) }}
	</div>
</div>
@endif
@stop