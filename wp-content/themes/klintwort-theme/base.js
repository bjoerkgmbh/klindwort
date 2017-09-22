document.body.onload = function () {
  setTodayDate();
  formsAutoComplete();
  getPharmacyOpenTimes();
  start();
  if (window.location.href.indexOf('/filiale/') > -1) {
   setTimeout(function(){ 
    showPage();
  }, 500);
  }
  createPolenCalender();
}

function formsAutoComplete() {
  var placesAutocomplete;
  placesAutocomplete = places({
    container: document.querySelector('#address'),
    language: 'de',
    countries: 'de',
    aroundLatLng: 53.86893 + ',' + 10.68729,
    aroundRadius: 15 * 1000,
    type: 'address',
    templates: {
      value: function(suggestion) {
        return suggestion.name + ', ' + suggestion.city;
      }
    }
  });
  // console.log(document.querySelector('#address'));
}

function validateInput() {
  var inputValue, error, infos;
  inputValue = document.getElementById("address").value;
  error = document.getElementById("error-message");
  infos = document.getElementById("all-informations");
  if (inputValue.length == 0) {
    error.classList.add("show-error-message");
    infos.classList.add("hide-infos");
    infos.style.marginTop = '30px';
  } else if (inputValue.length > 0) {
    var isValid = validateAddress(inputValue);
    if (isValid) {
      error.classList.remove("show-error-message");
      infos.classList.remove("hide-infos");
      getDataFromInput();
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
      sendDatatoServer(results[0].geometry.location.lat(), results[0].geometry.location.lng(), date, address);
    }
  });
}

function setTodayDate() {
  var today, dd, mm, yyyy;
  today = new Date();
  dd = ("0" + (today.getDate())).slice(-2);
  mm = ("0" + (today.getMonth() + 　1)).slice(-2);
  yyyy = today.getFullYear();
  today = yyyy + '-' + mm + '-' + dd;
  document.getElementById("date").setAttribute("value", today);
}

function getPharmacyOpenTimes () {
  // var pharmacyIDs = ['ChIJ2_wnOHkLskcRGTne-IlonL0', 'ChIJORzXoH4LskcRcjubHWlI_is', 'ChIJA-r_0lR0skcRVmXGsIrr9Do', 'ChIJXai2QgYLskcRIAb8-oyS5mU', 'ChIJL0kFQVR0skcRJ6ffqbm1uRk'];
  var url = ['/wp-content/uploads/daenischburger.json',
            '/wp-content/uploads/strandallee.json',
            '/wp-content/uploads/rathausgasse.json',
            '/wp-content/uploads/schwartau.json',
            '/wp-content/uploads/bergstrasse.json']
  var xhttp = new Array();
  for (var i = 0; i < url.length; i++) {
    (function(i) {
      // url[i] = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' + pharmacyIDs[i] + '&key=AIzaSyCGe4zzblB8biqGd0qAWW4t7bC2QA9O0Kw&language=de';
      // console.log(url[i]);
      if (window.XMLHttpRequest) {
        xhttp[i] = new XMLHttpRequest();
        xhttp[i].open("GET", url[i], true);
      }
      else {
        xhttp[i] = new ActiveXObject("Microsoft.XMLHTTP");
        xhttp[i].open("GET", url[i], true);
      }
      xhttp[i].onreadystatechange = function () {
        if (xhttp[i].readyState == 4) {
          if (xhttp[i].status == 200) {
            outputPharmacyOpenTimes(JSON.parse(xhttp[i].responseText));
          }
        }
      };
      xhttp[i].send();
    })(i);
  }
}

function outputPharmacyOpenTimes(jsonData) {
  // console.log(jsonData);
  var pElementMail, pElementFax;
  var openingHoursWeekdayText = jsonData.result.opening_hours.weekday_text;
  var pharmacyOpenTimes = document.getElementById('pharmacyOpenTimes');
  var divElement = document.createElement('div');
  divElement.className = 'col-md-4';
  var divOpeningHours = document.createElement('div');
  divOpeningHours.className = 'opening_hours branch_opening_hours';
  var pElementName = document.createElement('p');
  pElementName.className = 'filialen';
  pElementName.appendChild(document.createTextNode(jsonData.result.name));
  var divElementAdress = document.createElement('div');
  divElementAdress.className = 'address';
  var pElementAdressStreet = document.createElement('p');
  var pElementAdressCity = document.createElement('p');
  var address = jsonData.result.formatted_address;
  address = address.substring(0, address.length-13);
  address = address.split(', ');
  var [street, city] = address;
  pElementAdressStreet.appendChild(document.createTextNode(street));
  pElementAdressCity.appendChild(document.createTextNode(city));
  divElementAdress.appendChild(pElementAdressStreet);
  divElementAdress.appendChild(pElementAdressCity);
  if (jsonData.result.name === 'Klindwort Apotheke am Strand') {
    pElementMail = document.createElement('p');
    pElementMail.appendChild(document.createTextNode('apo4@klindwort.de'));
    pElementFax = document.createElement('p');
    pElementFax.appendChild(document.createTextNode('Fax: ' + '+49 04503 889049'));
  }
  if (jsonData.result.name === 'Klindwort Apotheke Bergstraße') {
    pElementMail = document.createElement('p');
    pElementMail.appendChild(document.createTextNode('apo3@klindwort.de'));
    pElementFax = document.createElement('p');
    pElementFax.appendChild(document.createTextNode('Fax: ' + '+49 04503 889039'));
  }
  if (jsonData.result.name === 'Klindwort Apotheke Rathausgasse') {
    pElementMail = document.createElement('p');
    pElementMail.appendChild(document.createTextNode('apo2@klindwort.de'));
    pElementFax = document.createElement('p');
    pElementFax.appendChild(document.createTextNode('Fax: ' + '+49 451 2925056'));
  }
  if (jsonData.result.name === 'Klindwort Apotheke Lübecker Straße') {
    pElementMail = document.createElement('p');
    pElementMail.appendChild(document.createTextNode('apo1@klindwort.de'));
    pElementFax = document.createElement('p');
    pElementFax.appendChild(document.createTextNode('Fax: ' + '+49 451 2925016'));
  }
  if (jsonData.result.name === 'Klindwort Apotheke im LUV') {
    pElementMail = document.createElement('p');
    pElementMail.appendChild(document.createTextNode('apo5@klindwort.de'));
    pElementFax = document.createElement('p');
    pElementFax.appendChild(document.createTextNode('Fax: ' + '+49 451 2925096'));
  }
  var pElementTel = document.createElement('p');
  pElementTel.appendChild(document.createTextNode('Tel: ' + jsonData.result.international_phone_number));
  var divElementDisplay = document.createElement('div');
  divElementDisplay.className = 'display';
  var iElement = document.createElement('i');
  iElement.className = 'fa fa-clock-o';
  var att = document.createAttribute('aria-hidden');
  att.value = 'true';
  iElement.setAttributeNode(att);
  divElementDisplay.appendChild(iElement);
  for (var j = 0; j < openingHoursWeekdayText.length; j++) {
    var divOneRecord = document.createElement('div');
    editOneRecord(openingHoursWeekdayText[j], divOneRecord);
    divOpeningHours.appendChild(divOneRecord);
  }
  divElement.appendChild(pElementName);
  divElement.appendChild(divElementAdress);
  divElement.appendChild(pElementMail);
  divElement.appendChild(pElementTel);
  divElement.appendChild(pElementFax);
  divElement.appendChild(divElementDisplay);
  divElement.appendChild(divOpeningHours);
  pharmacyOpenTimes.appendChild(divElement);
}

function editOneRecord(infos, divOneRecord) {
  infos = infos.replace(/ Uhr/g, '');
  // console.log(infos);
  var index = infos.split(': ');
  var [day, time] = index;
  var dayElement = document.createElement('p');
  dayElement.appendChild(document.createTextNode(getDayString(day)));
  var timeElement = document.createElement('p');
  timeElement.appendChild(document.createTextNode(time));
  divOneRecord.appendChild(dayElement);
  divOneRecord.appendChild(timeElement);
}

function sendDatatoServer(lat, lng, date, address) {
  var url, xhttp;
  // var startDateTime = date + '%2008:00:00';
  // var endDateTime = date + '%2023:59:59';
  //url = `http://v4.api.apotheken.de/api/b41803bc-5425-8529-bd1d-593a8adb6b2b/notdienst.json?search[location][geographicalPoint][latitude]=${lat}&search[location][geographicalPoint][longitude]=${lng}&search[startDateTime]=${startDateTime}&search[endDateTime]=${endDateTime}&search[radius]=3`;
  url = "/wp-content/uploads/notdienst.xml";
  // console.log(url);
  if (window.XMLHttpRequest) xhttp = new XMLHttpRequest();
  else xhttp = new ActiveXObject("Microsoft.XMLHTTP");

  xhttp.onreadystatechange = function () {
    postCallback(xhttp, date, address);
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}

function postCallback(xhttp, date, address) {
  if (xhttp.readyState == 4) {
    if (xhttp.status == 200) {
      fetchXmlDataFromServer(xhttp, date, address);
      //fetchJsonData(xhttp, JSON.parse(xhttp.responseText));
    }
  }
}

function fetchJsonData(xhttp, jsonData) {
  var pharmacies, services;
  var id, name, email, phone, fax, uri, startDateTime, endDateTime, street, zip, city, region, country, lat, lng,
    latLng;
  var serviceId, serviceName, serviceDescription, serviceLongDescription;
  var latLenArray = [];
  var divElement;
  pharmacies = jsonData.response.pharmacies;
  servicesInfos = jsonData.response.head.facets.services;
  //  console.log(pharmacies);
  document.getElementById("core").innerHTML = '';
  for (pharmacy in pharmacies) {
    divElement = document.createElement("div");
    divElement.className = 'col-md-6';
    id = pharmacies[pharmacy].id;
    name = pharmacies[pharmacy].name;
    if (pharmacies[pharmacy].primaryEmail === null) {
      email = 'Keine E-Mail.';
    } else {
      email = pharmacies[pharmacy].primaryEmail.identifier;
    }
    phone = pharmacies[pharmacy].phone;
    fax = pharmacies[pharmacy].fax;
    if (pharmacies[pharmacy].primaryUri === null) {
      uri = 'Keine Website.';
    } else {
      uri = pharmacies[pharmacy].primaryUri.identifier;
    }
    divElement.appendChild(createPharmacyContactInfos(id, name, email, phone, fax, uri));
    street = pharmacies[pharmacy].location.street;
    zip = pharmacies[pharmacy].location.zip;
    city = pharmacies[pharmacy].location.city;
    region = pharmacies[pharmacy].location.region;
    country = pharmacies[pharmacy].location.country;
    divElement.appendChild(createPharmacyLocationInfos(street, zip, city, region, country));
    startDateTime = pharmacies[pharmacy].startDateTime.date;
    endDateTime = pharmacies[pharmacy].endDateTime.date;
    // divElement.appendChild(createPharmacyTimeInfos(startDateTime, endDateTime));
    lat = pharmacies[pharmacy].location.geographicalPoint.latitude;
    lng = pharmacies[pharmacy].location.geographicalPoint.longitude;
    latLng = lat + ' ' + lng;
    latLenArray.push(latLng);
    for (service in pharmacies[pharmacy].services) {
      serviceId = pharmacies[pharmacy].services[service];
      serviceName = servicesInfos[serviceId].name;
      serviceDescription = servicesInfos[serviceId].description;
      serviceLongDescription = servicesInfos[serviceId].longdescription;
      //  divElement.appendChild(createPharmacyServiceInfos(serviceName, serviceDescription, serviceLongDescription));
    }
    document.getElementById("core").appendChild(divElement);
  }
  displayGoogleApiMap(latLenArray);
  document.getElementById("all-informations").style.marginTop = "50px";
}

function createPharmacyServiceInfos(serviceName, serviceDescription, serviceLongDescription) {
  var divElement, p;
  var elements = [serviceName, serviceDescription, serviceLongDescription];
  divElement = document.createElement("div");
  divElement.id = 'service_infos';
  for (var i = 0; i < elements.length; i++) {
    p = document.createElement('P');
    p.appendChild(document.createTextNode(elements[i]));
    divElement.appendChild(p);
  }
  return divElement;
}

function createPharmacyTimeInfos(startDateTime, endDateTime) {
  var divElement, p;
  var elements = [startDateTime, endDateTime];
  divElement = document.createElement("div");
  divElement.id = 'time_infos';
  for (var i = 0; i < elements.length; i++) {
    p = document.createElement('P');
    p.appendChild(document.createTextNode(elements[i]));
    divElement.appendChild(p);
  }
  return divElement;
}

function createPharmacyLocationInfos(street, zip, city, region, country) {
  var divElement, p, span;
  var elements = [street, zip, city, region];
  var labels = ['Straße ', 'ZIP ', 'Stadt ', 'Bundesland '];
  divElement = document.createElement("div");
  divElement.id = 'location_infos';
  for (var i = 0; i < elements.length; i++) {
    p = document.createElement('P');
    span = document.createElement('span');
    span.appendChild(document.createTextNode(labels[i]));
    p.appendChild(span);
    p.appendChild(document.createTextNode(elements[i]));
    divElement.appendChild(p);
  }
  return divElement;
}

function createPharmacyContactInfos(id, name, email, phone, fax, uri) {
  var divElement, p, span;
  var elements = [id, name, email, phone, fax];
  var labels = [' ID: ', 'Apothekenname ', 'E-Mail ', 'Phone ', 'FAX '];
  divElement = document.createElement("div");
  divElement.id = 'contact_infos';
  for (var i = 0; i < elements.length; i++) {
    if (i === 0) {} else if (i === 1) {
      p = document.createElement('P');
      span = document.createElement('span');
      span.appendChild(document.createTextNode(labels[0] + elements[0]));
      p.appendChild(document.createTextNode(labels[i] + elements[i]));
      p.appendChild(span);
    } else if (i > 1) {
      p = document.createElement('P');
      span = document.createElement('span');
      span.appendChild(document.createTextNode(labels[i]));
      p.appendChild(span);
      p.appendChild(document.createTextNode(elements[i]));
    }
    if (i !== 0) divElement.appendChild(p);
  }
  return divElement;
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

function fetchXmlDataFromServer(xml, date, address) {
  var xmlDoc = xml.responseXML;
  // console.log(xmlDoc);
  var emergencyServiceTimes, creationDate, emergencyService;
  var pharmacy, street, postcode, city, phone, latitude, longitude, location, latLen, dateXML, formatedInputDate;
  var latLenArray = [];
  document.getElementById("description").innerHTML =
    '<p>Die nächste notdienstbereiten Apotheken für den Standort: <span>' + address + '</span>.</p>';
  emergencyServiceTimes = xmlDoc.getElementsByTagName('notdienstzeiten')[0].firstChild.data;
  document.getElementById("emergencyServiceTimes").innerHTML = '<p>Notfall-Servicezeiten: ' + emergencyServiceTimes + '</p>';
  creationDate = xmlDoc.getElementsByTagName('erstellungsdatum')[0].firstChild.data;
  document.getElementById("creationDate").innerHTML = '<p>Erstellungsdatum: <span>' + creationDate + '</span></p>';
  emergencyService = xmlDoc.getElementsByTagName('notdienst');
  document.getElementById("addresses").innerHTML = "";
  formatedInputDate = dateFormation(date);

  for (var i = 0; i < emergencyService.length; i++) {
    dateXML = emergencyService[i].getElementsByTagName('datum')[0].firstChild.data;
    // console.log('dateXML :' + dateXML);
        // console.log('formatedInputDate :' + formatedInputDate);
    if (dateXML === formatedInputDate) {
        
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
      // console.log('pharmacy : ' + pharmacy);
      createDomElements(pharmacy, street, location, phone);
      document.getElementById("addresses").style.height = "250px";
      document.getElementById("all-informations").style.margin = "30px 0";
      document.getElementById("all-informations").style.height = "480px";
      displayGoogleApiMap(latLenArray);
    }
  }
  var printPage = document.getElementById("print_page");
  var printButton = document.createElement("a");
  printButton.setAttribute('href','#');
  printButton.innerHTML = "Jetzt drucken";
  printButton.className  = "btn btn-default red";
  printButton.addEventListener("click", function() {
      window.print();
  }, false);
  printPage.appendChild(printButton);
}

function dateFormation(todaysDate) {
  var index = todaysDate.split('-');
  var [year, month, day] = index;
  return day + '.' + month + '.' + year;
}

function displayGoogleApiMap(latLenData) {
  var marker, map;
  map = new google.maps.Map(document.getElementById("googleMap"), {
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
  var re1='((?:[a-z][a-z0-9_äöüÄÖÜß\\s+\-]*))';	// Variable Name 1
  var re2='(,)';	// Any Single Character 1
  var re3='(\\s+)';	// White Space 1
  var re4='((?:[a-z][a-z0-9_äöüÄÖÜß\\s+\-]*))';	// Variable Name 2

  var p = new RegExp(re1+re2+re3+re4,["i"]);
  return p.test(address);
}

function start() {
  setTimeout(function(){ 
    startComparing();
  }, 1000);
  setInterval(function () {
    startComparing();
  }, 60 * 1000);
}

function startComparing() {
  var currentDate, currentHour, currentMinute, currentDay, timeNow, dayNow, time, formatedTime;
  var parent, children, value, e, node, textnode, display, allValues, fontcolor;
  currentDate = new Date();
  currentHour = (currentDate.getHours() < 10 ? '0' : '') + currentDate.getHours();
  currentMinute = (currentDate.getMinutes() < 10 ? '0' : '') + currentDate.getMinutes();
  currentDay = currentDate.getDay();
  timeNow = currentHour + ':' + currentMinute;
  dayNow = getDay(currentDay);

  parent = document.getElementsByClassName('opening_hours branch_opening_hours');
  for (var j = 0; j < parent.length; j++) {
    children = parent[j].getElementsByTagName('div');
    for (var i = 0; i < children.length; i++) {
      e = children[i].firstChild.innerHTML;
      if (e === dayNow) {
        time = children[i].getElementsByTagName('P')[1].innerHTML;
        if (time === 'Geschlossen') {
          value = 'Geschlossen';
          formatedTime = time;
        }
        if (time.length > 13) {
          value = compareTimeLong(time, timeNow);
          formatedTime = time.slice(0, 12) + '<br>' + time.slice(12);
        } else {
          value = compareTime(time, timeNow);
          formatedTime = time;
        }
        allValues = children[i].getElementsByClassName('value');
        for (var v = 0; v < 5; v++) {
          if (allValues.length !== 0) {
            children[i].removeChild(children[i].lastChild);
          }
          node = document.createElement('P');
          textnode = document.createTextNode(value);
          node.className += " value";
          node.appendChild(textnode);
          node.style.fontWeight = '600';
          children[i].appendChild(node);
          children[i].lastChild.style.display = 'none';
          if (children[i].lastChild.innerHTML === 'Jetzt geöffnet') {
            children[i].lastChild.style.color = fontcolor = '#06cc06';
            children[i].firstChild.style.color = '#06cc06';
            children[i].getElementsByTagName('P')[1].style.color = '#06cc06';
            children[i].getElementsByTagName('P')[1].style.fontWeight = '600';
          } else if (children[i].lastChild.innerHTML === 'Geschlossen') {
            children[i].lastChild.style.color = fontcolor = '#7f1017';
            children[i].firstChild.style.color = '#7f1017';
            children[i].getElementsByTagName('P')[1].style.color = '#7f1017';
            children[i].getElementsByTagName('P')[1].style.fontWeight = '600';
          } else {
            children[i].lastChild.style.color = fontcolor = 'orange';
            children[i].firstChild.style.color = 'orange';
            children[i].getElementsByTagName('P')[1].style.color = 'orange';
            children[i].getElementsByTagName('P')[1].style.fontWeight = '600';
          }
        }
      }
    }
    if (document.getElementsByClassName('display')[j] === undefined) {return false;}
    display = document.getElementsByClassName('display')[j].innerHTML =
      '<i class="fa fa-clock-o" aria-hidden="true" style="color: ' + fontcolor + ' "></i>' +
      '<p class="time">' + formatedTime + '</p>' +
      '<p class="value" style="color: ' + fontcolor + ' ">' + value + '</p>';
  }
}

function getDay(day) {
  if (day == 0) return 'So.';
  else if (day == 1) return 'Mo.';
  else if (day == 2) return 'Di.';
  else if (day == 3) return 'Mi.';
  else if (day == 4) return 'Do.';
  else if (day == 5) return 'Fr.';
  return 'Sa.';
}

function getDayString(day) {
  if (day == 'Sonntag') return 'So.';
  else if (day == 'Montag') return 'Mo.';
  else if (day == 'Dienstag') return 'Di.';
  else if (day == 'Mittwoch') return 'Mi.';
  else if (day == 'Donnerstag') return 'Do.';
  else if (day == 'Freitag') return 'Fr.';
  return 'Sa.';
}

function compareTime(time, currentTime) {
  var index, index2;
  index = time.replace(/–/g, ' ');
  index2 = index.split(' ');
  var [start, end] = index2;
  if (currentTime > start && currentTime < end) {
    return 'Jetzt geöffnet';
  } else {
    return 'Geschlossen';
  }
}

function compareTimeLong(time, currentTime) {
  var index, index2, index3;
  index = time.replace(/,/g, '');
  index2 = index.replace(/–/g, ' ');
  index3 = index2.split(' ');
  var [start, one, two, end] = index3;
  if (currentTime > start && currentTime < end) {
    if (currentTime > one && currentTime < two) {
      return 'Pause';
    } else {
      return 'Jetzt geöffnet';
    }
  } else {
    return 'Geschlossen';
  }
}

function displayBurgerMenu() {
  var x = document.getElementById('menu-top-menu');
  x.classList.toggle('showMenu');
}

(function () {
  "use strict";
  var toggles = document.querySelectorAll(".c-hamburger");

  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  };

  function toggleHandler(toggle) {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      // (this.classList.contains("is-active") === true) ? this.classList.remove("is-active"): this.classList.add(
      //   "is-active");
      if (this.classList.contains("is-active")) {
        this.classList.remove("is-active");
      }
      else {
        this.classList.add("is-active");
      }
    });
  }

})();

function myFunction() {
  setTimeout(function(){ 
    showPage();
  }, 1000);
}

function showPage() {
  var root = document.getElementById('ajax-panel');
  root.className = 'animate-bottom';
  var openTimes = document.getElementsByClassName('ommo');
  var divElement = document.createElement('div');
  divElement.className = 'opening_hours branch_opening_hours';
  for(var i = 0; i < openTimes.length; i++){
    var infos = openTimes[i].innerHTML;
    // console.log(openTimes[i].innerHTML);
    var divInner = document.createElement('div');
    infos = infos.replace(/ Uhr/g, '');
    var index = infos.split(': ');
    var [day, time] = index;
    var dayElement = document.createElement('p');
    dayElement.appendChild(document.createTextNode(getDayString(day)));
    var timeElement = document.createElement('p');
    timeElement.appendChild(document.createTextNode(time));
    divInner.appendChild(dayElement);
    divInner.appendChild(timeElement);
    divElement.appendChild(divInner);
  }
  root.innerHTML = '';
  root.appendChild(divElement);
  loader.style.display = "none";
  root.style.display = 'block';
}

function createPolenCalender() {
  var createPolenCalender = document.getElementById('polen-calender');
  var rowEl = null;
  var table = document.createElement('table');
  table.id = 'calender-table';
  var thead = document.createElement('thead');
  table.appendChild(thead);
  var headerContent = ['Allergene', 'Dez', 'JAN', 'FEB', 'MAR', 'APR', 'MAI', 'JUN', 'JUL', 'AUG', 'SEP', 'OKT', 'NOV'];
  var allergies = ['Hasel', 'Erle', 'Pappel', 'Weide', 'Esche', 'Hainbuche', 'Birke', 'Buche', 'Eiche', 'Kiefer', 'Gräser', 'Spitzwegerich'];
  for (var row = 0; row <= 11; row++) {
    rowEl = table.insertRow();
    for (var col = 0; col <= 36; col++) {
      rowEl.insertCell();
    }
  }
  for (var tRow = 0; tRow < table.rows.length; tRow++) {
    var firstCol = table.rows[tRow].cells[0];
    firstCol.innerHTML = allergies[tRow];
    firstCol.style.padding = '.1rem';
  }
  for (var tCol = 0; tCol < 13; tCol++) {
    var th = document.createElement("th");
    thead.appendChild(th).appendChild(document.createTextNode(headerContent[tCol]));
    if (tCol > 0) {
      th.colSpan = '3';
      th.style.textAlign = 'center';
    }
  }
  table.style.width = '100%';
  table.className= 'table table-sm table-striped';
  createPolenCalender.appendChild(table);
  iteratePolenCalenderMenths(table);
}

function iteratePolenCalenderMenths(table) {
  var hasel, erle;
  hasel = ['_', '0', '0', '0', '0', '0', '0', '1', '2', '2', '2', '1', '1', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  erle = ['_', '0', '0', '0', '0', '0', '1', '1', '2', '2', '2', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  pappel = ['_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '1', '2', '2', '2', '1', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  weide = ['_', '_', '_', '_', '_', '0', '0', '0', '0', '0', '1', '2', '2', '2', '1', '1', '0', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  esche = ['_', '_', '_', '_', '_', '0', '0', '0', '0', '0', '0', '1', '2', '2', '1', '1', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  hainbuche = ['_', '_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '1', '1', '2', '1', '1', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  birke = ['_', '_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '1', '1', '2', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  buche = ['_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '0', '0', '1', '2', '1', '1', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  eiche = ['_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '0', '0', '0', '0', '1', '2', '1', '1', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_'];
  kiefer = ['_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '0', '1', '2', '2', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '_', '_', '_', '_', '_', '_', '_', '_'];
  graeser = ['_', '_', '_', '_', '_', '_', '_', '_', '_', '0', '0', '0', '0', '0', '1', '1', '1', '2', '2', '2', '2', '2', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '_', '_'];
  spitzwegerich = ['_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '0', '0', '0', '1', '1', '2', '2', '2', '2', '2', '2', '2', '1', '1', '1', '0', '0', '0', '0', '0', '_', '_', '_'];
  var polenMonths = [hasel, erle, pappel, weide, esche, hainbuche, birke, buche, eiche, kiefer, graeser, spitzwegerich];
  for (var type = 0; type < polenMonths.length; type++) {
    insertIntoPolenCalender(table, polenMonths[type], type);
  }
}

function insertIntoPolenCalender(table, polen, index) {
  var low = '#99ff00', middle = '#ff9900', high = '#ef0b0b';
  for (var i = index; i < index+1; i++) {
    for (var j = 0; j <= 36; j++) {
      var x = polen[j];
      if (x === '0') { table.rows[i].cells[j].style.backgroundColor = low; }
      else if (x === '1') { table.rows[i].cells[j].style.backgroundColor = middle; }
      else if (x === '2') { table.rows[i].cells[j].style.backgroundColor = high; }
    }
  }
}

/**
<div class="row">
<div class="col-md-12">
<p>ACHTUNG — Content geklaut, aber von der Idee her für den Besucher sicherlich nützlich. Vielleicht umschreiben und/oder eigene Tipps reinstellen?</p>
<p><strong>Sechs Tipps, um die Pollenbelastung zu verringern</strong></p>
<ul>
  <li>Informieren Sie sich täglich über die aktuelle Pollenbelastung.</li>
  <li>Die Pollenbelastung schwankt je nach Uhrzeit und Umgebung. In der Stadt ist die Belastung abends am stärksten, auf dem Land morgens zwischen 5 und 8 Uhr. Die beste Zeit zum Lüften ist daher in der Stadt morgens, auf dem Land in der Zeit bis Mitternacht.</li>
  <li>Warmes und trockenes Wetter begünstigt den Pollenflug. Regen drückt dagegen die fliegenden Pollen nach unten. Nach Regengüssen können Sie daher freier atmen. Bleiben Sie während der Blüh- und Flugzeit der Pollen nicht zu lange im Freien.</li>
  <li>Wenn Sie einen Garten haben: Sorgen Sie dafür, dass der Rasen kurz gehalten wird. Aber mähen Sie den Rasen nach Möglichkeit nicht selbst!</li>
  <li>Lassen Sie die Pollen draußen: Möglichst vor dem Schlafengehen die Pollen aus Ihren Haaren spülen. Legen Sie am Besten Ihre getragene Kleidung außerhalb des Schlafzimmers ab. Staubsaugen, um Pollen aus Teppich und Möbeln zu entfernen.</li>
  <li>Reisen Sie den Pollen davon: In Hochgebirgsregionen und an Küsten ist die Luft frischer und es gibt kaum Pollen.</li>
</ul>
</div>
<div class="col-md-12">
<div id="polen-calender"></div>
</div>
</div>
*/
