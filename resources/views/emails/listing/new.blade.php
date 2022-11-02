@extends('emails.template')

@section('header')

@stop

@section('content')
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7">
        <tbody>
        <tr>
            <td width="580" align="center">
                <table width="580" cellspacing="0" cellpadding="0" border="0" align="center"
                       style="background-color:#ffffff">
                    <tbody>
                    <tr>
                        <td width="580" align="center" style="">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                   style="background-color:#ffffff">
                                <tbody>
                                <tr>
                                    <td width="580" align="center"
                                        style="padding: 0px 30px; background-color: rgb(247, 247, 247);">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center"
                                               style="border-collapse: collapse;">
                                            <tbody>
                                            <tr>
                                                <td style="padding: 50px 23px 0px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                                           align="left"
                                                           style="border-radius: 8px; background-color: rgb(255, 255, 255);">
                                                        <tbody>
                                                        <tr>
                                                            <td align="left"
                                                                style="font-family: helvetica neue,helvetica,arial,sans-serif; font-weight: bold; color: rgb(85, 85, 85); overflow: hidden; text-overflow: ellipsis; font-size: 14px; padding: 20px;">
                                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                                       border="0" align="left"
                                                                       style="border-radius: 8px; background-color: rgb(255, 255, 255);">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="left">
                                                                            {{ trans('email.New Listing...') }}
                                                                        </td>
                                                                        <td align="right">
                                                                            {{ trans('email.Submited') }}:
                                                                            <b>{{ $listing->status_updated_at->format('M j, Y H:i') }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                                       border="0" align="left"
                                                                       style="border-collapse:collapse">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="padding-bottom:20px">
                                                                            <a href="{{ route('listing.show', $listing->slug) }}"
                                                                               target="_blank"
                                                                               title="{{ $listing->title }}">
                                                                                <img width="474" height="312" border="0"
                                                                                     src="{{ asset(config('imagecache.route') . '/474x312/' .  $listing->base_image) }}"
                                                                                     style="min-width: 474px; width:474px;min-height:184px;text-decoration:none;display:block;outline:none;background-color:#656361">
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="left"
                                                                style="padding:0 20px 0 20px;font-family:helvetica neue,helvetica,arial,sans-serif;font-size:18px;color:#555555">
                                                                <a href="{{ route('listing.show', $listing->slug) }}" target="_blank" style="color:#cb2027">{{ $listing->title }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <table width="439" cellspacing="0" cellpadding="0"
                                                                       border="0" align="center"
                                                                       style="border-collapse:collapse">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td valign="middle"
                                                                            style="padding:12px 0 16px 0">
                                                                            <div style="border-top:1px solid #efefef;font-size:1px;line-height:1px">
                                                                                &nbsp;
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0 20px 21px 20px;font-family:helvetica neue,helvetica,arial,sans-serif;font-size:18px;color:#555555">
                                                                <table width="100%" cellspacing="0" cellpadding="0"
                                                                       border="0" align="left"
                                                                       style="border-collapse:collapse">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td align="left"
                                                                            style="font-family:helvetica neue,helvetica,arial,sans-serif;font-size:12px;color:#444444">
                                                                            <table width="100%" cellspacing="0"
                                                                                   cellpadding="0" border="0"
                                                                                   align="left"
                                                                                   style="border-collapse:collapse">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td width="60" align="left"
                                                                                        style="font-family:helvetica neue,helvetica,arial,sans-serif;font-size:12px;color:#444444">
                                                                                        <div style="color: rgb(153, 153, 153); font-weight: bold; padding: 0px 10px; line-height: 23px; border: 1px solid rgba(0, 0, 0, 0.2); height: 25px; width: 52px; border-radius: 4px;">
                                                                                             <span style="color:#cb2027">{{ config("app_settings.values.furnish_types.$listing->furnish_type", 'null') }}</span>
                                                                                        </div>
                                                                                    </td>
                                                                              {{--      <td align="left"
                                                                                        style="font-family:helvetica neue,helvetica,arial,sans-serif;font-size:12px;color:#444444">
                                                                                        <div style="margin-left: 10px;">
                                                                                            <span style="color:#cb2027"><b>{{ $listing->priceForHuman }}</b></span>
                                                                                            <b>{{ $listing->price }}</b>
                                                                                        </div>
                                                                                    </td>--}}
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td align="right"
                                                                            style="font-family:helvetica neue,helvetica,arial,sans-serif;font-size:15px;color:#444444">
                                                                            {{ trans('email.Nb Rooms') }}:
                                                                            <b>{{ config("app_settings.values.structure")[number_format($listing->nb_room,1)] ?: 'null' }}</b>
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
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@stop
