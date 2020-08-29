<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Navigasi Utama</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Daftar Rekap Cuci</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('owner.bikehistories.index')}}"><i class="fa fa-motorcycle"></i>Cuci Motor</a></li>
            <li><a href="{{route('owner.carpethistories.index')}}"><i class="fa fa-list"></i>Cuci Karpet</a></li>
          </ul>
        </li>
        <li>
        <a href="{{route('owner.admin.index')}}">
            <i class="fa fa-users"></i> <span> Daftar Admin </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>