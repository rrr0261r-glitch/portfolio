/* =========================================================
   RINNE — behaviour
   Cart · drawer · pagination · image fallback
   No localStorage (works inside sandboxed previews too).
========================================================= */
(function () {
  "use strict";

  var cart = {}; // name -> { name, price, qty, tint }
  var $ = function (s) { return document.querySelector(s); };

  var drawer   = $("#cart");
  var scrim    = $("#cartScrim");
  var body     = $("#cartBody");
  var countEl  = $("#cartCount");
  var totalEl  = $("#cartTotal");
  var checkout = $("#cartCheckout");
  var toast    = $("#toast");

  /* ---------- toast ---------- */
  var toastTimer;
  function showToast(msg) {
    toast.textContent = msg;
    toast.classList.add("show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { toast.classList.remove("show"); }, 1700);
  }

  /* ---------- drawer open / close ---------- */
  function openCart()  { drawer.classList.add("open"); scrim.classList.add("open"); drawer.setAttribute("aria-hidden", "false"); }
  function closeCart() { drawer.classList.remove("open"); scrim.classList.remove("open"); drawer.setAttribute("aria-hidden", "true"); }

  $("#cartOpen").addEventListener("click", openCart);
  $("#cartOpen").addEventListener("keydown", function (e) { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); openCart(); } });
  $("#cartClose").addEventListener("click", closeCart);
  scrim.addEventListener("click", closeCart);
  document.addEventListener("keydown", function (e) { if (e.key === "Escape") closeCart(); });

  /* ---------- render ---------- */
  function money(n) { return "$" + n; }

  function render() {
    var rows = Object.keys(cart).map(function (k) { return cart[k]; });
    var qty = rows.reduce(function (s, i) { return s + i.qty; }, 0);
    var sum = rows.reduce(function (s, i) { return s + i.qty * i.price; }, 0);

    countEl.textContent = qty;
    totalEl.textContent = money(sum);
    checkout.disabled = qty === 0;

    if (!rows.length) {
      body.innerHTML = '<p class="cart-drawer-empty">Your bag is waiting for summer.</p>';
      return;
    }

    body.innerHTML = rows.map(function (i) {
      return '' +
        '<div class="cart-line">' +
          '<div class="cart-line-thumb" style="--tint:' + i.tint + '"></div>' +
          '<div class="cart-line-info">' +
            '<span class="cart-line-name">' + i.name + '</span>' +
            '<span class="cart-line-price">' + money(i.price) + '</span>' +
            '<div class="cart-qty">' +
              '<button data-act="dec" data-n="' + i.name + '" aria-label="Decrease">\u2212</button>' +
              '<span>' + i.qty + '</span>' +
              '<button data-act="inc" data-n="' + i.name + '" aria-label="Increase">+</button>' +
            '</div>' +
          '</div>' +
          '<button class="cart-line-remove" data-act="rm" data-n="' + i.name + '">Remove</button>' +
        '</div>';
    }).join("");
  }

  body.addEventListener("click", function (e) {
    var btn = e.target.closest("[data-act]");
    if (!btn) return;
    var name = btn.getAttribute("data-n");
    var act = btn.getAttribute("data-act");
    if (!cart[name]) return;
    if (act === "inc") cart[name].qty++;
    if (act === "dec" && --cart[name].qty <= 0) delete cart[name];
    if (act === "rm") delete cart[name];
    render();
  });

  /* ---------- add to bag ---------- */
  document.querySelectorAll(".item").forEach(function (item) {
    var name  = item.getAttribute("data-name");
    var price = parseInt(item.getAttribute("data-price"), 10);
    var tint  = item.querySelector(".item-img").style.getPropertyValue("--tint").trim() || "#F0EDE8";
    var btn   = item.querySelector(".add-bag");

    function openProduct() {
      window.location.href = "assets/product.html?item=" + encodeURIComponent(name);
    }

    item.addEventListener("click", openProduct);
    item.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        openProduct();
      }
    });

    if (!btn) return;
    btn.addEventListener("click", function (e) {
      e.stopPropagation();
      if (cart[name]) cart[name].qty++;
      else cart[name] = { name: name, price: price, qty: 1, tint: tint };
      render();
      showToast(name + " added");
      btn.classList.add("added");
      btn.textContent = "Added \u2713";
      setTimeout(function () { btn.classList.remove("added"); btn.textContent = "Add to bag"; }, 1100);
    });
  });

  checkout.addEventListener("click", function () { window.location.href = "assets/checkout.html"; });

  /* ---------- image fallback ---------- */
  document.querySelectorAll(".item-img img").forEach(function (img) {
    img.addEventListener("error", function () { img.parentElement.classList.add("broken"); });
  });

  /* ---------- dot pagination (3 dots = 3 pages of 2) ---------- */
  var PAGE = 2;
  var grid  = $("#grid");
  var items = Array.prototype.slice.call(grid.querySelectorAll(".item"));
  var dots  = Array.prototype.slice.call(document.querySelectorAll(".dot"));

  function showPage(p) {
    grid.style.opacity = "0";
    setTimeout(function () {
      items.forEach(function (it, i) {
        it.hidden = !(i >= p * PAGE && i < (p + 1) * PAGE);
      });
      dots.forEach(function (d, i) { d.classList.toggle("active", i === p); });
      grid.style.opacity = "1";
    }, 200);
  }

  dots.forEach(function (d, i) {
    d.setAttribute("role", "button");
    d.setAttribute("tabindex", "0");
    d.setAttribute("aria-label", "Page " + (i + 1));
    d.addEventListener("click", function () { showPage(i); });
    d.addEventListener("keydown", function (e) { if (e.key === "Enter" || e.key === " ") { e.preventDefault(); showPage(i); } });
  });

  showPage(0);
  render();
})();
