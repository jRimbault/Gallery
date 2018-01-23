<?php

use Utils\Http\Json;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Json::Response([
        'status' => 404,
        'message' => 'Not found',
    ], 404);
}

http_response_code(404);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>404 Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @-webkit-keyframes pulse {
            0% {
                -webkit-transform: translate(16px, 16px) scale(0.6);
                transform: translate(16px, 16px) scale(0.6);
                stroke-width: 13px;
            }
            50% {
                -webkit-transform: translate(-24px, -24px) scale(1.6);
                transform: translate(-24px, -24px) scale(1.6);
                stroke-width: 0;
            }
            100% {
                stroke-width: 0;
            }
        }
        @keyframes pulse {
            0% {
                -webkit-transform: translate(16px, 16px) scale(0.6);
                transform: translate(16px, 16px) scale(0.6);
                stroke-width: 13px;
            }
            50% {
                -webkit-transform: translate(-24px, -24px) scale(1.6);
                transform: translate(-24px, -24px) scale(1.6);
                stroke-width: 0;
            }
            100% {
                stroke-width: 0;
            }
        }
        @keyframes compact {
            0% {
                -webkit-transform: translate(-8px, -8px) scale(1.2);
                transform: translate(-8px, -8px) scale(1.2);
            }
            50% {
                -webkit-transform: translate(8px, 8px) scale(0.8);
                transform: translate(8px, 8px) scale(0.8);
            }
            100% {
                -webkit-transform: translate(-8px, -8px) scale(1.2);
                transform: translate(-8px, -8px) scale(1.2);
            }
        }
        .svg {
            padding-top: 5px;
            width: 72px;
            height: 72px;
        }
        .pulse {
            -webkit-animation: pulse 1s ease infinite;
            animation: pulse 1s ease infinite;
        }
        .compact {
            -webkit-animation: compact 1s ease infinite;
            animation: compact 1s ease infinite;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            justify-content: center;
            font-family: 'Lato Medium', sans-serif;
            color: rgba(0,0,0,0.6);
            background-color: #23232e;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .center {
            padding: 20px;
            align-self: center;
            border-radius: 3px;
        }
        .message {
            display: flex;
            align-items: center;
        }
        @media screen and (max-width: 640px) {
            .message {
                flex-direction: column;
            }
        }
        .message h2, .message p {
            margin: 0;
            text-align: center;
            line-height: 1.5em;
        }
        .message h2 {
            font-weight: 600;
            font-size: 1.3em;
            color: #4285f4;
        }
        .message p {
            font-size: 0.9em;
            color: #dddddd;
        }
    </style>
</head>
<body>
<div class="center">
    <div class="message">
        <svg class="svg">
            <svg viewBox="0 0 80 80">
                <circle class="pulse" cx="40" cy="40" r="20" fill="transparent" stroke="#4285f4"></circle>
                <circle class="compact" cx="40" cy="40" r="20" fill="#4285f4"></circle>
            </svg>
        </svg>
        <div>
            <h2>Error 404.</h2>
            <p>This ressource does not exists.</p>
        </div>
    </div>
</div>
</body>
</html>
