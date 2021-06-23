
<!DOCTYPE html>
<html>
      
<head>
    <title>
        jQuery UI | Date Picker
    </title>
      
    <link href=
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'>
      
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" >
    </script>
      
    <script src=
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" >
    </script>
</head>
  
<body>
    Date: <input type="text" id="my_date_picker">
   
    <script>
        $(document).ready(function() {
          
            $(function() {
                $( "#my_date_picker" ).datepicker();
            });
        })
    </script>
</body>
  
</html>