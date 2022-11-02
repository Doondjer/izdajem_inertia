
@extends('emails.template')

@section('header')
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7">
        <tbody>
        <tr>
            <td align="center">
                <table width="580" cellspacing="0" cellpadding="0" border="0" align="center" style="min-width:580px;background-color:#f7f7f7">
                    <tbody>
                    <tr>
                        <td align="center" style="">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;table-layout: fixed">
                                <tbody>
                                <tr>
                                    <td valign="bottom" align="left" style="padding:30px 0 10px 0; font-family:helvetica neue,helvetica,arial,sans-serif;font-size:16px;line-height:20px;font-weight:bold;color:#a7a7a7">
                                        {{ trans('email.You have posted a new message, regarding') }}:
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="bottom" align="left" style="padding-left: 10px; font-family:helvetica neue,helvetica,arial,sans-serif;font-size:16px;line-height:20px;font-weight:bold;color:#a7a7a7;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                        @if($thread->listing)
                                            <a href="{{ route('listing.show', $thread->listing->slug) }}" target="_blank" style="color:#a7a7a7">{{ $thread->subject }}</a>
                                        @else
                                            {{ $thread->subject }}
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7">
        <tbody>
            <tr>
                <td width="580" align="center" style="padding-top:20px">
                    <table width="580" height="40" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#ffffff">
                        <tbody>
                            <tr>
                                <td width="580" align="left" style="padding:30px 30px 20px 30px">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td valign="top" height="75" align="left">
                                                    <img width="75" height="75" border="0" style="text-decoration:none;display:block;outline:none" src="{{ asset( config('imagecache.route') . '/75x75/' . $sender->profile_image ) }}">
                                                </td>
                                                <td>

                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-size:32px;line-height:36px;padding:0 0 0 0;font-family:helvetica neue,helvetica,arial,sans-serif;font-weight:bold;color:#444444;max-width:510px;overflow:hidden;text-overflow:ellipsis">
                                                                <span style="color:#bd081c"> @ {{ ucwords($sender->name) }}</span>
                                                                {{ trans('email.message...')}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color:#999999;font-size: 13px;font-weight: normal;line-height:26px;">{{ trans("email.• That's you!") }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@stop

@section('content')
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7">
        <tbody>
            <tr>
                <td width="580" align="center">
                    <table width="580" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#ffffff">
                        <tbody>
                            <tr>
                                <td width="580" align="center" style="padding-bottom:40px">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#ffffff">
                                        <tbody>
                                            <tr>
                                                <td width="580" align="center" style="padding:0 30px 0 30px;background-color:#ffffff">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="bottom" align="left" style="padding:0 0 40px 0;font-family:helvetica neue,helvetica,arial,sans-serif;font-size:22px;line-height:26px;color:#444444">
                                                                    "{{ $newMessage->body }}"
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="580" align="center" style="padding:0 30px 0 30px;background-color:#ffffff">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" style="padding:0 35px 0 35px">
                                                                    <a target="_blank" style="text-decoration:none;display:block" href="#">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" style="padding:14px 20px 14px 20px;background-color:#bd081c;border-radius:4px">
                                                                                        <a href="{{ route('message.show', $thread->id) }}" target="_blank" style="font-family:helvetica neue,helvetica,arial,sans-serif;font-weight:bold;font-size:18px;line-height:22px;color:#ffffff;text-decoration:none;display:block;text-align:center;max-width:400px;overflow:hidden;text-overflow:ellipsis">{{ trans('email.Write back') }}</a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="580" align="center" style="padding:0 30px 0 30px;background-color:#ffffff">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="bottom" align="left" style="padding: 5px 44px 0">
                                                                    * {{ trans('email.:site_name is not responsible for the content of any posted message.', ['site_name' => ucfirst(env('APP_NAME'))]) }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@stop
