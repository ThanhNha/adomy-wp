"use strict";
$ = jQuery;

$(document).ready(function () {
  $("button.wishlist-button").click(false);
  $(document).on("click", function (e) {
    if ($(e.target).closest("#wide-nav").length === 0) {
      $(".menu-image-item .img-inner").removeClass("active");
      $(".main-menu-items").removeClass("open");
      $(".main-menu-active").show();
    }
  });
  checkBox();
  function checkBox() {
    const checked = $(".shop_table .icon-checked");
    if (checked.length > 0) {
      checked.each(function () {
        $(this).on("click", () => {
          $(this).toggleClass("checked");
        });
      });
    }
  }
  checkBoxConform();
  function checkBoxConform() {
    const checked = $(".conform .icon-checked");
    if (checked.length > 0) {
      checked.each(function () {
        $(this).on("click", () => {
          $(this).toggleClass("checked");
        });
      });
    }
  }

  activeMenu();
  function activeMenu() {
    const menuImages = $(".menu-image-item .img-inner");
    const menuItems = $(".main-menu-items");
    //list menu items
    const amazone = $(".amazone .menu-link");
    const sephora = $(".sephora .menu-link");
    const jomashop = $(".jomashop .menu-link");

    // console.log(sephora);
    if (menuImages.length > 0) {
      menuImages.each(function (index) {
        $(this).on("click", () => {
          activateFistMenu(this);
          menuItems.eq(index).find(".menu-item.menu-link").eq(0).addClass("active");
          $(".menu-image-item .img-inner.active").removeClass("active");
          $(this).addClass("active");
          $(".main-menu-active").hide();
          menuItems.removeClass("open");
          menuItems.eq(index).addClass("open");
        });
      });
    }
    if (amazone.length > 0) {
      amazone.each(function (index) {
        $(this).on("click", (e) => {
          e.preventDefault();
          amazone.removeClass("active");
          $(this).addClass("active");
          $(".menu-link-item").removeClass("active");
          $(".menu-link-item").eq(index).addClass("active");
        });
      });
    }
    if (sephora.length > 0) {
      sephora.each(function (index) {
        $(this).on("click", (e) => {
          e.preventDefault();
          sephora.removeClass("active");
          $(this).addClass("active");
          $(".sephora .menu-link-item").removeClass("active");
          $(".sephora .menu-link-item").eq(index).addClass("active");
        });
      });
    }
    if (jomashop.length > 0) {
      jomashop.each(function (index) {
        $(this).on("click", (e) => {
          e.preventDefault();
          jomashop.removeClass("active");
          $(this).addClass("active");
          $(".jomashop .menu-link-item").removeClass("active");
          $(".jomashop .menu-link-item").eq(index).addClass("active");
        });
      });
    }
  }
  function activateFistMenu(item) {
    // console.log(item);
    $(".menu-link-item").removeClass("active");
    $(".sephora .menu-link-item").eq(0).addClass("active");
    $(".amazone .menu-link-item").eq(0).addClass("active");
    $(".jomashop .menu-link-item").eq(0).addClass("active");
  }
  activeSize();
  function activeSize() {
    const itemsSize = $(".product-variations ul li");
    if (itemsSize.length > 0) {
      itemsSize.each(function (index) {
        $(this).on("click", () => {
          itemsSize.removeClass("active");
          $(this).addClass("active");
        });
      });
    }
  }
  checkboxCategory();
  function checkboxCategory() {
    const inputCheck = $("#categories-check input[type='checkbox']");
    const iconsCheck = inputCheck.prev();
    const labelCheck = inputCheck.next();
    iconsCheck.each(function (index) {
      $(this).on("click", () => {
        $(this).toggleClass("checked");
        if ($(this).hasClass("checked")) {
          inputCheck.eq(index).prop("checked", true);
        } else {
          inputCheck.eq(index).prop("checked", false);
        }
      });
    });
    labelCheck.each(function (index) {
      $(this).on("click", () => {
        iconsCheck.eq(index).toggleClass("checked");
        if ($(this).hasClass("checked")) {
          inputCheck.eq(index).prop("checked", true);
        } else {
          inputCheck.eq(index).prop("checked", false);
        }
      });
    });
  }
  rangePrice();
  function rangePrice() {
    let min = 10;
    let max = 100;

    const calcLeftPosition = (value) => (100 / (100 - 10)) * (value - 10);

    $("#rangeMin").on("input", function (e) {
      const newValue = parseInt(e.target.value);
      if (newValue > max) return;
      min = newValue;
      $("#thumbMin").css("left", calcLeftPosition(newValue) + "%");
      $("#min").html(newValue);
      $("#line").css({
        left: calcLeftPosition(newValue) + "%",
        right: 100 - calcLeftPosition(max) + "%",
      });
    });

    $("#rangeMax").on("input", function (e) {
      const newValue = parseInt(e.target.value);
      if (newValue < min) return;
      max = newValue;
      $("#thumbMax").css("left", calcLeftPosition(newValue) + "%");
      $("#max").html(newValue);
      $("#line").css({
        left: calcLeftPosition(min) + "%",
        right: 100 - calcLeftPosition(newValue) + "%",
      });
    });
  }
  fetch();

  // // Requires jQuery

  // // Initialize slider:
  // $(document).ready(function () {
  //   var rangeSlider = document.getElementById("slider-range");
  //   var moneyFormat = wNumb({
  //     decimals: 0,
  //     thousand: ",",
  //     prefix: "$",
  //   });
  //   noUiSlider.create(rangeSlider, {
  //     start: [500000, 1000000],
  //     step: 1,
  //     range: {
  //       min: [100000],
  //       max: [1000000],
  //     },
  //     format: moneyFormat,
  //     connect: true,
  //   });

  //   // Set visual min and max values and also update value hidden form inputs
  //   rangeSlider.noUiSlider.on("update", function (values, handle) {
  //     document.getElementById("slider-range-value1").innerHTML = values[0];
  //     document.getElementById("slider-range-value2").innerHTML = values[1];
  //     document.getElementsByName("min-value").value = moneyFormat.from(values[0]);
  //     document.getElementsByName("max-value").value = moneyFormat.from(values[1]);
  //   });
  // });

});