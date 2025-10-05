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
                    <a href="{{ route('freelancer.dashboard') }}" class="menu-link @if(Str::startsWith(Request::route()->getName(), 'freelancer.dashboard')) active @endif">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('freelancer.items') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-underlining fs-2"></i>
                        </span>
                        <span class="menu-title">Items</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('freelancer.quotes') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-underlining fs-2"></i>
                        </span>
                        <span class="menu-title">Quotes</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('freelancer.invoices') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-cheque fs-2"></i>
                        </span>
                        <span class="menu-title">Invoices</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('freelancer.payments') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-book-square fs-2"></i>
                        </span>
                        <span class="menu-title">Payments</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="{{ route('freelancer.kyc') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-shield-tick fs-2"></i>
                        </span>
                        <span class="menu-title">KYC Verification</span>
                    </a>
                </div>
                
                <!-- Deposit / Withdraw -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.transactions') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-wallet fs-2"></i>
                        </span>
                        <span class="menu-title">Deposit & Withdraw</span>
                    </a>
                </div>

                <!-- Deposit & Withdrawal History -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.transaction-history') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-time fs-2"></i>
                        </span>
                        <span class="menu-title">Transaction History</span>
                    </a>
                </div>

                <!-- Reports -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.reports') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-graph-up fs-2"></i>
                        </span>
                        <span class="menu-title">Reports</span>
                    </a>
                </div>

                <!-- Accounting Summary -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.accounting') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-calculator fs-2"></i>
                        </span>
                        <span class="menu-title">Accounting Summary</span>
                    </a>
                </div>

                <!-- Client Database -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.clients') }}" class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-user fs-2"></i>
                        </span>
                        <span class="menu-title">Clients Engagement</span>
                    </a>
                </div>

                <!-- Support Tickets -->
                <div class="menu-item">
                    <a href="{{ route('freelancer.support') }}" class="menu-link">
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
