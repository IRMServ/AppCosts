<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=yes"> 
  
            <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
         
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <meta name="apple-mobile-web-app-status-bar-style" content="default" />
            <link rel="apple-touch-startup-image"  sizes="768×1024"  media="screen, mobile" href="images/splash.png" />
            <link rel="apple-touch-icon-precomposed" href="images/icon.png"/>
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script>
    
            $(document).ready(function(){
                $("#link").click(function(){
                    $('div').addClass('rotate');
                })
            })
     
        </script>
        <style>
            div{
                width:200px;
                height:300px;
                background-color: #660;
            }
            .rotate
            {
                animation-delay: 1s;
                animation-name: roda;
                animation-duration: 3s;
                animation-timing-function: linear;
                -webkit-animation-delay: 1s;
                -webkit-animation-name: roda;
                -webkit-animation-duration: 3s;
                -webkit-animation-timing-function: linear;
            }

            @keyframes roda
            {
                0%{
                width:200px;
                height:300px;
                background-color: #660;
            }
            100%{
/*                width:100%;
                height:100%;*/
                background-color:#669;
                transform:rotateY(180deg);
            }
            }
            @-webkit-keyframes roda
            {
                0%{
                width:200px;
                height:300px;
                background-color: #660;
            }
            100%{
/*                width:100%;
                height:100%;*/
                background-color:#669;
                -webkit-transform:rotateY(180deg);
            }
            }
        </style>
    </head>
    <body>
        <div>

        </div>
        <a id="link" href="#" >click</a>
    </body>
</html>
