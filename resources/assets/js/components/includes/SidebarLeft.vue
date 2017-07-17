<template>

    <div class="fixed-sidebar-left">
       <ul class="nav navbar-nav side-nav nicescroll-bar">
          <li class="navigation-header">
             <span>
                {{ authUserStore.authUser.first_name }} &nbsp;
                {{ authUserStore.authUser.last_name }}
             </span> 
             <i class="zmdi zmdi-more"></i>
          </li>
          <li>
             <a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="dashboard_dr" class="collapse collapse-level-1">
                <li>
                   <a class="active-page" href="index.php">Home</a>
                </li>
            
                <li>
                   <a href="index2.php">Home 2</a>
                </li>
                <li>
                   <a href="profile.html">profile</a>
                </li>
             </ul>
          </li>

          <li>
             
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#app_dr">
                 <div class="pull-left">
                     <i class="zmdi zmdi-apps mr-20"></i>
                     <span class="right-nav-text">Users </span>
                 </div>
                 <div class="pull-right">
                    <i class="zmdi zmdi-caret-down"></i>
                 </div>
                 <div class="clearfix"></div>
             </a>

             <ul id="app_dr" class="collapse collapse-level-1">
                
                <router-link 
                    :to="{ name: 'admincreateuser' }" 
                    activeClass="active" 
                    tag="li" exact>
                    <a>
                        Create New User
                    </a>
                </router-link>

                <router-link 
                    :to="{ name: 'admincreateuser' }" 
                    activeClass="active" 
                    tag="li" exact>
                    <a>
                        Manage Users
                    </a>
                </router-link>

             </ul>
          </li>


          <li>
             <a href="widgets.php"><div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">widgets</span></div><div class="pull-right"><span class="label label-warning">8</span></div><div class="clearfix"></div></a>
          </li>
          <li><hr class="light-grey-hr mb-10"/></li>
          <li class="navigation-header">
             <span>component</span> 
             <i class="zmdi zmdi-more"></i>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#ui_dr"><div class="pull-left"><i class="zmdi zmdi-smartphone-setup mr-20"></i><span class="right-nav-text">UI Elements</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="ui_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                   <a href="panels_wells.php">Panels & Wells</a>
                </li>
                <li>
                   <a href="modals.php">Modals</a>
                </li>
                <li>
                   <a href="sweetalert.html">Sweet Alerts</a>
                </li>
                <li>
                   <a href="notifications.php">notifications</a>
                </li>
                <li>
                   <a href="typography.html">Typography</a>
                </li>
                <li>
                   <a href="buttons.php">Buttons</a>
                </li>
                <li>
                   <a href="accordion-toggle.html">Accordion / Toggles</a>
                </li>
                <li>
                   <a href="tabs.html">Tabs</a>
                </li>
                <li>
                   <a href="progressbars.php">Progress bars</a>
                </li>
      
                <li>
                   <a href="dorpdown.html">Dropdowns</a>
                </li>
             
                <li>
                   <a href="carousel.php">Carousel</a>
                </li>
                <li>
                   <a href="range_slider.php">Range Slider</a>
                </li>
                <li>
                   <a href="grid-styles.html">Grid</a>
                </li>
                <li>
                   <a href="bootstrap-ui.html">Bootstrap UI</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#form_dr"><div class="pull-left"><i class="zmdi zmdi-edit mr-20"></i><span class="right-nav-text">Forms</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="form_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                   <a href="form_element.php">Main Form</a>
                </li>
                <li>
                   <a href="form_new_group.php">New Group</a>
                </li>
                <li>
                   <a href="form_layout.php">form Layout</a>
                </li>
                <li>
                   <a href="form_advanced.php">Form Advanced</a>
                </li>
                <li>
                   <a href="form_picker.php">Form Picker</a>
                </li>
                <li>
                   <a href="form_validation.php">form Validation</a>
                </li>

                <li>
                   <a href="form_cropper.php">Cropperjs</a>
                </li>
                <li>
                   <a href="file_upload.php">File Upload</a>
                </li>

                <li>
                   <a href="form_type_ahead.php">Type Ahead</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#chart_dr"><div class="pull-left"><i class="zmdi zmdi-chart-donut mr-20"></i><span class="right-nav-text">Charts </span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="chart_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                   <a href="flot-chart.html">Flot Chart</a>
                </li>
                <li>
                   <a href="morris-chart.html">Morris Chart</a>
                </li>
                <li>
                   <a href="chart.js.html">chartjs</a>
                </li>
                <li>
                   <a href="chartist.html">chartist</a>
                </li>
                <li>
                   <a href="easy-pie-chart.html">Easy Pie Chart</a>
                </li>
                <li>
                   <a href="sparkline.html">Sparkline</a>
                </li>
                <li>
                   <a href="peity-chart.html">Peity Chart</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#table_dr"><div class="pull-left"><i class="zmdi zmdi-format-size mr-20"></i><span class="right-nav-text">Tables</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="table_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                   <a href="basic-table.html">Basic Table</a>
                </li>
                <li>
                   <a href="bootstrap-table.html">Bootstrap Table</a>
                </li>
                <li>
                   <a href="data-table.html">Data Table</a>
                </li>
                <li>
                   <a  href="export-table.html"><span class="pull-right"><span class="label label-danger">New</span></span>Export Table</a>
                </li>
                <li>
                   <a  href="responsive-data-table.html"><span class="pull-right"><span class="label label-danger">New</span></span>RSPV DataTable</a>
                </li>
                <li>
                   <a href="responsive-table.html">Responsive Table</a>
                </li>
                <li>
                   <a href="editable-table.html">Editable Table</a>
                </li>
                <li>
                   <a href="foo-table.html">Foo Table</a>
                </li>
                <li>
                   <a href="jsgrid-table.html">Jsgrid Table</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#icon_dr"><div class="pull-left"><i class="zmdi zmdi-iridescent mr-20"></i><span class="right-nav-text">Icons</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="icon_dr" class="collapse collapse-level-1">
                <li>
                   <a href="fontawesome.html">Fontawesome</a>
                </li>
                <li>
                   <a href="themify.html">Themify</a>
                </li>
                <li>
                   <a href="linea-icon.html">Linea</a>
                </li>
                <li>
                   <a href="simple-line-icons.html">Simple Line</a>
                </li>
                <li>
                   <a href="pe-icon-7.html">Pe-icon-7</a>
                </li>
                <li>
                   <a href="glyphicons.html">Glyphicons</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-map mr-20"></i><span class="right-nav-text">maps</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="maps_dr" class="collapse collapse-level-1">
                <li>
                   <a href="google_map.php">Google Map</a>
                </li>
             </ul>
          </li>
          <li><hr class="light-grey-hr mb-10"/></li>
          <li class="navigation-header">
             <span>featured</span> 
             <i class="zmdi zmdi-more"></i>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#pages_dr"><div class="pull-left"><i class="zmdi zmdi-google-pages mr-20"></i><span class="right-nav-text">Special Pages</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="pages_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                   <a href="blank.html">Blank Page</a>
                </li>
                <li>
                   <a href="javascript:void(0);" data-toggle="collapse" data-target="#auth_dr">Authantication pages<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                   <ul id="auth_dr" class="collapse collapse-level-2">
                      <li>
                         <a href="login.php">Login</a>
                      </li>
                      <li>
                         <a href="register.php">Register</a>
                      </li>
                      <li>
                         <a href="forgot_password.php">Forgot Password</a>
                      </li>
                      <li>
                         <a href="reset-password.html">reset Password</a>
                      </li>
                      <li>
                         <a href="locked.html">Lock Screen</a>
                      </li>
                   </ul>
                </li>
                <li>
                   <a href="javascript:void(0);" data-toggle="collapse" data-target="#invoice_dr">Invoice<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                   <ul id="invoice_dr" class="collapse collapse-level-2">
                      <li>
                         <a href="invoice.html">Invoice</a>
                      </li>
                      <li>
                         <a href="invoice-archive.html">Invoice Archive</a>
                      </li>
                   </ul>
                </li>
                <li>
                   <a href="javascript:void(0);" data-toggle="collapse" data-target="#error_dr">error pages<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                   <ul id="error_dr" class="collapse collapse-level-2">
                      <li>
                         <a href="404.html">Error 404</a>
                      </li>
                      <li>
                         <a href="500.html">Error 500</a>
                      </li>
                   </ul>
                </li>
                <li>
                   <a href="gallery.html">Gallery</a>
                </li>
                <li>
                   <a href="timeline.html">Timeline</a>
                </li>
                <li>
                   <a href="faq.html">FAQ</a>
                </li>
             </ul>
          </li>
          <li>
             <a href="documentation.html"><div class="pull-left"><i class="zmdi zmdi-book mr-20"></i><span class="right-nav-text">documentation</span></div><div class="clearfix"></div></a>
          </li>
          <li>
             <a href="javascript:void(0);" data-toggle="collapse" data-target="#dropdown_dr_lv1"><div class="pull-left"><i class="zmdi zmdi-filter-list mr-20"></i><span class="right-nav-text">multilevel</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
             <ul id="dropdown_dr_lv1" class="collapse collapse-level-1">
                <li>
                   <a href="#">Item level 1</a>
                </li>
                <li>
                   <a href="javascript:void(0);" data-toggle="collapse" data-target="#dropdown_dr_lv2">Dropdown level 2<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                   <ul id="dropdown_dr_lv2" class="collapse collapse-level-2">
                      <li>
                         <a href="#">Item level 2</a>
                      </li>
                      <li>
                         <a href="#">Item level 2</a>
                      </li>
                   </ul>
                </li>
             </ul>
          </li>
       </ul>
    </div>

</template>

<script>
    
    import { mapState } from 'vuex';

    export default {

          computed: {
              
              loggedIn() {
                  return ((this.authUserStore.authUser !== null) 
                        && (this.authUserStore.authUser.access_token !== null));
              },

              ...mapState({
                  authUserStore: state => state.authUser
              })

          }

    }

</script>