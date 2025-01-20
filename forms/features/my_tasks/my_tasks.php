<?php 
include("forms/common/side_menu.php");



?>


<div class="main-content d-flex" id="main-content" style="height: 100vh;justify-content: center;align-content: center;align-items: center;text-align: center;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div id='calendar' style="height:800px;"></div>
			</div>
		</div>  
	</div>
</div>


<script type="text/javascript">
	active_route("tasks_");

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
	initialView: "dayGridMonth",
    selectable: true,
    navLinks: true,
    editable: true,
    droppable: true,
    timeZone: "local",
    allDaySlot: false,
    header: {
      left: "prevYear, prev, today, next, nextYear",
      center: "title",
      right: "month,agendaWeek,agendaDay,list",
    },
	eventClick: function (event) {
      var modal = $("#schedule-edit");
      modal.modal();
      $("#event_id").val(event.id);
      $("#title_update").val(event.title);
      $("#description_update").val(event.description);
      $("#start_time_update").val(event.start_time.substring(0, 23));
      $("#end_time_update").val(event.end_time.substring(0, 23));
    },
    dayClick: function (date, jsEvent, view) {
      $("#schedule-add").modal("show");
      $("#add_new_booking").html("Add New Booking For " + date.format());
    },
    viewRender: function (view) {
      var date = $("#calendar").fullCalendar("getDate");
      var currentViewDate = date.toDate();
      var from = new Date(
        currentViewDate.getFullYear(),
        currentViewDate.getMonth(),
        1
      );
      var to = new Date(
        currentViewDate.getFullYear(),
        currentViewDate.getMonth() + 1,
        0
      );

      from = formatDate(from);
      to = formatDate(to);

      var eventsSource = "/en/origami/calendar.json?from=" + from + "&to=" + to;

      $("#calendar").fullCalendar("refetchEvents");
      $("#calendar").fullCalendar("removeEventSource", eventsSource);

      $("#calendar").fullCalendar("addEventSource", eventsSource);

      localStorage.setItem("from", from);
      localStorage.setItem("to", to);
    },
    eventDrop: function (info) {
      var id = info.id;
      var title = info.title;
      var description = info.description;
      var start_time = info.start.toISOString();
      var end_time = info.end.toISOString();
      update_booking(id, title, description, start_time, end_time);
    },
    eventResize: function (info) {
      var id = info.id;
      var title = info.title;
      var description = info.description;
      var start_time = info.start.toISOString();
      var end_time = info.end.toISOString();
      update_booking(id, title, description, start_time, end_time);
    },
  });
  calendar.render();
});

</script>
