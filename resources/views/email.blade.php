<p class="date" style="margin: 0; margin-bottom: 5px; font-size: 16px;">
    Dear {{ $user->USR_LASTNAME }}, </p>
<p style="margin: 0; font-size: 20px; font-weight: 300; line-height: 24px;">
    Below are eDCN cases pending for your
    approval:-</p>

<p><br></p>

<table align="center" border="0" cellpadding="0" cellspacing="0" class="mceItemTable"
    data-mce-style="font-size: 0px; width: 100%; background: #568feb;"
    style="cursor: default; font-size: 0px; width: 599px; background: rgb(86, 143, 235); text-align: center; ">
    <tbody>

        <tr>
            <td data-mce-style="text-align: center; vertical-align: top; direction: ltr; font-size: 0px; padding: 20px 0px; padding-bottom: 15px; padding-top: 15px;"
                style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 0px; margin: 8px; border-collapse: collapse; cursor: text;  text-align: center; vertical-align: top; direction: ltr; padding: 15px 0px;">
                <table border="0" cellpadding="0" cellspacing="0" class="mceItemTable"
                    data-mce-style="color: #000000; font-family: Ubuntu, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 22px; table-layout: auto; width: 100%;"
                    style="cursor: default;  color: rgb(0, 0, 0); font-family: Ubuntu, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 22px; table-layout: auto; width: 597px;">
                    <tbody>
                        <thead>
                            <tr>
                                <th>eDCN No.</th>
                                <th>Date Submitted</th>
                                <th>Document Title</th>
                            </tr>
                        </thead>

                        @foreach ($user->APP_NUMBERS as $index => $appNumber)
                            <tr>
                                <td align="Left" bgcolor="white"
                                    data-mce-style="border: 1px solid #568feb; padding: 0 15px 0 0;"
                                    style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; margin: 8px; border-collapse: collapse; cursor: text; border: 1px solid rgb(86, 143, 235); padding: 0px 15px 0px 0px;">
                                    {{ $appNumber }}</td>
                                <td align="Left" bgcolor="white"
                                    data-mce-style="border: 1px solid #568feb; padding: 0 15px 0 0;"
                                    style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; margin: 8px; border-collapse: collapse; cursor: text; border: 1px solid rgb(86, 143, 235); padding: 0px 15px 0px 0px;">
                                    {{ $user->DATES[$index] }}
                                </td>
                                <td align="Left" bgcolor="white"
                                    data-mce-style="border: 1px solid #568feb; padding: 0 15px 0 0;"
                                    style="color: rgb(0, 0, 0); font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; margin: 8px; border-collapse: collapse; cursor: text; border: 1px solid rgb(86, 143, 235); padding: 0px 15px 0px 0px;">
                                    {{ $user->TXT_DOCS[$index] }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </td>
        </tr>
    </tbody>
</table>

<p><br></p>

{{-- footer --}}

<div style="background:#54595f;background-color:#54595f;margin:0px auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#54595f;background-color:#54595f;width:100%;">
        <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:0px;text-align:center;">

                    <div style="margin:0px auto;max-width:600px;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                            style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">

                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                            style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                style="vertical-align:top;" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td align="center"
                                                            style="font-size:0px;padding:10px 25px;word-break:break-word;">
                                                            <div
                                                                style="font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;font-weight:400;line-height:20px;text-align:center;color:#ffffff;">

                                                                ***This is an automated notification
                                                                message; please do not reply to this email
                                                                address.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </td>
            </tr>
        </tbody>
    </table>
</div>
