/**
 * PESCMS Ticket Appointment Calendar
 * A reusable appointment calendar and time slot picker plugin
 */

(function ($) {
  "use strict";

  // Plugin definition
  $.fn.appointmentCalendar = function (options) {
    // Default options
    var settings = $.extend(
      {
        maxBookingTime: 14, // Maximum days ahead that can be booked
        workMode: 0, // 0: Workdays only, 1: Weekends only, 2: All days
        holidays: [], // Array of unix timestamps for holidays/closed days
        appointmentType: "full_day", // 'full_day' or 'time_slot'
        capacity: {}, // Object with hour keys and capacity values
        onDateSelect: function () {}, // Callback when a date is selected
        onTimeSelect: function () {}, // Callback when a time slot is selected
      },
      options
    );

    // Ensure holidays is an array
    if (!Array.isArray(settings.holidays)) {
      settings.holidays = [];
    }

    // Ensure capacity is an object
    if (typeof settings.capacity !== "object") {
      settings.capacity = {};
    }

    // Default capacity if empty (9am-5pm, 10 slots each)
    if (
      Object.keys(settings.capacity).length === 0 &&
      settings.appointmentType === "time_slot"
    ) {
      for (var h = 9; h < 17; h++) {
        settings.capacity[h] = 10;
      }
    }

    // Main plugin initialization
    return this.each(function () {
      var $container = $(this);
      var $dateInput = $(
        settings.dateInputSelector || ".appointment-date-input"
      );
      var $timeInput = $(settings.timeInputSelector || "#appointment_time");
      var $timeSlotsContainer = $(
        settings.timeSlotsContainerSelector || "#time-slots-container"
      );
      var $timeSlotsElement = $(settings.timeSlotsSelector || "#time-slots");

      // Initialize form validation
      initFormValidation();

      // Initialize calendar
      renderCalendar();

      // Initialize form validation
      function initFormValidation() {
        $(".ajax-submit").on("submit", function (e) {
          if ($dateInput.length > 0) {
            var appointmentDate = $dateInput.val();
            var appointmentTime = $timeInput.val();

            if (!appointmentDate) {
              alert("请选择预约日期");
              e.preventDefault();
              return false;
            }

            if (settings.appointmentType === "time_slot" && !appointmentTime) {
              alert("请选择预约时间段");
              e.preventDefault();
              return false;
            }
          }
        });
      }

      // Render calendar function
      function renderCalendar() {
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        // Calculate current month's first and last day
        var currentYear = today.getFullYear();
        var currentMonth = today.getMonth();
        var firstDay = new Date(currentYear, currentMonth, 1);

        // Calculate max booking date
        var maxDate = new Date();
        maxDate.setDate(today.getDate() + settings.maxBookingTime);

        // Create calendar title
        var calendarTitle =
          '<div class="calendar-header">' +
          '<button type="button" class="prev-month am-btn am-btn-default am-btn-xs">&lt;</button>' +
          '<span class="current-month">' +
          (currentMonth + 1) +
          "月 " +
          currentYear +
          "</span>" +
          '<button type="button" class="next-month am-btn am-btn-default am-btn-xs">&gt;</button>' +
          "</div>";

        // Create week header
        var weekDays = ["日", "一", "二", "三", "四", "五", "六"];
        var weekHeader = '<div class="week-header">';
        for (var i = 0; i < 7; i++) {
          weekHeader += '<div class="week-day">' + weekDays[i] + "</div>";
        }
        weekHeader += "</div>";

        // Calculate calendar's first row start date (may be from previous month)
        var firstDayOfWeek = firstDay.getDay(); // Get day of week for first day of month
        var startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDayOfWeek);

        // Create calendar days
        var calendarDays = '<div class="calendar-days">';

        // Calculate dates to display (usually 6 rows × 7 columns = 42 days)
        for (var i = 0; i < 42; i++) {
          var currentDate = new Date(startDate);
          currentDate.setDate(startDate.getDate() + i);

          var isCurrentMonth = currentDate.getMonth() === currentMonth;
          var isToday = currentDate.toDateString() === today.toDateString();
          var isSelectable = isDateSelectable(currentDate, today, maxDate);

          var dateClass = "calendar-day";
          if (!isCurrentMonth) dateClass += " other-month";
          if (isToday) dateClass += " today";
          if (!isSelectable) dateClass += " disabled";

          var dateFormatted = formatDate(currentDate);
          var dateText = currentDate.getDate();

          calendarDays +=
            '<div class="' +
            dateClass +
            '" data-date="' +
            dateFormatted +
            '">' +
            dateText +
            "</div>";
        }

        calendarDays += "</div>";

        // Combine calendar HTML
        var calendarHtml =
          '<div class="custom-calendar">' +
          calendarTitle +
          weekHeader +
          calendarDays +
          "</div>";

        // Render to container
        $container.html(calendarHtml);

        // Add month navigation events
        $container.find(".prev-month").on("click", function () {
          changeMonth(-1);
        });

        $container.find(".next-month").on("click", function () {
          changeMonth(1);
        });

        // Add date click events
        $container.find(".calendar-day").on("click", function () {
          if ($(this).hasClass("disabled")) return;

          // Remove other selected states
          $container.find(".calendar-day").removeClass("selected");

          // Add selected state
          $(this).addClass("selected");

          // Get selected date
          var selectedDate = $(this).data("date");

          // Set hidden input value
          $dateInput.val(selectedDate);

          // Clear previous time slot selection
          $timeInput.val("");

          // If time slot appointment, show time slots
          if (settings.appointmentType === "time_slot") {
            renderTimeSlots(new Date(selectedDate));
          } else {
            // If full day appointment, set as full day
            $timeInput.val("full_day");
            $timeSlotsContainer.addClass("am-hide");
          }

          // Call onDateSelect callback
          settings.onDateSelect.call(this, selectedDate);
        });
      }

      // Change month function
      function changeMonth(offset) {
        var date = $container.find(".current-month").text().trim();
        var parts = date.split(" ");
        var month = parseInt(parts[0]) - 1; // Convert month to 0-11
        var year = parseInt(parts[1]);

        // Calculate new month and year
        month += offset;
        if (month < 0) {
          month = 11;
          year--;
        } else if (month > 11) {
          month = 0;
          year++;
        }

        // Update calendar title
        $container.find(".current-month").text(month + 1 + "月 " + year);

        // Recalculate and display dates for the month
        var firstDay = new Date(year, month, 1);
        var firstDayOfWeek = firstDay.getDay();
        var startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDayOfWeek);

        var today = new Date();
        today.setHours(0, 0, 0, 0);

        // Calculate max booking date
        var maxDate = new Date();
        maxDate.setDate(today.getDate() + settings.maxBookingTime);

        // Update all date cells
        var dayElements = $container.find(".calendar-day");
        for (var i = 0; i < dayElements.length; i++) {
          var currentDate = new Date(startDate);
          currentDate.setDate(startDate.getDate() + i);

          var isCurrentMonth = currentDate.getMonth() === month;
          var isToday = currentDate.toDateString() === today.toDateString();
          var isSelectable = isDateSelectable(currentDate, today, maxDate);

          var $dayEl = $(dayElements[i]);
          $dayEl.removeClass("other-month today disabled selected");

          if (!isCurrentMonth) $dayEl.addClass("other-month");
          if (isToday) $dayEl.addClass("today");
          if (!isSelectable) $dayEl.addClass("disabled");

          $dayEl.data("date", formatDate(currentDate));
          $dayEl.text(currentDate.getDate());
        }
      }

      // Check if date is selectable
      function isDateSelectable(date, today, maxDate) {
        // Dates before today are not selectable
        if (date.valueOf() < today.valueOf()) {
          return false;
        }

        // Dates beyond max booking days are not selectable
        if (date.valueOf() > maxDate.valueOf()) {
          return false;
        }

        // Check if date is in holidays/closed days list
        var dateTimestamp = Math.floor(date.valueOf() / 1000);
        if (
          Array.isArray(settings.holidays) &&
          settings.holidays.indexOf(dateTimestamp) !== -1
        ) {
          return false;
        }

        try {
          // Filter based on work mode setting
          var day = date.getDay();
          if (settings.workMode === 0 && (day === 0 || day === 6)) {
            // Workdays only, disable weekends
            return false;
          } else if (settings.workMode === 1 && day !== 0 && day !== 6) {
            // Weekends only, disable workdays
            return false;
          }
        } catch (e) {
          console.error("Date filtering error:", e);
        }

        return true;
      }

      // Render time slots function
      function renderTimeSlots(selectedDate) {
        // Ensure selectedDate is a valid Date object
        if (!(selectedDate instanceof Date) || isNaN(selectedDate.getTime())) {
          selectedDate = new Date();
        }

        var slotsContainer = $timeSlotsElement;
        slotsContainer.empty();

        var selectedDateStr = formatDate(selectedDate);

        // Show time slots container
        $timeSlotsContainer.removeClass("am-hide");

        // Get day of week
        var weekDays = ["日", "一", "二", "三", "四", "五", "六"];
        var dayOfWeek = weekDays[selectedDate.getDay()];

        // Add date title
        var dateTitle = $('<div class="date-title"></div>').text(
          selectedDateStr + "（周" + dayOfWeek + "）预约时间段"
        );
        slotsContainer.append(dateTitle);

        // If no capacity defined, add default timeslots
        if (Object.keys(settings.capacity).length === 0) {
          for (var h = 9; h < 17; h++) {
            settings.capacity[h] = 10; // Default 10 slots per hour
          }
        }

        // Add time slots
        for (var time in settings.capacity) {
          if (settings.capacity.hasOwnProperty(time)) {
            var hour = parseInt(time);
            var capacityValue = parseInt(settings.capacity[time]);

            var timeSlot = $(
              '<div class="slot" data-time="' + hour + '"></div>'
            );
            if (capacityValue <= 0) {
              timeSlot.addClass("full");
            }

            var slotTime = $('<div class="slot-time"></div>').text(
              padZero(hour) + ":00 - " + padZero(hour + 1) + ":00"
            );

            var slotPeople = $('<div class="slot-people"></div>').text(
              capacityValue <= 0 ? "已满" : "剩余 " + capacityValue + " 个"
            );

            timeSlot.append(slotTime);
            timeSlot.append(slotPeople);
            slotsContainer.append(timeSlot);

            // Add time slot click event
            if (capacityValue > 0) {
              (function (hourValue) {
                timeSlot.on("click", function () {
                  // Remove other selected states
                  $(".slot").removeClass("selected");
                  // Add selected state
                  $(this).addClass("selected");
                  // Set selected time
                  $timeInput.val(hourValue);
                  // Call onTimeSelect callback
                  settings.onTimeSelect.call(this, hourValue);
                });
              })(hour);
            }
          }
        }
      }

      // Format date as yyyy-MM-dd
      function formatDate(date) {
        var year = date.getFullYear();
        var month = padZero(date.getMonth() + 1);
        var day = padZero(date.getDate());
        return year + "-" + month + "-" + day;
      }

      // Zero padding function
      function padZero(num) {
        return (num < 10 ? "0" : "") + num;
      }
    });
  };
})(jQuery);
