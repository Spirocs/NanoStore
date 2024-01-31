var code = "";

$(document).ready(function () {
  const wrapper = document.getElementById('weight');

  wrapper.addEventListener('click', async (event) => {
    if (event.target.nodeName != 'BUTTON') {
      return;
    }

    var elms = document.querySelectorAll("#category" + event.target.id);
    var others = document.getElementsByClassName("product-btn");

    for (var i = 0; i < others.length; i++) {
      others[i].style.display = "none";
    }

    for (var i = 0; i < elms.length; i++) {
      elms[i].style.display = 'unset';
    }

    $('#productModal').modal('show');
  });

  document.body.addEventListener("keydown", async function (evt) {
    if (evt.keyCode == 13) {
      console.log(code);
      jQuery.ajax({
        type: "POST",
        url: "scan/product.php",
        dataType: "json",
        data: { functionname: "check_code", argument: code },

        success: async function (obj, textstatus) {
          if (obj.exist == true) {
            var product_name = obj.name;
            var pPrice = obj.price;
            var pId = obj.id;

            if (findValueInRow(pId) == true) {
              var product_price = document.getElementById(
                product_name + "-price"
              ).innerHTML;
              var price = (Number(product_price) * 2).toFixed(2);

              document.getElementById(pId + '-quantity').stepUp();
              var quantity = Number($('#' + pId + '-quantity').val());

              if (quantity == 2) {
                document.getElementById(product_name + "-price").innerText = price;
              } else {
                price = ((product_price / (quantity-1)) * quantity).toFixed(2);
                document.getElementById(product_name + "-price").innerText = price;
              }
            } else {
              $("#table")
                .find("tbody")
                .append(
                  '<tr id="'+ pId + '"><td><img src="' + obj.img + '" width="30px" height="30px" style="margin-left: 20px"><a style="font-weight: bold;"> ' + product_name + '</a</td><td id="' + product_name + '-price">' + Number(pPrice).toFixed(2) + '</td><td width="200px" style="border-left-style: hidden; text-align: center;"><button class="stepDown" id="' + pId + '-stepDown">-</button><input class="amount" id="' + pId + '-quantity" type="number" min="1" max="999" value=1 disabled="true"><button class="stepUp" id="' + pId + '-stepUp"">+</button></td></tr>'
                );

                $("#" + pId + "-stepDown").on('click', function(){
                  if ($('#' + pId + '-quantity').val() == 1) {
                    var index = $(this).closest('tr').index();
                    $("tr").eq(index+1).remove();
                    document.getElementById("eur").innerText = getSum();
                    exportOrder();
                    return;
                  }

                  document.getElementById(pId + '-quantity').stepDown();

                  var value = $('#' + pId + '-quantity').val();

                  var product_price = document.getElementById(product_name + "-price").innerHTML;
                  onePrice = (Number(product_price) / (Number(value)+1)).toFixed(2);
                  document.getElementById(product_name + "-price").innerText = Number(onePrice*value).toFixed(2);
                
                  document.getElementById("eur").innerText = getSum();
                  exportOrder();
                });

                $("#" + pId + "-stepUp").on('click', function(){
                  if ($('#' + pId + '-quantity').val() == 999) {
                    return;
                  }

                  document.getElementById(pId + '-quantity').stepUp();

                  var value = $('#' + pId + '-quantity').val();
                  
                  var product_price = document.getElementById(product_name + "-price").innerHTML;
                  onePrice = (Number(product_price) / (Number(value)-1)).toFixed(2);
                  document.getElementById(product_name + "-price").innerText = Number(onePrice*value).toFixed(2);
                
                  document.getElementById("eur").innerText = getSum();
                  exportOrder();
                });
            }

            document.getElementById("eur").innerText = getSum();
            exportOrder();
          } else {
            console.log(obj.exist);
          }
        },
      });
      code = "";
    } else {
      code += evt.key;
    }
  });
});

var price = null;
var gramm = null;
var command = "";
var ws = null;

async function show(clickedId) {
  $('#productModal').modal('hide');
  $('#weightModalLabel').text(document.getElementById(clickedId).children[2].textContent);
  document.getElementById("pImage").src = document.getElementById(clickedId).children[0].src;
  $('#weightModal').modal('show');
  ws = new WebSocket("ws://localhost:8765/");

  ws.onopen = function(){
      console.log("Connection is Established");
      command = "weight";
      ws.send(command);
  };

  ws.onmessage = function(evt) {
      gramm = evt.data;
      console.log(gramm);
      $('#gramm').text(gramm);
      price = (Number(gramm.replace('.', '').replace('kg', '')) * Number(document.getElementById(clickedId).children[4].textContent.replace("€", ""))).toFixed(2);
      $('#price').text(price + '€');
      ws.send(command);
  };

}

async function closeWeightModal() {
  $('#weightModal').modal('hide');
  ws.send("stop");
  ws.close();
}

async function populate() {
  $('#weightModal').modal('hide');
  ws.send("stop");
  ws.close();

  jQuery.ajax({
    type: "POST",
    url: "scan/product.php",
    dataType: "json",
    data: { functionname: "check_name", argument: String(document.getElementById('weightModalLabel').innerText) },

    success: async function (obj, textstatus) {
      if (obj.exist == true) {
        var product_name = obj.name;
        var pId = obj.id;

        $("#table")
          .find("tbody")
          .append(
            '<tr id="' + pId + '"><td><img src="' + document.getElementById('pImage').src + '" width="30px" height="30px" style="margin-left: 20px"><a style="font-weight: bold;"> ' + product_name + '</a><a> (' + gramm + ')</a></td><td id="' + product_name + '-price">' + price + '</td><td width="200px" style="border-left-style: hidden; text-align: center;"><button class="stepDown" id="' + pId + '-stepDown">-</button><input class="amount" type="number" min="1" max="999" value=1 disabled="true"><button class="stepDown" style="visibility: hidden;">-</button></td></tr>'
          );

          $("#" + pId + "-stepDown").on('click', function(){
            var index = $(this).closest('tr').index();
            $("tr").eq(index+1).remove();

            document.getElementById("eur").innerText = getSum();
            exportOrder();
          });

        document.getElementById("eur").innerText = getSum();
        exportOrder();
      } else {
        console.log(obj.exist);
      }
    },
  });
}

function findValueInRow(value) {
  var myEle = document.getElementById(value);

  if (myEle) {
    return true;
  }

  return false;
}

function getSum() {
  var rows = document.getElementsByTagName("tbody")[0].rows;
  var sum = Number();
  for (let i = 0; i < rows.length; i++) {
    cell = rows[i].cells[1];
    if (cell != null) {
      sum += Number(cell.innerHTML);
    }
  }

  return Number(sum).toFixed(2);
}

function exportOrder() {
  var rows = document.getElementsByTagName("tbody")[0].rows;
  var test = Array();

  for (let i = 0; i < rows.length; i++) {
    var arr = Array();
    var name = rows[i].cells[0].innerText;
    var price = rows[i].cells[1].innerText;
    var amount = rows[i].cells[2].innerText.replace('-', rows[i].cells[2].getElementsByClassName("amount")[0].value).replace('+', '');
    
    arr.push(name, price, amount);

    test.push(arr);
  }

  console.log(test);

  jQuery.ajax({
    type: "POST",
    url: "scan/product.php",
    dataType: "json",
    data: { functionname: "safe_order", argument: test },

    success: async function (obj, textstatus) {

    },
  });
}

function pay() {
  var all = getSum();

  if (getSum() < 0.50) {
    return;
  }

  var rows = document.getElementsByTagName("tbody")[0].rows;
  const regex = /([0-9]\.[0-9]+)/;
  const idMap = new Map();

  for (let i = 0; i < rows.length; i++) {
    var row = rows[i];
    if (row.getAttribute('id') != null) {
      var productId = row.getAttribute('id');

      if (row.cells[0].textContent.endsWith("kg)")) {
        var match = row.cells[0].textContent.match(regex)[0];

        var fullPrice = Number(row.cells[1].textContent.replace(".", ""));
        var kg = fullPrice/Number(String(match).replace(".", ""));

        var quantity = Number(fullPrice)/Number(kg);
        console.log(quantity);

        if (idMap.has(productId)) {
          var mapAmount = idMap.get(productId) + quantity;
          idMap.set(productId, mapAmount);
        } else {
          idMap.set(productId, quantity);
        }
      } else {
        idMap.set(productId, Number(row.cells[2].children[1].value));
      }
    }
  }

  var argument = JSON.stringify(Object.fromEntries(idMap));
  console.log(argument);

  jQuery.ajax({
    type: "POST",
    url: "scan/product.php",
    dataType: "json",
    data: { functionname: "safe", argument: argument },

    success: async function (obj, textstatus) {
      console.log(obj.safed);
    },
  });

  var sum = 0;

  if (all < 10) {
    sum = "0" + all;
  } else {
    sum = all;
  }

  window.location.href = "http://localhost:4242/checkout/checkout.php?value=" + sum;
}

function end() {
  window.location.href = "http://localhost:4242/welcome/welcome.php";

  jQuery.ajax({
    type: "POST",
    url: "scan/product.php",
    dataType: "json",
    data: { functionname: "delete", argument: "" },

    success: async function (obj, textstatus) {
      console.log(obj.deleted);
    },
  });
}
