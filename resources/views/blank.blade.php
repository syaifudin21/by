<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

        <form id="myForm" action="{{url('https://payment.linkaja.id/checkout/payment?Message='.$token['pgpToken'])}}" method="post">
                <?php
                    // foreach ($_POST as $a => $b) {
                    //     echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
                    // }
                ?>
                </form>
                <script type="text/javascript">
                    document.getElementById('myForm').submit();
                </script>
    
</body>
</html>