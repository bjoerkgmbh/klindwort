/******* Do not edit this file *******
Simple Custom CSS and JS - by Silkypress.com
Saved: Jun 19 2017 | 09:08:53 */
function validateInput() {
    var inputValue, error, infos;
    inputValue = document.getElementById("address").value;
    error = document.getElementById("error-message");
    infos = document.getElementById("all-informations");
    if (inputValue.length == 0) {
        error.classList.add("show-error-message");
        infos.classList.add("hide-infos");
    } else if (inputValue.length > 0) {
        var isValid = validateAddress(inputValue);
        if (isValid) {
            error.classList.remove("show-error-message");
            infos.classList.remove("hide-infos");
            getDataFromInput();
            document.getElementById("address").value = " ";
        } else {
            error.classList.add("show-error-message");
            infos.classList.add("hide-infos");
        }
    }
}

function getDataFromInput() {
    var address, date, geocoder;
    address = document.getElementById('address').value;
    date = document.getElementById('date').value;
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        address: address
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            sendDatatoServer(results[0].geometry.location.lat(), results[0].geometry.location.lng(), date);
        }
    });
}

function setTodayDate() {
    var today = new Date();
    var dd = ("0" + (today.getDate())).slice(-2);
    var mm = ("0" + (today.getMonth() + 　1)).slice(-2);
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("date").setAttribute("value", today);
}

function sendDatatoServer(lat, lng, date) {
    var url, xhttp;
    url = 'https://www.aksh-notdienst.de/notdienste/exporte/xml.php?m=koord&w=' + lat + ';' + lng + '&z=' + date + ';' + date + '&a=4&c=iso';
    if (window.XMLHttpRequest)
        xhttp = new XMLHttpRequest();
    else
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xhttp.onreadystatechange = function () {
        postCallback(xhttp);
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

function postCallback(xhttp) {
    if (xhttp.readyState == 4) {
        if (xhttp.status == 200) {
            fetchXmlDataFromServer(xhttp);
        }
    }
}

function fetchXmlDataFromServer(xml) {
    var xmlDoc = xml.responseXML;
    var description, emergencyServiceTimes, creationDate, emergencyService;
    var pharmacy, street, postcode, city, phone, latitude, longitude, location, latLen;
    var latLenArray = [];

    description = xmlDoc.getElementsByTagName('beschreibung')[0].firstChild.data;
    document.getElementById("description").innerHTML = description;
    emergencyServiceTimes = xmlDoc.getElementsByTagName('notdienstzeiten')[0].firstChild.data;
    document.getElementById("emergencyServiceTimes").innerHTML = emergencyServiceTimes;
    creationDate = xmlDoc.getElementsByTagName('erstellungsdatum')[0].firstChild.data;
    document.getElementById("creationDate").innerHTML = creationDate;
    emergencyService = xmlDoc.getElementsByTagName('notdienst');
    document.getElementById("addresses").innerHTML = "";
    for (var i = 0; i < emergencyService.length; i++) {
        pharmacy = emergencyService[i].getElementsByTagName('apotheke')[0].firstChild.data;
        street = emergencyService[i].getElementsByTagName('strasse')[0].firstChild.data;
        postcode = emergencyService[i].getElementsByTagName('plz')[0].firstChild.data;
        city = emergencyService[i].getElementsByTagName('ort')[0].firstChild.data;
        phone = emergencyService[i].getElementsByTagName('telefon')[0].firstChild.data;
        latitude = emergencyService[i].getElementsByTagName('latitude')[0].firstChild.data;
        longitude = emergencyService[i].getElementsByTagName('longitude')[0].firstChild.data;
        location = postcode + ' ' + city;
        latLen = latitude + ' ' + longitude;
        latLenArray.push(latLen);
        createDomElements(pharmacy, street, location, phone);
    }
    displayGoogleApiMap(latLenArray);
}

function createDomElements(pharmacy, street, location, phone) {
    var divElement, pElementPharmacy, pElementStreet, pElementLocation, pElementPhone;
    
    divElement = document.createElement("div");
    divElement.className = 'col-md-6';
    pElementPharmacy = document.createElement("P");
    pElementPharmacy.className = 'pharmacy';
    pElementPharmacy.appendChild(document.createTextNode(pharmacy));
    pElementStreet = document.createElement("P");
    pElementStreet.appendChild(document.createTextNode(street));
    pElementLocation = document.createElement("P");
    pElementLocation.appendChild(document.createTextNode(location));
    pElementPhone = document.createElement("P");
    pElementPhone.appendChild(document.createTextNode('Tel.: ' + phone));
    divElement.appendChild(pElementPharmacy);
    divElement.appendChild(pElementStreet);
    divElement.appendChild(pElementLocation);
    divElement.appendChild(pElementPhone);
    document.getElementById("addresses").appendChild(divElement);
}

function displayGoogleApiMap(latLenData) {
    var marker;
    var map = new google.maps.Map(document.getElementById("googleMap"), {
        zoom: 10,
        center: new google.maps.LatLng(53.86893, 10.68729),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    for (var i = 0; i < latLenData.length; i++) {
        var index, lat, len;
        index = latLenData[i].indexOf(" ");
        lat = latLenData[i].substr(0, index);
        len = latLenData[i].substr(index + 1);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, len),
            map: map
        });
    }
}

function validateAddress(address) {
    var re1 = '((?:[a-z][a-z]+))';
    var re2 = '([a-z])';
    var re3 = '([a-z])';
    var re4 = '.*?';
    var re5 = '(\\s+)';
    var re6 = '(\\d+)';
    var re7 = '(\\s+)';
    var re8 = '(\\d)';
    var re9 = '(\\d)';
    var re10 = '(\\d)';
    var re11 = '(\\d)';
    var re12 = '(\\d)';
    var re13 = '(\\s+)';
    var re14 = '([a-z])';
    var re15 = '(.)';
    var re16 = '((?:[a-z][a-z]+))';
    var p = new RegExp(re1 + re2 + re3 + re4 + re5 + re6 + re7 + re8 + re9 + re10 + re11 + re12 + re13 + re14 + re15 + re16, ["i"]);
    return p.test(address);
}