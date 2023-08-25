<?php

include '../partials/header.php';
include '../partials/left.php';
include '../partials/footer.php';


?>
<html>

<head>
  <title>Basebol Sport</title>
  <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/plugins/fullcalendar/main.css">
  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
  <script src="https://kit.fontawesome.com/a4ea18999d.js" crossorigin="anonymous"></script>

</head>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/calendario/futebol.php" class="nav-link"><i class="fa-solid fa-futbol"></i>futebol</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/calendario/hoquei.php" class="nav-link"><i class="fa-solid fa-hockey-puck"></i>hoquei</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/calendario/basquete.php" class="nav-link"><i class="fa-solid fa-basketball" style="color: #ff8c00;"></i>basquetebol</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/calendario/futamericano.php" class="nav-link"><i class="fa-solid fa-helmet-un" style="color: #042a6c;"></i>Rurby</a>
    </li>
  </ul>
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/minha_PAP/Views/calendario/tenis.php" class="nav-link"><i class="fa-solid fa-baseball" style="color: #2fd501;"></i>tenis</a>
    </li>
  </ul>
</nav>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Calendar</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="sticky-top mb-3">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Ligas:</h4>
              </div>
              <div class="card-body">
                <div id="external-events">
                  <form method="post">
                    <?php
                    $numberOfDays = 5;
                    $startDate = date("d/m/Y");
                    $endDate = date("d/m/Y", strtotime("+$numberOfDays days"));

                    $start = str_replace("/", "%2F", $startDate);
                    $end = str_replace("/", "%2F", $endDate);
                    $curl = curl_init();

                    curl_setopt_array($curl, [
                      CURLOPT_URL => "https://allscores.p.rapidapi.com/api/allscores/games-scores?startDate=" . $start . "&langId=1&sport=6&endDate=" . $end . "&timezone=Portugal&onlyMajorGames=true&withTop=true",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: allscores.p.rapidapi.com", 
                        "X-RapidAPI-Key: ab7a71a2f4mshfb7fbd9e4cec934p193a77jsne9272113dde1"
                      ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                      echo json_encode(["error" => "cURL Error: " . $err]);
                    } else {
                      $response = json_decode($response, true);
                      if (!$response) {
                        echo json_encode(["error" => "Error: Failed to fetch data from API."]);
                      } else {
                        $leagues = [];
                        foreach ($response["games"] as $info) {
                          $competitionId = isset($info["competitionId"]) ? $info["competitionDisplayName"] : null;
                          $leagueName = $competitionId;
                          $leagues[$leagueName] = true; // Store league names as keys to eliminate duplicates
                        }

                        // Output the league names as checkboxes
                        foreach ($leagues as $leagueName => $value) {
                          echo '<input type="checkbox" name="leagues[]" value="' . $leagueName . '"> ' . $leagueName . '<br>';
                        }
                      }
                    }
                    ?>
                    <input type="submit" name="submit" value="Submit">
                  </form>
                </div>
              </div>

            </div>
            <!-- the events -->


            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">

          </div>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary">
          <div class="card-body p-0">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/fullcalendar/main.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  const savebookmark = document.querySelectorAll(".save_bookmark");
  savebookmark.forEach(function(togglePassword) {
    togglePassword.addEventListener("click", function() {
      const save_team = this.id.replace("bookmark_", "");
      const productId = $("#" + save_team).val();
      console.log(productId);

      $.ajax({
        url: '<?= $global_configs['SERVER_URL'] ?>/api/addfavorite.php',
        method: 'post',
        data: {
          'productId': productId,

        }
      }).done(function(res) {
        res = JSON.parse(res);
        if (res.status == 'success') {
          toastr[res.status](res.message);
        } else {
          toastr[res.status](res.message);
        }
      })
    });
  });

  $(function() {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function() {

        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0 //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'UTC',
      initialView: 'resourceTimeGridFourDay',
      headerToolbar: {
        right: 'resourceTimeGridDay,resourceTimeGridFourDay'
      },
      views: {
        resourceTimeGridFourDay: {
          type: 'timeGrid',
          duration: {
            days: 3
          },
          buttonText: '3 day'
        },
        resourceTimeGridDay: {
          type: 'timeGrid',
          duration: {
            days: 1
          },
          buttonText: 'Today'
        }
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: {
        url: '../../api/futamericanoapi.php',
        method: 'POST',
      },
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();

    // Function to filter events based on selected checkboxes
    // Function to filter events based on selected checkboxes
    function createLeagueEventSource(league) {
      return {
        url: '../../api/filterfutamericanoapi.php',
        method: 'POST',
        extraParams: {
          league: league // Pass the league as an extra parameter to the API
        },
        eventDataTransform: function(responseData) {
          // Transform the API response data if needed
          return responseData;
        }
      };
    }

    // Function to filter events based on selected checkboxes
    function filterEvents(selectedLeagues) {
      // Get the existing event sources from the calendar
      const existingSources = calendar.getEventSources();

      // Remove all existing event sources from the calendar
      existingSources.forEach((source) => source.remove());

      // Add event sources for the selected leagues
      selectedLeagues.forEach((league) => {
        const eventSource = createLeagueEventSource(league);
        calendar.addEventSource(eventSource);
      });
    }

    // Handle form submission
    $('form').on('submit', function(event) {
      event.preventDefault();

      // Get the selected leagues
      const selectedLeagues = $('input[name="leagues[]"]:checked').map(function() {
        return $(this).val();
      }).get();

      if (selectedLeagues.length === 0) {
        // If no leagues are selected, display all events
        filterEvents(['']); // Show events for an empty league (won't match any events)
      } else {
        // If leagues are selected, filter and display the events
        filterEvents(selectedLeagues);
      }
    });
  });

  /* ADDING EVENTS */
  var currColor = '#3c8dbc' //Red by default
  // Color chooser button
  $('#color-chooser > li > a').click(function(e) {
    e.preventDefault()
    // Save color
    currColor = $(this).css('color')
    // Add color effect to button
    $('#add-new-event').css({
      'background-color': currColor,
      'border-color': currColor
    })
  })
  $('#add-new-event').click(function(e) {
    e.preventDefault()
    // Get value and make sure it is not null
    var val = $('#new-event').val()
    if (val.length == 0) {
      return
    }

    // Create events
    var event = $('<div />')
    event.css({
      'background-color': currColor,
      'border-color': currColor,
      'color': '#fff'
    }).addClass('external-event')
    event.text(val)
    $('#external-events').prepend(event)

    // Add draggable functionality
    ini_events(event)

    // Remove event from text input
    $('#new-event').val('')
  });
</script>


</html>


<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/jszip/jszip.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



<script src=https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js></script>
<script src=https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js></script>
<script src=https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js></script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js></script>


<!-- Page specific script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

</html>