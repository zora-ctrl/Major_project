<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <style>
        /* Footer Customization */
        .tt-footer-custom {
            background-color: #333; /* Dark background */
            color: #fff; /* White text */
            padding: 20px 0;
            font-family: Arial, sans-serif;
        }
        
        .container {
            width: 90%;
            margin: 0 auto;
        }

        .tt-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tt-col-left, .tt-col-right {
            flex: 1;
        }

        .tt-box-copyright {
            font-size: 14px;
            color: #ffffff;
            font-weight: 300;
        }

        .tt-box-copyright strong {
            color: #ffffff;
            font-weight: 300;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <footer class="tt-footer-custom tt-color-scheme-02">
        <div class="container">
            <div class="tt-row">
                <div class="tt-col-cent">
                    <div class="tt-col-item">
                        <div class="tt-box-copyright">
                            © Mobile Accessories <script>document.write(new Date().getFullYear())</script>. All Rights Reserved. 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>


