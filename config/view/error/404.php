<?php

use Gallery\Utils\Json;
use Gallery\Utils\Color;
use Gallery\Utils\Config;
use Gallery\Utils\Http\Request;

$request = new Request();

if ($request->getMethod() !== 'GET') {
    Json::Response([
        'status' => 404,
        'message' => 'Not found',
    ], 404);
}

http_response_code(404);

$conf = Config::Instance();

$bg = false;
$color = '#ffffff';
try {
    $bg = new Color($conf->getBackground());
    if ($bg->getLightness() > 200) {
        $color = '#000000';
    }
} catch (\Exception $e) {
    $bg = false;
}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Error 404</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style rel="stylesheet">
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
            -webkit-animation: pulse 2s ease infinite;
            animation: pulse 2s ease infinite;
        }

        .compact {
            -webkit-animation: compact 2s ease infinite;
            animation: compact 2s ease infinite;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            color: rgba(0, 0, 0, 0.6);
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

        .message .brand,
        .message p {
            margin: 0;
            line-height: 1.5em;
        }

        .message .brand {
            font-size: 1.25rem;
            text-decoration: none;
        }

        .message p {
            font-size: 0.9em;
            color: #868e96 !important;
        }

        .bg-dark {
            background-color: #343a40;
        }
    </style>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="bg-dark">
    <div class="center">
        <div class="message">
            <svg class="svg">
                <svg viewBox="0 0 80 80">
                    <circle class="pulse" cx="40" cy="40" r="20" fill="transparent" stroke="<?php echo $color; ?>"></circle>
                    <circle class="compact" cx="40" cy="40" r="20" fill="<?php echo $color; ?>"></circle>
                </svg>
            </svg>
            <div>
                <a class="brand" href="/" style="color: <?php echo $color; ?>;">404 Not found</a>
                <p>This ressource does not exists</p>
            </div>
        </div>
    </div>
</body>

</html>
