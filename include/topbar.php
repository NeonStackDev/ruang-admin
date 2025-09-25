        <style>
          .nav-item {
            position: relative;
            display: inline-block;
          }

          .nav-link {
            cursor: pointer;
            padding: 10px;
            font-size: 20px;
            color: #333;
          }

          .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 200px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            display: none;
            overflow: hidden;
            z-index: 1000;
          }

          .dropdown-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
          }

          .dropdown-menu a:hover {
            background: #f7f7f7;
          }

          .nav-item.show .dropdown-menu {
            display: block;
          }

          .badge-red {
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            vertical-align: top;
            margin-left: 4px;
          }
        </style>
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
              <div class="nav-link dropdown-toggle" id="notifyDropdown" role="button">
                <i class="fas fa-bell fa-fw"></i>
                <span id="notifyCount" class="badge-red">0</span>
              </div>
              <div class="notify dropdown-menu">
                <a href="#">🔔 Notification 1</a>
                <a href="#">🔔 Notification 2</a>
                <a href="#">🔔 Notification 3</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button">
                <i class="fas fa-search fa-fw"></i>
              </a>

            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Tauqeer Ahmed</span>
              </a>

            </li>
          </ul>
        </nav>