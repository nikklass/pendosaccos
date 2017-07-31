<nav class="navbar navbar-inverse navbar-fixed-top">
 <div class="mobile-only-brand pull-left">
    <div class="nav-header pull-left">
       <div class="logo-wrap">
          
          @include('layouts.partials.headerLogo')

       </div>
    </div>   
    <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
    <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
    <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
    <form id="search_form" role="search" class="top-nav-search collapse pull-left">
       <div class="input-group">
          <input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
          <span class="input-group-btn">
          <button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
          </span>
       </div>
    </form>
 </div>
 <div id="mobile_only_nav" class="mobile-only-nav pull-right">
    <ul class="nav navbar-right top-nav pull-right">
       <li>
          <a id="open_right_sidebar" href="#"><i class="zmdi zmdi-settings top-nav-icon"></i></a>
       </li>

       <!-- <li class="dropdown app-drp">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps top-nav-icon"></i></a>
          <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
             <li>
                <div class="app-nicescroll-bar">
                   <ul class="app-icon-wrap pa-10">
                      <li>
                         <a href="weather.html" class="connection-item">
                         <i class="zmdi zmdi-cloud-outline txt-info"></i>
                         <span class="block">weather</span>
                         </a>
                      </li>
                      <li>
                         <a href="inbox.html" class="connection-item">
                         <i class="zmdi zmdi-email-open txt-success"></i>
                         <span class="block">e-mail</span>
                         </a>
                      </li>
                      <li>
                         <a href="calendar.html" class="connection-item">
                         <i class="zmdi zmdi-calendar-check txt-primary"></i>
                         <span class="block">calendar</span>
                         </a>
                      </li>
                      <li>
                         <a href="vector-map.html" class="connection-item">
                         <i class="zmdi zmdi-map txt-danger"></i>
                         <span class="block">map</span>
                         </a>
                      </li>
                      <li>
                         <a href="chats.html" class="connection-item">
                         <i class="zmdi zmdi-comment-outline txt-warning"></i>
                         <span class="block">chat</span>
                         </a>
                      </li>
                      <li>
                         <a href="contact-card.html" class="connection-item">
                         <i class="zmdi zmdi-assignment-account"></i>
                         <span class="block">contact</span>
                         </a>
                      </li>
                   </ul>
                </div>   
             </li>
             <li>
                <div class="app-box-bottom-wrap">
                   <hr class="light-grey-hr ma-0"/>
                   <a class="block text-center read-all" href="javascript:void(0)"> more </a>
                </div>
             </li>
          </ul>
       </li> -->
    
       <li class="dropdown alert-drp">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i><span class="top-nav-icon-badge">5</span></a>
          <ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
             <li>
                <div class="notification-box-head-wrap">
                   <span class="notification-box-head pull-left inline-block">notifications</span>
                   <a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)"> clear all </a>
                   <div class="clearfix"></div>
                   <hr class="light-grey-hr ma-0"/>
                </div>
             </li>
             <li>
                <div class="streamline message-nicescroll-bar">
                   <div class="sl-item">
                      <a href="javascript:void(0)">
                         <div class="icon bg-green">
                            <i class="zmdi zmdi-flag"></i>
                         </div>
                         <div class="sl-content">
                            <span class="inline-block capitalize-font  pull-left truncate head-notifications">
                            New message received</span>
                            <span class="inline-block font-11  pull-right notifications-time">2pm</span>
                            <div class="clearfix"></div>
                            <p class="truncate">
                            Your customer xyz sent you a message. Click to view message.</p>
                         </div>
                      </a>  
                   </div>
                   <hr class="light-grey-hr ma-0"/>
                   <div class="sl-item">
                      <a href="javascript:void(0)">
                         <div class="icon bg-yellow">
                            <i class="zmdi zmdi-trending-down"></i>
                         </div>
                         <div class="sl-content">
                            <span class="inline-block capitalize-font  pull-left truncate head-notifications txt-warning">Mpesa payments are due</span>
                            <span class="inline-block font-11 pull-right notifications-time">1pm</span>
                            <div class="clearfix"></div>
                            <p class="truncate">Some technical error occurred needs to be resolved.</p>
                         </div>
                      </a>  
                   </div>
                   <hr class="light-grey-hr ma-0"/>
                   <div class="sl-item">
                      <a href="javascript:void(0)">
                         <div class="icon bg-blue">
                            <i class="zmdi zmdi-email"></i>
                         </div>
                         <div class="sl-content">
                            <span class="inline-block capitalize-font  pull-left truncate head-notifications">SMS balance is almost depleted</span>
                            <span class="inline-block font-11  pull-right notifications-time">4pm</span>
                            <div class="clearfix"></div>
                            <p class="truncate"> Click here to renew sms balances.</p>
                         </div>
                      </a>  
                   </div>
                   
                   <hr class="light-grey-hr ma-0"/>
                   <div class="sl-item">
                      <a href="javascript:void(0)">
                         <div class="icon bg-red">
                            <i class="zmdi zmdi-storage"></i>
                         </div>
                         <div class="sl-content">
                            <span class="inline-block capitalize-font  pull-left truncate head-notifications txt-danger">New Message</span>
                            <span class="inline-block font-11  pull-right notifications-time">1pm</span>
                            <div class="clearfix"></div>
                            <p class="truncate">consectetur, adipisci velit.</p>
                         </div>
                      </a>  
                   </div>
                </div>
             </li>
             <li>
                <div class="notification-box-bottom-wrap">
                   <hr class="light-grey-hr ma-0"/>
                   <a class="block text-center read-all" href="javascript:void(0)"> View all </a>
                   <div class="clearfix"></div>
                </div>
             </li>
          </ul>
       </li>
       <li class="dropdown auth-drp">
          <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown">
              <img src="{{ asset('images/no_user.jpg') }}" 
                  alt="{{ Auth::user()->name }}" 
                  class="user-auth-img img-circle"/>
              <span class="user-online-status"></span>
          </a>
          <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
             <li>
                <a href="#" class="dropdown-toggle pr-0 level-2-drp">
                    <i class="zmdi zmdi-account text-success"></i> 
                    {{ Auth::user()->first_name }} 
                    &nbsp; 
                    <!-- {{ Auth::user()->last_name }} -->
                </a>
             </li>
             <li class="divider"></li>
             <li>
                <a href="#"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
             </li>
             <li>
                <a href="#"><i class="zmdi zmdi-card"></i><span>my balance</span></a>
             </li>
             <li>
                <a href="#"><i class="zmdi zmdi-email"></i><span>Inbox</span></a>
             </li>
             <li>
                <a href="#"><i class="zmdi zmdi-settings"></i><span>Settings</span></a>
             </li>
             <li class="divider"></li>
             <li class="sub-menu show-on-hover">
                <a href="#" class="dropdown-toggle pr-0 level-2-drp">
                  <i class="zmdi zmdi-check text-success"></i> 
                  available
                </a>
                <ul class="dropdown-menu open-left-side">
                   <li>
                      <a href="#">
                        <i class="zmdi zmdi-check text-success"></i>
                        <span>available</span>
                      </a>
                   </li>
                   <li>
                      <a href="#"><i class="zmdi zmdi-circle-o text-warning"></i><span>busy</span></a>
                   </li>
                   <li>
                      <a href="#"><i class="zmdi zmdi-minus-circle-outline text-danger"></i><span>offline</span></a>
                   </li>
                </ul> 
             </li>
             <li class="divider"></li>
             <li>
                  <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                      <i class="zmdi zmdi-power"></i><span>Log Out</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>

             </li>
          </ul>
       </li>
    </ul>
 </div>   
</nav>