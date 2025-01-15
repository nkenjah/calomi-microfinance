<?php
include("link.php");
?>
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="staff_dashboard.php">
      <i class="bi bi-grid"></i>
      <span>Staff Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>client</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="register_client.php">
              <i class="bi bi-circle"></i><span>Register client</span>
            </a>
          </li>
          <li>
            <a href="view_all_clients_details.php">
              <i class="bi bi-circle"></i><span>view all client details</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-currency-exchange"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="transaction_record.php">
              <i class="bi bi-circle"></i><span>record transaction</span>
            </a>
          </li>
          <li>
            <a href="show_all_transaction.php">
              <i class="bi bi-circle"></i><span>view transaction details</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i><span>settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="change_pw.php">
              <i class="bi bi-circle"></i><span>change password</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-left"></i>
          <span>Logout</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="https://wa.me//+255694995652">
          <i class="bi bi-question-square-fill"></i>
          <span>you need help?</span>
        </a>
      </li>
        </ul>
</aside>