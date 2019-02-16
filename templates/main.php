<body>
  <main >
    <table class="table table-striped">
      <?php $JsonHandler->drawTable(); ?>
    </table>
    <!-- chart wrap -->
    <div id="chart_wrap" style="margin: 0px auto; width: 800px; height: 400px;" ></div>
    <!-- chart filter -->
    <div class="chart_filter_wrap">
      <form class="filter">
        <div class="filter_select_wrap">
          <p>Period:</p>
          <select id="filter_select" class="custom-select">
            <!-- select drawing -->
            <?php $JsonHandler->drawSelect(); ?>
          </select>
        </div>
        <p>Discipline</p>
        <div>
          <!-- Checkbox drawing -->
          <fieldset>
          <?php $JsonHandler->drawCheckboxes(); ?>
          </fieldset>
        </div>
        <div class="button_wrap">
          <a type="button" class="filter_button" onclick="filterHandler()">Filter</a>
        </div>
        <div id="filter_notification"></div>
      </form>
    </div>
    <!-- END chart filter -->
  </main>