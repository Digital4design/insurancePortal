<aside class="left-sidebar">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<li class="nav-devider"></li>
				<li>
					<a class="  waves-effect waves-dark" href="{{ url('admin/') }}" aria-expanded="false">
						<i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard
					</a>
				</li>
				<li class="nav-devider"></li>
				<li class="nav-small-cap">Management</li> 
				<li>
					<a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
						<i class="fa fa-users" aria-hidden="true"></i><span class="hide-menu">Policy Holders</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('company/user-management') }}"> <i class="mdi mdi-view-list"></i>Listing</a></li>
						<!-- <li><a href="{{ url('company/user-management') }}"> <i class="mdi mdi-account-plus"></i>Create</a></li> -->
					</ul>
				</li>

				<li>
					<a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
						<i class="mdi mdi-bullseye" aria-hidden="true"></i><span class="hide-menu">Policy Parameters</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('company/speed-management') }}"> <i class="mdi mdi-view-list"></i>Listing</a></li>
						</ul>
				</li>
				<li class="nav-devider"></li>
			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>