<?php
require_once("init.php");
include("linknice.php");
?>

<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="Admin_dashboard.php">
      <i class="bi bi-grid" style="color:rgb(29, 204, 67);"></i>
      <span>Admin Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#staff-nav" data-bs-toggle="collapse" href="#"> 
      <i class="bi bi-person-badge-fill" style="color: orange;"></i><span>Staff Member</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="staff-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_staff_member.php">
          <i class="bi bi-circle"></i><span>Add Staff Member</span>
        </a>
      </li>
      <li>
        <a href="manage_staff_member.php">
          <i class="bi bi-circle"></i><span>Manage Staff Member</span>
        </a>
      </li>
      <li>
        <a href="view_all_staff.php">
          <i class="bi bi-circle"></i><span>view all staff</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#clients-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-person-lines-fill" style="color: blue;"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="clients-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="client.php">
          <i class="bi bi-circle"></i><span>Add Client</span>
        </a>
      </li>
      <li>
        <a href="client_manage.php">
          <i class="bi bi-circle"></i><span>Manage Clients</span>
        </a>
      </li>
      <li>
        <a href="view_all_clients.php">
          <i class="bi bi-circle"></i><span>View All Clients</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-card-list" style="color: blue;"></i><span>Manage Website</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="transaction-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="manage_website.php">
          <i class="bi bi-circle"></i><span>Manage Contents</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#member-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-currency-exchange" style="color: blue;"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="member-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li>
        <a href="transaction_record.php">
          <i class="bi bi-circle"></i><span>Record Transaction</span>
        </a>
      </li>
      <li>
        <a href="transaction_manage.php">
          <i class="bi bi-circle"></i><span>Manage Transaction</span>
        </a>
      </li>
      <li>
        <a href="show_all_transaction.php">
          <i class="bi bi-circle"></i><span>View All Transactions</span>
        </a>
      </li>
  </li>
    </ul>
    <li class="nav-item">
    <a class="nav-link collapsed" href="reg.php">
      <i class="bi bi-person-fill-add" style="color: green;"></i>
      <span>Reg staff in system</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="del_insystem.php">
    <i class="bi bi-person-slash" style="color: red;"></i>
      <span>Remove staff in system</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="calendar.php">
    <i class="bi bi-calendar-fill" style="color:rgb(20, 181, 209);"></i>
      <span>Calendar</span>
    </a>
  </li>
</ul>
</ul>
</ul>
</aside><!-- End Sidebar -->