$(function () {
  "use strict";

  var STORAGE_KEY = "activeMenu";
  var SCROLL_PADDING = 80; // adjust how much space above item

  // Save clicked menu before reload
  $("#sidebarnav a").on("click", function () {
    var href = $(this).attr("href");
    if (href && href !== "#" && href.indexOf("javascript:") !== 0) {
      localStorage.setItem(STORAGE_KEY, href);
    }
  });

  // After page load, restore active menu
  var savedHref = localStorage.getItem(STORAGE_KEY);
  if (savedHref) {
    var element = $("#sidebarnav a[href='" + savedHref + "']").first();

    if (element.length) {
      // Remove old states
      $("#sidebarnav a").removeClass("active");
      $("#sidebarnav li").removeClass("selected active");
      $("#sidebarnav ul").removeClass("in");

      // Mark active + open parents
      element.addClass("active");
      element.parents("li").addClass("selected");
      element.parents("ul").addClass("in");

      // Scroll into view
      var container = $(".scroll-sidebar");
      if (container.length) {
        var offset = element.offset().top - container.offset().top + container.scrollTop() - SCROLL_PADDING;
        container.scrollTop(offset);
      }
    }
  }
});
