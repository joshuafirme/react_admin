 <!-- Main Sidebar Container -->

 <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="/" class="brand-link">

      <img src="{{asset(settings()->logo)}}" alt="{{ settings()->logo }} Logo" class="brand-image" style="opacity: .8">

      <span class="brand-text font-weight-light"><small>{{ settings()->app_name }}</small></span>

    </a>

     

    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="/images/profile_picture_alt.jpg" class="img-circle elevation-2" alt="User Image">

        </div>

          <div class="info">

          <a href="#" class="d-block"> {{ Auth::user()->username }}</a>

        </div>

      </div>



      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->

          <li class="nav-item">

            <a href="/home" class="nav-link {{Request::path() == 'home' ? 'active' : '' }}">

              <i class="fas fa-tachometer-alt nav-icon"></i>

              <p>Dashboard</p>

            </a>

          </li>

        


        @if(isAdmin() || isSuperAdmin())    
          <li class="nav-item has-treeview">

            <a href="#" class="nav-link active">

              <i class="far fa-user nav-icon"></i>

              <p>

                App Users

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            
            <ul class="nav nav-treeview"><li class="nav-item">

                <a href="/catalog/users/add" class="nav-link {{Request::path() == 'catalog/users/add' ? 'active' : '' }}">

                  <i class="far fa-user nav-icon"></i>

                  <p>Create Users</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="/catalog/users" class="nav-link {{Request::path() == 'catalog/users' ? 'active' : '' }}">

                  <i class="far fa-user nav-icon"></i>

                  <p>Manage Users</p>

                </a>

              </li>

              

              <li class="nav-item">

                <a href="/catalog/roles" class="nav-link {{Request::path() == 'catalog/roles' ? 'active' : '' }}">

                  <i class="far fa-check-square nav-icon"></i>

                  <p>Roles</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="/catalog/agencies" class="nav-link {{Request::path() == 'catalog/agencies' ? 'active' : '' }}">

                  <i class="far fa-building nav-icon"></i>

                  <p>Agencies</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="/catalog/categories" class="nav-link {{Request::path() == 'catalog/categories' ? 'active' : '' }}">

                  <i class="fas fa-tag nav-icon"></i>

                  <p>Case Types</p>

                </a>

              </li>



              <!-- <li class="nav-item">

                <a href="/catalog/subcategories" class="nav-link {{Request::path() == 'catalog/subcategories' ? 'active' : '' }}">

                  <i class="fas fa-tag nav-icon"></i>

                  <p>Incident Types</p>

                </a>

              </li> -->


            </ul>

          </li>

          @endif
          <li class="nav-item">

            <a href="/catalog/messaging" class="nav-link {{Request::path() == 'catalog/messaging' ? 'active' : '' }}">

              <i class="nav-icon fas fa-envelope"></i>

              <p>

                Messaging

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="/catalog/announcements" class="nav-link {{Request::path() == 'catalog/announcements' ? 'active' : '' }}">

              <i class="nav-icon fas fa-bullhorn"></i>

              <p>

                Announcements

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="/catalog/logs" class="nav-link {{Request::path() == 'catalog/logs' ? 'active' : '' }}">

              <i class="nav-icon fa fa-list"></i>

              <p>

                Case Summary

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="/catalog/reports" class="nav-link {{Request::path() == 'catalog/reports' ? 'active' : '' }}">

              <i class="nav-icon fa fa-list-alt"></i>

              <p>

                Reports

              </p>

            </a>

          </li>
          @if (isAdmin() || isSuperAdmin())
              
          <li class="nav-item">

            <a href="/catalog/settings" class="nav-link {{Request::path() == 'catalog/settings' ? 'active' : '' }}">

              <i class="nav-icon fa fa-cog"></i>

              <p>

                Settings

              </p>

            </a>

          </li>
          @endif
          <!-- <li class="nav-item">

            <a href="/catalog/adminUsers" class="nav-link {{Request::path() == 'catalog/adminUsers' ? 'active' : '' }}">

              <i class="nav-icon fas fa-bullhorn"></i>

              <p>

                Admin Users

              </p>

            </a>

          </li> -->

          <!-- <li class="nav-item has-treeview">

            <a href="#" class="nav-link active">

              <i class="fa fa-truck nav-icon"></i>

              <p>

                Tracking Module

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">
            
              <li class="nav-item">

                <a href="/catalog/tracking" class="nav-link {{ Request::path() == 'catalog/tracking' ? 'active' : '' }}">

                  <i class="nav-icon fa fa-truck"></i>

                  <p>

                    Tracking

                  </p>

              </a>

              </li>

              <li class="nav-item">

                <a href="/catalog/tracking/updatestatus" class="nav-link {{ Request::path() == 'catalog/tracking/updatestatus' ? 'active' : '' }}">

                  <i class="nav-icon fas fa-sync"></i>

                  <p>

                    Update Status

                  </p>

              </a>

              </li>

              <li class="nav-item">

                <a href="/catalog/tracking/report" class="nav-link {{ Request::path() == '/catalog/tracking/report' ? 'active' : '' }}">

                  <i class="far fa-user nav-icon"></i>

                  <p>Reports</p>

                </a>

              </li>

            </ul>

            </li> -->

          



        </ul>

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>