<!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <img src="{{asset('assets/images/logo.jpg')}}" style="width:200px;height: 100px;" alt="not found"> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0 ">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
                        
                      
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/users/avatar.jpg')}}" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('assets/images/users/avatar.jpg')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{auth()->user()->name}}</h4>
                                                <p class="text-muted">{{auth()->user()->email}}</p><a href="{{route('user.show',auth()->user()->id)}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('user.show',auth()->user()->id)}}"><i class="ti-user"></i> My Profile</a></li>
                                    
                                       <li>
                                        <form method="POST" action="{{route('logout')}}">
                                            @csrf
                                        <button class="btn btn-block btn-danger"> Logout</button>
                                            
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{asset('assets/images/users/avatar.jpg')}}" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{auth()->user()->name}} <span class="caret"></span></a>
                        <div class="dropdown-menu animated flipInY">
                            <a href="{{route('user.show',auth()->user()->id)}}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                            <div class="dropdown-divider"></div>
                                   <form method="POST" action="{{route('logout')}}">
                                            @csrf
                                        <button class="btn btn-block btn-danger"> Logout</button>
                                            
                                        </form>
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">PERSONAL</li>
                        <li>
                            <a href="/" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a>
                        </li>
                        <li>
                            <a href="{{route('user.show',auth()->user()->id)}}" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Profile</span></a>
                        </li>
                      <!--   <li>
                            <a href="/chat" aria-expanded="false"><i class="fa fa-comment"></i><span class="hide-menu">Chat</span></a>
                        </li> -->
                        @if(auth()->user()->role=="admin")
                        <li>
                            <a href="{{route('user.index')}}" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Users</span></a>
                        </li>
                        @endif
                        <li>
                            <a href="{{route('client.index')}}" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Clients</span></a>
                        </li>      
                        
                       <!--  <li>
                            <a href="{{route('video.index')}}" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu">Files</span></a>
                        </li>   -->
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu">Files</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('video.index')}}">All</a></li>
                                <li><a href="{{route('shareableLinks.index')}}">Shareable Links</a></li>
                              
                                <li><a href="{{route('multiuseLinks.index')}}">Multiuse Links</a></li>
                            </ul>
                        </li>

                          <li>
                            <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-link" aria-hidden="true"></i><span class="hide-menu">External Links</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('externalLink.index')}}">All</a></li>
                                <li><a href="{{route('external.shareableLinks.index')}}">Shareable Links</a></li>
                              
                                <li><a href="{{route('exteralLinks.multiuseLinks.index')}}">Multiuse Links</a></li>
                            </ul>
                        </li>
                         @if(auth()->user()->role=="admin")
                        <li>
                            <a href="{{route('plan.index')}}" aria-expanded="false"><i class="fa fa-archive" aria-hidden="true"></i><span class="hide-menu">Plans</span></a>
                        </li>
                        @endif
                        <li><a href="{{route('tutorials')}}"><i class="fa fa-book"></i>Tutorial</a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <!-- <div class="sidebar-footer"> -->
                <!-- item-->
                <!-- <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a> -->
                <!-- item-->
                <!-- <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a> -->
                <!-- item-->
                <!-- <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> -->
            <!-- </div> -->
            <!-- End Bottom points-->
        </aside>