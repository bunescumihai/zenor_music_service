<!DOCTYPE html>
<?php
?>

<html lang="en">
<head>
    <title>Ajax</title>
</head>
<body>
    <script>
        function foo(){
            let frm = document.myform;
            let txt = frm.song_id.value;
            let hahah = document.getElementById('hahahah');

            const xmlhttp = new XMLHttpRequest();
            xmlhttp.getResponseHeader('Content-Type', 'application/json');

            xmlhttp.onload = function (){
                let obj = JSON.parse(this.response);

                for(let item of obj.results){
                    let pElement = document.createElement('p');
                    let text = document.createTextNode(item.name + ' - ' + item.artist);
                    pElement.classList.add('new-class');

                    pElement.appendChild(text);
                    hahah.appendChild(pElement);
                }

            }
            xmlhttp.open('GET', 'api/music/search.php?search=' + txt);
            xmlhttp.send();
        }

    </script>

    <form name="myform">
        <input type="text" name="song_id">
        <button type="button" onclick="foo()">OK</button>
    </form>
    <div id="hahahah">

    </div>
</body>
</html>
