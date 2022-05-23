<?php

include('testcors.txt');
include('testcors2.php');

?>
<script src="jquery-3.6.0.min.js"></script>
<script>
$.ajax({
    type: 'GET',
    url: 'testcorsajax.php',
    //data: {person_id:getUserID},
    data: { },
    headers: {
//             Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
//             "Header Name Two": 'Header Value Two'  //for object property name, use quoted notation shown in second
    //    'Accept': 'blah',
    //    'Sec-Fetch-Site': 'cross-origin',
    //    'Sec-Fetch-Mode': 'no-cors',
    },
    success: function(data){
        //alert(data);
        alert('data from testcorsajax.php: ' + data);
        //$("#processing").hide();
        //$("#person-data").html(data);
    }
});

$.ajax({
    type: 'GET',
    url: 'testcorsajax.php',
    data: { },
    success: function(data){
        alert('data from testcorsajax.php (again): ' + data);
    }
});

$.ajax({
    type: 'GET',
    url: 'testcorsajax2.php',
    data: { },
    success: function(data){
        alert('data from testcorsajax2.php (again): ' + data);
    }
});

$.ajax({
    type: 'GET',
    url: 'testcorsajax3.php',
    data: { },
    success: function(data){
        alert('data from testcorsajax3.php: ' + data);
    }
});

/*$.ajax({
    type: 'GET',
    url: 'testcorsajax2.php',
    //data: {person_id:getUserID},
    data: { },
    headers: {
//             Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
//             "Header Name Two": 'Header Value Two'  //for object property name, use quoted notation shown in second
    //    'Accept': 'blah',
    //    'Sec-Fetch-Site': 'cross-origin',
    //    'Sec-Fetch-Mode': 'no-cors',
    },
    success: function(data){
        //alert(data);
        alert('data from testcorsajax2.php: ' + data);
        //$("#processing").hide();
        //$("#person-data").html(data);
    }
});*/
</script>
