<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>

        <div>
            @yield('header')

            @yield('content')

            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7f7f7">
                <tbody>
                <tr>
                    <td align="center">
                        <table width="580" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#f7f7f7">
                            <tbody>
                            <tr>
                                <td align="center" style="padding:0 30px 30px 30px">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                        <tbody>
                                        <tr>
                                            <td align="center" style="padding:0 0 15px">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                    <tbody>
                                                    <tr>
                                                        <td valign="bottom" align="left" style="padding:30px 0 10px 0; font-family:helvetica neue,helvetica,arial,sans-serif;font-size:16px;line-height:20px;font-weight:bold;color:#a7a7a7">
                                                            {{ trans('email.Best regards') }},
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="bottom" align="left" style="padding-left: 10px; font-family:helvetica neue,helvetica,arial,sans-serif;font-size:16px;line-height:20px;font-weight:bold;color:#a7a7a7">
                                                            {{ trans('email.The :site_name staff.', ['site_name' => ucfirst(env('APP_NAME'))]) }}
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
        </div>
    </body>
</html>
