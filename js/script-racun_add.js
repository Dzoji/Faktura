document.getElementById("dodaj_stavku").addEventListener("click", function () {
  const tabela = document
    .getElementById("stavke")
    .getElementsByTagName("tbody")[0];
  const noviRed = tabela.insertRow();
  noviRed.classList.add("dodano");
  const artikal = noviRed.insertCell();
  const kolicina = noviRed.insertCell();
  const cijena = noviRed.insertCell();

  const selectArtikal = document.createElement("select");
  selectArtikal.name = "artikal_id[]";
  selectArtikal.classList.add("artikal_id");
  const opcijaDefault = document.createElement("option");
  // opcijaDefault.value = "";
  // opcijaDefault.textContent = "Odaberi artikal";
  // selectArtikal.appendChild(opcijaDefault);

  // Slanje AJAX zahtjeva za dohvaćanje artikala
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "dohvati_artikle_za_racun.php", true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      const artikli = JSON.parse(xhr.responseText);
      artikli.forEach(function (artikal) {
        const opcija = document.createElement("option");
        opcija.value = artikal.ArtikalId;
        opcija.textContent = artikal.Naziv;
        selectArtikal.appendChild(opcija);
      });
    } else {
      console.error("Greška prilikom dohvaćanja artikala");
    }
  };
  xhr.send();

  artikal.appendChild(selectArtikal);

  const inputKolicina = document.createElement("input");
  inputKolicina.type = "number";
  inputKolicina.name = "kolicina[]";
  inputKolicina.classList.add("kolicina");
  inputKolicina.required = true;
  inputKolicina.min = 0;
  inputKolicina.step = 0.1;
  inputKolicina.value = "";
  // inputKolicina.placeholder = "Količina";
  kolicina.appendChild(inputKolicina);

  const inputCijena = document.createElement("input");
  inputCijena.type = "number";
  inputCijena.name = "cijena[]";
  inputCijena.classList.add("cijena");
  inputCijena.required = true;
  inputCijena.min = 0;
  inputCijena.step = 0.1;
  inputCijena.value = "";
  // inputCijena.placeholder = "Cijena";
  cijena.appendChild(inputCijena);
});

function ocistiFormu() {
  // Selektiraj sve input i select elemente unutar forme i postavi im vrijednost na prazan string
  const formElementi = document.querySelectorAll("#forma input, #forma select");
  formElementi.forEach((element) => {
    element.value = "";
  });

  // Sakrij redove sa stavkama
  const redoviStavki = document.querySelectorAll("#stavke tbody tr");
  redoviStavki.forEach((red) => {
    red.style.display = "none";
  });
}

// ponisti dugme
const ponistiButton = document.getElementById("ponisti");

ponistiButton.addEventListener("click", function () {
  ocistiFormu();
});
