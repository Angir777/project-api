@extends('emails.layout.theme')

@section('content')
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td style="padding: 20px 0;">
                <h1>Hello, {{ $name }}!</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0;">
                <p>Thank you for using our service. This is a test email.</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="text-align: center;">
                            <a href="#">Click me</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
