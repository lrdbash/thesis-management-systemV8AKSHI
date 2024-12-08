<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #1a252f;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Hello {{ $receiver->name }},</h1>
        <p>You have received a new message on the Strathmore Thesis Management System.</p>
        <p><strong>Message from {{ $sender->name }}:</strong></p>
        <blockquote style="font-style: italic; color: #555555;">
            "{{ $messageContent }}"
        </blockquote>
        <p>Please <a href="{{ url('/login') }}" class="btn">Log in</a> to view and reply to your messages.</p>
        <p>Thank you for using the Strathmore Thesis Management System.</p>
        <div class="footer">
            <p>This email was automatically generated. Please do not reply.</p>
            <p>Strathmore University | Thesis Management System</p>
        </div>
    </div>
</body>
</html>
