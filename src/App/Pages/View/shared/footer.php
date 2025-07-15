</div> <!-- container -->


</div> <!-- content -->

<script src="../../../public/js/partials/header.js"></script>
<script src="../../../public/js/utils/spinner.js"></script>
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
    const isCollapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('menuCollapsed', isCollapsed);
  }

  document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('#sidebar');
    if (!sidebar) return;

    let isCollapsed = localStorage.getItem('menuCollapsed');

    <?php
    if (isset($_SESSION['sidebarinactive']) && $_SESSION['sidebarinactive'] === true) {
      echo "isCollapsed = 'true';";
      echo "localStorage.setItem('menuCollapsed', 'true');";
      $_SESSION['sidebarinactive'] = false;
    }
    ?>

    if (isCollapsed === 'true') {
      sidebar.classList.add('collapsed');
    } else {
      sidebar.classList.remove('collapsed');
    }
  });
</script>



</body>

</html>