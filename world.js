document.getElementById('lookup').addEventListener('click', function() {
    var country = document.getElementById('country').value;

    // Use AJAX to fetch data from world.php
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('result').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'world.php?country=' + country, true);
    xhr.send();
});

document.getElementById('lookupCities').addEventListener('click', function() {
    var country = document.getElementById('country').value;

    // Use AJAX to fetch city data from world.php
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('result').innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', 'world.php?country=' + country + '&lookup=cities', true);
    xhr.send();
});