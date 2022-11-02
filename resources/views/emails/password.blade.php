@extends('emails.template')

@section('header')
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7;border-radius: 5px">
        <tbody>
        <tr>
            <td width="580" align="center" style="min-width:580px;padding-top:20px">
                <table width="580" height="40" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#ffffff">
                    <tbody>
                    <tr>
                        <td width="580" align="left" style="color:#ffffff;font-size:1px">
                            {{ trans("email.(Notice! You have 1 hour to pick your password. After that, you'll have to ask for a new one.)") }}
                        </td>
                    </tr>
                    <tr>
                        <td width="580" align="left" style="padding:30px 30px 20px 30px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td valign="bottom" height="50" align="left">
                                        <a href="{{ asset('') }}" target="_blank" title="{{ trans('email.Visit :site_name', ['site_name' => env('APP_NAME')]) }}" style="color: rgb(203, 32, 39); font-family: Brush Script MT,cursive; font-size: 40px;">
                                            {{--<img width="50" height="50" border="0" style="text-decoration:none;display:block;outline:none" src="#">--}}
                                            {{ ucfirst(env('APP_NAME')) }}
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="580" align="left" style="color:#ffffff;font-size:0px">
                            {{ date('Y-m-d H:i:s') }}
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
                                <td align="center" style="padding:0 30px 50px 30px">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td valign="bottom" align="left" style="padding:0 0 40px 0;font-family:helvetica neue,helvetica,arial,sans-serif;font-size:22px;line-height:26px;color:#444444">
                                                    {{ trans('email.Ready to change your password?') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="padding:0 35px 0 35px">
                                                    <a target="_blank" style="text-decoration:none;display:block" href="{{ asset("/reset-password/$token") }}">
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" style="padding:14px 20px 14px 20px;background-color:#bd081c;border-radius:4px">
                                                                        <a target="_blank" style="font-family:helvetica neue,helvetica,arial,sans-serif;font-weight:bold;font-size:18px;line-height:22px;color:#ffffff;text-decoration:none;display:block;text-align:center;max-width:400px;overflow:hidden;text-overflow:ellipsis" href="{{ asset("/reset-password/$token") }}">
                                                                            {{ trans('email.Reset password') }}
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody>
                                            <tr>
                                                <td style="height:40px;font-size:40px">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody><tr>
                                            <td valign="bottom" align="left" style="padding:0 0 0px 0;font-family:helvetica neue,helvetica,arial,sans-serif;font-size:16px;line-height:20px;color:#444444">
                                                {{ trans("email.(Notice! You have 1 hour to pick your password. After that, you'll have to ask for a new one.)") }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="580" align="left" style="color:#ffffff;font-size:0px">
                                    {{ date('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
@stop
