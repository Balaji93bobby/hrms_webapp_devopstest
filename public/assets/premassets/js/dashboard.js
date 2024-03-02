// upcoming birthday
var scrollDuration = 300;
var leftPaddle = document.getElementsByClassName('left-paddle');
var rightPaddle = document.getElementsByClassName('right-paddle');
var itemsLength = $('.item').length;
var itemSize = $('.item').outerWidth(true);
var paddleMargin = 20;

var picLength = $('#picture-scroll').attr('picLength');

var getMenuWrapperSize = function() {
	return $('.menu-wrapper').outerWidth();
}
var menuWrapperSize = getMenuWrapperSize();
$(window).on('resize', function() {
	menuWrapperSize = getMenuWrapperSize();
});
var menuVisibleSize = menuWrapperSize;

var getMenuSize = function() {
	return itemsLength * itemSize;
};
var menuSize = getMenuSize();
var menuInvisibleSize = menuSize - menuWrapperSize;

var getMenuPosition = function() {
	return $('.menu').scrollLeft();
};

$('.menu').on('scroll', function() {

	menuInvisibleSize = menuSize - menuWrapperSize;
	var menuPosition = getMenuPosition();
	var menuEndOffset = menuInvisibleSize - paddleMargin;
    if (picLength < 9) {
		$(leftPaddle).addClass('hidden');
		$(rightPaddle).addClass('hidden');
    } else {
        if (menuPosition <= paddleMargin) {
            $(leftPaddle).addClass('hidden');
            $(rightPaddle).removeClass('hidden');
        } else if (menuPosition < menuEndOffset) {
            $(leftPaddle).removeClass('hidden');
            $(rightPaddle).removeClass('hidden');
        } else if (menuPosition >= menuEndOffset) {
            $(leftPaddle).removeClass('hidden');
            $(rightPaddle).addClass('hidden');
        }
    }
	$('#print-wrapper-size span').text(menuWrapperSize);
	$('#print-menu-size span').text(menuSize);
	$('#print-menu-invisible-size span').text(menuInvisibleSize);
	$('#print-menu-position span').text(menuPosition);

}).trigger('scroll');

$(rightPaddle).on('click', function() {
	$('.menu').animate( { scrollLeft: menuInvisibleSize+50}, scrollDuration);
});

$(leftPaddle).on('click', function() {
	$('.menu').animate( { scrollLeft: '0' }, scrollDuration);
});


// new joiners
var scrollDurationJoiner = 300;
var leftPaddleJoiner = document.getElementsByClassName('left-paddle-joiner');
var rightPaddleJoiner = document.getElementsByClassName('right-paddle-joiner');
var itemsLengthJoiner = $('.item-joiner').length;
var itemSizeJoiner = $('.item-joiner').outerWidth(true);
var paddleMarginJoiner = 20;

var picLength = $('#picture-scroll-joiner').attr('picLength');

var getMenuWrapperSizeJoiner = function() {
	return $('.menu-wrapper-joiner').outerWidth();
}
var menuWrapperSizeJoiner = getMenuWrapperSizeJoiner();
$(window).on('resize', function() {
	menuWrapperSizeJoiner = getMenuWrapperSizeJoiner();
});
var menuVisibleSize = menuWrapperSizeJoiner;

var getMenuSizeJoiner = function() {
	return itemsLengthJoiner * itemSizeJoiner;
};
var menuSize = getMenuSizeJoiner();
var menuInvisibleSizeJoiner = menuSize - menuWrapperSizeJoiner;

var getMenuPosition = function() {
	return $('.menu-joiner').scrollLeft();
};

$('.menu-joiner').on('scroll', function() {

	menuInvisibleSizeJoiner = menuSize - menuWrapperSizeJoiner;
	var menuPosition = getMenuPosition();
	var menuEndOffset = menuInvisibleSizeJoiner - paddleMarginJoiner;
    if (picLength < 9) {
		$(leftPaddleJoiner).addClass('hidden');
		$(rightPaddleJoiner).addClass('hidden');
    } else {
        if (menuPosition <= paddleMarginJoiner) {
            $(leftPaddleJoiner).addClass('hidden');
            $(rightPaddleJoiner).removeClass('hidden');
        } else if (menuPosition < menuEndOffset) {
            $(leftPaddleJoiner).removeClass('hidden');
            $(rightPaddleJoiner).removeClass('hidden');
        } else if (menuPosition >= menuEndOffset) {
            $(leftPaddleJoiner).removeClass('hidden');
            $(rightPaddleJoiner).addClass('hidden');
        }
    }
	$('#print-wrapper-size-joiner span').text(menuWrapperSizeJoiner);
	$('#print-menu-size-joiner span').text(menuSize);
	$('#print-menu-invisible-size-joiner span').text(menuInvisibleSizeJoiner);
	$('#print-menu-position-joiner span').text(menuPosition);

}).trigger('scroll');

$(rightPaddleJoiner).on('click', function() {
	$('.menu-joiner').animate( { scrollLeft: menuInvisibleSizeJoiner+50}, scrollDurationJoiner);
});

$(leftPaddleJoiner).on('click', function() {
	$('.menu-joiner').animate( { scrollLeft: '0' }, scrollDurationJoiner);
});

$(document).ready(function () {
  var SITEURL = "{{ url('/') }}";
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var calendar = $('#full_calendar_events').fullCalendar({
      editable: true,
      editable: true,
      events: SITEURL + "/calendar-event",
      displayEventTime: true,
      eventRender: function (event, element, view) {
          if (event.allDay === 'true') {
              event.allDay = true;
          } else {
              event.allDay = false;
          }
      },
      selectable: true,
      selectHelper: true,
      select: function (event_start, event_end, allDay) {
          var event_name = prompt('Event Name:');
          if (event_name) {
              var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
              var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
              $.ajax({
                  // url: SITEURL + "/calendar-crud-ajax",
                  // data: {
                  //     event_name: event_name,
                  //     event_start: event_start,
                  //     event_end: event_end,
                  //     type: 'create'
                  // },
                  // type: "POST",
                  // success: function (data) {
                  //     displayMessage("Event created.");
                  //     calendar.fullCalendar('renderEvent', {
                  //         id: data.id,
                  //         title: event_name,
                  //         start: event_start,
                  //         end: event_end,
                  //         allDay: allDay
                  //     }, true);
                  //     calendar.fullCalendar('unselect');
                  // }
              });
          }
      },
      eventDrop: function (event, delta) {
          var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
          var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
          $.ajax({
              // url: SITEURL + '/calendar-crud-ajax',
              // data: {
              //     title: event.event_name,
              //     start: event_start,
              //     end: event_end,
              //     id: event.id,
              //     type: 'edit'
              // },
              // type: "POST",
              // success: function (response) {
              //     displayMessage("Event updated");
              // }
          });
      },
      eventClick: function (event) {
          var eventDelete = confirm("Are you sure?");
          if (eventDelete) {
              $.ajax({
                  // type: "POST",
                  // url: SITEURL + '/calendar-crud-ajax',
                  // data: {
                  //     id: event.id,
                  //     type: 'delete'
                  // },
                  // success: function (response) {
                  //     calendar.fullCalendar('removeEvents', event.id);
                  //     displayMessage("Event removed");
                  // }
              });
          }
      }
  });
});
function displayMessage(message) {
  toastr.success(message, 'Event');            
}