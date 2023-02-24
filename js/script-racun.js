// Dohvatite tablicu
var table = document.getElementById("racuni");

// Dodavanje događaja na tablicu
table.addEventListener("dblclick", function (event) {
  // Provjera da li je klik bio na ćeliju, a ne zaglavlje
  if (event.target.tagName === "TD") {
    // Dohvatite redak koji je kliknut
    var row = event.target.parentNode;

    // Dohvatite podatke iz retka
    var racunId = row.cells[0].textContent;

    // Provjerite da li su detalji već prikazani
    if (
      row.nextElementSibling &&
      row.nextElementSibling.classList.contains("detalji")
    ) {
      // Detalji su već prikazani, sakrij ih
      row.nextElementSibling.remove();
    } else {
      // Detalji još nisu prikazani, kreirajte elemente i prikažite ih
      var detailsRow = document.createElement("tr");
      detailsRow.classList.add("detalji");

      var detailsCell = document.createElement("td");
      detailsCell.setAttribute("colspan", "8");

      var html = "";
      html += "<strong>Račun ID:</strong> " + racunId + "<br>";
      html +=
        "&nbsp;<strong>Datum računa:</strong> " +
        row.cells[1].textContent +
        "<br>";
      html +=
        "&nbsp;<strong>Broj računa:</strong> " +
        row.cells[2].textContent +
        "<br>";
      html +=
        "&nbsp;<strong>Radnik:</strong> " + row.cells[3].textContent + "<br>";
      html += "&nbsp;<strong>Naziv artikla:</strong><br>";
      html +=
        "&nbsp;&nbsp;&nbsp;&nbsp;" +
        row.cells[4].innerHTML.replace(
          /<br>/g,
          "<br>&nbsp;&nbsp;&nbsp;&nbsp;"
        ) +
        "<br>";
      html += "&nbsp;<strong>Količina:</strong><br>";
      html +=
        "&nbsp;&nbsp;&nbsp;&nbsp;" +
        row.cells[5].innerHTML.replace(
          /<br>/g,
          "<br>&nbsp;&nbsp;&nbsp;&nbsp;"
        ) +
        "<br>";
      html += "&nbsp;<strong>Cijena:</strong><br>";
      html +=
        "&nbsp;&nbsp;&nbsp;&nbsp;" +
        row.cells[6].innerHTML
          .replace(/<br>/g, "<br>&nbsp;&nbsp;&nbsp;&nbsp;")
          .replace(/(\d+\.\d{2})/, "$1&nbsp;") +
        "<br>";
      html +=
        "&nbsp;<strong>Ukupna cijena:</strong> " +
        row.cells[7].textContent.replace(/(\d+\.\d{2})/, "$1&nbsp;") +
        "<br>";

      detailsCell.innerHTML = html;
      detailsRow.appendChild(detailsCell);

      row.parentNode.insertBefore(detailsRow, row.nextSibling);
    }
  }
});

// Dodavanje event l. na tablicu za praćenje kada miš prelazi preko nje
table.addEventListener("mouseover", function (event) {
  // Dohvatite cilj
  var target = event.target;

  // Postavite CSS kursor ovisno o tagu ciljnog elementa
  target.style.cursor =
    target.tagName.toLowerCase() === "th" ? "default" : "pointer";
});

// Dodavanje event listenera na tablicu za praćenje kada miš napusti tablicu
table.addEventListener("mouseout", function (event) {
  // Dohvatite ciljni element
  var target = event.target;

  // Uklonite CSS kursor ako ciljni element nije zaglavlje
  if (target.tagName.toLowerCase() !== "th") {
    target.style.cursor = "";
  }
});
