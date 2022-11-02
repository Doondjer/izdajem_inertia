@extends('emails.template')

@section('header')
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7;border-radius: 5px">
        <tbody>
        <tr>
            <td width="580" align="center" style="min-width:580px;padding-top:20px">
                <table width="580" height="40" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#ffffff">
                    <tbody>
                    <tr>
                        <td width="580" align="left" style="padding:30px 30px 20px 30px">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                    <td valign="bottom" height="50" align="left">
                                        <a href="{{ asset('') }}" target="_blank" title="{{ trans('email.Visit :site_name', ['site_name' => env('APP_NAME')]) }}" style="color: rgb(203, 32, 39); font-family: Brush Script MT,cursive; font-size: 40px;">
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
                                                    {!! $body !!}
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
