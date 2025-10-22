<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div class="app-sidebar-wrapper">
        <div id="kt_app_sidebar_wrapper" class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper"
             data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                 class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
                <!--begin:Menu item-->
                <div class="menu-item">
                    <a href="{{ route('client.dashboard') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.dashboard')) active @endif">
						<span class="menu-icon">
							<i class="ki-outline ki-home-2 fs-2"></i>
						</span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('client.items') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.item')) active @endif">
                        <span class="menu-icon"> 
                            <i class="ki-outline ki-underlining fs-2"></i>
                        </span>
                        <span class="menu-title">Items</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('client.quotes') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.quote')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-underlining fs-2"></i>
                        </span>
                        <span class="menu-title">Quotes</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('client.invoices') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.invoice')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-cheque fs-2"></i>
                        </span>
                        <span class="menu-title">Invoices</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('client.payments') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.payment')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-book-square fs-2"></i>
                        </span>
                        <span class="menu-title">Payments</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('client.kyb') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.kyb')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-shield-tick fs-2"></i>
                        </span>
                        <span class="menu-title">KYB Verification</span>
                    </a>
                </div>
                
                <!-- Deposit / Withdraw -->
                <div class="menu-item">
                    <a href="{{ route('client.transactions') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.transaction')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-wallet fs-2"></i>
                        </span>
                        <span class="menu-title">Deposit & Withdraw</span>
                    </a>
                </div>

                <!-- Deposit & Withdrawal History -->
                <div class="menu-item">
                    <a href="{{ route('client.transaction-history') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.transaction-history')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-time fs-2"></i>
                        </span>
                        <span class="menu-title">Transaction History</span>
                    </a>
                </div>

                <!-- Support Tickets -->
                <div class="menu-item">
                    <a href="{{ route('client.support') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'client.support')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-message-text fs-2"></i>
                        </span>
                        <span class="menu-title">Support Tickets</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Sidebar-->
