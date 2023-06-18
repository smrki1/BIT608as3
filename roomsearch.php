<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <title>Check available rooms</title> 
        <script> 
        function searchResult(searchstr) 
        { 
            if (searchstr.length == 0) 
            { 
                return; 
            } 
            let xhRequest = new XMLHttpRequest(); 
            xhRequest.open("GET","roomavailability.php?searchfor=" + searchstr,true); 
            xhRequest.responseType = 'json'; 
            xhRequest.send(); 

            xhRequest.onload = function() 
            { 
                if(xhRequest.status == 200) 
                { 
                    const matchedRooms = xhRequest.response; 
                    var table = document.getElementById("tablerooms"); 
                    var rowCount = table.rows.length; 
                    for(var i = 1; i < rowCount; i++) 
                    { 
                        table.deleteRow(1);  
                    } 

                    if(matchedRooms == null) 
                    { 
                        document.getElementById("message").innerText = "No matching rooms"; 
                    } 
                    else 
                    { 
                       for(var i=0; i < matchedRooms.length; i++) 
                        { 
                            var roomID = matchedRooms[i]['roomID']; 
                            var rn = matchedRooms[i]['roomname']; 



                            tr = table.insertRow(-1); 
                            var tabCell = tr.insertCell(-1); 
                            tabCell.innerHTML = rn; 

                            var tabCell = tr.insertCell(-1); 
                            tabCell.innerHTML = urls;             
                        } 
                        document.getElementById("message").innerText = matchedRooms.length + " rooms found"; 
                    } 
                } 
                else 
                { 
                    alert("Response status was " + xhRequest.status); 
                } 
            } 

            xhRequest.onerror = function() 
            {  
                alert('Connection error'); 
            } 
        } 
        </script> 
    </head> 
    <body> 
        <h1>Room List Search by room name</h1> 
        <h2><a href='registermember.php'>[Create new Customer]</a><a href='index.php'>[Return to home page]</a></h2> 
        <form> 
            <label for="roomname">Roomname: </label> 
            <input id="roomname" type="text" size="30" onkeyup="searchResult(this.value)" onclick="this.value = ''" placeholder="Enter a room name"> 
        </form> 
        <table id="tablerooms" border="1"> 
            <thead><tr><th>Room name</th><th>Actions</th></tr></thead> 
        </table> 
        <p id="message"></p> 
    </body> 
</html> 
