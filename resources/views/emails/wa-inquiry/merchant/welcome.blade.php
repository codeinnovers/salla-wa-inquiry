<!DOCTYPE html>
<html>
<head>
    <style>
        /* General styles for the email */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        table {
            border-spacing: 0;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header styles */
        .email-header {
            background-color: #2ecc71;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            max-height: 60px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Body styles */
        .email-body {
            padding: 20px;
            color: #333333;
        }

        .email-body h2 {
            margin: 0 0 10px;
            color: #2ecc71;
        }

        .email-body p {
            margin: 0 0 15px;
        }

        .email-body a {
            color: #2ecc71;
            text-decoration: none;
        }

        /* Button styles */
        .email-button {
            display: inline-block;
            background-color: #2ecc71;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }

        /* Footer styles */
        .email-footer {
            background-color: #f3f3f3;
            color: #999999;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .email-footer a {
            color: #2ecc71;
            text-decoration: none;
        }
    </style>
</head>
<body>
<table>
    <!-- Header -->
    <tr>
        <td class="email-header">
            <h1>{{$app_name}}</h1>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td class="email-body">
            <h2>Hello {{$name}},</h2>
            <p>Thank you for installing the <strong>Salla {{$app_name}}</strong> app! We're thrilled to have you onboard and can't wait to help you connect with your customers seamlessly.</p>
            <p>With this app, your customers can directly inquire about products via WhatsApp, making their shopping experience faster and more personal.</p>
            <p><b>Here's How to Get Started:</b></p>
            <ul>
                <li>1. Log in to your Salla store and access the installed app from your dashboard.</li>
                <li>2. Explore the settings to customize {{$app_name}} app.</li>
            </ul>
            <p>If you have any questions or need assistance, feel free to reach out to our support team at <a href="mailto:support@coding-home.com">support@coding-home.com</a>.</p>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td class="email-footer">
            <p>© {{date('Y')}} Coding Home. All rights reserved.</p>
        </td>
    </tr>
</table>
</body>
</html>
